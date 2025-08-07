@extends('admin.layouts.app')

@section('title', 'Thêm sản phẩm')
@section('page-title', 'Thêm sản phẩm')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Thông tin sản phẩm</h3>
        </div>
        
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
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
                                <div class="flex space-x-2">
                                    <input type="text" id="sku" name="sku" value="{{ old('sku') }}"
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
                    
                    <!-- Product Images -->
                    <div class="space-y-4">
                        <h4 class="text-md font-medium text-gray-900 border-b pb-2">Hình ảnh sản phẩm</h4>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-images mr-1 text-blue-500"></i>Chọn hình ảnh
                                </label>
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
                            
                            <!-- Image Preview Container -->
                            <div id="new-image-preview-container" class="hidden">
                                <h5 class="text-sm font-medium text-gray-700 mb-2">Xem trước hình ảnh:</h5>
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
                                    <i class="fas fa-star mr-1 text-yellow-500"></i>Sản phẩm nổi bật
                                </label>
                            </div>
                            
                            <div class="flex items-center">
                                <input type="checkbox" id="is_sale" name="is_sale" value="1" {{ old('is_sale') ? 'checked' : '' }}
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
                                <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title') }}"
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
                                <input type="text" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}"
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
                                    <option value="index,follow" {{ old('meta_robots') == 'index,follow' ? 'selected' : '' }}>index,follow (Mặc định)</option>
                                    <option value="noindex,follow" {{ old('meta_robots') == 'noindex,follow' ? 'selected' : '' }}>noindex,follow</option>
                                    <option value="index,nofollow" {{ old('meta_robots') == 'index,nofollow' ? 'selected' : '' }}>index,nofollow</option>
                                    <option value="noindex,nofollow" {{ old('meta_robots') == 'noindex,nofollow' ? 'selected' : '' }}>noindex,nofollow</option>
                                </select>
                                @error('meta_robots')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="meta_author" class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fas fa-user-edit mr-1 text-orange-500"></i>Meta Author
                                </label>
                                <input type="text" id="meta_author" name="meta_author" value="{{ old('meta_author') }}"
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
                                      maxlength="160">{{ old('meta_description') }}</textarea>
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
                            <input type="url" id="meta_canonical_url" name="meta_canonical_url" value="{{ old('meta_canonical_url') }}"
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
                                <button type="button" onclick="testRemoveAttribute()" class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded text-xs">
                                    Test JS
                                </button>
                                <button type="button" onclick="addAttribute()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                                    <i class="fas fa-plus mr-2"></i>Thêm thuộc tính
                                </button>
                            </div>
                        </div>
                        
                        <div id="product-attributes">
                            <div id="attributes-container" class="space-y-4">
                                <!-- Dynamic attributes will be added here -->
                                <div class="text-center py-8 text-gray-500" id="no-attributes-message">
                                    <i class="fas fa-cogs text-4xl mb-4"></i>
                                    <p>Chưa có thuộc tính nào. Nhấn "Thêm thuộc tính" để bắt đầu.</p>
                                </div>
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
                            </div>
                        </div>
                        
                        <div id="product-variants">
                            <div id="variants-container" class="space-y-4">
                                <!-- Dynamic variants will be added here -->
                                <div class="text-center py-8 text-gray-500" id="no-variants-message">
                                    <i class="fas fa-layer-group text-4xl mb-4"></i>
                                    <p>Chưa có phân loại nào. Nhấn "Thêm phân loại" để bắt đầu.</p>
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
                    <i class="fas fa-save mr-2"></i>Thêm sản phẩm
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
    console.log('DOM loaded, initializing functions...'); // Debug log
    
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
    
    const testBtn = document.querySelector('button[onclick="testRemoveAttribute()"]');
    if (testBtn) {
        testBtn.removeAttribute('onclick');
        testBtn.addEventListener('click', function() {
            testRemoveAttribute();
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
    
    // Test functions are available
    console.log('removeAttribute function:', typeof removeAttribute);
    console.log('addAttribute function:', typeof addAttribute);
    console.log('previewNewImages function:', typeof previewNewImages);
});

// Test function for debugging
function testRemoveAttribute() {
    console.log('Test function called');
    alert('JavaScript functions are working!');
}

// Product Attributes Management
const commonUnits = @json(\App\Models\ProductAttribute::getCommonUnits());
const commonKeys = @json(\App\Models\ProductAttribute::getCommonAttributeKeys());
let attributeIndex = 0;

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
                <select name="attributes[${attributeIndex}][attribute_key]" class="attribute-key-select w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Chọn thuộc tính</option>
                    ${Object.entries(commonKeys).map(([key, label]) => `<option value="${key}">${label}</option>`).join('')}
                </select>
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
                <select name="attributes[${attributeIndex}][attribute_unit]" class="attribute-unit-select w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Chọn đơn vị</option>
                </select>
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
    const keySelect = attributeRow.querySelector('.attribute-key-select');
    
    removeBtn.addEventListener('click', function() {
        removeAttribute(this);
    });
    
    keySelect.addEventListener('change', function() {
        updateAttributeUnits(this);
    });
    
    attributeIndex++;
}

function removeAttribute(button) {
    console.log('removeAttribute called', button); // Debug log
    const attributeRow = button.closest('.attribute-row');
    const container = document.getElementById('attributes-container');
    
    console.log('attributeRow:', attributeRow); // Debug log
    console.log('container:', container); // Debug log
    
    if (confirm('Bạn có chắc muốn xóa thuộc tính này?')) {
        attributeRow.remove();
        
        // Show no attributes message if no attributes left
        const remainingRows = container.querySelectorAll('.attribute-row');
        console.log('remainingRows:', remainingRows.length); // Debug log
        
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

function updateAttributeUnits(selectElement) {
    const attributeKey = selectElement.value;
    const row = selectElement.closest('.attribute-row');
    const unitSelect = row.querySelector('.attribute-unit-select');
    
    // Clear current options
    unitSelect.innerHTML = '<option value="">Chọn đơn vị</option>';
    
    // Add units for selected attribute
    if (commonUnits[attributeKey]) {
        commonUnits[attributeKey].forEach(unit => {
            const option = document.createElement('option');
            option.value = unit;
            option.textContent = unit;
            unitSelect.appendChild(option);
        });
    }
}

// Image Preview Functions
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

// Auto-update SKU preview when category, brand, or type changes
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('category_id');
    const brandSelect = document.getElementById('brand_id');
    
    
    if (categorySelect) {
        categorySelect.addEventListener('change', function() {
            const skuInput = document.getElementById('sku');
            if (!skuInput.value) {
                generateSKUPreview();
            }
        });
    }
    
    if (brandSelect) {
        brandSelect.addEventListener('change', function() {
            const skuInput = document.getElementById('sku');
            if (!skuInput.value) {
                generateSKUPreview();
            }
        });
    }
    
        // if (productTypeSelect) {
        //     productTypeSelect.addEventListener('change', function() {
        //         const skuInput = document.getElementById('sku');
        //         if (!skuInput.value) {
        //             generateSKUPreview();
        //         }
        //     });
        // }
});

// Product Variants Management
let variantIndex = 0;

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
        noMessage.style.display = 'block';
    }
}
</script>
@endsection 