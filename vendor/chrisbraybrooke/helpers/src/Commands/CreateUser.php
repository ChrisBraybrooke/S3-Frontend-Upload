<?php

namespace ChrisBraybrooke\Helpers\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user.';

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
        $name = $this->ask('Name:');
        $email = $this->ask('Email:');
        $password = $this->ask('Password:');

        $user = config('helpers.user_model')::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        $this->info('User created: ' . $user->id);
    }
}
