<?php

namespace App;

class Airtable
{

    protected $table;
    public $fields;
    public $id;

    public function __construct($data = null)
    {
        if (isset($data)) {
            $this->id = isset($data->id) ? $data->id : null;
            $this->fields = isset($data->fields) ? $data->fields : null;
        }
    }

    public function id()
    {
        return isset($this->id) ? $this->id : null;
    }

    public function name()
    {
        return isset($this->fields->Name) ? $this->fields->Name : null;
    }

    /**
     * @return \TANIOS\Airtable\Airtable
     * @throws \Exception
     */
    public static function api()
    {
        if (! env('AIRTABLE_API_KEY') || ! env('AIRTABLE_BASE_ID')) {
            throw new \Exception("Need to set airtable api key and base ID");
        }

        $airtable = new \TANIOS\Airtable\Airtable(array(
            'api_key' => env('AIRTABLE_API_KEY'),
            'base'    => env('AIRTABLE_BASE_ID'),
        ));

        return $airtable;
    }

    /**
     * @param $content
     * @param $update
     *
     * @throws \Exception
     */
    public function save($update)
    {
        if (! $this->table || ! $this->id) {
            throw new \Exception("Missing table or id when trying to save");
        }

        $content = $this->table . "/" . $this->id;
        $result = self::api()->updateContent($content, $update);
        if (isset($result->error->message)) {
            throw new \Exception($result->error->message);
        }

        $this->id = $result->id;
        $this->fields = $result->fields;

        return $this;
    }

    /**
     * @param $content
     * @param $update
     *
     * @throws \Exception
     */
    public function delete()
    {
        if (! $this->id) {
            throw new \Exception("Missing id on this record when trying to delete");
        }

        $content = $this->table . "/" . $this->id;
        $result = self::api()->deleteContent($content);
        if (isset($result->error->message)) {
            throw new \Exception($result->error->message);
        }

        return $this;
    }

    /**
     * @param $content
     *
     * @return \TANIOS\Airtable\Response
     * @throws \Exception
     */
    public function getContent($content, $params = "")
    {
        $request = self::api()->getContent($content, $params);
        $result = $request->getResponse();
        if (isset($result->error->message)) {
            throw new \Exception($result->error->message);
        }

        return $result;
    }

    /**
     * @param $id
     *
     * @return $this|null
     * @throws \Exception
     */
    public function load($id)
    {
        $content = $this->table . "/" . $id;

        $request = self::api()->getContent($content);
        $result = $request->getResponse();
        if (isset($result->error->message)) {
            throw new \Exception($result->error->message);
        }

        if (!isset($result->id)) {
            return null;
        }

        $this->id = $result->id;
        $this->fields = $result->fields;

        return $this;
    }

    /**
     * @param        $content
     * @param string $params
     *
     * @return array|mixed|null
     * @throws \Exception
     */
    public function getRecords($params = "")
    {
        try {
            $result = $this->getContent($this->table, $params);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage() . ": {$this->table} - " . print_r($params, 1));
        }

        if (isset($result['records'])) {
            $classes = [];
            foreach ($result['records'] as $record) {
                $classes[] = new static($record);
            }
            return $classes;
        }

        return [];
    }

    /**
     * @param        $content
     * @param string $params
     *
     * @return array|mixed|null
     * @throws \Exception
     */
//    public static function getRecordsWithOffset($content, $params = "")
//    {
//        $result = self::getContent($content, $params);
//        if (isset($result['records'])) {
//            return [$result['records'], $result['offset']];
//        }
//
//        return [];
//    }

    /**
     * @param $content
     * @param $filter
     *
     * @return mixed|null
     * @throws \Exception
     */
    public function lookupWithFilter($filter)
    {
        $params = array(
            "filterByFormula" => $filter,
            "maxRecords"      => 1,
        );

        $records = $this->getRecords($params);
        if (isset($records[0])) {
            return $records[0];
        }

        return null;
    }

    /**
     * @param $content
     * @param $filter
     *
     * @return mixed|null
     * @throws \Exception
     */
    public function recordsWithFilter($filter)
    {
        $params = array(
            "filterByFormula" => $filter,
        );

        return $this->getRecords($params);
    }

    /**
     * @param $table
     * @param $data
     *
     * @deprecated use create() instead
     *
     * @return \TANIOS\Airtable\Response
     * @throws \Exception
     */
    public static function saveContent($table, $data)
    {
        $result = self::api()->saveContent($table, $data);
        if (isset($result->error->message)) {
            throw new \Exception($result->error->message);
        }

        return $result;
    }

    /**
     * @param $data
     *
     * @return static
     * @throws \Exception
     */
    public function create($data)
    {
        $result = self::api()->saveContent($this->table, $data);
        if (isset($result->error->message)) {
            throw new \Exception($result->error->message);
        }

        return new static($result);
    }

    public static function lookupField($airRecord, $fieldName)
    {
        return isset($airRecord->fields->$fieldName[0]) ? $airRecord->fields->$fieldName[0] : null;
    }

    public function searchTitle()
    {
        return isset($this->fields->{'Search Title'}) ? $this->fields->{'Search Title'} : 0;
    }

    public function searchIndexId()
    {
        return 'airtable_record_' . $this->id();
    }

    public function toSearchIndexArray()
    {
        return [
            'object_id'    => $this->searchIndexId(),
            'type'         => 'generic',
            'search_title' => $this->searchTitle(),
        ];
    }
}
