<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotSearch;
use App\Models\HotSearchItem;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class HotSearchController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', '');
        $search = $request->get('search', '');
        $status = $request->get('status', '');

        $query = HotSearch::with(['items.product', 'items.brand', 'items.category']);

        // Filter by type
        if ($type) {
            $query->where('type', $type);
        }

        // Filter by status
        if ($status !== '') {
            $query->where('is_active', $status == '1');
        }

        // Search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('keyword', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $hotSearches = $query->orderBy('sort_order', 'asc')
                           ->orderBy('created_at', 'desc')
                           ->paginate(20)
                           ->withQueryString();

        $stats = [
            'total' => HotSearch::count(),
            'active' => HotSearch::where('is_active', true)->count(),
            'inactive' => HotSearch::where('is_active', false)->count(),
            'by_type' => [
                'product' => HotSearch::where('type', HotSearch::TYPE_PRODUCT)->count(),
                'keyword' => HotSearch::where('type', HotSearch::TYPE_KEYWORD)->count(),
                'brand' => HotSearch::where('type', HotSearch::TYPE_BRAND)->count(),
                'category' => HotSearch::where('type', HotSearch::TYPE_CATEGORY)->count(),
            ]
        ];

        return view('admin.hot-searches.index', compact('hotSearches', 'stats', 'type', 'search', 'status'));
    }

    public function create()
    {
        $types = HotSearch::TYPES;
        $products = Product::where('status', true)->select('id', 'name')->orderBy('name')->get();
        $brands = Brand::where('is_active', true)->select('id', 'name')->orderBy('name')->get();
        $categories = Category::where('is_active', true)->select('id', 'name')->orderBy('name')->get();

        return view('admin.hot-searches.create', compact('types', 'products', 'brands', 'categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:' . implode(',', array_keys(HotSearch::TYPES)),
            'title' => 'required|string|max:255',
            'item' => 'nullable|integer|min:1',
            'keyword' => 'nullable|string|max:255',
            'image_url' => 'nullable|url|max:500',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'integer|min:0|max:999',
            'is_active' => 'boolean'
        ]);

        // Custom validation rules based on type
        $validator->after(function ($validator) use ($request) {
            $type = $request->input('type');
            $item = $request->input('item');
            $keyword = $request->input('keyword');

            if ($type === HotSearch::TYPE_KEYWORD) {
                if (empty($keyword)) {
                    $validator->errors()->add('keyword', 'Từ khóa là bắt buộc khi loại là "Từ khóa".');
                }
            } else {
                if (empty($item)) {
                    $validator->errors()->add('item', 'Phải chọn một mục khi không phải loại "Từ khóa".');
                } else {
                    // Validate item exists
                    $this->validateItems($validator, $type, [$item]);
                }
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::transaction(function () use ($request) {
            $data = $request->only(['type', 'title', 'keyword', 'image_url', 'description', 'sort_order', 'is_active']);
            
            // Set default max_items to 1 since we only allow single selection
            $data['max_items'] = 1;
            
            // Clean up data based on type
            if ($data['type'] === HotSearch::TYPE_KEYWORD) {
                // For keyword type, no items needed
            } else {
                $data['keyword'] = null;
            }

            $hotSearch = HotSearch::create($data);

            // Create items if not keyword type
            if ($data['type'] !== HotSearch::TYPE_KEYWORD && $request->input('item')) {
                $this->createItems($hotSearch, $data['type'], [$request->input('item')]);
            }
        });

        return redirect()->route('admin.hot-searches.index')
                        ->with('success', 'Hot search đã được tạo thành công!');
    }

    public function show(HotSearch $hotSearch)
    {
        $hotSearch->load(['items.product', 'items.brand', 'items.category']);
        return view('admin.hot-searches.show', compact('hotSearch'));
    }

    public function edit(HotSearch $hotSearch)
    {
        $types = HotSearch::TYPES;
        $products = Product::where('status', true)->select('id', 'name')->orderBy('name')->get();
        $brands = Brand::where('is_active', true)->select('id', 'name')->orderBy('name')->get();
        $categories = Category::where('is_active', true)->select('id', 'name')->orderBy('name')->get();

        $hotSearch->load(['items.product', 'items.brand', 'items.category']);

        return view('admin.hot-searches.edit', compact('hotSearch', 'types', 'products', 'brands', 'categories'));
    }

    public function update(Request $request, HotSearch $hotSearch)
    {


        $validator = Validator::make($request->all(), [
            'type' => 'required|in:' . implode(',', array_keys(HotSearch::TYPES)),
            'title' => 'required|string|max:255',
            'item' => 'nullable|integer|min:1',
            'keyword' => 'nullable|string|max:255',
            'image_url' => 'nullable|url|max:500',
            'description' => 'nullable|string|max:1000',
            'sort_order' => 'integer|min:0|max:999',
            'is_active' => 'boolean'
        ]);

        // Custom validation rules based on type
        $validator->after(function ($validator) use ($request) {
            $type = $request->input('type');
            $item = $request->input('item');
            $keyword = $request->input('keyword');


            if ($type === HotSearch::TYPE_KEYWORD) {
                if (empty($keyword)) {
                    $validator->errors()->add('keyword', 'Từ khóa là bắt buộc khi loại là "Từ khóa".');
                }
            } else {
                if (empty($item)) {
                    $validator->errors()->add('item', 'Phải chọn một mục khi không phải loại "Từ khóa".');
                } else {
                    // Validate item exists
                    $this->validateItems($validator, $type, [$item]);
                }
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::transaction(function () use ($request, $hotSearch) {
                $data = $request->only(['type', 'title', 'keyword', 'image_url', 'description', 'sort_order', 'is_active']);
                
                // Set default max_items to 1 since we only allow single selection
                $data['max_items'] = 1;
                
                // Clean up data based on type
                if ($data['type'] === HotSearch::TYPE_KEYWORD) {
                    // For keyword type, no items needed
                } else {
                    $data['keyword'] = null;
                }



                $hotSearch->update($data);

                // Delete old items and create new ones
                $hotSearch->items()->delete();

                // Create new items if not keyword type
                if ($data['type'] !== HotSearch::TYPE_KEYWORD && $request->input('item')) {
                    $this->createItems($hotSearch, $data['type'], [$request->input('item')]);
                }
            });
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Có lỗi xảy ra khi cập nhật: ' . $e->getMessage()])
                ->withInput();
        }

        return redirect()->route('admin.hot-searches.index')
                        ->with('success', 'Hot search đã được cập nhật thành công!');
    }

    public function destroy(HotSearch $hotSearch)
    {
        try {
            DB::transaction(function () use ($hotSearch) {
                $hotSearch->items()->delete();
                $hotSearch->delete();
            });
            
            return redirect()->route('admin.hot-searches.index')
                            ->with('success', 'Hot search đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.hot-searches.index')
                            ->with('error', 'Có lỗi xảy ra khi xóa hot search!');
        }
    }

    public function toggleStatus(HotSearch $hotSearch)
    {
        $hotSearch->update(['is_active' => !$hotSearch->is_active]);
        
        $status = $hotSearch->is_active ? 'kích hoạt' : 'vô hiệu hóa';
        
        return redirect()->back()->with('success', "Hot search đã được {$status} thành công!");
    }

    // API method to get reference options based on type
    public function getReferenceOptions(Request $request)
    {
        $type = $request->get('type');
        $search = $request->get('search', '');
        
        $options = [];
        
        switch ($type) {
            case HotSearch::TYPE_PRODUCT:
                $query = Product::where('status', true)->select('id', 'name');
                if ($search) {
                    $query->where('name', 'like', "%{$search}%");
                }
                $options = $query->orderBy('name')->limit(50)->get();
                break;
                
            case HotSearch::TYPE_BRAND:
                $query = Brand::where('is_active', true)->select('id', 'name');
                if ($search) {
                    $query->where('name', 'like', "%{$search}%");
                }
                $options = $query->orderBy('name')->limit(50)->get();
                break;
                
            case HotSearch::TYPE_CATEGORY:
                $query = Category::where('is_active', true)->select('id', 'name');
                if ($search) {
                    $query->where('name', 'like', "%{$search}%");
                }
                $options = $query->orderBy('name')->limit(50)->get();
                break;
        }
        
        return response()->json($options);
    }

    // Private helper methods
    private function validateItems($validator, $type, $items)
    {
        switch ($type) {
            case HotSearch::TYPE_PRODUCT:
                $existingIds = Product::where('status', true)->whereIn('id', $items)->pluck('id')->toArray();
                break;
            case HotSearch::TYPE_BRAND:
                $existingIds = Brand::where('is_active', true)->whereIn('id', $items)->pluck('id')->toArray();
                break;
            case HotSearch::TYPE_CATEGORY:
                $existingIds = Category::where('is_active', true)->whereIn('id', $items)->pluck('id')->toArray();
                break;
            default:
                return;
        }

        $invalidIds = array_diff($items, $existingIds);
        if (!empty($invalidIds)) {
            $validator->errors()->add('items', 'Một số mục đã chọn không tồn tại hoặc không hoạt động: ' . implode(', ', $invalidIds));
        }
    }

    private function createItems($hotSearch, $type, $items)
    {
        $itemType = '';
        switch ($type) {
            case HotSearch::TYPE_PRODUCT:
                $itemType = HotSearchItem::TYPE_PRODUCT;
                break;
            case HotSearch::TYPE_BRAND:
                $itemType = HotSearchItem::TYPE_BRAND;
                break;
            case HotSearch::TYPE_CATEGORY:
                $itemType = HotSearchItem::TYPE_CATEGORY;
                break;
        }

        foreach ($items as $index => $itemId) {
            HotSearchItem::create([
                'hot_search_id' => $hotSearch->id,
                'item_type' => $itemType,
                'item_id' => $itemId,
                'sort_order' => $index
            ]);
        }
    }
}