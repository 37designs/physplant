<?php

namespace App\Console\Commands;

use App\Permission\Permissions;
use Illuminate\Console\Command;
use App\User;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin {username*} {--create}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make users admins (Laratrust)';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('create')) {

            foreach ($this->argument('username') as $username) {
                User::create($username, null, null, Permissions::R_Admin);
            }

        } else {

            foreach ($this->argument('username') as $username) {
                $user = User::where('username', $username)->first();
                $user->detachRoles($user->roles);
                $user->attachRole(Permissions::R_Admin);
            }

        }
    }
}
