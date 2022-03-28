<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\ReqresWrapper;
use App\Models\User;

class FetchUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches users from the Reqres API and stores them in the users table';

    protected $api;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->api = new ReqresWrapper();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $users = $this->api->getUsers();

        foreach ($users->data as $user_data) {
            $user = new User();

            $user->reqres_id = $user_data->id;
            $user->email = $user_data->email;
            $user->name = $user_data->first_name . ' ' . $user_data->last_name;
            $user->avatar = $user_data->avatar;

            $user->save();
        }

        return 0;
    }
}
