@extends('admin.layouts.app')

@section('title', 'Thêm Thuộc tính Sản phẩm')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Thêm Thuộc tính Sản phẩm</h1>
        <a href="{{ route('admin.product-attributes.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-arrow-left mr-2"></i>Quay lại
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-sm">
        <form action="{{ route('admin.product-attributes.store') }}" method="POST" class="p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-4">
                    <div>
                        <label for="product_id" class="block text-sm font-medium text-gray-700 mb-2">Sản phẩm *</label>
                        <select id="product_id" name="product_id" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('product_id') border-red-500 @enderror">
                            <option value="">Chọn sản phẩm</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} (ID: {{ $product->id }})
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="attribute_key" class="block text-sm font-medium text-gray-700 mb-2">Thuộc tính *</label>
                        <select id="attribute_key" name="attribute_key" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('attribute_key') border-red-500 @enderror"
                                onchange="updateUnitOptions()">
                            <option value="">Chọn thuộc tính</option>
                            @foreach($commonKeys as $key => $label)
                                <option value="{{ $key }}" {{ old('attribute_key') == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                            <option value="custom" {{ old('attribute_key') == 'custom' ? 'selected' : '' }}>Tùy chỉnh</option>
                        </select>
                        @error('attribute_key')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div id="custom_key_field" style="display: none;">
                        <label for="custom_attribute_key" class="block text-sm font-medium text-gray-700 mb-2">Tên thuộc tính tùy chỉnh</label>
                        <input type="text" id="custom_attribute_key" name="custom_attribute_key" value="{{ old('custom_attribute_key') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Nhập tên thuộc tính">
                    </div>

                    <div>
                        <label for="attribute_value" class="block text-sm font-medium text-gray-700 mb-2">Giá trị</label>
                        <input type="text" id="attribute_value" name="attribute_value" value="{{ old('attribute_value') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('attribute_value') border-red-500 @enderror"
                               placeholder="Nhập giá trị">
                        @error('attribute_value')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-4">
                    <div>
                        <label for="attribute_unit" class="block text-sm font-medium text-gray-700 mb-2">Đơn vị</label>
                        <select id="attribute_unit" name="attribute_unit"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('attribute_unit') border-red-500 @enderror">
                            <option value="">Chọn đơn vị</option>
                        </select>
                        @error('attribute_unit')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Thứ tự hiển thị</label>
                        <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('sort_order') border-red-500 @enderror">
                        @error('sort_order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="is_visible" name="is_visible" value="1" {{ old('is_visible', true) ? 'checked' : '' }}
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="is_visible" class="ml-2 block text-sm text-gray-900">
                            Hiển thị thuộc tính này
                        </label>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="mt-6">
                <label for="attribute_description" class="block text-sm font-medium text-gray-700 mb-2">Mô tả</label>
                <textarea id="attribute_description" name="attribute_description" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('attribute_description') border-red-500 @enderror"
                          placeholder="Mô tả chi tiết về thuộc tính này">{{ old('attribute_description') }}</textarea>
                @error('attribute_description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t mt-6">
                <a href="{{ route('admin.product-attributes.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg">
                    Hủy
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    <i class="fas fa-save mr-2"></i>Tạo thuộc tính
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const commonUnits = @json($commonUnits);

function updateUnitOptions() {
    const attributeKey = document.getElementById('attribute_key').value;
    const unitSelect = document.getElementById('attribute_unit');
    const customKeyField = document.getElementById('custom_key_field');
    
    // Show/hide custom key field
    if (attributeKey === 'custom') {
        customKeyField.style.display = 'block';
    } else {
        customKeyField.style.display = 'none';
    }
    
    // Clear current options
    unitSelect.innerHTML = '<option value="">Chọn đơn vị</option>';
    
    // Add units for selected attribute
    if (commonUnits[attributeKey]) {
        commonUnits[attributeKey].forEach(unit => {
            const option = document.createElement('option');
            option.value = unit;
            option.textContent = unit;
            if ('{{ old("attribute_unit") }}' === unit) {
                option.selected = true;
            }
            unitSelect.appendChild(option);
        });
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    updateUnitOptions();
});
</script>
@endsection 