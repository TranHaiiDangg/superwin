@extends('admin.layouts.app')

@section('title', 'Chi tiết Thuộc tính')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Chi tiết Thuộc tính</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.product-attributes.edit', $productAttribute) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-edit mr-2"></i>Chỉnh sửa
            </a>
            <a href="{{ route('admin.product-attributes.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-arrow-left mr-2"></i>Quay lại
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Attribute Info -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin Thuộc tính</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Tên thuộc tính</label>
                            <div class="mt-1 text-sm text-gray-900 font-medium">
                                {{ \App\Models\ProductAttribute::getCommonAttributeKeys()[$productAttribute->attribute_key] ?? $productAttribute->attribute_key }}
                            </div>
                            <div class="text-xs text-gray-500">{{ $productAttribute->attribute_key }}</div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Giá trị</label>
                            <div class="mt-1 text-sm text-gray-900 font-medium">{{ $productAttribute->attribute_value ?: '-' }}</div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Đơn vị</label>
                            <div class="mt-1 text-sm text-gray-900">{{ $productAttribute->attribute_unit ?: '-' }}</div>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Thứ tự hiển thị</label>
                            <div class="mt-1 text-sm text-gray-900">{{ $productAttribute->sort_order }}</div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Trạng thái</label>
                            <div class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $productAttribute->is_visible ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    <i class="fas {{ $productAttribute->is_visible ? 'fa-eye' : 'fa-eye-slash' }} mr-1"></i>
                                    {{ $productAttribute->is_visible ? 'Hiển thị' : 'Ẩn' }}
                                </span>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Ngày tạo</label>
                            <div class="mt-1 text-sm text-gray-900">{{ $productAttribute->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                    </div>
                </div>
                
                @if($productAttribute->attribute_description)
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <label class="block text-sm font-medium text-gray-500 mb-2">Mô tả</label>
                    <div class="text-sm text-gray-900">{{ $productAttribute->attribute_description }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Sản phẩm</h3>
                
                @if($productAttribute->product)
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Tên sản phẩm</label>
                            <div class="mt-1">
                                <a href="{{ route('admin.products.edit', $productAttribute->product) }}" 
                                   class="text-blue-600 hover:text-blue-900 font-medium">
                                    {{ $productAttribute->product->name }}
                                </a>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">SKU</label>
                            <div class="mt-1 text-sm text-gray-900">{{ $productAttribute->product->sku }}</div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Danh mục</label>
                            <div class="mt-1 text-sm text-gray-900">{{ $productAttribute->product->category->name ?? '-' }}</div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Thương hiệu</label>
                            <div class="mt-1 text-sm text-gray-900">{{ $productAttribute->product->brand->name ?? '-' }}</div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Giá</label>
                            <div class="mt-1 text-sm text-gray-900">{{ number_format($productAttribute->product->price) }} VNĐ</div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Trạng thái sản phẩm</label>
                            <div class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $productAttribute->product->status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $productAttribute->product->status ? 'Hoạt động' : 'Không hoạt động' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-exclamation-triangle text-4xl text-gray-300 mb-2"></i>
                        <p class="text-gray-500">Sản phẩm không tồn tại</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Related Attributes -->
    @if($productAttribute->product && $productAttribute->product->attributes->count() > 1)
    <div class="mt-6">
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Thuộc tính khác của sản phẩm</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($productAttribute->product->attributes->where('id', '!=', $productAttribute->id) as $attribute)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="text-sm font-medium text-gray-900">
                                {{ \App\Models\ProductAttribute::getCommonAttributeKeys()[$attribute->attribute_key] ?? $attribute->attribute_key }}
                            </h4>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                {{ $attribute->is_visible ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <i class="fas {{ $attribute->is_visible ? 'fa-eye' : 'fa-eye-slash' }} mr-1"></i>
                            </span>
                        </div>
                        <div class="text-sm text-gray-600">
                            {{ $attribute->attribute_value }} {{ $attribute->attribute_unit }}
                        </div>
                        @if($attribute->attribute_description)
                            <div class="text-xs text-gray-500 mt-1">{{ Str::limit($attribute->attribute_description, 60) }}</div>
                        @endif
                        <div class="mt-2">
                            <a href="{{ route('admin.product-attributes.show', $attribute) }}" 
                               class="text-blue-600 hover:text-blue-900 text-xs">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection 