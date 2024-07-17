<?php

namespace App\Console\Commands;

use App\Enums\UserStatusEnum;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class BulkUserEmailRegistration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bulkuser:email {filename?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bulk Users Registration via Email - Please provide valid csv file with extension (ex. new_registeration.csv), csv file should be in folder "database/seeds/files".';

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
        $filename = $this->argument('filename');

        if (empty($filename)) {
            // $filename = $this->ask('What is your csv filename (default: new_registeration.csv)?');
            // if (empty($filename)) {
            $filename = 'new_registeration.csv';
            // }
        }

        $userService = app(UserService::class);

        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = substr(str_shuffle($chars), 0, 8);

        $handle = fopen(database_path().'/seeds/files/'.$filename, 'r');

        Log::channel('new_registration')->info('---------------- Script Started ----------------');
        $index = 1;
        while (($email = fgetcsv($handle)) !== false) {
            $email = $email[0];

            if ($user = User::where(['email' => $email])->first()) {
                Log::channel('new_registration')->info('User with email "'.$email.'" already exists. USER_ID = '.$user->id);
                $this->info($index++.') User with email "'.$email.'" already exists. USER_ID = '.$user->id);
            } else {
                $lname = explode('@', $email)[0];
                $user = User::create([
                    'last_name'     => $lname,
                    'email'         => $email,
                    'username'      => $email,
                    'password'      => Hash::make($password),
                    'status'        => UserStatusEnum::__default,
                    'provider'      => 'email',
                    'email_verified_at' => date('Y-m-d H:i:s'),
                ])->assignDefaultRole();

                $userService->createConsumer($user, ['email' => $email]);

                Log::channel('new_registration')->info('New user registration with email "'.$email.'" created. USER_ID = '.$user->id);

                $this->info($index++.') New user registration with email "'.$email.'" created. USER_ID = '.$user->id);
            }
        }

        Log::channel('new_registration')->info('---------------- Script Completed ----------------');
        $this->info('All registration are completed');

        fclose($handle);
    }
}
