@extends('admin.layouts.app')

@section('title', 'Quản lý Permissions')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Quản lý Permissions</h1>
        <div class="flex space-x-3">
            <div class="relative">
                <button onclick="toggleSyncMenu()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-sync mr-2"></i>Sync Permissions
                    <i class="fas fa-chevron-down ml-2"></i>
                </button>
                
                <!-- Sync Menu -->
                <div id="syncMenu" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
                    <div class="p-4 border-b border-gray-200">
                        <h4 class="font-medium text-gray-900 mb-2">Chọn cách sync</h4>
                        <p class="text-sm text-gray-600">Sync permissions và roles từ code vào database</p>
                    </div>
                    <div class="p-2">
                        <button onclick="syncPermissions()" class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded flex items-center">
                            <i class="fas fa-code mr-2 text-blue-500"></i>
                            <div>
                                <div class="font-medium">Sync từ Service</div>
                                <div class="text-xs text-gray-500">Dùng PermissionManager</div>
                            </div>
                        </button>
                        <button onclick="runArtisanCommand()" class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded flex items-center">
                            <i class="fas fa-terminal mr-2 text-green-500"></i>
                            <div>
                                <div class="font-medium">Chạy Artisan Command</div>
                                <div class="text-xs text-gray-500">php artisan permissions:sync</div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
            
            <button onclick="showAddPermissionModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-plus mr-2"></i>Thêm Permission
            </button>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="flex border-b border-gray-200 mb-6">
        <button onclick="switchMainTab('permissions-tab')" 
                class="main-tab-button active px-4 py-2 text-sm font-medium text-blue-600 border-b-2 border-blue-600">
            Permissions
        </button>
        <button onclick="switchMainTab('roles-tab')" 
                class="main-tab-button px-4 py-2 text-sm font-medium text-gray-500 hover:text-gray-700">
            Roles & Permissions
        </button>
    </div>

    <!-- Permissions Tab -->
    <div id="permissions-tab" class="main-tab-content">
        <div class="bg-white rounded-lg shadow-md">
            @if($permissions->count() > 0)
            @foreach($permissions as $module => $modulePermissions)
            <div class="border-b border-gray-200 last:border-b-0">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-700 capitalize">
                        {{ $module }} 
                        <span class="text-sm text-gray-500 font-normal">({{ $modulePermissions->count() }} permissions)</span>
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($modulePermissions as $permission)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $permission->display_name }}</h4>
                                    <p class="text-sm text-gray-500 mt-1">{{ $permission->name }}</p>
                                    @if($permission->description)
                                    <p class="text-xs text-gray-400 mt-2">{{ $permission->description }}</p>
                                    @endif
                                    <div class="mt-3">
                                        @if($permission->roles->count() > 0)
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($permission->roles as $role)
                                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                                {{ $role->display_name }}
                                            </span>
                                            @endforeach
                                        </div>
                                        @else
                                        <span class="text-xs text-gray-400">Chưa gán cho role nào</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <button onclick="deletePermission({{ $permission->id }}, '{{ $permission->display_name }}')" 
                                            class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
            @else
            <div class="p-8 text-center text-gray-500">
                <i class="fas fa-shield-alt text-4xl mb-4"></i>
                <p>Chưa có permissions nào. Hãy sync từ code hoặc thêm mới.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Roles Tab -->
    <div id="roles-tab" class="main-tab-content hidden">
        <div class="bg-white rounded-lg shadow-md p-6">
            @if($roles->count() > 0)
            <div class="space-y-6">
                @foreach($roles as $role)
                <div class="border border-gray-200 rounded-lg p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $role->display_name }}</h3>
                            @if($role->description)
                            <p class="text-sm text-gray-500 mt-1">{{ $role->description }}</p>
                            @endif
                            <p class="text-xs text-blue-600 mt-2">{{ $role->permissions->count() }} permissions</p>
                        </div>
                        <button onclick="editRolePermissions({{ $role->id }}, '{{ $role->display_name }}')" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                            <i class="fas fa-edit mr-2"></i>Chỉnh sửa
                        </button>
                    </div>
                    
                    @if($role->permissions->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                        @foreach($role->permissions->groupBy('module') as $module => $modulePermissions)
                        <div class="bg-gray-50 rounded p-3">
                            <h4 class="font-medium text-gray-700 capitalize mb-2">{{ $module }}</h4>
                            <div class="space-y-1">
                                @foreach($modulePermissions as $permission)
                                <div class="text-sm text-gray-600">{{ $permission->display_name }}</div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-gray-500 text-sm">Chưa có permissions nào</p>
                    @endif
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center text-gray-500">
                <i class="fas fa-users text-4xl mb-4"></i>
                <p>Chưa có roles nào.</p>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Permission Modal -->
<div id="addPermissionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Thêm Permission Mới</h3>
            </div>
            <form id="addPermissionForm" class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tên Permission</label>
                    <input type="text" name="name" placeholder="products.view" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tên hiển thị</label>
                    <input type="text" name="display_name" placeholder="Xem sản phẩm" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Module</label>
                    <select name="module" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Chọn module</option>
                        <option value="dashboard">Dashboard</option>
                        <option value="products">Products</option>
                        <option value="categories">Categories</option>
                        <option value="brands">Brands</option>
                        <option value="orders">Orders</option>
                        <option value="users">Users</option>
                        <option value="customers">Customers</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mô tả</label>
                    <textarea name="description" rows="3" placeholder="Mô tả permission này..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
            </form>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button onclick="hideAddPermissionModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                    Hủy
                </button>
                <button onclick="submitAddPermission()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Thêm Permission
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Role Permissions Modal -->
<div id="editRoleModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-screen overflow-y-auto">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Chỉnh sửa Permissions cho Role: <span id="roleEditName"></span></h3>
            </div>
            <form id="editRoleForm" class="p-6">
                <input type="hidden" id="editRoleId" name="role_id">
                <div id="permissionsGrid" class="space-y-4">
                    <!-- Permissions sẽ được load bằng JavaScript -->
                </div>
            </form>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button onclick="hideEditRoleModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">
                    Hủy
                </button>
                <button onclick="submitEditRole()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Cập nhật
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Tab switching
function switchMainTab(activeTabId) {
    document.querySelectorAll('.main-tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    document.querySelectorAll('.main-tab-button').forEach(button => {
        button.classList.remove('active', 'text-blue-600', 'border-blue-600');
        button.classList.add('text-gray-500');
    });
    
    document.getElementById(activeTabId).classList.remove('hidden');
    event.target.classList.add('active', 'text-blue-600', 'border-blue-600');
    event.target.classList.remove('text-gray-500');
}

