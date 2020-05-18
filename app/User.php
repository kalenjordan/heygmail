<?php

namespace App;

class User extends Airtable
{

    protected $table = "Users";

    public function email()
    {
        return isset($this->fields->{'Email'}) ? $this->fields->{'Email'} : null;
    }

    public function name()
    {
        return isset($this->fields->{'Name'}) ? $this->fields->{'Name'} : null;
    }

    public function about()
    {
        return isset($this->fields->{'About'}) ? $this->fields->{'About'} : null;
    }

    public function phone()
    {
        return isset($this->fields->{'Phone'}) ? $this->fields->{'Phone'} : null;
    }

    public function avatar()
    {
        return isset($this->fields->{'Avatar'}[0]->url) ? $this->fields->{'Avatar'}[0]->url : null;
    }

    public function location()
    {
        return isset($this->fields->{'Location'}) ? $this->fields->{'Location'} : null;
    }

    public function apiKey()
    {
        return isset($this->fields->{'API Key'}) ? $this->fields->{'API Key'} : null;
    }
}