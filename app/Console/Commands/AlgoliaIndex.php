<?php

namespace App\Console\Commands;

use Algolia\AlgoliaSearch\SearchClient;
use Algolia\AlgoliaSearch\SearchIndex;
use App\Blog;
use App\Util;
use Illuminate\Console\Command;

class AlgoliaIndex extends Command
{
    /** @var SearchIndex */
    protected $index;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'algolia:index {--limit=} {--v}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send data to algolia index';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function _limit()
    {
        return $this->option('limit') ? $this->option('limit') : 5;
    }

    /**
     * @throws \Algolia\AlgoliaSearch\Exceptions\MissingObjectId
     * @throws \Exception
     */
    public function handle()
    {
        $params = array(
            "sort" => [['field' => 'Published', 'direction' => "desc"]],
            "maxRecords" => $this->_limit(),
        );

        $client = SearchClient::create(Util::algoliaAppId(), Util::algoliaPrivateKey());
        $this->index = $client->initIndex('all');
        $this->info("Updating Algolia search index (limit: " . $this->_limit() . ")");

        $blogs = (new Blog())->getRecords($params);

        $this->info(count($blogs) . " blogs");
        foreach ($blogs as $blog) {
            $this->_indexBlog($blog);
        }

        return;
    }

    /**
     * @param Blog $blog
     *
     * @throws \Algolia\AlgoliaSearch\Exceptions\MissingObjectId
     */
    protected function _indexBlog(Blog $blog) {
        $this->info("Indexing blog: " . $blog->title()  . " - " . $blog->searchIndexId());
        $data = $blog->toSearchIndexArray();
        if ($this->option('v')) {
            foreach ($data as $key => $val) {
                $this->info("    - $key: $val");
            }
        }
        $this->index->saveObjects([$data], [
            'objectIDKey' => 'object_id',
        ]);
    }

}
