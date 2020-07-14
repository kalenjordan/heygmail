<?php

namespace App\Console\Commands;

use App\GoogleClient;
use App\Screening;
use App\User;
use App\Util;
use Google_Service_Gmail;
use Google_Service_Gmail_Thread;
use Google_Service_Gmail_ModifyThreadRequest;

class GmailApi extends AbstractCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gmail:api {--silent} {--email=} {--limit=1} {--to-process} {--screened-out} {--imbox} {--feed} {--paper-trail} {--all}';

    protected $labels;

    /** @var Google_Service_Gmail */
    protected $service;

    protected $email;

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

    public function handle()
    {
        $this->info("Processing Gmail");
        $filter = "";
        if ($this->option('email')) {
            $this->info(" - Filter: " . $this->option('email'));
            $this->info(" - Limit: " . $this->limit());
            $filter = "FIND('" . $this->option('email') . "', Email) > 0";
        }

        $users = (new User())->recordsWithFilter($filter);
        foreach ($users as $user) {
            try {
                $this->handleUser($user);
            } catch (\Exception $e) {
                if (strpos($e->getMessage(), "invalid authentication") !== false) {
                    $this->info(" - Refreshing access token");
                    $client = GoogleClient::refreshToken($user);
                    $this->service = new Google_Service_Gmail($client);
                    $this->handleUser($user);
                }
            }
        }
    }

    protected function handleUser(User $user)
    {
        $this->email = $user->email();
        $this->info("\nUser: $this->email");

        /** @var User $user */
        $user = (new User())->lookupWithFilter("Email = '$this->email'");

        $client = GoogleClient::client($user);
        $this->service = new Google_Service_Gmail($client);

        if ($this->option('to-process') || $this->option('all')) {
            $this->handleToProcess();
        }
        if ($this->option('imbox') || $this->option('all')) {
            $this->handleFolder('Imbox');
        }
        if ($this->option('screened-out') || $this->option('all')) {
            $this->handleFolder('Screened Out');
        }
        if ($this->option('feed') || $this->option('all')) {
            $this->handleFolder('Feed');
        }
        if ($this->option('paper-trail') || $this->option('all')) {
            $this->handleFolder('Paper Trail');
        }
    }

    protected function handleToProcess()
    {
        $toProcessLabelId = $this->labelIdForName('To Process');

        $this->info("\nTo Process:");

        $response = $this->service->users_threads->listUsersThreads($this->email, [
            'maxResults' => $this->limit(),
            'labelIds'   => [$toProcessLabelId]
        ]);

        $threads = $response->getThreads();
        $i = 1;
        foreach ($threads as $thread) {
            $threadDetail = $this->service->users_threads->get($this->email, $thread->id);

            $this->handleToProcessThread($i, $threadDetail);
            $i++;
        }
    }

    /**
     * @param $threadDetail Google_Service_Gmail_Thread
     */
    protected function handleToProcessThread($i, $threadDetail)
    {
        $labelIds = $this->labelsForThread($threadDetail);
        $snippet = $this->snippetForThread($threadDetail);
        $subject = $this->subject($threadDetail);
        $fromEmail = $this->fromEmail($threadDetail);
        $this->info("\n  $i. $subject ($snippet)");
        $this->info("   - Labels: " . implode(", ", $this->labelIdsToNames($labelIds)));
        $this->info("   - From: " . $fromEmail);

        $screening = $this->senderScreening($threadDetail);
        if ($screening) {
            $folder = $screening->folder();
            $labelIdToAdd = $this->labelIdForName($folder);
            $this->info("   - Screening found: " . $screening->name());
            $this->info("   - Moving to $folder and removing 'To Process' and Unread labels");

            $mods = new Google_Service_Gmail_ModifyThreadRequest();
            $mods->setAddLabelIds($labelIdToAdd);
            $mods->setRemoveLabelIds([$this->labelIdForName('To Process'), 'UNREAD']);
            $this->service->users_threads->modify($this->email, $threadDetail->id, $mods);
        } else {
            $this->info("   - To Screen");

            $mods = new Google_Service_Gmail_ModifyThreadRequest();
            $labelIdToAdd = $this->labelIdForName('To Screen');
            $mods->setAddLabelIds($labelIdToAdd);
            $mods->setRemoveLabelIds($this->labelIdForName('To Process'));
            $this->service->users_threads->modify($this->email, $threadDetail->id, $mods);
        }
    }

    protected function handleFolder($folder)
    {
        $this->info("\n$folder:");
        $labelName = str_replace(" ", "-", strtolower($folder));
        $query = "label:$labelName -label:p";
        $this->info(" - Query: $query");

        $response = $this->service->users_threads->listUsersThreads($this->email, [
            'maxResults' => $this->limit(),
            'q'          => $query,
        ]);

        $threads = $response->getThreads();
        $i = 1;
        foreach ($threads as $thread) {
            $threadDetail = $this->service->users_threads->get($this->email, $thread->id);

            $this->handleFolderThread($folder, $i, $threadDetail);
            $i++;
        }
    }

    /**
     * @param $threadDetail Google_Service_Gmail_Thread
     */
    protected function handleFolderThread($folder, $i, $threadDetail)
    {
        $labelIds = $this->labelsForThread($threadDetail);
        $snippet = $this->snippetForThread($threadDetail);
        $subject = $this->subject($threadDetail);
        $fromEmail = $this->fromEmail($threadDetail);
        $this->info("\n  $i. $subject ($snippet)");
        $this->info("   - Labels: " . implode(", ", $this->labelIdsToNames($labelIds)));
        $this->info("   - From: " . $fromEmail);

        $screening = $this->senderScreening($threadDetail);
        if ($screening) {
            $this->info("   - Already screened");
        } else {
            $this->info("   - Creating screening");

            (new Screening())->create([
                'Email'  => $fromEmail,
                'Folder' => $folder,
            ]);
        }

        $labelIdToAdd = $this->labelIdForName('p');
        $this->info("   - Applying label 'p'");

        $mods = new Google_Service_Gmail_ModifyThreadRequest();
        $mods->setAddLabelIds($labelIdToAdd);
        $this->service->users_threads->modify($this->email, $threadDetail->id, $mods);
    }

    protected function fromEmail($threadDetail)
    {
        $messages = $threadDetail->getMessages();

        /** @var \Google_Service_Gmail_Message $message */
        $message = $messages[0];
        foreach ($message->getPayload()->getHeaders() as $header) {
            /** @var \Google_Service_Gmail_MessagePartHeader $header */
            if ($header->getName() == 'From') {
                $fullFrom = $header->getValue();
                return Util::extractEmail($fullFrom);
            }
        }

        return null;
    }

    protected function subject($threadDetail)
    {
        $messages = $threadDetail->getMessages();
        /** @var \Google_Service_Gmail_Message $message */
        $message = $messages[0];
        foreach ($message->getPayload()->getHeaders() as $header) {
            /** @var \Google_Service_Gmail_MessagePartHeader $header */
            if ($header->getName() == 'Subject') {
                return $header->getValue();
            }
        }

        return null;
    }

    protected function messageId($threadDetail)
    {
        $messages = $threadDetail->getMessages();
        /** @var \Google_Service_Gmail_Message $message */
        $message = $messages[0];
        foreach ($message->getPayload()->getHeaders() as $header) {
            /** @var \Google_Service_Gmail_MessagePartHeader $header */
            if ($header->getName() == 'Message-Id') {
                return $header->getValue();
            }
        }

        return null;
    }

    protected function labelsForThread($threadDetail)
    {
        $messages = $threadDetail->getMessages();
        foreach ($messages as $message) {
            return $message->getLabelIds();
        }

        return null;
    }

    protected function snippetForThread($threadDetail)
    {
        $messages = $threadDetail->getMessages();
        foreach ($messages as $message) {
            /** @var \Google_Service_Gmail_Message $message */
            return $message->getSnippet();
        }

        return null;
    }

    protected function labels()
    {
        if (isset($this->labels)) {
            return $this->labels;
        }

        $labels = $this->service->users_labels->listUsersLabels($this->email);
        foreach ($labels as $label) {
            $labelDetail = $this->service->users_labels->get($this->email, $label->id);
            $labelDetail->getId();
            $this->labels[$labelDetail->getId()] = $labelDetail->getName();
        }

        return $this->labels;
    }

    protected function labelIdsToNames($labelIds)
    {
        $labels = $this->labels();
        $names = [];
        foreach ($labelIds as $labelId) {
            $names[] = $labels[$labelId];
        }

        return $names;
    }

    protected function labelIdForName($name)
    {
        $labels = $this->labels();
        foreach ($labels as $labelId => $labelName) {
            if ($labelName == $name) {
                return $labelId;
            }
        }

        return null;
    }

    /**
     * @param $email
     * @param $threadDetail Google_Service_Gmail_Thread
     * @return Screening|null
     */
    protected function senderScreening($threadDetail)
    {
        $email = $this->fromEmail($threadDetail);
        $subject = $this->subject($threadDetail);
        $messageId = $this->messageId($threadDetail);

        $this->info("   - Email: " . $email);

        $screening = (new Screening())->loadByEmail($email);
        if ($screening) {
            return $screening;
        }

        $screenings = (new Screening())->recordsWithFilter("Pattern = 1");
        foreach ($screenings as $screening) {
            /** @var Screening $screening */
            if ($screening->matchesThread($email, $subject, $messageId)) {
                return $screening;
            }
        }

        return null;
    }
}
