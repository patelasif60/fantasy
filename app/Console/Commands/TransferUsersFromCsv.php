<?php

namespace App\Console\Commands;

use App\Enums\UserStatusEnum;
use App\Models\Consumer;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class TransferUsersFromCsv extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to migrate users from CSV file to database';

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
        $this->info('Migration of users started');

        if (($handle = fopen(database_path().'/seeds/files/transfer_users.csv', 'r')) !== false) {
            $flag = true;

            $userIdMapping = [];
            $tempArray[0] = 'CSVID';
            $tempArray[1] = 'DBID';
            $userIdMapping[] = $tempArray;

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if ($flag) {
                    $flag = false;
                    continue;
                }

                $email = string_preg_replace($data[4]);
                $user = User::where('email', $email)->first();

                if ($user) {
                    $consumer = Consumer::where('user_id', $user->id)->first();
                    if (! $consumer) {
                        $consumer = Consumer::create([
                            'user_id' => $user->id,
                            'dob' => $data[9] != 'NULL' ? Carbon::parse($data[9])->format('Y-m-d') : null,
                            'address_1' => get_substring_from_string($data[11], '<a1>', '</a1>') ?? '',
                            'town' => get_substring_from_string($data[11], '<a2>', '</a2>') ?? '',
                            'county' => get_substring_from_string($data[11], '<a3>', '</a3>') ?? '',
                            'post_code' => get_substring_from_string($data[11], '<pc>', '</pc>') ?? '',
                            'country' => get_substring_from_string($data[11], '<cn>', '</cn>') ?? '',
                            'telephone' => $telephone,
                            'has_games_news' => $hasGamesNews ? true : false,
                            'has_third_parities' => false,
                        ]);
                    }
                    $tempArray[0] = $data[0];
                    $tempArray[1] = $consumer->id;
                    $userIdMapping[] = $tempArray;
                    info('User already exist.', ['UserID' => $data[0]]);
                    continue;
                }

                $telephone = get_substring_from_string($data[11], '<mt>', '</mt>') ?? '';
                if (! $telephone) {
                    $telephone = get_substring_from_string($data[11], '<ht>', '</ht>') ?? '';
                }
                $hasGamesNews = get_substring_from_string($data[11], '<optin>', '</optin>') ?? '';
                $user = User::create([
                    'first_name' => string_preg_replace($data[7]),
                    'last_name' => string_preg_replace($data[8]),
                    'email' => string_preg_replace($email),
                    'password' => bcrypt(Str::random(8)),
                    'username' => string_preg_replace($email),
                    'status' => UserStatusEnum::ACTIVE,
                    'provider' => 'email',
                ])->assignDefaultRole();

                $consumer = $user->consumer()->create([
                    'user_id' => $user->id,
                    'dob' => $data[9] != 'NULL' ? Carbon::parse($data[9])->format('Y-m-d') : null,
                    'address_1' => get_substring_from_string($data[11], '<a1>', '</a1>') ?? '',
                    'town' => get_substring_from_string($data[11], '<a2>', '</a2>') ?? '',
                    'county' => get_substring_from_string($data[11], '<a3>', '</a3>') ?? '',
                    'post_code' => get_substring_from_string($data[11], '<pc>', '</pc>') ?? '',
                    'country' => get_substring_from_string($data[11], '<cn>', '</cn>') ?? '',
                    'telephone' => $telephone,
                    'has_games_news' => $hasGamesNews ? true : false,
                    'has_third_parities' => false,
                ]);

                $tempArray[0] = $data[0];
                $tempArray[1] = $consumer->id;
                $userIdMapping[] = $tempArray;
            }

            fclose($handle);

            $this->createUserMappingCsv($userIdMapping);

            $this->info('Migration of users completed');
        }
    }

    private function createUserMappingCsv($userIdMapping)
    {
        $filename = database_path().'/seeds/files/transfer_user_id_map.csv';
        $handle = fopen($filename, 'w+');
        foreach ($userIdMapping as $row) {
            fputcsv($handle, $row);
        }

        fclose($handle);
    }
}
