<?php

namespace ChrisBraybrooke\Helpers\Commands;

use Illuminate\Console\Command;

class CreateApiToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:token {userEmail : The email of the user.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a sanctum api token.';

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
            $token = $user->createToken('token-name');
            $this->info('Token: ' . $token->plainTextToken);
        } else {
            $this->error("Can't find user!");
        }
    }
}
