<?php

namespace App\Modules\Adminx\Models\gridComponent;

use App\Modules\Adminx\Models\Userx;

class UserxGenerator
{
    //------------------------------------------- constructor attributes
    public $gridxId;
    public $modelClass = '';
    public $filterView = '';
    public $pagination = 0;
    public $paginationFrame = 6;
    public $tableOptions = [
        'class' => 'table table-bordered table-hover table-condensed',
        'style' => ' width: 100%; table-layout: fixed;',
    ];
    public $headerOptions = [
    ];
    public $rowOptions = [];
    public $colOptions = [
        'headerOptions' => [
            'class' => 'headerColumn',
        ],
        'contentOptions' => [
            'class' => 'contentColumn'
        ],
    ];
    public $columns = [];
    public $sortOptions = [];

    public $requestParams = [];
    public $filterData = [];
    public $paginationData = [];

    //------------------------------------------ pagination attributes
    public $sort = [];
    public $offset = 0;
    public $limit=0;
    public $page = 1;

    //------------------------------------------ filter attributes
    public $name;
    public $email;


    //------------------------------------------ other
    public $totalCount;
    public $query;


    //------------------------------------------ getters
  //  public $header;
  //  public $filter;

    public function __construct($params, $requestParams = [])
    {
        $r = 1;
        $this->loadData($params);

        $this->loadData($requestParams);

        /*
        if (!empty($requestParams['page'])){
            $this->page = $requestParams['page'];
        }

        if (!empty($requestParams['offset'])){
            $this->offset = $requestParams['offset'];
        }
        */

        if ( (isset($requestParams['filter']))){
            $this->loadData($requestParams['filter']);
        }

        if ( (isset($requestParams['sort']))){
            $this->sort = $requestParams['sort'];
        }
     //  $this->loadData($this->paginationData);
    //    $this->loadData($this->filterData);

        //------------------------------------------------------------------------------------------------ grid configs
        /*
        $this->gridxId = $params['gridxId'];
        $this->modelClass = $params['modelClass'];
        $this->url = $params['url'];
        $this->filterView = (!empty($params['filterView'])) ? $params['filterView'] : '';
        $this->pagination = (!empty($params['pagination'])) ? $params['pagination'] : 0;
        $this->tableOptions = (!empty($params['tableOptions'])) ? $params['tableOptions'] : [];
        $this->headerOptions = (!empty($params['headerOptions'])) ? $params['headerOptions'] : [];
        $this->rowOptions = (!empty($params['rowOptions'])) ? $params['rowOptions'] : [];
        $this->colOptions = (!empty($params['colOptions'])) ? $params['colOptions'] : [];
        $this->columns = (!empty($params['columns'])) ? $params['columns'] : [];
        */

        //------------------------------------------------------------------------------------------------ grid pagination
        /*
        $this->offset = (!empty($requestParams['offset'])) ? $requestParams['offset'] : 0;
        $this->page = (!empty($requestParams['page'])) ? $requestParams['page'] : 1;
        $this->limit = $this->pagination;
        */

        //------------------------------------------------------------------------------------------------ grid filter

        //------------------------------------------------------------------------------------------------ grid sort

        //------------------------------------------------------------------------------------------------ grid init
        $this->init();
    }

    private function loadData($properties){
        if (!empty($properties)){
            foreach ($properties as $name => $value) {
                $this->$name = $value;
            }
        }
    }

    public function attributeLabels()
    {
        return [
          'name' => 'Login',
          'email' => 'Email',
        ];
    }

    public function init()
    {
        $this->limit = $this->pagination;
        $this->query = ($this->modelClass)::query();
        $this->getQueryWhere();
        $this->totalCount = $this->query->count(); //todo *******???????

    }

    /**
     * Добавление к $this->query условий фильтра
     */
    public function getQueryWhere()
    {
        $r=1;
        if (!empty($this->name)) {
            $this->query->where("name", "LIKE", "%" . $this->name . "%");
        }

        if (!empty($this->email)) {
            $this->query->where("email", "LIKE", "%$this->email%");
        }

    }

