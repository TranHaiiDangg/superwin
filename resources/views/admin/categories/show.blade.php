@extends('admin.layouts.app')

@section('title', 'Chi tiết danh mục')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    <i class="fas fa-folder mr-2 text-blue-500"></i>{{ $category->name }}
                </h1>
                <p class="text-gray-600">Chi tiết danh mục và danh mục con</p>
            </div>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.categories.edit', $category) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-edit mr-2"></i>Chỉnh sửa
            </a>
            <a href="{{ route('admin.categories.create') }}?parent_id={{ $category->id }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-plus mr-2"></i>Thêm danh mục con
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Category Info -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin danh mục</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Tên danh mục</label>
                        <div class="mt-1 text-sm text-gray-900">{{ $category->name }}</div>
                    </div>
                    
                    @if($category->image)
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Hình ảnh</label>
                        <div class="mt-1">
                            <img src="{{ $category->image }}" alt="{{ $category->name }}" 
                                 class="h-24 w-auto object-contain rounded-lg border">
                        </div>
                    </div>
                    @endif
                    
                    @if($category->description)
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Mô tả</label>
                        <div class="mt-1 text-sm text-gray-900">{{ $category->description }}</div>
                    </div>
                    @endif
                    

                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Trạng thái</label>
                        <div class="mt-1">
                            @if($category->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>Kích hoạt
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times mr-1"></i>Không kích hoạt
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-500">Thống kê</label>
                        <div class="mt-1 space-y-2">
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Danh mục con:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $category->children_count }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-sm text-gray-600">Sản phẩm:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $category->products_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Children Categories and Products -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Children Categories -->
            @if($category->children->count() > 0)
            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">
                        <i class="fas fa-folder-open mr-2 text-purple-500"></i>
                        Danh mục con ({{ $category->children->count() }})
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($category->children as $child)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h4 class="text-sm font-medium text-gray-900">
                                        <i class="fas fa-folder mr-2 text-blue-400"></i>{{ $child->name }}
                                    </h4>
                                    @if($child->description)
                                        <p class="text-xs text-gray-500 mt-1">{{ Str::limit($child->description, 60) }}</p>
                                    @endif
                                    <div class="flex items-center space-x-4 mt-2">
                                        <span class="text-xs text-gray-500">
                                            <i class="fas fa-box mr-1"></i>{{ $child->products->count() }} sản phẩm
                                        </span>

                                    </div>
                                </div>
                                <div class="flex space-x-1 ml-4">
                                    <a href="{{ route('admin.categories.show', $child) }}" 
                                       class="text-green-600 hover:text-green-900 text-sm" title="Chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.categories.edit', $child) }}" 
                                       class="text-blue-600 hover:text-blue-900 text-sm" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Products in this category -->
            @if($category->products->count() > 0)
            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">
                        <i class="fas fa-box mr-2 text-green-500"></i>
                        Sản phẩm trong danh mục ({{ $category->products->count() }})
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Sản phẩm
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    SKU
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Giá
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tồn kho
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
                            @foreach($category->products->take(10) as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $product->sku }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ number_format($product->price) }} VNĐ
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        {{ $product->stock_quantity > $product->min_stock_level ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $product->stock_quantity }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($product->status)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Hoạt động
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Không hoạt động
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.products.edit', $product) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($category->products->count() > 10)
                <div class="px-6 py-3 bg-gray-50 text-center">
                    <a href="{{ route('admin.products.index') }}?category_id={{ $category->id }}" 
                       class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                        Xem tất cả {{ $category->products->count() }} sản phẩm
                    </a>
                </div>
                @endif
            </div>
            @endif

            <!-- Empty state -->
            @if($category->children->count() == 0 && $category->products->count() == 0)
            <div class="bg-white rounded-lg shadow-md p-8">
                <div class="text-center">
                    <i class="fas fa-folder-open text-4xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Danh mục trống</h3>
                    <p class="text-gray-500 mb-4">Danh mục này chưa có danh mục con hoặc sản phẩm nào.</p>
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('admin.categories.create') }}?parent_id={{ $category->id }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                            <i class="fas fa-plus mr-2"></i>Thêm danh mục con
                        </a>
                        <a href="{{ route('admin.products.create') }}?category_id={{ $category->id }}" 
                           class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                            <i class="fas fa-box mr-2"></i>Thêm sản phẩm
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 