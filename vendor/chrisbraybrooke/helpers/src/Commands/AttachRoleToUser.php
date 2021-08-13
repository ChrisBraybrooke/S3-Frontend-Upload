<?php

namespace ChrisBraybrooke\Helpers\Commands;

use Illuminate\Console\Command;

class AttachRoleToUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:attach {userEmail : The email of the user.} {roleName : The name of the role to attache.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Attach a role to a user.';

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
        $user = config('helpers.user_model')::firstWhere('email', $this->argument('userEmail'));

        if ($user) {
            $user->assignRole($this->argument('roleName'));
            $this->info("{$user->name} attached to " . $this->argument('roleName'));
        } else {
            $this->error("Can't find user!");
        }
    }
}
