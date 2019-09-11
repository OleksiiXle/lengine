<?php

namespace App\Modules\Adminx\Models;


class Settings
{
    const CHECK_AND_FILL = [
        'DefaultModel' => [
            'defaultScenario' => [
                'rules' => [],
                'fillable' => [],
                'guarded' => [],
            ],
        ],
        'Userx' => [
            'default' => [
                'rules' => [],
                'fillable' => [],
                'guarded' => [],
            ],
            'createByAdmin' => [
                'rules' => [
                    'name' => 'required|max:255',
                    'email' => 'required|max:255',
                ],
                'fillable' => [
                    'name', 'email',
                ],
                'guarded' => [
                ],
            ],
            'updateByAdmin' => [
                'rules' => [
                    'name' => 'required|max:255',
                    'email' => 'required|max:255',
                ],
                'fillable' => [
                    'name', 'email',
                ],
                'guarded' => [
                ],
            ],
        ],

    ] ;

    public static function checkAndFill($modelName, $scenario)
    {
        if (isset(self::CHECK_AND_FILL[$modelName]) && isset(self::CHECK_AND_FILL[$modelName][$scenario])){
            return self::CHECK_AND_FILL[$modelName][$scenario];
        } else {
            return self::CHECK_AND_FILL['DefaultModel']['defaultScenario'];
        }
    }

}