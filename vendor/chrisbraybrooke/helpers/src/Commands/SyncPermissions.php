<?php

namespace ChrisBraybrooke\Helpers\Commands;

use App\Providers\AuthServiceProvider;
use Illuminate\Console\Command;

class SyncPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:sync {--role=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync the permissions from the AuthService provider.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (method_exists(AuthServiceProvider::class, 'availablePermissions')) {
            foreach (AuthServiceProvider::availablePermissions() as $name => $permission) {
                config('helpers.permission_model')::firstOrCreate(['name' => $name], [
                    'group' => $permission['group'],
                    'description' => $permission['description']
                ]);
            }

            $this->call('permission:cache-reset');

            if ($roles = $this->option('role')) {
                $permissions = config('helpers.permission_model')::get();
                foreach ($roles as $key => $roleName) {
                    $role = config('helpers.role_model')::firstOrCreate(['name' => $roleName]);
                    foreach ($permissions as $key => $permission) {
                        $role->givePermissionTo($permission->name);
                    }
                }
            }
        } else {
            $this->error('Please define availablePermissions method on AuthServiceProvider');
        }
    }
}
