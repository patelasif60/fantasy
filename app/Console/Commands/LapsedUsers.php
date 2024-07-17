<?php

namespace App\Console\Commands;

use App\Enums\UserStatusEnum;
use App\Models\User;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class LapsedUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lapsed:users {filename?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migration of Lapsed Users - Please provide valid csv file with extension (ex. lapsed_auction_users.csv), csv file should be in folder "database/seeds/files".';

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
            // $filename = $this->ask('What is your csv filename (default: lapsed_auction_users.csv)?');
            // if (empty($filename)) {
            $filename = 'lapsed_auction_users.csv';
            // }
        }

        $userService = app(UserService::class);

        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = substr(str_shuffle($chars), 0, 8);

        $handle = fopen(database_path().'/seeds/files/'.$filename, 'r');

        // array:13 [
        //   0 => "Email"
        //   1 => "Username"
        //   2 => "First Name"
        //   3 => "Surname"
        //   4 => "Date of Birth"
        //   5 => "Address 1"
        //   6 => "Address 2"
        //   7 => "Address 3"
        //   8 => "Postcode"
        //   9 => "Country"
        //   10 => "Mobile Phone"
        //   11 => "Home Phone"
        //   12 => "Optin"
        // ]

        Log::channel('lapsed_users')->info('---------------- Script Started ----------------');
        $index = 1;
        $record = fgetcsv($handle);
        while (($record = fgetcsv($handle)) !== false) {
            unset($userArr);
            unset($consumerArr);

            $userArr['email'] = $record[0];
            $userArr['username'] = $record[1];
            $userArr['first_name'] = $record[2];
            $userArr['last_name'] = $record[3];

            if (trim($record[4]) != '' && trim($record[4]) != 'NULL') {
                $record[4] = str_replace('/', '-', $record[4]);
                $consumerArr['dob'] = Carbon::parse($record[4])->format('Y-m-d');
            }
            $consumerArr['address_1'] = $record[5];
            $consumerArr['town'] = $record[6];
            $consumerArr['county'] = $record[7];
            $consumerArr['post_code'] = $record[8];
            $consumerArr['country'] = $record[9];

            $consumerArr['telephone'] = $record[10];
            if (trim($record[10]) == '' || trim($record[10]) == 'NULL') {
                $consumerArr['telephone'] = $record[11];
            }

            $consumerArr['has_games_news'] = ($record[12] == 1) ? 1 : 0;

            if ($user = User::where(['email' => $userArr['email']])->first()) {
                Log::channel('lapsed_users')->info('User with email "'.$userArr['email'].'" already exists. USER_ID = '.$user->id);
                $this->info($index++.') User with email "'.$userArr['email'].'" already exists. USER_ID = '.$user->id);
            } else {
                if ($user = User::where(['username' => $userArr['username']])->first()) {
                    $userArr['username'] = $userArr['email'];
                    Log::channel('lapsed_users')->info('User with username "'.$userArr['username'].'" already exists. USER_ID = '.$user->id);
                    $this->info($index.') User with username "'.$userArr['username'].'" already exists. USER_ID = '.$user->id);
                }
                $user = User::create([
                    'first_name'    => $userArr['first_name'],
                    'last_name'     => $userArr['last_name'],
                    'email'         => $userArr['email'],
                    'username'      => $userArr['username'],
                    'password'      => Hash::make($password),
                    'status'        => UserStatusEnum::__default,
                    'provider'      => 'email',
                    'email_verified_at' => date('Y-m-d H:i:s'),
                ])->assignDefaultRole();

                $userService->createConsumerWithDetails($user, $consumerArr);

                Log::channel('lapsed_users')->info('New user registration with email "'.$userArr['email'].'" created. USER_ID = '.$user->id);
                $this->info($index++.') New user registration with email "'.$userArr['email'].'" created. USER_ID = '.$user->id);
            }
        }

        Log::channel('lapsed_users')->info('---------------- Script Completed ----------------');
        $this->info('All registration are completed');

        fclose($handle);
    }
}
