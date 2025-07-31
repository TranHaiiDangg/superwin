@extends('admin.layouts.app')

@section('title', 'Thêm sản phẩm')
@section('page-title', 'Thêm sản phẩm')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Thông tin sản phẩm</h3>
        </div>
        
        <form action="{{ route('admin.products.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Basic Information -->
                <div class="space-y-4">
                    <h4 class="text-md font-medium text-gray-900 border-b pb-2">Thông tin cơ bản</h4>
                    
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Tên sản phẩm <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Danh mục <span class="text-red-500">*</span>
                        </label>
                        <select id="category_id" name="category_id" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Chọn danh mục</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="brand_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Thương hiệu <span class="text-red-500">*</span>
                        </label>
                        <select id="brand_id" name="brand_id" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Chọn thương hiệu</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="product_type" class="block text-sm font-medium text-gray-700 mb-1">
                            Loại sản phẩm <span class="text-red-500">*</span>
                        </label>
                        <select id="product_type" name="product_type" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Chọn loại sản phẩm</option>
                            <option value="bom" {{ old('product_type') == 'bom' ? 'selected' : '' }}>Máy bơm</option>
                            <option value="quat" {{ old('product_type') == 'quat' ? 'selected' : '' }}>Quạt</option>
                            <option value="motor" {{ old('product_type') == 'motor' ? 'selected' : '' }}>Motor</option>
                            <option value="bom_chim" {{ old('product_type') == 'bom_chim' ? 'selected' : '' }}>Bơm chìm</option>
                            <option value="quat_tron" {{ old('product_type') == 'quat_tron' ? 'selected' : '' }}>Quạt tròn</option>
                        </select>
                        @error('product_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Pricing & Inventory -->
                <div class="space-y-4">
                    <h4 class="text-md font-medium text-gray-900 border-b pb-2">Giá cả & Tồn kho</h4>
                    
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">
                            Giá gốc <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" min="0" step="1000" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="0">
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="sale_price" class="block text-sm font-medium text-gray-700 mb-1">
                            Giá khuyến mãi
                        </label>
                        <input type="number" id="sale_price" name="sale_price" value="{{ old('sale_price') }}" min="0" step="1000"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="0">
                        @error('sale_price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">
                            SKU
                        </label>
                        <input type="text" id="sku" name="sku" value="{{ old('sku') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Mã sản phẩm">
                        @error('sku')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-1">
                                Số lượng tồn kho <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', 0) }}" min="0" required
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('stock_quantity')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="min_stock_level" class="block text-sm font-medium text-gray-700 mb-1">
                                Mức tồn kho tối thiểu <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="min_stock_level" name="min_stock_level" value="{{ old('min_stock_level', 5) }}" min="0" required
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('min_stock_level')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Description -->
            <div class="space-y-4">
                <h4 class="text-md font-medium text-gray-900 border-b pb-2">Mô tả</h4>
                
                <div>
                    <label for="short_description" class="block text-sm font-medium text-gray-700 mb-1">
                        Mô tả ngắn
                    </label>
                    <textarea id="short_description" name="short_description" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Mô tả ngắn gọn về sản phẩm">{{ old('short_description') }}</textarea>
                    @error('short_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                        Mô tả chi tiết
                    </label>
                    <textarea id="description" name="description" rows="6"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Mô tả chi tiết về sản phẩm">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- SEO và Meta -->
            <div class="space-y-4">
                <h4 class="text-md font-medium text-gray-900 border-b pb-2">SEO và Meta</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                        <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Tiêu đề SEO">
                        @error('meta_title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-1">Meta Keywords</label>
                        <input type="text" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Từ khóa SEO (phân cách bằng dấu phẩy)">
                        @error('meta_keywords')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="meta_robots" class="block text-sm font-medium text-gray-700 mb-1">Meta Robots</label>
                        <select id="meta_robots" name="meta_robots"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="index,follow" {{ old('meta_robots') == 'index,follow' ? 'selected' : '' }}>index,follow</option>
                            <option value="noindex,follow" {{ old('meta_robots') == 'noindex,follow' ? 'selected' : '' }}>noindex,follow</option>
                            <option value="index,nofollow" {{ old('meta_robots') == 'index,nofollow' ? 'selected' : '' }}>index,nofollow</option>
                            <option value="noindex,nofollow" {{ old('meta_robots') == 'noindex,nofollow' ? 'selected' : '' }}>noindex,nofollow</option>
                        </select>
                        @error('meta_robots')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="meta_author" class="block text-sm font-medium text-gray-700 mb-1">Meta Author</label>
                        <input type="text" id="meta_author" name="meta_author" value="{{ old('meta_author') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Tác giả">
                        @error('meta_author')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Mô tả SEO">{{ old('meta_description') }}</textarea>
                    @error('meta_description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="meta_canonical_url" class="block text-sm font-medium text-gray-700 mb-1">Canonical URL</label>
                    <input type="url" id="meta_canonical_url" name="meta_canonical_url" value="{{ old('meta_canonical_url') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="https://example.com/product-url">
                    @error('meta_canonical_url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Thông số kỹ thuật -->
            <div class="space-y-4">
                <h4 class="text-md font-medium text-gray-900 border-b pb-2">Thông số kỹ thuật</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="power" class="block text-sm font-medium text-gray-700 mb-1">Công suất</label>
                        <input type="text" id="power" name="power" value="{{ old('power') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="VD: 0.5 HP, 45W">
                        @error('power')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="voltage" class="block text-sm font-medium text-gray-700 mb-1">Điện áp</label>
                        <input type="text" id="voltage" name="voltage" value="{{ old('voltage') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="VD: 220V/50Hz">
                        @error('voltage')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="flow_rate" class="block text-sm font-medium text-gray-700 mb-1">Lưu lượng</label>
                        <input type="text" id="flow_rate" name="flow_rate" value="{{ old('flow_rate') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="VD: 25 L/phút">
                        @error('flow_rate')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="pressure" class="block text-sm font-medium text-gray-700 mb-1">Áp lực/Cột áp</label>
                        <input type="text" id="pressure" name="pressure" value="{{ old('pressure') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="VD: 25m">
                        @error('pressure')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="efficiency" class="block text-sm font-medium text-gray-700 mb-1">Hiệu suất</label>
                        <input type="text" id="efficiency" name="efficiency" value="{{ old('efficiency') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="VD: 85%">
                        @error('efficiency')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="noise_level" class="block text-sm font-medium text-gray-700 mb-1">Mức ồn</label>
                        <input type="text" id="noise_level" name="noise_level" value="{{ old('noise_level') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="VD: < 65dB">
                        @error('noise_level')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="warranty_period" class="block text-sm font-medium text-gray-700 mb-1">Bảo hành</label>
                        <input type="text" id="warranty_period" name="warranty_period" value="{{ old('warranty_period') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="VD: 12 tháng">
                        @error('warranty_period')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Settings -->
            <div class="space-y-4">
                <h4 class="text-md font-medium text-gray-900 border-b pb-2">Cài đặt</h4>
                
                <div class="flex items-center space-x-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="status" name="status" value="1" {{ old('status', true) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="status" class="ml-2 block text-sm text-gray-900">
                            Hoạt động
                        </label>
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                            Sản phẩm nổi bật
                        </label>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="flex justify-end space-x-4 pt-6 border-t">
                <a href="{{ route('admin.products.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                    Hủy
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    Thêm sản phẩm
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 