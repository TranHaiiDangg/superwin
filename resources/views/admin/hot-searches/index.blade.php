@extends('admin.layouts.app')

@section('title', 'Quản lý Hot Search')
@section('page-title', 'Quản lý Hot Search')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Quản lý Hot Search</h1>
            <p class="text-gray-600">Quản lý các mục hot search hiển thị khi người dùng click vào ô tìm kiếm</p>
        </div>
        <a href="{{ route('admin.hot-searches.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
            <i class="fas fa-plus mr-2"></i> Thêm Hot Search
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-search text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Tổng số</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['total']) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-eye text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Đang hoạt động</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['active']) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-eye-slash text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Không hoạt động</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['inactive']) }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-hashtag text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Từ khóa</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ number_format($stats['by_type']['keyword']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Type Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <i class="fas fa-box text-blue-500 text-3xl mb-3"></i>
            <h3 class="text-xl font-semibold text-gray-900">{{ $stats['by_type']['product'] }}</h3>
            <p class="text-gray-600">Sản phẩm</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <i class="fas fa-tags text-green-500 text-3xl mb-3"></i>
            <h3 class="text-xl font-semibold text-gray-900">{{ $stats['by_type']['brand'] }}</h3>
            <p class="text-gray-600">Thương hiệu</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <i class="fas fa-list text-yellow-500 text-3xl mb-3"></i>
            <h3 class="text-xl font-semibold text-gray-900">{{ $stats['by_type']['category'] }}</h3>
            <p class="text-gray-600">Danh mục</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6 text-center">
            <i class="fas fa-keyboard text-purple-500 text-3xl mb-3"></i>
            <h3 class="text-xl font-semibold text-gray-900">{{ $stats['by_type']['keyword'] }}</h3>
            <p class="text-gray-600">Từ khóa</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Loại</label>
                <select name="type" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Tất cả loại</option>
                    @foreach(\App\Models\HotSearch::TYPES as $key => $label)
                        <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">Tất cả trạng thái</option>
                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Không hoạt động</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm</label>
                <input type="text" name="search" class="w-full border border-gray-300 rounded-lg px-3 py-2" placeholder="Tìm theo tiêu đề, từ khóa..." value="{{ request('search') }}">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">&nbsp;</label>
                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                        <i class="fas fa-search mr-2"></i> Lọc
                    </button>
                    <a href="{{ route('admin.hot-searches.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg inline-flex items-center">
                        <i class="fas fa-refresh mr-2"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Hot Searches Table -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Danh sách Hot Search ({{ $hotSearches->total() }} mục)</h3>
        </div>
        <div class="p-6">
            @if($hotSearches->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STT</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hình ảnh</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tiêu đề</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loại</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tham chiếu</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thứ tự</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lượt click</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($hotSearches as $index => $hotSearch)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $hotSearches->firstItem() + $index }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <img src="{{ $hotSearch->display_image }}" alt="{{ $hotSearch->display_title }}" 
                                             class="w-12 h-12 rounded-lg object-cover">
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="text-sm font-medium {{ $hotSearch->is_active ? 'text-gray-900' : 'text-gray-400' }}">
                                                {{ $hotSearch->display_title }}
                                            </div>
                                            <span class="ml-2 inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                                {{ $hotSearch->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                                <i class="fas fa-circle mr-1" style="font-size: 6px;"></i>
                                                {{ $hotSearch->is_active ? 'Hoạt động' : 'Tắt' }}
                                            </span>
                                        </div>
                                        @if($hotSearch->description)
                                            <div class="text-sm {{ $hotSearch->is_active ? 'text-gray-500' : 'text-gray-400' }}">
                                                {{ Str::limit($hotSearch->description, 50) }}
                                            </div>
                                        @endif
                                        @if($hotSearch->type === 'keyword')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mt-1">
                                                {{ $hotSearch->keyword }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if($hotSearch->type === 'product') bg-blue-100 text-blue-800
                                            @elseif($hotSearch->type === 'brand') bg-green-100 text-green-800
                                            @elseif($hotSearch->type === 'category') bg-yellow-100 text-yellow-800
                                            @else bg-purple-100 text-purple-800 @endif">
                                            {{ $hotSearch->type_name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($hotSearch->type !== 'keyword')
                                            @if($hotSearch->items->count() > 0)
                                                <div class="text-sm">
                                                    @foreach($hotSearch->items->take(3) as $item)
                                                        <span class="inline-block bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs mr-1 mb-1">
                                                            {{ $item->item_name }}
                                                        </span>
                                                    @endforeach
                                                    @if($hotSearch->items->count() > 3)
                                                        <span class="text-gray-500 text-xs">+{{ $hotSearch->items->count() - 3 }} khác</span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-gray-400 text-sm">Chưa có items</span>
                                            @endif
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $hotSearch->sort_order }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-900 text-white">
                                            {{ number_format($hotSearch->click_count) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <!-- Edit Button -->
                                            <a href="{{ route('admin.hot-searches.edit', $hotSearch) }}" 
                                               class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-50" 
                                               title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <!-- Toggle Status Button -->
                                            <form method="POST" action="{{ route('admin.hot-searches.toggle-status', $hotSearch) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="p-2 rounded-lg {{ $hotSearch->is_active ? 'text-orange-600 hover:text-orange-900 hover:bg-orange-50' : 'text-green-600 hover:text-green-900 hover:bg-green-50' }}"
                                                        title="{{ $hotSearch->is_active ? 'Tắt kích hoạt' : 'Kích hoạt' }}"
                                                        onclick="return confirm('{{ $hotSearch->is_active ? 'Bạn có muốn tắt kích hoạt mục này?' : 'Bạn có muốn kích hoạt mục này?' }}')">
                                                    <i class="fas fa-{{ $hotSearch->is_active ? 'toggle-on' : 'toggle-off' }}"></i>
                                                </button>
                                            </form>
                                            
                                            <!-- Delete Button (Keep for permanent deletion) -->
                                            <!-- <form method="POST" action="{{ route('admin.hot-searches.destroy', $hotSearch) }}" 
                                                  class="inline" onsubmit="return confirm('⚠️ CẢNH BÁO: Bạn có chắc chắn muốn XÓA VĨNH VIỄN mục này?\n\nHành động này KHÔNG THỂ hoàn tác!')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50" 
                                                        title="Xóa vĩnh viễn">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form> -->
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="flex items-center justify-between mt-6">
                    <div class="text-sm text-gray-700">
                        Hiển thị {{ $hotSearches->firstItem() }} đến {{ $hotSearches->lastItem() }} 
                        trong tổng số {{ $hotSearches->total() }} mục
                    </div>
                    <div>
                        {{ $hotSearches->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-search text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Chưa có hot search nào</h3>
                    <p class="text-gray-600 mb-4">Hãy tạo hot search đầu tiên để hiển thị trong ô tìm kiếm.</p>
                    <a href="{{ route('admin.hot-searches.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                        <i class="fas fa-plus mr-2"></i> Tạo Hot Search
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection