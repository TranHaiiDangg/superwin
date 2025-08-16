<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
// use Intervention\Image\ImageManager;
// use Intervention\Image\Drivers\Imagick\Driver;

class ReviewController extends Controller
{
    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        // Debug: Log request data
        Log::info('Review submission request:', [
            'all_data' => $request->all(),
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'user_agent' => $request->header('User-Agent'),
            'ip' => $request->ip()
        ]);

        // Kiểm tra xem user đã đăng nhập chưa
        if (!Auth::guard('customer')->check()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn cần đăng nhập để viết bình luận.',
                    'redirect' => route('login')
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để viết bình luận.');
        }

        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string|min:10|max:1000',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120', // Max 5MB per image
        ], [
            'product_id.required' => 'Sản phẩm không hợp lệ.',
            'product_id.exists' => 'Sản phẩm không tồn tại.',
            'rating.required' => 'Vui lòng chọn số sao đánh giá.',
            'rating.integer' => 'Đánh giá phải là số nguyên.',
            'rating.min' => 'Đánh giá tối thiểu là 1 sao.',
            'rating.max' => 'Đánh giá tối đa là 5 sao.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'comment.required' => 'Vui lòng nhập nội dung bình luận.',
            'comment.min' => 'Bình luận phải có ít nhất 10 ký tự.',
            'comment.max' => 'Bình luận không được vượt quá 1000 ký tự.',
            'images.max' => 'Tối đa 5 ảnh được phép tải lên.',
            'images.*.image' => 'File phải là ảnh.',
            'images.*.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'images.*.max' => 'Ảnh không được vượt quá 5MB.',
        ]);

        if ($validator->fails()) {
            Log::warning('Review validation failed:', [
                'errors' => $validator->errors()->toArray(),
                'input' => $request->all()
            ]);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dữ liệu không hợp lệ.',
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $customer = Auth::guard('customer')->user();
        
        // Kiểm tra xem customer đã review sản phẩm này chưa
        $existingReview = Review::where('product_id', $request->product_id)
                               ->where('user_id', $customer->id)
                               ->first();

        Log::info('Checking existing review:', [
            'customer_id' => $customer->id,
            'product_id' => $request->product_id,
            'existing_review_found' => $existingReview ? 'Yes' : 'No',
            'existing_review_id' => $existingReview ? $existingReview->id : null
        ]);

        if ($existingReview) {
            Log::warning('Duplicate review attempt:', [
                'customer_id' => $customer->id,
                'product_id' => $request->product_id,
                'existing_review_id' => $existingReview->id,
                'existing_review_created' => $existingReview->created_at
            ]);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn đã đánh giá sản phẩm này rồi. Mỗi khách hàng chỉ có thể đánh giá một lần.'
                ], 422);
            }
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi. Mỗi khách hàng chỉ có thể đánh giá một lần.');
        }

        try {
            // Xử lý upload ảnh
            $imageUrls = [];
            if ($request->hasFile('images')) {
                $imageUrls = $this->uploadReviewImages($request->file('images'));
            }

            // Tạo review mới
            $review = Review::create([
                'product_id' => $request->product_id,
                'user_id' => $customer->id, // Sử dụng customer->id làm user_id
                'rating' => $request->rating,
                'title' => $request->title,
                'comment' => $request->comment,
                'images' => $imageUrls, // Lưu array ảnh
                'is_approved' => true, // Tự động approve, có thể thay đổi thành false nếu cần duyệt
            ]);
            
            Log::info('Review created successfully:', [
                'review_id' => $review->id,
                'product_id' => $request->product_id,
                'customer_id' => $customer->id,
                'rating' => $request->rating
            ]);

            // Cập nhật rating trung bình của sản phẩm
            $this->updateProductRating($request->product_id);

            // Get updated product rating
            $updatedProduct = Product::find($request->product_id);
            $updatedRating = [
                'average' => $updatedProduct->rating_average,
                'count' => $updatedProduct->rating_count
            ];

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cảm ơn bạn đã đánh giá sản phẩm!',
                    'review' => [
                        'id' => $review->id,
                        'customer_name' => $customer->name,
                        'rating' => $review->rating,
                        'title' => $review->title,
                        'comment' => $review->comment,
                        'images' => $review->images,
                        'created_at' => $review->created_at->format('d/m/Y'),
                    ],
                    'updated_rating' => $updatedRating
                ]);
            }

            return back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');

        } catch (\Exception $e) {
            Log::error('Error creating review: ' . $e->getMessage(), [
                'exception' => $e,
                'customer_id' => $customer->id,
                'product_id' => $request->product_id,
                'stack_trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi lưu đánh giá. Vui lòng thử lại.',
                    'error_details' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }
            return back()->with('error', 'Có lỗi xảy ra khi lưu đánh giá. Vui lòng thử lại.');
        }
    }

    /**
     * Update product rating average
     */
    private function updateProductRating($productId)
    {
        $product = Product::find($productId);
        if ($product) {
            $approvedReviews = Review::where('product_id', $productId)
                                   ->where('is_approved', true)
                                   ->get();
            
            if ($approvedReviews->count() > 0) {
                $averageRating = $approvedReviews->avg('rating');
                $ratingCount = $approvedReviews->count();
                
                $product->update([
                    'rating_average' => round($averageRating, 1),
                    'rating_count' => $ratingCount
                ]);
            } else {
                // No approved reviews, reset to 0
                $product->update([
                    'rating_average' => 0,
                    'rating_count' => 0
                ]);
            }
        }
    }

    /**
     * Get reviews for a product (AJAX)
     */
    public function getProductReviews(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        
        $reviews = Review::with('customer')
                        ->where('product_id', $productId)
                        ->where('is_approved', true)
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'reviews' => $reviews->items(),
                'pagination' => [
                    'current_page' => $reviews->currentPage(),
                    'last_page' => $reviews->lastPage(),
                    'total' => $reviews->total(),
                ]
            ]);
        }

        return view('products.reviews', compact('product', 'reviews'));
    }



    /**
     * Lấy ảnh đánh giá của sản phẩm (cho gallery)
     */
    public function getProductReviewImages($productId)
    {
        $reviews = Review::where('product_id', $productId)
                        ->where('is_approved', true)
                        ->whereNotNull('images')
                        ->where('images', '!=', '[]')
                        ->with('customer')
                        ->orderBy('created_at', 'desc')
                        ->get();
        
        $images = [];
        foreach ($reviews as $review) {
            if ($review->images && is_array($review->images)) {
                foreach ($review->images as $image) {
                    $images[] = [
                        'original' => $image['original'] ?? $image,
                        'thumbnail' => $image['thumbnail'] ?? $image,
                        'customer_name' => $review->customer_name,
                        'rating' => $review->rating,
                        'comment' => $review->comment,
                        'created_at' => $review->created_at->format('d/m/Y')
                    ];
                }
            }
        }
        
        return response()->json([
            'success' => true,
            'images' => $images,
            'total' => count($images)
        ]);
    }

    /**
     * Upload review images - Simple approach like admin
     */
    private function uploadReviewImages($images)
    {
        $imageUrls = [];
        
        foreach ($images as $index => $image) {
            try {
                // Tạo tên file unique
                $filename = time() . '_' . $index . '_' . $image->getClientOriginalName();
                
                // Lưu trực tiếp vào public/images/reviews/
                $destinationPath = public_path('images/reviews');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
                
                // Move file (không resize)
                $image->move($destinationPath, $filename);
                
                // Sử dụng cùng 1 file cho cả original và thumbnail
                $imageUrl = '/images/reviews/' . $filename;
                $imageUrls[] = [
                    'original' => $imageUrl,
                    'thumbnail' => $imageUrl
                ];
                
            } catch (\Exception $e) {
                Log::error('Error uploading review image: ' . $e->getMessage());
                continue;
            }
        }
        
        return $imageUrls;
    }
}
