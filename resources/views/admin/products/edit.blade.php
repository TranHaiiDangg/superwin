@extends('admin.layouts.app')

@section('title', 'Chỉnh sửa sản phẩm')
@section('page-title', 'Chỉnh sửa sản phẩm')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Chỉnh sửa sản phẩm: {{ $product->name }}</h3>
                <a href="{{ route('admin.products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-arrow-left mr-2"></i>Quay lại
                </a>
            </div>
        </div>
        
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Tab Navigation -->
            <div class="px-6 pt-6">
                <nav class="flex space-x-8" aria-label="Tabs">
                    <button type="button" onclick="switchTab('basic')" id="tab-basic" 
                            class="tab-button active whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                        <i class="fas fa-info-circle mr-2"></i>Thông tin cơ bản
                    </button>
                    <button type="button" onclick="switchTab('seo')" id="tab-seo" 
                            class="tab-button whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                        <i class="fas fa-search mr-2"></i>SEO & Meta
                    </button>
                    <button type="button" onclick="switchTab('attributes')" id="tab-attributes" 
                            class="tab-button whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                        <i class="fas fa-cogs mr-2"></i>Thuộc tính
                    </button>
                    <button type="button" onclick="switchTab('variants')" id="tab-variants" 
                            class="tab-button whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                        <i class="fas fa-layer-group mr-2"></i>Phân loại
                    </button>
                </nav>
            </div>
            
            <!-- Tab Content -->
            <div class="px-6 pb-6">
                <!-- Tab 1: Basic Information -->
                <div id="content-basic" class="tab-content space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Information -->
                        <div class="space-y-4">
                            <h4 class="text-md font-medium text-gray-900 border-b pb-2">Thông tin cơ bản</h4>
                            
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                    Tên sản phẩm <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">
                                    Slug
                                </label>
                                <input type="text" id="slug" name="slug" value="{{ old('slug', $product->slug) }}"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('slug')
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
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                                        <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('brand_id')
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
                                <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" min="0" step="1000" required
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
                                <input type="number" id="sale_price" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" min="0" step="1000"
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
                                <div class="flex space-x-2">
                                    <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}"
                                           class="flex-1 border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="Mã sản phẩm (để trống để tự động tạo)">
                                    <button type="button" onclick="generateSKUPreview()" class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg">
                                        <i class="fas fa-magic"></i>
                                    </button>
                                </div>
                                <small class="text-gray-500">Để trống để hệ thống tự động tạo SKU</small>
                                @error('sku')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-1">
                                        Số lượng tồn kho <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0" required
                                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('stock_quantity')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="min_stock_level" class="block text-sm font-medium text-gray-700 mb-1">
                                        Mức tồn kho tối thiểu <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" id="min_stock_level" name="min_stock_level" value="{{ old('min_stock_level', $product->min_stock_level) }}" min="0" required
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
                                      placeholder="Mô tả ngắn gọn về sản phẩm">{{ old('short_description', $product->short_description) }}</textarea>
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
                                      placeholder="Mô tả chi tiết về sản phẩm">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Product Images -->
                    <div class="space-y-4">
                        <h4 class="text-md font-medium text-gray-900 border-b pb-2">Hình ảnh sản phẩm</h4>
                        
                        <!-- Existing Images -->
                        <div id="existing-images" class="space-y-4">
                            <h5 class="text-sm font-medium text-gray-700">Hình ảnh hiện tại:</h5>
                            <div id="existing-images-grid" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach($product->images as $image)
                                <div class="relative group" data-image-id="{{ $image->id }}">
                                    <img src="{{ asset($image->url) }}" 
                                         alt="{{ $image->alt_text }}" 
                                         class="w-full h-24 object-cover rounded-lg border border-gray-200 {{ $image->is_base ? 'ring-2 ring-blue-500' : '' }}">
                                    
                                    @if($image->is_base)
                                    <div class="absolute top-1 left-1 bg-blue-500 text-white text-xs px-2 py-1 rounded">
                                        Ảnh chính
                                    </div>
                                    @endif
                                    
                                    <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center space-x-2">
                                        @if(!$image->is_base)
                                        <button type="button" onclick="setAsBaseImage({{ $image->id }})"
                                                class="bg-blue-500 text-white px-2 py-1 rounded text-xs hover:bg-blue-600">
                                            <i class="fas fa-star"></i>
                                        </button>
                                        @endif
                                        @if($product->images->count() > 1)
                                        <button type="button" onclick="deleteExistingImage({{ $image->id }})"
                                                class="bg-red-500 text-white px-2 py-1 rounded text-xs hover:bg-red-600">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Add New Images -->
                        <div class="space-y-4">
                            <h5 class="text-sm font-medium text-gray-700">Thêm hình ảnh mới:</h5>
                            <div>
                                <div class="flex items-center justify-center w-full">
                                    <label for="product-images" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                            <p class="mb-2 text-sm text-gray-500">
                                                <span class="font-semibold">Nhấn để chọn ảnh</span> hoặc kéo thả
                                            </p>
                                            <p class="text-xs text-gray-500">PNG, JPG, GIF (tối đa 2MB mỗi ảnh)</p>
                                        </div>
                                        <input id="product-images" name="images[]" type="file" class="hidden" multiple accept="image/*" onchange="previewNewImages(this)">
                                    </label>
                                </div>
                            </div>
                            
                            <!-- New Image Preview Container -->
                            <div id="new-image-preview-container" class="hidden">
                                <h6 class="text-sm font-medium text-gray-700 mb-2">Xem trước hình ảnh mới:</h6>
                                <div id="new-image-preview-grid" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <!-- Preview images will be added here -->
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Settings -->
                    <div class="space-y-4">
                        <h4 class="text-md font-medium text-gray-900 border-b pb-2">Cài đặt</h4>
                        
                        <div class="flex items-center space-x-6">
                            <div class="flex items-center">
                                <input type="checkbox" id="status" name="status" value="1" {{ old('status', $product->status) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="status" class="ml-2 block text-sm text-gray-900">
                                    Hoạt động
                                </label>
                            </div>
                            
                            <div class="flex items-center">
                                <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                                    <i class="fas fa-star mr-1 text-yellow-500"></i>Sản phẩm nổi bật
                                </label>
                            </div>
                            
                            <div class="flex items-center">
                                <input type="checkbox" id="is_sale" name="is_sale" value="1" {{ old('is_sale', $product->is_sale) ? 'checked' : '' }}
                                       class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                                <label for="is_sale" class="ml-2 block text-sm text-gray-900">
                                    <i class="fas fa-fire mr-1 text-red-500"></i>Sản phẩm khuyến mãi
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tab 2: SEO & Meta -->
                <div id="content-seo" class="tab-content hidden space-y-6">
                    <div class="space-y-4">
                        <h4 class="text-md font-medium text-gray-900 border-b pb-2">Thông tin SEO</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fas fa-heading mr-1 text-blue-500"></i>Meta Title
                                </label>
                                <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $product->meta_title) }}"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="Tiêu đề SEO (tối đa 60 ký tự)"
                                       maxlength="60">
                                <div class="text-xs text-gray-500 mt-1">
                                    <span id="meta-title-count">0</span>/60 ký tự
                                </div>
                                @error('meta_title')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fas fa-tags mr-1 text-green-500"></i>Meta Keywords
                                </label>
                                <input type="text" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $product->meta_keywords) }}"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="Từ khóa SEO (phân cách bằng dấu phẩy)">
                                @error('meta_keywords')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="meta_robots" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fas fa-robot mr-1 text-purple-500"></i>Meta Robots
                                </label>
                                <select id="meta_robots" name="meta_robots"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="index,follow" {{ old('meta_robots', $product->meta_robots) == 'index,follow' ? 'selected' : '' }}>index,follow (Mặc định)</option>
                                    <option value="noindex,follow" {{ old('meta_robots', $product->meta_robots) == 'noindex,follow' ? 'selected' : '' }}>noindex,follow</option>
                                    <option value="index,nofollow" {{ old('meta_robots', $product->meta_robots) == 'index,nofollow' ? 'selected' : '' }}>index,nofollow</option>
                                    <option value="noindex,nofollow" {{ old('meta_robots', $product->meta_robots) == 'noindex,nofollow' ? 'selected' : '' }}>noindex,nofollow</option>
                                </select>
                                @error('meta_robots')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="meta_author" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fas fa-user-edit mr-1 text-orange-500"></i>Meta Author
                                </label>
                                <input type="text" id="meta_author" name="meta_author" value="{{ old('meta_author', $product->meta_author) }}"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="Tác giả">
                                @error('meta_author')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-align-left mr-1 text-indigo-500"></i>Meta Description
                            </label>
                            <textarea id="meta_description" name="meta_description" rows="3"
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="Mô tả SEO (tối đa 160 ký tự)"
                                      maxlength="160">{{ old('meta_description', $product->meta_description) }}</textarea>
                            <div class="text-xs text-gray-500 mt-1">
                                <span id="meta-desc-count">0</span>/160 ký tự
                            </div>
                            @error('meta_description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="meta_canonical_url" class="block text-sm font-medium text-gray-700 mb-1">
                                <i class="fas fa-link mr-1 text-red-500"></i>Canonical URL
                            </label>
                            <input type="url" id="meta_canonical_url" name="meta_canonical_url" value="{{ old('meta_canonical_url', $product->meta_canonical_url) }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="https://example.com/product-url">
                            @error('meta_canonical_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Tab 3: Product Attributes -->
                <div id="content-attributes" class="tab-content hidden space-y-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <h4 class="text-md font-medium text-gray-900 border-b pb-2 flex-1">Thông số kỹ thuật</h4>
                            <div class="ml-4 space-x-2">
                                <button type="button" onclick="addAttribute()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                                    <i class="fas fa-plus mr-2"></i>Thêm thuộc tính
                                </button>
                                <button type="button" onclick="saveAttributes()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                                    <i class="fas fa-save mr-2"></i>Cập nhật thuộc tính
                                </button>
                            </div>
                        </div>
                        
                        <div id="product-attributes">
                            <div id="attributes-container" class="space-y-4">
                                <!-- Existing attributes will be loaded here -->
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tab 4: Product Variants -->
                <div id="content-variants" class="tab-content hidden space-y-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <h4 class="text-md font-medium text-gray-900 border-b pb-2 flex-1">Phân loại sản phẩm</h4>
                            <div class="ml-4 space-x-2">
                                <button type="button" onclick="addVariant()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                                    <i class="fas fa-plus mr-2"></i>Thêm phân loại
                                </button>
                                <button type="button" onclick="saveVariants()" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg">
                                    <i class="fas fa-save mr-2"></i>Lưu phân loại
                                </button>
                            </div>
                        </div>
                        
                        <div id="product-variants">
                            <div id="variants-container" class="space-y-4">
                                <!-- Dynamic variants will be loaded here -->
                                <div class="text-center py-8 text-gray-500" id="no-variants-message">
                                    <i class="fas fa-layer-group text-4xl mb-4"></i>
                                    <p>Đang tải phân loại...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="flex justify-end space-x-4 px-6 py-4 border-t bg-gray-50">
                <a href="{{ route('admin.products.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                    <i class="fas fa-times mr-2"></i>Hủy
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    <i class="fas fa-save mr-2"></i>Cập nhật sản phẩm
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.tab-button {
    border-bottom-color: transparent;
    color: #6B7280;
    transition: all 0.2s;
}

.tab-button:hover {
    color: #374151;
    border-bottom-color: #D1D5DB;
}

.tab-button.active {
    color: #3B82F6;
    border-bottom-color: #3B82F6;
}

.tab-content {
    min-height: 400px;
}

.attribute-row {
    transition: all 0.3s ease;
}

.attribute-row:hover {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}
</style>

<script>
// Tab Management
function switchTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Remove active class from all tab buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active');
    });
    
    // Show selected tab content
    document.getElementById('content-' + tabName).classList.remove('hidden');
    
    // Add active class to selected tab button
    document.getElementById('tab-' + tabName).classList.add('active');
}

