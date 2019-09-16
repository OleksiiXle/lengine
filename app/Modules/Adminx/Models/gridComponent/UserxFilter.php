<?php

namespace App\Modules\Adminx\Models\gridComponent;

class UserxFilter
{
    public $modelClass = 'App\Modules\Adminx\Models\gridComponent\UserxRow';
 //   public $pagination;
    public $sort;
    public $query;
    public $filterContent = '';
    public $offset;
    public $limit;

    public $filterName;
    public $filterEmail;

    public $columns;

    public function __construct($columns)
    {
        $r = 1;
        $this->query = ($this->modelClass)::query();
        $this->columns = $columns;
    }

    public function getQueryWhere()
    {
        $r=1;
        if (!empty($this->filterName)) {
            $this->query->where("name", "LIKE", "%" . $this->filterName . "%");
        }

        if (!empty($this->filterEmail)) {
            $this->query->where("email", "LIKE", "%$this->filterEmail%");
        }

    }

    public function getQuery()
    {
        $this->getQueryWhere();

        if (!empty($this->sort)){
            foreach ($this->sort as $key => $value){
                $this->query->orderBy($key, $value);
            }
        }

        if (!empty($this->offset)){
            $this->query->skip($this->offset);
        }

        if (!empty($this->limit)){
            $this->query->take($this->limit);
        }

        $ret = $this->query->get();

        $s =  $this->query->toSql();

        return $ret;

    }

    public function getRows()
    {
        $ret = [];
        $data = $this->getQuery();
        foreach ($data as $row){
            $buf = [];
            foreach ($this->columns as $column){
                $buf[$column] =  $row[$column];
            }
            $ret[] = $buf;
        }
        return $ret;
    }


    public function getFilterContent()
    {

    }



}