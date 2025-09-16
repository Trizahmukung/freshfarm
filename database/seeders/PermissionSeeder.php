<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use File;
use Illuminate\Support\Facades\Log;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $jsonPath = database_path("seeders/data/permissions.json");
            
            if (!File::exists($jsonPath)) {
                throw new \Exception("Permissions JSON file not found at: " . $jsonPath);
            }
            
            $json = File::get($jsonPath);
            $data = json_decode($json, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception("Invalid JSON format: " . json_last_error_msg());
            }
            
            // Handle different JSON structures
            if (isset($data['permissions']) && isset($data['roles'])) {
                // Direct object structure
                $permissions = $data['permissions'];
                $roles = $data['roles'];
            } elseif (isset($data[0]['permissions']) && isset($data[0]['roles'])) {
                // Array wrapper structure
                $permissions = $data[0]['permissions'];
                $roles = $data[0]['roles'];
            } else {
                throw new \Exception("Invalid JSON structure. Expected either direct object or array wrapper format.");
            }
            
            // Create permissions (with validation)
            $createdPermissions = [];
            foreach ($permissions as $permission) {
                // Trim and normalize permission names
                $normalizedPermission = trim($permission);
                $normalizedPermission = preg_replace('/\s+/', ' ', $normalizedPermission); // Replace multiple spaces with single space
                
                $permissionModel = Permission::firstOrCreate([
                    'name' => $normalizedPermission,
                    'guard_name' => 'api'
                ]);
                
                $createdPermissions[] = $normalizedPermission;
            }
            
            $this->command->info('Created permissions: ' . implode(', ', $createdPermissions));
            
            // Create roles and assign permissions (with validation)
            foreach ($roles as $roleData) {
                $role = Role::firstOrCreate([
                    'name' => $roleData['name'],
                    'guard_name' => 'api'
                ]);
                
                // Normalize and validate permissions before syncing
                $validPermissions = [];
                foreach ($roleData['permissions'] as $permissionName) {
                    $normalizedPermission = trim($permissionName);
                    $normalizedPermission = preg_replace('/\s+/', ' ', $normalizedPermission);
                    
                    // Check if permission exists
                    $permissionExists = Permission::where('name', $normalizedPermission)
                        ->where('guard_name', 'api')
                        ->exists();
                        
                    if ($permissionExists) {
                        $validPermissions[] = $normalizedPermission;
                    } else {
                        $this->command->warn("Permission '{$normalizedPermission}' does not exist for role '{$roleData['name']}'. Skipping.");
                    }
                }
                
                $role->syncPermissions($validPermissions);
                $this->command->info("Role '{$roleData['name']}' assigned permissions: " . implode(', ', $validPermissions));
            }
            
            $this->command->info('Permissions and roles seeded successfully!');
            
        } catch (\Exception $e) {
            $this->command->error('Error seeding permissions: ' . $e->getMessage());
            Log::error('PermissionSeeder error: ' . $e->getMessage());
        }
    }
}