// Character counters for SEO fields
document.addEventListener('DOMContentLoaded', function() {
    const metaTitle = document.getElementById('meta_title');
    const metaTitleCount = document.getElementById('meta-title-count');
    const metaDesc = document.getElementById('meta_description');
    const metaDescCount = document.getElementById('meta-desc-count');
    
    if (metaTitle && metaTitleCount) {
        metaTitle.addEventListener('input', function() {
            metaTitleCount.textContent = this.value.length;
        });
        metaTitleCount.textContent = metaTitle.value.length;
    }
    
    if (metaDesc && metaDescCount) {
        metaDesc.addEventListener('input', function() {
            metaDescCount.textContent = this.value.length;
        });
        metaDescCount.textContent = metaDesc.value.length;
    }
    
    // Add event listeners for buttons
    const addAttributeBtn = document.querySelector('button[onclick="addAttribute()"]');
    if (addAttributeBtn) {
        addAttributeBtn.removeAttribute('onclick');
        addAttributeBtn.addEventListener('click', function() {
            console.log('Add attribute button clicked');
            addAttribute();
        });
    }
    
    // Add event listener for image upload
    const imageInput = document.getElementById('product-images');
    if (imageInput) {
        imageInput.removeAttribute('onchange');
        imageInput.addEventListener('change', function() {
            console.log('Image input changed');
            previewNewImages(this);
        });
    }
    
    // Add event listeners for existing image management buttons
    document.querySelectorAll('button[onclick^="setAsBaseImage"]').forEach(btn => {
        const imageId = btn.getAttribute('onclick').match(/\d+/)[0];
        btn.removeAttribute('onclick');
        btn.addEventListener('click', function() {
            setAsBaseImage(imageId);
        });
    });
    
    document.querySelectorAll('button[onclick^="deleteExistingImage"]').forEach(btn => {
        const imageId = btn.getAttribute('onclick').match(/\d+/)[0];
        btn.removeAttribute('onclick');
        btn.addEventListener('click', function() {
            deleteExistingImage(imageId);
        });
    });
    
    // Load existing attributes
    loadExistingAttributes();
});

