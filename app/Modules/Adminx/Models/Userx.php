<?php

namespace App\Modules\Adminx\Models;

use Illuminate\Database\Eloquent\Model;

class Userx extends Model
{

    protected $table = 'userx';
    protected $fillable = [];
    protected $guarded = [];

    public $scenario = 'default';
    public $rules;
    public $exeptionMessage = '';

    public function setScenario($scenario)
    {
        $settings = Settings::checkAndFill('Userx', $scenario);
        $this->scenario = $scenario;
        $this->rules = $settings['rules'];
        $this->fillable = $settings['fillable'];
        $this->guarded = $settings['guarded'];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
        ];
    }


    //********************************************************************************************************** SETTERS & GETTERS

    public function getTextTestAttribute()
    {
        return $this->name ." qwerty";
    }

    //********************************************************************************************************** ПЕРЕОПРЕДЕЛЕННЫЕ МЕТОДЫ

    public function save(array $options = [])
    {
        try{
            $ret = parent::save($options);
        } catch (\Exception $e){
            $this->exeptionMessage = $e->getMessage();
            $ret = false;
        }
        return $ret;
    }

    //********************************************************************************************************** СВЯЗАННЫЕ ДАННЫЕ



}
