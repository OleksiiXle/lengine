<?php

namespace App\Modules\Adminx\Models\gridComponent;

use App\Modules\Adminx\Models\Userx;

class UserxGenerator
{
    //------------------------------------------- constructor attributes
    public $modelClass;
    public $filterView;
    public $pagination = 0;
    public $tableOptions = [
        'class' => 'table table-bordered table-hover table-condensed',
        'style' => ' width: 100%; table-layout: fixed;',
    ];
    public $headerOptions = [];
    public $rowOptions = [];
    public $colOptions = [
        'headerOptions' => ['style' => 'color: blue'],
        'contentOptions' => ['style' => 'color: black'],
    ];
    public $columns = [];
    public $gridxId;

    //------------------------------------------ request attributes
    public $ajax = false;
    public $sort = [];
    public $offset;
    public $limit;

    //------------------------------------------ filter attributes
    public $filter_name = '';
    public $filter_email = '';
    public $query;

    //------------------------------------------ getters
  //  public $header;
  //  public $filter;

    public function __construct($params)
    {
        $r = 1;
        $this->gridxId = $params['gridxId'];
        $this->modelClass = $params['modelClass'];
        $this->filterView = (!empty($params['filterView'])) ? $params['filterView'] : '';
        $this->pagination = (!empty($params['pagination'])) ? $params['pagination'] : 0;
        $this->tableOptions = (!empty($params['tableOptions'])) ? $params['tableOptions'] : [];
        $this->headerOptions = (!empty($params['headerOptions'])) ? $params['headerOptions'] : [];
        $this->rowOptions = (!empty($params['rowOptions'])) ? $params['rowOptions'] : [];
        $this->colOptions = (!empty($params['colOptions'])) ? $params['colOptions'] : [];
        $this->columns = (!empty($params['columns'])) ? $params['columns'] : [];

        if (empty($this->offset) && empty($this->limit) && !empty($this->pagination)){
            $this->offset = 0;
            $this->limit = $this->pagination;
        }

        $this->query = ($this->modelClass)::query();
    }

    public function attributeLabels()
    {
        return [
          'filter_name' => 'Login',
          'filter_email' => 'Email',
        ];
    }

    public function getQueryWhere()
    {
        $r=1;
        if (!empty($this->filter_name)) {
            $this->query->where("name", "LIKE", "%" . $this->filter_name . "%");
        }

        if (!empty($this->filter_email)) {
            $this->query->where("email", "LIKE", "%$this->filter_email%");
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

    public function getFilter()
    {
        $ret = [];
        $attrs = $this->attributeLabels();
        foreach ($attrs as $key => $value){
            $ret[$key] = [
                'value' => $this->{$key},
                'label' => $value,
            ];
        }
        return $ret;
    }

    public function getHeader()
    {
        $ret = [];
        foreach ($this->columns as $colunm){
            $ret [] = (!empty($colunm['label'])) ? $colunm['label'] : $colunm['attribute'];
        }
        return $ret;
    }

    public function getTableBody()
    {
        $ret = [];
        $datas = $this->getQuery();
        foreach ($datas as $data){
            $rowData = [];
            foreach ($this->columns as $colunm){
                if (empty($colunm['content'])){
                    if (isset($data->{$colunm['attribute']})){
                        $rowData[$colunm['attribute']] = $data->{$colunm['attribute']};
                    }
                } else {
                    $r = 1;
                    $rowData[$colunm['attribute']] = call_user_func($colunm['content'], $data);
                }
            }
            $ret[] = $rowData;
        }
        return $ret;
    }

    public function getFilterContent()
    {

    }


}