@extends('admin.layouts.app')

@section('title', 'Danh sách Thuộc tính')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Danh sách Thuộc tính</h1>
        <a href="{{ route('admin.product-attributes.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-plus mr-2"></i>Thêm thuộc tính
        </a>
    </div>

    <!-- Simple Search -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <form method="GET" action="{{ route('admin.product-attributes.index') }}" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Tìm kiếm thuộc tính..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                <i class="fas fa-search mr-2"></i>Tìm kiếm
            </button>
            
            @if(request('search'))
            <a href="{{ route('admin.product-attributes.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                <i class="fas fa-times mr-2"></i>Xóa bộ lọc
            </a>
            @endif
        </form>
    </div>

    <!-- Attributes List -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Thuộc tính
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Giá trị
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Đơn vị
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Sản phẩm
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Trạng thái
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Thao tác
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($attributes as $attribute)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ \App\Models\ProductAttribute::getCommonAttributeKeys()[$attribute->attribute_key] ?? $attribute->attribute_key }}
                            </div>
                            @if($attribute->attribute_description)
                                <div class="text-xs text-gray-500">{{ Str::limit($attribute->attribute_description, 40) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 font-medium">{{ $attribute->attribute_value }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ $attribute->attribute_unit ?: '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $attribute->product->name ?? 'N/A' }}</div>
                            <div class="text-xs text-gray-500">{{ $attribute->product->sku ?? '' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $attribute->is_visible ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <i class="fas {{ $attribute->is_visible ? 'fa-eye' : 'fa-eye-slash' }} mr-1"></i>
                                {{ $attribute->is_visible ? 'Hiển thị' : 'Ẩn' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.product-attributes.edit', $attribute) }}"
                                   class="text-blue-600 hover:text-blue-900" title="Chỉnh sửa">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($attribute->is_visible)
                                    <form method="POST" action="{{ route('admin.product-attributes.destroy', $attribute) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-orange-600 hover:text-orange-900" 
                                                title="Ẩn thuộc tính"
                                                onclick="return confirm('Bạn có chắc muốn ẩn thuộc tính này?')">
                                            <i class="fas fa-eye-slash"></i>
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.product-attributes.restore', $attribute) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900" 
                                                title="Hiển thị lại"
                                                onclick="return confirm('Bạn có chắc muốn hiển thị lại thuộc tính này?')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-list-alt text-4xl text-gray-300 mb-2"></i>
                                <p class="text-lg font-medium">Chưa có thuộc tính nào</p>
                                <p class="text-sm">Hãy thêm thuộc tính đầu tiên</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($attributes->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $attributes->links() }}
        </div>
        @endif
    </div>

    <!-- Quick Stats -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-list-alt text-2xl text-blue-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Tổng thuộc tính</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $attributes->total() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-eye text-2xl text-green-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Đang hiển thị</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $attributes->where('is_visible', true)->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-eye-slash text-2xl text-red-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-500">Đã ẩn</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $attributes->where('is_visible', false)->count() }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 