// Product Attributes Management
const commonUnits = @json(\App\Models\ProductAttribute::getCommonUnits());
const commonKeys = @json(\App\Models\ProductAttribute::getCommonAttributeKeys());
const productId = {{ $product->id }};
let attributeIndex = 0;

function loadExistingAttributes() {
    fetch(`/admin/products/${productId}/attributes`)
        .then(response => response.json())
        .then(attributes => {
            const container = document.getElementById('attributes-container');
            container.innerHTML = '';
            
            if (attributes.length === 0) {
                container.innerHTML = `
                    <div class="text-center py-8 text-gray-500" id="no-attributes-message">
                        <i class="fas fa-cogs text-4xl mb-4"></i>
                        <p>Chưa có thuộc tính nào. Nhấn "Thêm thuộc tính" để bắt đầu.</p>
                    </div>
                `;
            } else {
                attributes.forEach(attribute => {
                    addExistingAttribute(attribute);
                });
            }
        })
        .catch(error => {
            console.error('Error loading attributes:', error);
        });
}

function addExistingAttribute(attribute) {
    const container = document.getElementById('attributes-container');
    const attributeRow = document.createElement('div');
    attributeRow.className = 'attribute-row border border-gray-200 rounded-lg p-4 bg-white hover:shadow-md transition-shadow';
    attributeRow.setAttribute('data-index', attributeIndex);
    
    attributeRow.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-tag mr-1 text-blue-500"></i>Thuộc tính
                </label>
                <input type="text" name="attributes[${attributeIndex}][attribute_key]" value="${attribute.attribute_key || ''}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Nhập tên thuộc tính (VD: Công suất, Điện áp, Lưu lượng...)">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-edit mr-1 text-green-500"></i>Giá trị
                </label>
                <input type="text" name="attributes[${attributeIndex}][attribute_value]" value="${attribute.attribute_value || ''}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Nhập giá trị">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-ruler mr-1 text-purple-500"></i>Đơn vị
                </label>
                <input type="text" name="attributes[${attributeIndex}][attribute_unit]" value="${attribute.attribute_unit || ''}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="VD: HP, V, L/phút, m, %...">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-sort-numeric-down mr-1 text-orange-500"></i>Thứ tự
                </label>
                <input type="number" name="attributes[${attributeIndex}][sort_order]" value="${attribute.sort_order || attributeIndex}" min="0"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <button type="button" class="remove-attribute-btn bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg transition-colors">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-info-circle mr-1 text-indigo-500"></i>Mô tả
            </label>
            <input type="text" name="attributes[${attributeIndex}][attribute_description]" value="${attribute.attribute_description || ''}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="Mô tả thuộc tính">
        </div>
        <input type="hidden" name="attributes[${attributeIndex}][is_visible]" value="1">
    `;
    
    container.appendChild(attributeRow);
    
    // Add event listeners after adding to DOM
    const removeBtn = attributeRow.querySelector('.remove-attribute-btn');
    
    removeBtn.addEventListener('click', function() {
        removeAttribute(this);
    });
    
    attributeIndex++;
}

function addAttribute() {
    const container = document.getElementById('attributes-container');
    const noMessage = document.getElementById('no-attributes-message');
    
    // Hide no attributes message
    if (noMessage) {
        noMessage.style.display = 'none';
    }
    
    const attributeRow = document.createElement('div');
    attributeRow.className = 'attribute-row border border-gray-200 rounded-lg p-4 bg-white hover:shadow-md transition-shadow';
    attributeRow.setAttribute('data-index', attributeIndex);
    
    attributeRow.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-tag mr-1 text-blue-500"></i>Thuộc tính
                </label>
                <input type="text" name="attributes[${attributeIndex}][attribute_key]"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Nhập tên thuộc tính (VD: Công suất, Điện áp, Lưu lượng...)">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-edit mr-1 text-green-500"></i>Giá trị
                </label>
                <input type="text" name="attributes[${attributeIndex}][attribute_value]" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="Nhập giá trị">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-ruler mr-1 text-purple-500"></i>Đơn vị
                </label>
                <input type="text" name="attributes[${attributeIndex}][attribute_unit]"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       placeholder="VD: HP, V, L/phút, m, %...">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-sort-numeric-down mr-1 text-orange-500"></i>Thứ tự
                </label>
                <input type="number" name="attributes[${attributeIndex}][sort_order]" value="${attributeIndex}" min="0"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <button type="button" class="remove-attribute-btn bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg transition-colors">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
        <div class="mt-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                <i class="fas fa-info-circle mr-1 text-indigo-500"></i>Mô tả
            </label>
            <input type="text" name="attributes[${attributeIndex}][attribute_description]"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                   placeholder="Mô tả thuộc tính">
        </div>
        <input type="hidden" name="attributes[${attributeIndex}][is_visible]" value="1">
    `;
    
    container.appendChild(attributeRow);
    
    // Add event listeners after adding to DOM
    const removeBtn = attributeRow.querySelector('.remove-attribute-btn');
    
    removeBtn.addEventListener('click', function() {
        removeAttribute(this);
    });
    
    attributeIndex++;
}

