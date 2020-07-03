<?php

namespace App\Console\Commands;

use App\Models\Users\UsersRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UserEmailLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'neology:user-log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $userRepository = new UsersRepository();
        $users = $userRepository->getUsers();
        foreach ($users as $index => $value) {
            echo $users[$index]['email'];
            Log::debug('email user:'.$users[$index]['email']);
        }
    }
}
