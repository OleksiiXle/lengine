<?php

namespace App\Widgets\Models;


class GridxRow
{
    public $id;

    public $columns;

    public function __construct($columns)
    {
        $this->columns = $columns;
    }

}