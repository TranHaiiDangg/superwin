<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PermissionManager;

class SyncPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:sync 
                            {--roles : Sync roles as well}
                            {--force : Force sync without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync permissions and roles from code config to database';

    private PermissionManager $permissionManager;

    public function __construct(PermissionManager $permissionManager)
    {
        parent::__construct();
        $this->permissionManager = $permissionManager;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Bắt đầu sync permissions...');

        if (!$this->option('force') && !$this->confirm('Bạn có chắc muốn sync permissions không?')) {
            $this->info('❌ Hủy bỏ sync permissions.');
            return 0;
        }

        // Sync permissions
        $this->info('📝 Đang sync permissions...');
        $permissionResults = $this->permissionManager->syncPermissions();
        
        $this->line("✅ Permissions: {$permissionResults['created']} tạo mới, {$permissionResults['updated']} cập nhật");

        // Sync roles nếu có option --roles
        if ($this->option('roles')) {
            $this->info('👥 Đang sync roles...');
            $roleResults = $this->permissionManager->syncRoles();
            
            $this->line("✅ Roles: {$roleResults['created']} tạo mới, {$roleResults['updated']} cập nhật");
            $this->line("✅ Permissions đã gán cho {$roleResults['permissions_synced']} roles");
        }

        $this->newLine();
        $this->info('🎉 Sync hoàn tất!');
        
        // Hiển thị summary
        $this->showSummary();

        return 0;
    }

    private function showSummary(): void
    {
        $this->info('📊 Tóm tắt hệ thống:');
        
        $permissions = $this->permissionManager->getPermissionsByModule();
        foreach ($permissions as $module => $perms) {
            $this->line("  📂 {$module}: " . count($perms) . " permissions");
        }
        
        if ($this->option('roles')) {
            $roles = $this->permissionManager->getRolesWithPermissions();
            $this->newLine();
            $this->info('👥 Roles:');
            foreach ($roles as $role) {
                $permCount = count($role['permissions'] ?? []);
                $this->line("  🎭 {$role['display_name']}: {$permCount} permissions");
            }
        }

        $this->newLine();
        $this->info('💡 Sử dụng:');
        $this->line('  • php artisan permissions:sync --roles    (sync cả roles)');
        $this->line('  • php artisan permissions:sync --force    (không hỏi xác nhận)');
    }
}
