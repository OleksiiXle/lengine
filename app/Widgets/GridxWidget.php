<?php

namespace App\Widgets;

use App\Widgets\Contract\ContractWidget;

class GridxWidget  implements ContractWidget
{

    private $id;
    public $generator;

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

    /**
     * @var int a counter used to generate [[id]] for widgets.
     * @internal
     */
    public static $counter = 0;


    public function __construct($generator)
    {
        $this->gridxId = $generator->gridxId;
        $this->modelClass = $generator->modelClass;
        $this->filterView = $generator->filterView;
        $this->pagination = $generator->pagination;
        $this->tableOptions = $generator->tableOptions;
        $this->headerOptions = $generator->headerOptions;
        $this->rowOptions = $generator->rowOptions;
        $this->colOptions = $generator->colOptions;
        $this->columns = $generator->columns;

        $this->header = $generator->getHeader();
        $this->filter = $generator->getFilter();
        $this->tableBody = $generator->getTableBody();
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
            'gridxId' => $this->gridxId,
            'modelClass' => $this->modelClass,
            'filterView' => $this->filterView,
            'pagination' => $this->pagination,
            'tableOptions' => $this->tableOptions,
            'headerOptions' => $this->headerOptions,
            'rowOptions' => $this->rowOptions,
            'colOptions' => $this->colOptions,
            'columns' => $this->columns,
            'header' => $this->header,
            'filter' => $this->filter,
            'tableBody' => $this->tableBody,
        ]);
    }
}