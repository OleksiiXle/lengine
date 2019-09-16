<?php

namespace App\Modules\Adminx\Models\gridComponent;

use Illuminate\Database\Eloquent\Model;


class UserxRow extends Model
{
    protected $table = 'userx';

    public function save(array $options = [])
    {
        return false;
    }

    public function delete()
    {
        return false;
    }



}