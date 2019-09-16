<?php

namespace App\Modules\Adminx\Models;

use Illuminate\Database\Query\Builder;

abstract class Filter
{
    //todo VALIDATION ************************************************************************************

    public $modelClass;

    public $query;

    public $filterContent = '';

    public $offset;

    public $limit;

    public function __construct($modelClass)
    {
        $r = 1;
        $this->modelClass = $modelClass;
        $this->query = ($modelClass)::query();
    }



    abstract public function getQueryWhere();

    abstract public function getFilterContent();

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


}