<?php

namespace App\Console\Commands;

use App\Screening;
use App\Util;
use Illuminate\Console\Command;
use Webklex\IMAP\Client;
use Webklex\IMAP\Folder;
use Webklex\IMAP\Message;

class EmailSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:sync {--show-folders} {--limit=1}';

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

    protected function limit()
    {
        return ($this->option('limit') ? $this->option('limit') : 1);
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        $client = new Client([
            'host'          => Util::imapHost(),
            'port'          => Util::imapPort(),
            'username'      => Util::imapUsername(),
            'password'      => Util::imapPassword(),
            'encryption'    => 'ssl',
            'validate_cert' => true,
            'protocol'      => 'imap'
        ]);

        $client->connect();

        if ($this->option('show-folders')) {
            $this->info("Show folders");
            $folders = $client->getFolders();
            foreach($folders as $folder){
                /** @var Folder $folder */
                $this->info(" - " . $folder->name);
            }
            die();
        }

        /** @var \Webklex\IMAP\Support\FolderCollection $aFolder */
        $folder = $client->getFolder('To Process');

        $messages = $folder->messages()->leaveUnread()->all()->get();
        $i = 1;
        foreach ($messages as $message) {
            /** @var Message $message */
            $this->info("$i. Message: " . $message->subject);

            $screening = $this->senderScreening($message);
            if ($screening) {
                $folder = $screening->folder();
                $this->info(" - Screened in ($folder)");
                $message->moveToFolder($folder);
                $this->markAsRead($client, $folder);
            } else {
                $this->info(" - To Screen");
                $message->moveToFolder('To Screen');
            }

            $i++;
            if ($i > $this->limit()) {
                break;
            }
        }
    }

    /**
     * @param Client $client
     * @param $folderName
     * @throws \Webklex\IMAP\Exceptions\ConnectionFailedException
     * @throws \Webklex\IMAP\Exceptions\GetMessagesFailedException
     */
    protected function markAsRead(Client $client, $folderName)
    {
        $folderObject = $client->getFolder($folderName);
        $folderObject->messages()->markAsRead()->all()->get();
    }

    /**
     * @param Message $message
     * @throws \Exception
     */
    protected function senderScreening(Message $message)
    {
        /** @var Message $message */
        $from = $message->getFrom();
        $email = $from[0]->mail;
        $this->info(" - Email: " . $email);

        /** @var Screening $screening */
        $screening = (new Screening())->loadByEmail($email);
        if (! $screening) {
            return null;
        }

        return $screening;
    }
}
