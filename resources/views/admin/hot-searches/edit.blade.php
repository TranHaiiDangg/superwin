@extends('admin.layouts.app')

@section('title', 'Sửa Hot Search')
@section('page-title', 'Sửa Hot Search')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Sửa Hot Search</h1>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-gray-900">Dashboard</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <a href="{{ route('admin.hot-searches.index') }}" class="text-gray-700 hover:text-gray-900">Hot Search</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="text-gray-500">Sửa: {{ $hotSearch->display_title }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.hot-searches.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Quay lại
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Thông tin Hot Search</h3>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.hot-searches.update', $hotSearch) }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Type Selection -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                Loại Hot Search <span class="text-red-500">*</span>
                            </label>
                            <select name="type" id="type" class="w-full border border-gray-300 rounded-lg px-3 py-2 @error('type') border-red-500 @enderror" required>
                                <option value="">Chọn loại...</option>
                                @foreach($types as $key => $label)
                                    <option value="{{ $key }}" {{ old('type', $hotSearch->type) == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                                Tiêu đề hiển thị <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" id="title" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 @error('title') border-red-500 @enderror" 
                                   value="{{ old('title', $hotSearch->title) }}" required>
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Tiêu đề sẽ hiển thị trong danh sách gợi ý tìm kiếm</p>
                        </div>

                        <!-- Product Selection -->
                        <div id="products-section" class="hidden">
                            <label for="products" class="block text-sm font-medium text-gray-700 mb-2">
                                Chọn sản phẩm <span class="text-red-500">*</span>
                            </label>
                            <select id="products" class="select2-products w-full" disabled>
                                <option value="">Chọn sản phẩm...</option>
                                @foreach($products as $product)
                                    @php
                                        $selectedProductIds = old('item', $hotSearch->items->where('item_type', 'product')->pluck('item_id')->toArray());
                                        $selectedProductId = is_array($selectedProductIds) && count($selectedProductIds) > 0 ? $selectedProductIds[0] : null;
                                        $isSelected = $selectedProductId == $product->id;
                                    @endphp
                                    <option value="{{ $product->id }}" {{ $isSelected ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('item')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Tìm kiếm và chọn 1 sản phẩm</p>
                        </div>

                        <!-- Brand Selection -->
                        <div id="brands-section" class="hidden">
                            <label for="brands" class="block text-sm font-medium text-gray-700 mb-2">
                                Chọn thương hiệu <span class="text-red-500">*</span>
                            </label>
                            <select id="brands" class="select2-brands w-full" disabled>
                                <option value="">Chọn thương hiệu...</option>
                                @foreach($brands as $brand)
                                    @php
                                        $selectedBrandIds = old('item', $hotSearch->items->where('item_type', 'brand')->pluck('item_id')->toArray());
                                        $selectedBrandId = is_array($selectedBrandIds) && count($selectedBrandIds) > 0 ? $selectedBrandIds[0] : null;
                                        $isSelected = $selectedBrandId == $brand->id;
                                    @endphp
                                    <option value="{{ $brand->id }}" {{ $isSelected ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('item')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Tìm kiếm và chọn 1 thương hiệu</p>
                        </div>

                        <!-- Category Selection -->
                        <div id="categories-section" class="hidden">
                            <label for="categories" class="block text-sm font-medium text-gray-700 mb-2">
                                Chọn danh mục <span class="text-red-500">*</span>
                            </label>
                            <select id="categories" class="select2-categories w-full" disabled>
                                <option value="">Chọn danh mục...</option>
                                @foreach($categories as $category)
                                    @php
                                        $selectedCategoryIds = old('item', $hotSearch->items->where('item_type', 'category')->pluck('item_id')->toArray());
                                        $selectedCategoryId = is_array($selectedCategoryIds) && count($selectedCategoryIds) > 0 ? $selectedCategoryIds[0] : null;
                                        $isSelected = $selectedCategoryId == $category->id;
                                    @endphp
                                    <option value="{{ $category->id }}" {{ $isSelected ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('item')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Tìm kiếm và chọn 1 danh mục</p>
                        </div>

                        <!-- Keyword (for keyword type) -->
                        <div id="keyword-section" style="display: none;">
                            <label for="keyword" class="block text-sm font-medium text-gray-700 mb-2">
                                Từ khóa tìm kiếm <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="keyword" id="keyword" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 @error('keyword') border-red-500 @enderror" 
                                   value="{{ old('keyword', $hotSearch->keyword) }}">
                            @error('keyword')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Từ khóa sẽ được sử dụng để tìm kiếm khi người dùng click</p>
                        </div>

                        <!-- Image URL -->
                        <div>
                            <label for="image_url" class="block text-sm font-medium text-gray-700 mb-2">URL Hình ảnh (Tùy chọn)</label>
                            <input type="url" name="image_url" id="image_url" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 @error('image_url') border-red-500 @enderror" 
                                   value="{{ old('image_url', $hotSearch->image_url) }}">
                            @error('image_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Để trống để sử dụng hình ảnh mặc định từ mục tham chiếu</p>
                        </div>

                        <!-- Max Items (for non-keyword types) -->
                        <div id="max-items-section" style="display: none;">
                            <label for="max_items" class="block text-sm font-medium text-gray-700 mb-2">Số lượng mục tối đa</label>
                            <input type="number" name="max_items" id="max_items" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 @error('max_items') border-red-500 @enderror" 
                                   value="{{ old('max_items', $hotSearch->max_items ?? 5) }}" min="1" max="20">
                            @error('max_items')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Giới hạn số lượng mục hiển thị (1-20)</p>
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Mô tả (Tùy chọn)</label>
                            <textarea name="description" id="description" rows="3" 
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 @error('description') border-red-500 @enderror">{{ old('description', $hotSearch->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sort Order -->
                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Thứ tự sắp xếp</label>
                            <input type="number" name="sort_order" id="sort_order" 
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 @error('sort_order') border-red-500 @enderror" 
                                   value="{{ old('sort_order', $hotSearch->sort_order) }}" min="0" max="999">
                            @error('sort_order')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Số thứ tự nhỏ hơn sẽ hiển thị trước (0 = hiển thị đầu tiên)</p>
                        </div>

                        <!-- Is Active -->
                        <div>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" 
                                       class="h-4 w-4 text-blue-600 border-gray-300 rounded" 
                                       value="1" {{ old('is_active', $hotSearch->is_active) ? 'checked' : '' }}>
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">
                                    Kích hoạt
                                </label>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Hot search chỉ hiển thị khi được kích hoạt</p>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex space-x-3">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                                <i class="fas fa-save mr-2"></i> Cập nhật Hot Search
                            </button>
                            <a href="{{ route('admin.hot-searches.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg inline-flex items-center">
                                <i class="fas fa-times mr-2"></i> Hủy
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1 space-y-6">
            <!-- Current Info Card -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-blue-500"></i> Thông tin hiện tại
                    </h3>
                </div>
                <div class="p-6">
                    <div class="text-center mb-4">
                        <img src="{{ $hotSearch->display_image }}" alt="{{ $hotSearch->display_title }}" 
                             class="w-20 h-20 rounded-lg object-cover mx-auto mb-3">
                        <h4 class="font-medium text-gray-900">{{ $hotSearch->display_title }}</h4>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Loại:</span>
                            <span class="font-medium">{{ $hotSearch->type_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Lượt click:</span>
                            <span class="font-medium">{{ number_format($hotSearch->click_count) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Trạng thái:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $hotSearch->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $hotSearch->is_active ? 'Hoạt động' : 'Tắt' }}
                            </span>
                        </div>
                    </div>
                    
                    @if($hotSearch->type !== 'keyword')
                        <!-- <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="text-sm">
                                <span class="text-gray-600">Tham chiếu:</span><br>
                                <span class="font-medium">
                                    @switch($hotSearch->type)
                                        @case('product')
                                            {{ $hotSearch->product?->name ?? 'Sản phẩm không tồn tại' }}
                                            @break
                                        @case('brand')
                                            {{ $hotSearch->brand?->name ?? 'Thương hiệu không tồn tại' }}
                                            @break
                                        @case('category')
                                            {{ $hotSearch->category?->name ?? 'Danh mục không tồn tại' }}
                                            @break
                                    @endswitch
                                </span>
                            </div>
                        </div> -->
                    @else
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="text-sm">
                                <span class="text-gray-600">Từ khóa:</span><br>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $hotSearch->keyword }}
                                </span>
                            </div>
                        </div>
                    @endif
                    
                    <!-- <div class="mt-4">
                        <a href="{{ $hotSearch->search_url }}" target="_blank" 
                           class="w-full bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg inline-flex items-center justify-center">
                            <i class="fas fa-external-link-alt mr-2"></i> Xem trước
                        </a>
                    </div> -->
                </div>
            </div>

            <!-- Help Card -->
            <div class="bg-white rounded-lg shadow">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <i class="fas fa-question-circle mr-2 text-blue-500"></i> Hướng dẫn
                    </h3>
                </div>
                <div class="p-6">
                    <h4 class="font-medium text-gray-900 mb-3">Các loại Hot Search:</h4>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-start">
                            <i class="fas fa-box text-blue-500 mr-2 mt-1"></i>
                            <div>
                                <strong>Sản phẩm:</strong> Liên kết đến trang chi tiết sản phẩm
                            </div>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-tags text-green-500 mr-2 mt-1"></i>
                            <div>
                                <strong>Thương hiệu:</strong> Liên kết đến trang thương hiệu
                            </div>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-list text-yellow-500 mr-2 mt-1"></i>
                            <div>
                                <strong>Danh mục:</strong> Liên kết đến trang danh mục
                            </div>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-keyboard text-purple-500 mr-2 mt-1"></i>
                            <div>
                                <strong>Từ khóa:</strong> Thực hiện tìm kiếm với từ khóa
                            </div>
                        </li>
                    </ul>
                    
                    <hr class="my-4">
                    
                    <h4 class="font-medium text-gray-900 mb-3">Lưu ý:</h4>
                    <ul class="space-y-1 text-sm text-gray-600">
                        <li>• Hot search sẽ hiển thị khi người dùng click vào ô tìm kiếm</li>
                        <li>• Thứ tự sắp xếp quyết định vị trí hiển thị</li>
                        <li>• Chỉ các mục được kích hoạt mới hiển thị</li>
                        <li>• Hệ thống sẽ theo dõi số lượt click của từng mục</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Initialize Select2 for all select elements (single selection)
    $('.select2-products').select2({
        placeholder: 'Tìm kiếm và chọn sản phẩm...',
        allowClear: true,
        width: '100%',
        language: {
            noResults: function() {
                return "Không tìm thấy sản phẩm nào";
            },
            searching: function() {
                return "Đang tìm kiếm...";
            }
        }
    });
    
    $('.select2-brands').select2({
        placeholder: 'Tìm kiếm và chọn thương hiệu...',
        allowClear: true,
        width: '100%',
        language: {
            noResults: function() {
                return "Không tìm thấy thương hiệu nào";
            },
            searching: function() {
                return "Đang tìm kiếm...";
            }
        }
    });
    
    $('.select2-categories').select2({
        placeholder: 'Tìm kiếm và chọn danh mục...',
        allowClear: true,
        width: '100%',
        language: {
            noResults: function() {
                return "Không tìm thấy danh mục nào";
            },
            searching: function() {
                return "Đang tìm kiếm...";
            }
        }
    });
    
          // Handle type change
      $('#type').on('change', function() {
          const selectedType = $(this).val();
          console.log('Type changed to:', selectedType);
          
          // Hide all sections first
          $('#products-section').addClass('hidden');
          $('#brands-section').addClass('hidden');
          $('#categories-section').addClass('hidden');
          $('#keyword-section').hide();
          
          // Disable all selects to prevent them from submitting values
          $('#products, #brands, #categories').attr('disabled', true).removeAttr('name');
          $('#keyword').removeAttr('required');
          
          if (selectedType === 'keyword') {
              // Show keyword section
              $('#keyword-section').show();
              $('#keyword').attr('required', true);
              
          } else if (selectedType === 'product') {
              // Show products section
              $('#products-section').removeClass('hidden');
              $('#products').removeAttr('disabled').attr('name', 'item').attr('required', true);
              console.log('Enabled products select with name="item"');
              
          } else if (selectedType === 'brand') {
              // Show brands section
              $('#brands-section').removeClass('hidden');
              $('#brands').removeAttr('disabled').attr('name', 'item').attr('required', true);
              console.log('Enabled brands select with name="item"');
              
          } else if (selectedType === 'category') {
              // Show categories section
              $('#categories-section').removeClass('hidden');
              $('#categories').removeAttr('disabled').attr('name', 'item').attr('required', true);
              console.log('Enabled categories select with name="item"');
          }
      });
    
    // Trigger change event if type is already selected
    if ($('#type').val()) {
        $('#type').trigger('change');
    }
    
    // Debug: Log form data before submit
    $('form').on('submit', function() {
        console.log('=== FORM SUBMIT DEBUG ===');
        console.log('Form data:', {
            type: $('#type').val(),
            item_from_products: $('#products').val(),
            item_from_brands: $('#brands').val(), 
            item_from_categories: $('#categories').val(),
            keyword: $('#keyword').val(),
            products_name: $('#products').attr('name'),
            brands_name: $('#brands').attr('name'),
            categories_name: $('#categories').attr('name'),
            products_disabled: $('#products').prop('disabled'),
            brands_disabled: $('#brands').prop('disabled'),
            categories_disabled: $('#categories').prop('disabled')
        });
        
        // Serialize form data to see what actually gets sent
        console.log('Serialized form data:', $(this).serialize());
        console.log('=== END FORM SUBMIT DEBUG ===');
    });
});
</script>
@endsection