function removeAttribute(button) {
    const attributeRow = button.closest('.attribute-row');
    const container = document.getElementById('attributes-container');
    
    if (confirm('Bạn có chắc muốn xóa thuộc tính này?')) {
        attributeRow.remove();
        
        // Show no attributes message if no attributes left
        const remainingRows = container.querySelectorAll('.attribute-row');
        if (remainingRows.length === 0) {
            container.innerHTML = `
                <div class="text-center py-8 text-gray-500" id="no-attributes-message">
                    <i class="fas fa-cogs text-4xl mb-4"></i>
                    <p>Chưa có thuộc tính nào. Nhấn "Thêm thuộc tính" để bắt đầu.</p>
                </div>
            `;
        }
    }
}

function saveAttributes() {
    const saveBtn = event.target;
    const originalText = saveBtn.innerHTML;
    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Đang lưu...';
    saveBtn.disabled = true;

    // Collect all attribute data
    const attributes = [];
    const attributeRows = document.querySelectorAll('.attribute-row');
    
    attributeRows.forEach(row => {
        const attributeKey = row.querySelector('[name*="[attribute_key]"]').value;
        const attributeValue = row.querySelector('[name*="[attribute_value]"]').value;
        const attributeUnit = row.querySelector('[name*="[attribute_unit]"]').value;
        const attributeDescription = row.querySelector('[name*="[attribute_description]"]').value;
        const sortOrder = row.querySelector('[name*="[sort_order]"]').value;
        const isVisible = row.querySelector('[name*="[is_visible]"]').value;
        
        if (attributeKey.trim()) {
            attributes.push({
                attribute_key: attributeKey,
                attribute_value: attributeValue,
                attribute_unit: attributeUnit,
                attribute_description: attributeDescription,
                sort_order: parseInt(sortOrder) || 0,
                is_visible: isVisible === '1'
            });
        }
    });

    // Send AJAX request
    fetch(`/admin/products/${productId}/attributes`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ attributes: attributes })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Cập nhật thuộc tính thành công!');
            window.location.reload(); // Reload toàn trang
        } else {
            alert('Lỗi: ' + (data.message || 'Unknown error'));
            saveBtn.innerHTML = originalText;
            saveBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error saving attributes:', error);
        alert('Có lỗi xảy ra khi lưu thuộc tính');
        saveBtn.innerHTML = originalText;
        saveBtn.disabled = false;
    });
}

