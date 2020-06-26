<?php

namespace App;

use GrahamCampbell\Markdown\Facades\Markdown;

class Screening extends Airtable
{

    protected $table = "Screenings";

    public function folder()
    {
        return isset($this->fields->Folder) ? $this->fields->Folder : null;
    }

    public function loadByEmail($email)
    {
        return $this->lookupWithFilter("LOWER(Email) = LOWER('$email')");
    }
}
