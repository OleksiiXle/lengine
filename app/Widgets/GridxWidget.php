<?php

namespace App\Widgets;

use App\Widgets\Contract\ContractWidget;

class GridxWidget  implements ContractWidget
{

    private $id;

    /**
     * @var int a counter used to generate [[id]] for widgets.
     * @internal
     */
    public static $counter = 0;

    protected $params;

    public function __construct($params){
        $this->params = $params;
        if ($this->id === null) {
            $this->id = 'x' . static::$counter++;
        }
        $this->init();
    }

    /**
     * Returns the ID of the widget.
     * @param bool $autoGenerate whether to generate an ID if it is not set previously
     * @return string ID of the widget.
     */
    public function getId()
    {
        return $this->_id;
    }

    public function init()
    {

    }





    public function execute(){
        return view('Widgets::gridx', [
            'id' => $this->id,
            'params' => $this->params
        ]);
    }
}