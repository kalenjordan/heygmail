<?php

namespace App;

class Thing extends Airtable
{
    protected $table = "Things";

    public function name()
    {
        return isset($this->fields->{'Name'}) ? $this->fields->{'Name'} : null;
    }

    public function description()
    {
        return isset($this->fields->{'Description'}) ? $this->fields->{'Description'} : null;
    }

    public function price()
    {
        return isset($this->fields->{'Price'}) ? $this->fields->{'Price'} : 0;
    }

    public function priceFormatted()
    {
        return number_format($this->price(), 2);
    }

    public function isEnabled()
    {
        return isset($this->fields->{'Enabled'}) ? true : false;
    }

    public function editUrl()
    {
        return url('/account/things/' . $this->id());
    }
}