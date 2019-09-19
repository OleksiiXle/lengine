<?php

namespace App\Modules\Adminx\Models\gridComponent;

use App\Modules\Adminx\Models\Userx;

class UserxGenerator
{
    //------------------------------------------- constructor attributes
    public $url;
    public $modelClass;
    public $filterView;
    public $pagination = 0;
    public $paginationFrame = 6;
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
    public $requestType = 'normal';  // normal or ajax
    public $sort = [];
    public $offset = 0;
    public $limit;
    public $page = 1;

    //------------------------------------------ filter attributes
    public $filter_name = '';
    public $filter_email = '';
    public $query;

    //------------------------------------------ other
    public $totalCount;


    //------------------------------------------ getters
  //  public $header;
  //  public $filter;

    public function __construct($params)
    {
        $r = 1;
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

        $this->offset = (!empty($params['offset'])) ? $params['offset'] : 0;
        $this->page = (!empty($params['page'])) ? $params['page'] : 1;
        $this->limit = $this->pagination;

        $this->query = ($this->modelClass)::query();
        $this->totalCount = $this->query->count();

    }

    public function attributeLabels()
    {
        return [
          'filter_name' => 'Login',
          'filter_email' => 'Email',
        ];
    }

    /**
     * Добавление к $this->query условий фильтра
     */
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

    /**
     * Получение набора моделей с учетом смещения и лимита
     * @return mixed
     */
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

        return $buttons;
    }

    /**
     * Возврашает строку информации пагинации (25-35 (1987))
     *
     * @return string
     */
    public function getPaginationInfo()
    {
        $ret = (($this->offset + $this->limit) < $this->totalCount)
            ? ($this->offset+1) . " - " . ($this->offset + $this->limit) . " (" . $this->totalCount . ")"
            : ($this->offset+1) . " - " . ($this->totalCount) . " (" . $this->totalCount . ")";

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
        ];
        return $ret;
    }




    /**
     *
     */
    public function getFilterContent()
    {

    }


}