// Toggle sync menu
function toggleSyncMenu() {
    const menu = document.getElementById('syncMenu');
    menu.classList.toggle('hidden');
    
    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('#syncMenu') && !event.target.closest('button[onclick="toggleSyncMenu()"]')) {
            menu.classList.add('hidden');
        }
    });
}

// Sync permissions (Service method)
async function syncPermissions() {
    document.getElementById('syncMenu').classList.add('hidden');
    
    const syncRoles = confirm('🎭 Bạn có muốn sync cả roles không?\n\n✅ Có: Sync permissions + roles\n❌ Không: Chỉ sync permissions');
    
    const loadingAlert = showLoadingAlert('🔄 Đang sync permissions từ code...');
    
    try {
        const response = await fetch('{{ route("admin.permissions.sync") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                sync_roles: syncRoles
            })
        });
        
        const result = await response.json();
        loadingAlert.close();
        
        if (result.success) {
            showSuccessAlert(result.message, result.summary);
            setTimeout(() => location.reload(), 2000);
        } else {
            alert('❌ ' + result.message);
        }
    } catch (error) {
        loadingAlert.close();
        alert('❌ Lỗi: ' + error.message);
    }
}

// Run Artisan Command
async function runArtisanCommand() {
    document.getElementById('syncMenu').classList.add('hidden');
    
    const syncRoles = confirm('🎭 Chạy với --roles?\n\n✅ Có: php artisan permissions:sync --roles --force\n❌ Không: php artisan permissions:sync --force');
    
    const loadingAlert = showLoadingAlert('⚡ Đang chạy Artisan command...');
    
    try {
        const response = await fetch('{{ route("admin.permissions.artisanSync") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                sync_roles: syncRoles,
                force: true
            })
        });
        
        const result = await response.json();
        loadingAlert.close();
        
        if (result.success) {
            showCommandResult(result);
            setTimeout(() => location.reload(), 3000);
        } else {
            alert('❌ ' + result.message);
        }
    } catch (error) {
        loadingAlert.close();
        alert('❌ Lỗi: ' + error.message);
    }
}

// Show loading alert
function showLoadingAlert(message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'fixed top-4 right-4 bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
    alertDiv.innerHTML = `
        <div class="flex items-center">
            <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-3"></div>
            <span>${message}</span>
        </div>
    `;
    document.body.appendChild(alertDiv);
    
    return {
        close: () => document.body.removeChild(alertDiv)
    };
}