// Function removed - no longer using dropdown for units

// Image Management Functions
function previewNewImages(input) {
    const container = document.getElementById('new-image-preview-container');
    const grid = document.getElementById('new-image-preview-grid');
    
    if (input.files && input.files.length > 0) {
        container.classList.remove('hidden');
        grid.innerHTML = '';
        
        Array.from(input.files).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageDiv = document.createElement('div');
                    imageDiv.className = 'relative group';
                    imageDiv.innerHTML = `
                        <img src="${e.target.result}" 
                             alt="Preview ${index + 1}" 
                             class="w-full h-24 object-cover rounded-lg border border-gray-200">
                        <button type="button" 
                                onclick="removeNewImagePreview(this, ${index})"
                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs p-1 rounded-b-lg">
                            ${file.name}
                        </div>
                    `;
                    grid.appendChild(imageDiv);
                };
                reader.readAsDataURL(file);
            }
        });
    } else {
        container.classList.add('hidden');
    }
}

function removeNewImagePreview(button, index) {
    const input = document.getElementById('product-images');
    const dt = new DataTransfer();
    
    // Add all files except the one to remove
    Array.from(input.files).forEach((file, i) => {
        if (i !== index) {
            dt.items.add(file);
        }
    });
    
    input.files = dt.files;
    previewNewImages(input);
}

