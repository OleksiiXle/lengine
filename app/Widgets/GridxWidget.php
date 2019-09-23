<?php

namespace App\Widgets;

use App\Widgets\Contract\ContractWidget;

class GridxWidget  implements ContractWidget
{

    private $id;
    private $generator;

    public $gridxId;
    public $modelClass;
    public $filterView;
    public $pagination;
    public $tableOptions;
    public $headerOptions;
    public $rowOptions;
    public $colOptions;
    public $columns;



    public $header;
    public $filter;
    public $tableBody;

    public $paginationInfo;
    public $paginationButtons;

    /**
     * @var int a counter used to generate [[id]] for widgets.
     * @internal
     */
    public static $counter = 0;


    public function __construct($generator)
    {
        $gridxId = $generator->gridxId;
        $modelClass = $generator->modelClass;
        $filterView = $generator->filterView;
        $pagination = $generator->pagination;
        $tableOptions = $generator->tableOptions;
        $headerOptions = $generator->headerOptions;
        $rowOptions = $generator->rowOptions;
        $colOptions = $generator->colOptions;
        $columns = $generator->columns;

        $header = $generator->getHeader();
        $filter = $generator->getFilter();
        $tableBody = $generator->getTableBody();
        $paginationInfo = $generator->getPaginationInfo();

        $this->generator = $generator;

        if ($this->id === null) {
            $this->id = 'x' . static::$counter++;
        }
        $this->init();
    }

    public function init()
    {

    }

    public function execute(){
        return view('Widgets::gridx.gridx', [
            'id' => $this->id,
            'url' => $this->generator->url,
            'gridxId' => $this->generator->gridxId,
            'modelClass' => $this->generator->modelClass,
            'filterView' => $this->generator->filterView,
            'pagination' => $this->generator->pagination,
            'tableOptions' => $this->generator->tableOptions,
            'headerOptions' => $this->generator->headerOptions,
            'rowOptions' => $this->generator->rowOptions,
            'colOptions' => $this->generator->colOptions,
            'columns' => $this->generator->columns,
            'header' => $this->generator->getHeader(),
            'filter' => $this->generator->getFilter(),
            'tableBody' => $this->generator->getTableBody(),
            'paginationInfo' => $this->generator->getPaginationInfo(),
            'paginationButtons' => $this->generator->getPaginateButtons(),
            'filterContent' => $this->generator->getFilterContent(),
        ]);
    }
}