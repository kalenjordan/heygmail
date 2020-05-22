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

    public function isAdmin()
    {
        return Util::isAdmin($this);
    }

    public function url()
    {
        return '/users/' . $this->id();
    }

    public function searchTitle()
    {
        return isset($this->fields->{'Search Title'}) ? $this->fields->{'Search Title'} : 0;
    }

    public function searchIndexId()
    {
        return 'user_' . $this->id();
    }

    public function toSearchIndexArray()
    {
        return [
            'url'          => $this->url(),
            'object_id'    => $this->searchIndexId(),
            'type'         => 'blog',
            'search_title' => $this->searchTitle(),
            'name'         => $this->name(),
            'about'        => $this->about(),
            'location'     => $this->location(),
            'public'       => false,
        ];
    }

    public function status()
    {
        return isset($this->fields->{'Status'}) ? $this->fields->{'Status'} : null;
    }

    /**
     * @return mixed|null
     * @throws \Exception
     */
    public function favoriteThingsIds()
    {
        return isset($this->fields->{'Favorite Things'}) ? $this->fields->{'Favorite Things'} : [];
    }

    /**
     * @return mixed|null
     * @throws \Exception
     */
    public function favoriteThingsNames()
    {
        return isset($this->fields->{'Favorite Things Names'}) ? $this->fields->{'Favorite Things Names'} : [];
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function favoriteThingsVue()
    {
        $ids = $this->favoriteThingsIds();
        $names = $this->favoriteThingsNames();

        $results = [];
        for ($i = 0; $i < count($ids); $i++) {
            $results[] = [
                'id'     => $ids[$i],
                'name'   => $names[$i],
            ];
        }

        return $results;
    }
}