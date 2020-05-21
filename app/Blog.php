<?php

namespace App;

use GrahamCampbell\Markdown\Facades\Markdown;

class Blog extends Airtable
{

    protected $table = "Blogs";

    public function title()
    {
        return isset($this->fields->{'Title'}) ? $this->fields->{'Title'} : null;
    }

    public function slug()
    {
        return isset($this->fields->{'Slug'}) ? $this->fields->{'Slug'} : null;
    }

    public function content()
    {
        return isset($this->fields->{'Content'}) ? $this->fields->{'Content'} : null;
    }

    public function contentRendered()
    {
        if (!$this->content()) {
            return null;
        }

        return Markdown::convertToHtml($this->content());
    }

    public function category()
    {
        return isset($this->fields->{'Category'}) ? $this->fields->{'Category'} : 0;
    }

    public function categoryColorClass()
    {
        if ($this->category() == 'Things I Built') {
            return 'orange';
        } elseif ($this->category() == 'Product Ideas') {
            return 'green';
        } elseif ($this->category() == "It's time to build") {
            return 'yellow';
        } else {
            return 'gray';
        }
    }

    public function url()
    {
        return '/blog/' . $this->slug();
    }

    public function searchTitle()
    {
        return isset($this->fields->{'Search Title'}) ? $this->fields->{'Search Title'} : 0;
    }

    public function searchIndexId()
    {
        return 'blog_' . $this->id();
    }

    public function toSearchIndexArray()
    {
        return [
            'url'          => $this->url(),
            'object_id'    => $this->searchIndexId(),
            'type'         => 'blog',
            'search_title' => $this->searchTitle(),
            'content'      => $this->content(),
            'category'     => $this->category(),
            'public'       => true,
        ];
    }
}