// Show success alert
function showSuccessAlert(message, summary) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 max-w-md';
    
    let summaryHtml = '';
    if (summary) {
        summaryHtml = `
            <div class="mt-2 text-sm opacity-90">
                📊 Permissions: ${summary.total_permissions} | 
                👥 Roles: ${summary.total_roles} | 
                🔐 Users: ${summary.active_users}
            </div>
        `;
    }
    
    alertDiv.innerHTML = `
        <div class="flex items-start">
            <i class="fas fa-check-circle mr-3 mt-1"></i>
            <div>
                <div style="white-space: pre-line">${message}</div>
                ${summaryHtml}
            </div>
        </div>
    `;
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        if (document.body.contains(alertDiv)) {
            document.body.removeChild(alertDiv);
        }
    }, 5000);
}

// Show command result
function showCommandResult(result) {
    const alertDiv = document.createElement('div');
    alertDiv.className = 'fixed top-4 right-4 bg-gray-800 text-green-400 px-6 py-4 rounded-lg shadow-lg z-50 max-w-lg font-mono text-sm';
    
    let summaryHtml = '';
    if (result.summary) {
        summaryHtml = `
            <div class="mt-2 text-gray-300 text-xs">
                📊 Total: ${result.summary.total_permissions} permissions, ${result.summary.total_roles} roles, ${result.summary.active_users} users
            </div>
        `;
    }
    
    alertDiv.innerHTML = `
        <div>
            <div class="text-white font-bold mb-2">⚡ Command Output:</div>
            <div class="text-blue-400 mb-2">${result.command}</div>
            <div style="white-space: pre-line" class="bg-gray-900 p-2 rounded">${result.output || result.message}</div>
            ${summaryHtml}
        </div>
    `;
    document.body.appendChild(alertDiv);
    
    setTimeout(() => {
        if (document.body.contains(alertDiv)) {
            document.body.removeChild(alertDiv);
        }
    }, 8000);
}

// Add Permission Modal
function showAddPermissionModal() {
    document.getElementById('addPermissionModal').classList.remove('hidden');
}

function hideAddPermissionModal() {
    document.getElementById('addPermissionModal').classList.add('hidden');
    document.getElementById('addPermissionForm').reset();
}

async function submitAddPermission() {
    const form = document.getElementById('addPermissionForm');
    const formData = new FormData(form);
    
    try {
        const response = await fetch('{{ route("admin.permissions.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert('✅ ' + result.message);
            hideAddPermissionModal();
            location.reload();
        } else {
            alert('❌ ' + result.message);
        }
    } catch (error) {
        alert('❌ Lỗi: ' + error.message);
    }
}

// Delete Permission
async function deletePermission(id, name) {
    if (!confirm(`Bạn có chắc muốn xóa permission "${name}"?`)) {
        return;
    }
    
    try {
        const response = await fetch(`/admin/permissions/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert('✅ ' + result.message);
            location.reload();
        } else {
            alert('❌ ' + result.message);
        }
    } catch (error) {
        alert('❌ Lỗi: ' + error.message);
    }
}

// Edit Role Permissions
function editRolePermissions(roleId, roleName) {
    document.getElementById('editRoleId').value = roleId;
    document.getElementById('roleEditName').textContent = roleName;
    
    // Load permissions for this role
    loadRolePermissions(roleId);
    
    document.getElementById('editRoleModal').classList.remove('hidden');
}

function hideEditRoleModal() {
    document.getElementById('editRoleModal').classList.add('hidden');
}

async function loadRolePermissions(roleId) {
    // This would load permissions - for now, we'll use the data from the page
    const permissionsGrid = document.getElementById('permissionsGrid');
    permissionsGrid.innerHTML = 'Loading...';
    
    // In a real implementation, you'd fetch this data via AJAX
    // For now, we'll create a simple grid
    setTimeout(() => {
        permissionsGrid.innerHTML = `
            <p class="text-gray-600 mb-4">Chọn permissions cho role này:</p>
            <div class="text-sm text-gray-500">
                Feature này sẽ được implement chi tiết hơn. Hiện tại bạn có thể sử dụng edit user để gán permissions.
            </div>
        `;
    }, 500);
}

async function submitEditRole() {
    // Implementation for updating role permissions
    alert('Feature này đang được phát triển. Vui lòng sử dụng edit user để gán permissions.');
    hideEditRoleModal();
}
</script>
@endsection