    /**
     * Получение набора моделей с учетом смещения и лимита
     * @return mixed
     */
    public function getQuery()
    {
       // $this->getQueryWhere();
     //   $this->query->orderBy('name','asc');
     //   $this->query->orderBy('email','desc');
        $r=1;

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

    /**
     * @return array
     */
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

    /**
     * Возврашает массив заголовков
     *
     * @return array
     */
    public function getHeader()
    {
        $ret = [];
        foreach ($this->columns as $colunm){
            $ret [] = (!empty($colunm['label'])) ? $colunm['label'] : $colunm['attribute'];
        }
        return $ret;
    }

    /**
     * Возвращает массив рядов таблицы в формате attribute => value для каждого ряда
     * @return array
     */
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

    /**
     * Возврашает массив кнопок пагинации
     *
     * @return array
     */
    public function getPaginateButtons()
    {
        $buttons = [];
        if ($this->totalCount > 0){
            $currentPage = $this->page;
            $pageSize = $this->limit;
            $pageCount = (int) (($this->totalCount + $pageSize - 1) / $pageSize);;

            $beginPage = max(0, $currentPage - (int) ($this->paginationFrame / 2));
            if (($endPage = $beginPage + $this->paginationFrame - 1) >= $pageCount) {
                $endPage = $pageCount - 1;
                $beginPage = max(0, $endPage - $this->paginationFrame + 1);
            }

            // first page
            $buttons [] = [
                'label' =>'first',
                'offset' => 0,
                'page' => 1,
                'active' => false,
                'disabled' => $currentPage == 1,
            ];

            // prev page
            $buttons [] = [
                'label' =>'prev',
                'offset' => ($currentPage > 1) ? ($this->offset - $this->limit) : 0,
                'page' => ($currentPage > 1) ? ($currentPage -1 ) : 1 ,
                'active' => false,
                'disabled' => $currentPage == 1,
            ];

            // internal pages
            for ($i = $beginPage; $i <= $endPage; ++$i) {
                $buttons [] = [
                    'label' => ($i + 1),
                    'offset' => $i * $this->limit,
                    'page' => ($i + 1),
                    'active' => ($i == $currentPage - 1),
                    'disabled' => ($i == $currentPage - 1),
                ];
            }

            // next page

            $buttons [] = [
                'label' =>'next',
                'offset' => ($currentPage <= $pageCount ) ? $this->offset + $this->limit : $this->totalCount,
                'page' => ($currentPage <= $pageCount ) ? $currentPage + 1 : $pageCount,
                'active' => false,
                'disabled' => $currentPage >= $pageCount,
            ];

            // last page
            $buttons [] = [
                'label' =>'last',
                'offset' => ($pageCount - 1) * $this->limit,
                'page' => $pageCount,
                'active' => false,
                'disabled' => $currentPage == $pageCount ,
            ];
        }


        return $buttons;
    }

    /**
     * Возврашает строку информации пагинации (25-35 (1987))
     *
     * @return string
     */
    public function getPaginationInfo()
    {
        if ($this->totalCount > 0){
            $ret = (($this->offset + $this->limit) < $this->totalCount)
                ? ($this->offset+1) . " - " . ($this->offset + $this->limit) . " (" . $this->totalCount . ")"
                : ($this->offset+1) . " - " . ($this->totalCount) . " (" . $this->totalCount . ")";
        } else {
            $ret = 0;
        }

        return $ret;
    }

    /**
     * Возврашает массив для перерисовки грида
     *
     * @return array
     */
    function getGridRefreshData()
    {
        $ret = [
            'tableBody' => $this->getTableBody(),
            'paginationButtons' => $this->getPaginateButtons(),
            'paginationInfo' => $this->getPaginationInfo(),
            'filterContent' => $this->getFilterContent(),
        ];
        return $ret;
    }




    /**
     *
     */
    public function getFilterContent()
    {
        $ret = '';
        $attrs = $this->attributeLabels();


        if (!empty($this->name)) {
            $ret = ' ' . $attrs['name'] . '=*' . $this->name . '*';
        }

        if (!empty($this->email)) {
            $ret .= ' ' . $attrs['email'] . '=*' . $this->email . '*';
        }

        if (strlen($ret) > 0){
            $ret = 'Filter:' . $ret;
        }

        return $ret;


    }


}