function setAsBaseImage(imageId) {
    if (confirm('Đặt ảnh này làm ảnh chính?')) {
        fetch(`/admin/products/${productId}/set-base-image`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ image_id: imageId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove ring from all images
                document.querySelectorAll('#existing-images-grid img').forEach(img => {
                    img.classList.remove('ring-2', 'ring-blue-500');
                });
                
                // Remove all "Ảnh chính" badges
                document.querySelectorAll('#existing-images-grid .absolute.top-1.left-1').forEach(badge => {
                    badge.remove();
                });
                
                // Add ring to selected image
                const selectedImage = document.querySelector(`[data-image-id="${imageId}"] img`);
                selectedImage.classList.add('ring-2', 'ring-blue-500');
                
                // Add "Ảnh chính" badge
                const selectedContainer = document.querySelector(`[data-image-id="${imageId}"]`);
                const badge = document.createElement('div');
                badge.className = 'absolute top-1 left-1 bg-blue-500 text-white text-xs px-2 py-1 rounded';
                badge.textContent = 'Ảnh chính';
                selectedContainer.appendChild(badge);
                
                alert(data.message);
            } else {
                alert('Lỗi: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi đặt ảnh chính');
        });
    }
}

function deleteExistingImage(imageId) {
    if (confirm('Bạn có chắc muốn xóa ảnh này?')) {
        fetch(`/admin/products/${productId}/delete-image`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ image_id: imageId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the image from DOM
                document.querySelector(`[data-image-id="${imageId}"]`).remove();
                alert(data.message);
            } else {
                alert('Lỗi: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi xóa ảnh');
        });
    }
}

// SKU Generation Functions
function generateSKUPreview() {
    const categorySelect = document.getElementById('category_id');
    const brandSelect = document.getElementById('brand_id');
    
    const skuInput = document.getElementById('sku');
    
    let prefix = 'SP';
    
    // Add category prefix
    if (categorySelect.value) {
        const categoryText = categorySelect.options[categorySelect.selectedIndex].text;
        prefix += categoryText.substring(0, 2).toUpperCase();
    }
    
    // Add brand prefix
    if (brandSelect.value) {
        const brandText = brandSelect.options[brandSelect.selectedIndex].text;
        prefix += brandText.substring(0, 2).toUpperCase();
    }
    
    // Add product type prefix
    // if (productTypeSelect.value) {
    //     const typeMap = {
    //         'bom': 'BM',
    //         'quat': 'QT',
    //         'motor': 'MT',
    //         'bom_chim': 'BC',
    //         'quat_tron': 'QR'
    //     };
    //     prefix += typeMap[productTypeSelect.value] || 'SP';
    // }
    
    // Generate preview with random number
    const randomNum = Math.floor(Math.random() * 9999) + 1;
    const sku = prefix + String(randomNum).padStart(4, '0');
    
    skuInput.value = sku;
    skuInput.focus();
}

