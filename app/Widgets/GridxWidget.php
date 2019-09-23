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

    public $tableClass;
    public $tableStyle;
    public $headerClass;
    public $headerStyle;



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

        $this->tableClass = (!empty($generator->tableOptions) && !empty($generator->tableOptions['class']))
            ? $generator->tableOptions['class']
            :"";
        $this->tableStyle = (!empty($generator->tableOptions) && !empty($generator->tableOptions['style']))
            ? $generator->tableOptions['style']
            :'';
        $this->headerClass = (!empty($generator->headerOptions) && !empty($generator->headerOptions['class']))
            ? 'class="' . $generator->tableOptions['class'] . '"'
            :'';
        $this->headerStyle = (!empty($generator->headerOptions) && !empty($generator->headerOptions['style']))
            ? 'style="' . $generator->tableOptions['style'] . '"'
            :'';



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
            'gridxId' => $this->generator->gridxId,
            'modelClass' => $this->generator->modelClass,
            'filterView' => $this->generator->filterView,
            'pagination' => $this->generator->pagination,
            'rowOptions' => $this->generator->rowOptions,
            'colOptions' => $this->generator->colOptions,
            'columns' => $this->generator->columns,
            'header' => $this->generator->getHeader(),
            'filter' => $this->generator->getFilter(),
            'tableBody' => $this->generator->getTableBody(),
            'paginationInfo' => $this->generator->getPaginationInfo(),
            'paginationButtons' => $this->generator->getPaginateButtons(),
            'filterContent' => $this->generator->getFilterContent(),
            'sortOptions' => $this->generator->sortOptions,
            'sort' => $this->generator->sort,

            'tableClass' => $this->tableClass,
            'tableStyle' => $this->tableStyle,
            'headerClass' => $this->headerClass,
            'headerStyle' => $this->headerStyle,


        ]);
    }
}