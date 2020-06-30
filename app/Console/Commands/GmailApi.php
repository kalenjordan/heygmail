<?php

namespace App\Console\Commands;

use App\GoogleClient;
use App\User;
use Illuminate\Console\Command;
use Google_Service_Gmail;

class GmailApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gmail:api';

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

    public function handle()
    {
        /** @var User $user */
        $user = (new User())->lookupWithFilter("Email = 'kalenj@gmail.com'");
        $accessToken = $user->googleAccessToken();

        $client = GoogleClient::client($accessToken);
        $service = new Google_Service_Gmail($client);
        $response = $service->users_messages->listUsersMessages($user->email(), [
            'q'          => 'test',
            'maxResults' => 2,
        ]);

        $messages = $response->getMessages();
        $i = 1;
        foreach ($messages as $message) {
            $messageDetail = $service->users_messages->get($user->email(), $message->id);
            $this->info("$i. " . $messageDetail->snippet);
            $i++;
        }
    }
}