// Product Variants Management for Edit
let variantIndex = 0;

function loadExistingVariants() {
    const container = document.getElementById('variants-container');
    const noMessage = document.getElementById('no-variants-message');
    
    if (!container || !noMessage) {
        return; // Silently fail if elements not found
    }
    
    // Show loading message
    noMessage.innerHTML = '<i class="fas fa-spinner fa-spin text-4xl mb-4"></i><p>Đang tải phân loại...</p>';
    noMessage.style.display = 'block';
    
    fetch(`/admin/products/${productId}/variants`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                container.innerHTML = '';
                
                if (data.variants.length === 0) {
                    noMessage.innerHTML = '<i class="fas fa-layer-group text-4xl mb-4"></i><p>Chưa có phân loại nào. Nhấn "Thêm phân loại" để bắt đầu.</p>';
                    noMessage.style.display = 'block';
                } else {
                    noMessage.style.display = 'none';
                    data.variants.forEach(variant => {
                        addExistingVariant(variant);
                    });
                }
            } else {
                noMessage.innerHTML = '<i class="fas fa-layer-group text-4xl mb-4"></i><p>Chưa có phân loại nào. Nhấn "Thêm phân loại" để bắt đầu.</p>';
                noMessage.style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error loading variants:', error);
            noMessage.innerHTML = '<i class="fas fa-layer-group text-4xl mb-4"></i><p>Chưa có phân loại nào. Nhấn "Thêm phân loại" để bắt đầu.</p>';
            noMessage.style.display = 'block';
        });
}

function addExistingVariant(variant) {
    const container = document.getElementById('variants-container');
    const variantRow = document.createElement('div');
    variantRow.className = 'variant-row border border-gray-200 rounded-lg p-4 bg-white hover:shadow-md transition-shadow';
    variantRow.setAttribute('data-index', variantIndex);
    variantRow.setAttribute('data-id', variant.id);
    
    variantRow.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-tag mr-1 text-blue-500"></i>Tên phân loại <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="variants[${variantIndex}][name]" 
                       value="${variant.name || ''}"
                       placeholder="VD: Máy bơm nhật"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-code mr-1 text-green-500"></i>Mã phân loại <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="variants[${variantIndex}][code]" 
                       value="${variant.code || ''}"
                       placeholder="VD: MBN1"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-dollar-sign mr-1 text-yellow-500"></i>Giá <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       name="variants[${variantIndex}][price]" 
                       value="${variant.price || 0}"
                       placeholder="0"
                       min="0"
                       step="0.01"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-percentage mr-1 text-red-500"></i>Giá khuyến mãi
                </label>
                <input type="number" 
                       name="variants[${variantIndex}][price_sale]" 
                       value="${variant.price_sale || ''}"
                       placeholder="0"
                       min="0"
                       step="0.01"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-boxes mr-1 text-purple-500"></i>Số lượng <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       name="variants[${variantIndex}][quantity]" 
                       value="${variant.quantity || 0}"
                       placeholder="0"
                       min="0"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>
            
            <div class="flex space-x-2">
                <label class="inline-flex items-center">
                    <input type="checkbox" 
                           name="variants[${variantIndex}][is_active]" 
                           value="1" 
                           ${variant.is_active ? 'checked' : ''}
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">Hoạt động</span>
                </label>
                <button type="button" 
                        onclick="removeVariant(this)" 
                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md text-sm">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            
            <input type="hidden" name="variants[${variantIndex}][id]" value="${variant.id || ''}">
            <input type="hidden" name="variants[${variantIndex}][sort_order]" value="${variant.sort_order || variantIndex}">
        </div>
    `;
    
    container.appendChild(variantRow);
    variantIndex++;
}

function addVariant() {
    const container = document.getElementById('variants-container');
    const noMessage = document.getElementById('no-variants-message');
    
    // Hide no variants message
    if (noMessage) {
        noMessage.style.display = 'none';
    }
    
    const variantRow = document.createElement('div');
    variantRow.className = 'variant-row border border-gray-200 rounded-lg p-4 bg-white hover:shadow-md transition-shadow';
    variantRow.setAttribute('data-index', variantIndex);
    
    variantRow.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-tag mr-1 text-blue-500"></i>Tên phân loại <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="variants[${variantIndex}][name]" 
                       placeholder="VD: Máy bơm nhật"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-code mr-1 text-green-500"></i>Mã phân loại <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="variants[${variantIndex}][code]" 
                       placeholder="VD: MBN1"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-dollar-sign mr-1 text-yellow-500"></i>Giá <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       name="variants[${variantIndex}][price]" 
                       placeholder="0"
                       min="0"
                       step="0.01"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-percentage mr-1 text-red-500"></i>Giá khuyến mãi
                </label>
                <input type="number" 
                       name="variants[${variantIndex}][price_sale]" 
                       placeholder="0"
                       min="0"
                       step="0.01"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    <i class="fas fa-boxes mr-1 text-purple-500"></i>Số lượng <span class="text-red-500">*</span>
                </label>
                <input type="number" 
                       name="variants[${variantIndex}][quantity]" 
                       placeholder="0"
                       min="0"
                       value="0"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
            </div>
            
            <div class="flex space-x-2">
                <label class="inline-flex items-center">
                    <input type="checkbox" 
                           name="variants[${variantIndex}][is_active]" 
                           value="1" 
                           checked
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-sm text-gray-600">Hoạt động</span>
                </label>
                <button type="button" 
                        onclick="removeVariant(this)" 
                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md text-sm">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
            
            <input type="hidden" name="variants[${variantIndex}][sort_order]" value="${variantIndex}">
        </div>
    `;
    
    container.appendChild(variantRow);
    variantIndex++;
}

