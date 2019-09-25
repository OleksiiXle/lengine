<?php

namespace App\Modules\Adminx\Models\gridComponent;

use Illuminate\Support\Facades\Validator;


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

    public $result = [
        'status' => true,
        'data' => 'ok',
    ];


    //------------------------------------------ getters
  //  public $header;
  //  public $filter;

    public function __construct($params, $requestParams = [])
    {
        //todo подумать над валидацией всех данных
        $r = 1;
        $this->loadData($params);
        if ($this->validate($requestParams)){

            $this->loadData($requestParams);

            if ( (isset($requestParams['filter']))){
                $this->loadData($requestParams['filter']);
            }

            if ( (isset($requestParams['sort']))){
                $this->sort = $requestParams['sort'];
            }

        }
        $this->init();
    }

    private function loadData($properties){
        if (!empty($properties)){
            foreach ($properties as $name => $value) {
                $this->$name = $value;
            }
        }
    }

    public function rules()
    {
        return [
           // 'name' => 'required|max:2',
            'name' => 'min:2|max:255|alpha_dash',
            'email' => 'min:2|max:255|email',
        ];
    }

    public function validate($requestParams)
    {
        $t=1;
        if (!empty($requestParams['filter'])){
            $validator = Validator::make($requestParams['filter'], $this->rules());
            if ($validator->fails()) {
                $r=1;
                $this->result = [
                    'status' => false,
                    'data' => $validator->errors()->messages(),
                ];
                return false;
            } else {
                $this->result = [
                    'status' => true,
                    'data' => 'ok',
                ];
            }
        }
        return true;


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
        if ($this->result['status']){
            $this->query = ($this->modelClass)::query();
            $this->getQueryWhere();
        } else {
            $model = new $this->modelClass;
            $this->query = ($this->modelClass)::query()->where($model->getTable() . '.id');

        }
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
        $r=1;
        if ($this->result['status']){
            $this->result = [
                'status' => false,
                'data' => 'error',
            ];
            try{
                $this->result = [
                    'status' => true,
                    'data' =>  [
                        'tableBody' => $this->getTableBody(),
                        'paginationButtons' => $this->getPaginateButtons(),
                        'paginationInfo' => $this->getPaginationInfo(),
                        'filterContent' => $this->getFilterContent(),
                    ]
                ];
            } catch (\Exception $e){
                $this->result['data'] = $e->getMessage();
            }
        }
        return $this->result;
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