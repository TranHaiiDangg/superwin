@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa sản phẩm')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Chỉnh sửa sản phẩm</h1>
        <a href="{{ route('admin.products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-arrow-left mr-2"></i>Quay lại
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Thông tin cơ bản -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Thông tin cơ bản</h3>
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Tên sản phẩm *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug', $product->slug) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('slug')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Danh mục *</label>
                        <select id="category_id" name="category_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Chọn danh mục</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-2">Thương hiệu</label>
                        <select id="brand_id" name="brand_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Chọn thương hiệu</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="product_type" class="block text-sm font-medium text-gray-700 mb-2">Loại sản phẩm *</label>
                        <select id="product_type" name="product_type" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Chọn loại sản phẩm</option>
                            <option value="bom" {{ old('product_type', $product->product_type) == 'bom' ? 'selected' : '' }}>Bơm</option>
                            <option value="quat" {{ old('product_type', $product->product_type) == 'quat' ? 'selected' : '' }}>Quạt</option>
                            <option value="motor" {{ old('product_type', $product->product_type) == 'motor' ? 'selected' : '' }}>Motor</option>
                        </select>
                        @error('product_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Giá và tồn kho -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-700 border-b pb-2">Giá và tồn kho</h3>
                    
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Giá gốc (VNĐ) *</label>
                        <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" min="0" step="1000" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sale_price" class="block text-sm font-medium text-gray-700 mb-2">Giá khuyến mãi (VNĐ)</label>
                        <input type="number" id="sale_price" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" min="0" step="1000"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('sale_price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-2">Số lượng tồn kho *</label>
                        <input type="number" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('stock_quantity')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="min_stock_level" class="block text-sm font-medium text-gray-700 mb-2">Mức tồn kho tối thiểu</label>
                        <input type="number" id="min_stock_level" name="min_stock_level" value="{{ old('min_stock_level', $product->min_stock_level) }}" min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('min_stock_level')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="status" name="status" value="1" {{ old('status', $product->status) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="status" class="ml-2 block text-sm text-gray-900">Kích hoạt</label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="is_featured" class="ml-2 block text-sm text-gray-900">Sản phẩm nổi bật</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mô tả -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Mô tả</h3>
                
                <div>
                    <label for="short_description" class="block text-sm font-medium text-gray-700 mb-2">Mô tả ngắn</label>
                    <textarea id="short_description" name="short_description" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('short_description', $product->short_description) }}</textarea>
                    @error('short_description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Mô tả chi tiết</label>
                    <textarea id="description" name="description" rows="6"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- SEO và Meta -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">SEO và Meta</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-2">Meta Title</label>
                        <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Tiêu đề SEO">
                        @error('meta_title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-2">Meta Keywords</label>
                        <input type="text" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $product->meta_keywords) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Từ khóa SEO (phân cách bằng dấu phẩy)">
                        @error('meta_keywords')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="meta_robots" class="block text-sm font-medium text-gray-700 mb-2">Meta Robots</label>
                        <select id="meta_robots" name="meta_robots"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="index,follow" {{ old('meta_robots', $product->meta_robots) == 'index,follow' ? 'selected' : '' }}>index,follow</option>
                            <option value="noindex,follow" {{ old('meta_robots', $product->meta_robots) == 'noindex,follow' ? 'selected' : '' }}>noindex,follow</option>
                            <option value="index,nofollow" {{ old('meta_robots', $product->meta_robots) == 'index,nofollow' ? 'selected' : '' }}>index,nofollow</option>
                            <option value="noindex,nofollow" {{ old('meta_robots', $product->meta_robots) == 'noindex,nofollow' ? 'selected' : '' }}>noindex,nofollow</option>
                        </select>
                        @error('meta_robots')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="meta_author" class="block text-sm font-medium text-gray-700 mb-2">Meta Author</label>
                        <input type="text" id="meta_author" name="meta_author" value="{{ old('meta_author', $product->meta_author) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Tác giả">
                        @error('meta_author')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="mt-4">
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Mô tả SEO">{{ old('meta_description', $product->meta_description) }}</textarea>
                    @error('meta_description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mt-4">
                    <label for="meta_canonical_url" class="block text-sm font-medium text-gray-700 mb-2">Canonical URL</label>
                    <input type="url" id="meta_canonical_url" name="meta_canonical_url" value="{{ old('meta_canonical_url', $product->meta_canonical_url) }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="https://example.com/product-url">
                    @error('meta_canonical_url')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Quản lý hình ảnh -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Quản lý hình ảnh</h3>
                
                <!-- Upload hình ảnh mới -->
                <div class="mb-6 p-4 border border-gray-200 rounded-lg bg-gray-50">
                    <h4 class="text-md font-medium text-gray-900 mb-3">Thêm hình ảnh mới</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="new_images" class="block text-sm font-medium text-gray-700 mb-2">Chọn hình ảnh</label>
                            <input type="file" id="new_images" name="new_images[]" multiple accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="flex items-end">
                            <button type="button" onclick="uploadImages()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                                <i class="fas fa-upload mr-2"></i>Tải lên
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Danh sách hình ảnh hiện tại -->
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4" id="product-images">
                    @forelse($product->images as $image)
                    <div class="relative group border border-gray-200 rounded-lg overflow-hidden" data-image-id="{{ $image->id }}">
                        <img src="{{ $image->url }}" alt="{{ $image->alt_text }}" class="w-full h-32 object-cover">
                        
                        <!-- Overlay controls -->
                        <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center space-x-2">
                            <button type="button" onclick="setAsBase({{ $image->id }})" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full {{ $image->is_base ? 'bg-green-600' : '' }}"
                                    title="{{ $image->is_base ? 'Ảnh chính' : 'Đặt làm ảnh chính' }}">
                                <i class="fas fa-star text-xs"></i>
                            </button>
                            <button type="button" onclick="deleteImage({{ $image->id }})" 
                                    class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-full"
                                    title="Xóa ảnh">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                        
                        <!-- Base image indicator -->
                        @if($image->is_base)
                        <div class="absolute top-2 right-2 bg-green-600 text-white px-2 py-1 rounded-full text-xs">
                            <i class="fas fa-star mr-1"></i>Chính
                        </div>
                        @endif
                    </div>
                    @empty
                    <div class="col-span-full text-center py-8 text-gray-500">
                        <i class="fas fa-images text-4xl mb-4"></i>
                        <p>Chưa có hình ảnh nào</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Thông số kỹ thuật -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Thông số kỹ thuật</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="power" class="block text-sm font-medium text-gray-700 mb-2">Công suất</label>
                        <input type="text" id="power" name="power" value="{{ old('power', $product->power) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="VD: 0.5 HP, 45W">
                    </div>
                    <div>
                        <label for="voltage" class="block text-sm font-medium text-gray-700 mb-2">Điện áp</label>
                        <input type="text" id="voltage" name="voltage" value="{{ old('voltage', $product->voltage) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="VD: 220V/50Hz">
                    </div>
                    <div>
                        <label for="flow_rate" class="block text-sm font-medium text-gray-700 mb-2">Lưu lượng</label>
                        <input type="text" id="flow_rate" name="flow_rate" value="{{ old('flow_rate', $product->flow_rate) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="VD: 25 L/phút">
                    </div>
                    <div>
                        <label for="pressure" class="block text-sm font-medium text-gray-700 mb-2">Áp lực/Cột áp</label>
                        <input type="text" id="pressure" name="pressure" value="{{ old('pressure', $product->pressure) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="VD: 25m">
                    </div>
                    <div>
                        <label for="efficiency" class="block text-sm font-medium text-gray-700 mb-2">Hiệu suất</label>
                        <input type="text" id="efficiency" name="efficiency" value="{{ old('efficiency', $product->efficiency) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="VD: 85%">
                    </div>
                    <div>
                        <label for="noise_level" class="block text-sm font-medium text-gray-700 mb-2">Mức ồn</label>
                        <input type="text" id="noise_level" name="noise_level" value="{{ old('noise_level', $product->noise_level) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="VD: < 65dB">
                    </div>
                    <div>
                        <label for="warranty_period" class="block text-sm font-medium text-gray-700 mb-2">Bảo hành</label>
                        <input type="text" id="warranty_period" name="warranty_period" value="{{ old('warranty_period', $product->warranty_period) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="VD: 12 tháng">
                    </div>
                </div>
            </div>

            <!-- Nút submit -->
            <div class="mt-8 flex justify-end space-x-4">
                <a href="{{ route('admin.products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                    Hủy
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    <i class="fas fa-save mr-2"></i>Cập nhật sản phẩm
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Image management functions
    function uploadImages() {
        const fileInput = document.getElementById('new_images');
        const files = fileInput.files;
        
        if (files.length === 0) {
            alert('Vui lòng chọn ít nhất một hình ảnh');
            return;
        }

        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('product_id', '{{ $product->id }}');
        
        for (let i = 0; i < files.length; i++) {
            formData.append('images[]', files[i]);
        }

        fetch('{{ route("admin.products.upload-images", $product->id) }}', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Lỗi: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi tải lên hình ảnh');
        });
    }

    function setAsBase(imageId) {
        if (!confirm('Bạn có chắc chắn muốn đặt ảnh này làm ảnh chính?')) {
            return;
        }

        fetch('{{ route("admin.products.set-base-image", $product->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ image_id: imageId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Lỗi: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra');
        });
    }

    function deleteImage(imageId) {
        if (!confirm('Bạn có chắc chắn muốn xóa ảnh này?')) {
            return;
        }

        fetch('{{ route("admin.products.delete-image", $product->id) }}', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ image_id: imageId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector(`[data-image-id="${imageId}"]`).remove();
            } else {
                alert('Lỗi: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra');
        });
    }
</script>
@endsection 