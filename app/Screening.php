<?php

namespace App;

use Google_Service_Gmail_Thread;

class Screening extends Airtable
{

    protected $table = "Screenings";

    public function folder()
    {
        return isset($this->fields->Folder) ? $this->fields->Folder : null;
    }

    public function email()
    {
        return isset($this->fields->Email) ? $this->fields->Email : null;
    }

    public function messageIdFilter()
    {
        return isset($this->fields->{'Message ID Filter'}) ? $this->fields->{'Message ID Filter'} : null;
    }

    public function subjectPattern()
    {
        return isset($this->fields->{'Subject Pattern'}) ? $this->fields->{'Subject Pattern'} : null;
    }

    public function loadByEmail($email)
    {
        return $this->lookupWithFilter("AND(
            LOWER(Email) = LOWER('$email'),
            Pattern = 0
        )");
    }

    public function matchesThread($email, $subject, $messageId)
    {
        $emailPattern = $this->email();
        if (!preg_match('/' . $emailPattern . '/', $email)) {
            return false;
        }

        if ($this->messageIdFilter() && !preg_match('/' . $this->messageIdFilter() . '/', $messageId)) {
            return false;
        }

        if ($this->subjectPattern() && !preg_match('/' . $this->subjectPattern() . '/', $subject)) {
            return false;
        }

        return true;
    }
}