function removeVariant(button) {
    const variantRow = button.closest('.variant-row');
    const container = document.getElementById('variants-container');
    const noMessage = document.getElementById('no-variants-message');
    
    variantRow.remove();
    
    // Show no variants message if no variants left
    const remainingVariants = container.querySelectorAll('.variant-row');
    if (remainingVariants.length === 0 && noMessage) {
        noMessage.innerHTML = '<i class="fas fa-layer-group text-4xl mb-4"></i><p>Chưa có phân loại nào. Nhấn "Thêm phân loại" để bắt đầu.</p>';
        noMessage.style.display = 'block';
    }
}

function saveVariants() {
    const container = document.getElementById('variants-container');
    
    if (!container) {
        alert('Lỗi: Không tìm thấy container. Vui lòng chuyển sang tab Phân loại trước.');
        return;
    }
    
    const variantRows = container.querySelectorAll('.variant-row');
    const variants = [];
    
    variantRows.forEach(row => {
        const inputs = row.querySelectorAll('input');
        const variant = {};
        
        inputs.forEach(input => {
            const name = input.name;
            if (name && name.includes('variants[')) {
                const field = name.match(/variants\[\d+\]\[(\w+)\]/)[1];
                if (input.type === 'checkbox') {
                    variant[field] = input.checked ? 1 : 0;
                } else {
                    variant[field] = input.value;
                }
            }
        });
        
        if (variant.name && variant.code) {
            variants.push(variant);
        }
    });
    
    if (variants.length === 0) {
        alert('Vui lòng thêm ít nhất một phân loại!');
        return;
    }
    
    // Show loading
    const saveBtn = document.querySelector('button[onclick="saveVariants()"]');
    const originalText = saveBtn.innerHTML;
    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Đang lưu...';
    saveBtn.disabled = true;
    
    fetch(`/admin/products/${productId}/variants/bulk-update`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ variants: variants })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Lưu phân loại thành công!');
            window.location.reload(); // Reload toàn page
        } else {
            alert('Lỗi: ' + (data.message || 'Unknown error'));
            saveBtn.innerHTML = originalText;
            saveBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error saving variants:', error);
        alert('Có lỗi xảy ra khi lưu phân loại');
        saveBtn.innerHTML = originalText;
        saveBtn.disabled = false;
    });
}

// Load existing variants when variants tab is activated
let variantsLoaded = false;

// Override switchTab function to load variants when needed
const originalSwitchTab = window.switchTab;
window.switchTab = function(tabName) {
    originalSwitchTab(tabName);
    
    if (tabName === 'variants' && !variantsLoaded) {
        setTimeout(() => {
            loadExistingVariants();
            variantsLoaded = true;
        }, 200);
    }
};
</script>
@endsection 