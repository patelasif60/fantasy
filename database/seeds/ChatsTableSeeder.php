<?php

use App\Models\Chat;
use App\Models\ChatRecipient;
use App\Models\Division;
use Illuminate\Database\Seeder;

class ChatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $divisions = Division::orderBy('id')->find([1, 2, 4, 5, 9]);

        if ($divisions->count()) {
            foreach ($divisions as $key => $division) {
                $managers = $division->divisionTeams->pluck('manager_id');
                if (! $managers->contains($division->chairman_id)) {
                    $managers = $managers->push($division->chairman_id);
                }

                if ($managers->count()) {
                    $recipients = $managers;
                    foreach ($managers as $key => $manager) {
                        for ($i = 0; $i < 100; $i++) {
                            $chat = Chat::create([
                                'division_id' => $division->id,
                                'sender_id' => $manager,
                                'message'=> 'Hey this is message no('.($i + 1).') from #'.$manager,
                            ]);

                            $chatsRecipients = [];

                            foreach ($recipients as $key => $recipient) {
                                if ($recipient != $manager) {
                                    $tempChat['created_at'] = now()->format(config('fantasy.db.datetime.format'));
                                    $tempChat['updated_at'] = now()->format(config('fantasy.db.datetime.format'));
                                    $tempChat['chat_id'] = $chat->id;
                                    $tempChat['receiver_id'] = $recipient;

                                    $chatsRecipients[] = $tempChat;
                                }
                            }

                            $this->createChatMessage($chatsRecipients);
                        }
                    }
                }
            }
        }
    }

    private function createChatMessage($data)
    {
        ChatRecipient::insert($data);
    }
}
