<?php

namespace App\Widgets;

use App\Widgets\Contract\ContractWidget;
use App\Widgets\Models\ActiveFieldx;

class ActiveFormxWidget  implements ContractWidget
{

    const ENABLE_FIELD_OPTION_STRING = [
        'disabled',
        'hidden',
        'left' ,
        'right'
    ];

    const ENABLE_FIELD_OPTION_ARRAY = [
        'align',
    ];

    /**
     * @var int a counter used to generate [[id]] for widgets.
     * @internal
     */
    public static $counter = 0;
    /**
     * @var string the prefix to the automatically generated widget IDs.
     * @see getId()
     */
    public static $autoIdPrefix = 'form_';

    public $id;
    public $model;
    public $attributeLabels;

    public $inputOptions = [
        'wrapClass' => 'form-group',
        'id' => '',
        'name' => '',
        'type' => '',
        'value' => '',
        'labelContent' => '',
        'inputClass' => 'class="form-control"',
        'inputStyle' => '',
        'labelClass' => 'class=control-label"',
        'labelStyle' => '',
        'errorBlockClass' => 'class="error-block"',
        'errorBlockStyle' => '',
        'inputOptions'  => [
          //  'class' => '',
          //  'style' => '',
        ],
        'labelOptions'  => [
           // 'class' => '',
          //  'style' => '',
        ],
        'errorBlockOptions'  => [
          //  'class' => '',
          //  'style' => '',
        ],
    ];


    /*
    <div class="form-group field-login-username required has-error">
        <label class="control-label" for="login-username">Логін</label>
        <input type="text" id="login-username" class="form-control" name="Login[username]" aria-required="true" aria-invalid="true">

        <p class="help-block help-block-error">Необхідно заповнити "Логін".</p>
    </div>
     */



    public function __construct($model, $options = [])
    {
        $i = 1;
        $this->model = $model;
        $this->id = (!empty($options['id']))
            ? $options['id']
            : static::$autoIdPrefix . static::$counter++;

        $className = get_class($model);
        $slashPos = strripos($className, "\\");
        $this->shortModelName = substr($className,  $slashPos ? $slashPos + 1 : 0);

        if (method_exists($this->model, 'attributeLabels')){
            $this->attributeLabels = $model->attributeLabels();
        }
    }

    private function getFieldId($attributeName)
    {
        $ret = mb_strtolower($this->shortModelName . '-' . $attributeName, 'UTF-8');
        return $ret;
    }

    private function getErrorBlockId($attributeName)
    {
        $ret = mb_strtolower('error-' . $this->shortModelName . '-' . $attributeName, 'UTF-8');
        return $ret;
    }


    private function getInputOptions($attribute, $type, $options = [])
    {
        if (!empty($options) && !empty($options['wrapClass'])){
            $this->inputOptions['wrapClass'] .= ' ' . $options['wrapClass'];
        }
        $this->inputOptions['id'] = $this->getFieldId($attribute);
        $this->inputOptions['name'] = $attribute;
        $this->inputOptions['type'] = $type;
        $this->inputOptions['value'] = (!empty($options) && !empty($options['value'])) ? $options['value'] : '';
        $this->inputOptions['errorBlockId'] = $this->getErrorBlockId($attribute);

        if (!empty($this->attributeLabels) && isset($this->attributeLabels[$attribute])){
            $this->inputOptions['labelContent'] = $this->attributeLabels[$attribute];
        }


        if (!empty($options['inputOptions']) && is_array($options['inputOptions'])){
            foreach ($options['inputOptions'] as $option){
                if (is_array($option)){
                    if (key($option) === 'class'){
                        $this->inputOptions['inputClass'] = 'class="' . $option[key($option)] . '"';
                    } elseif (key($option) === 'style'){
                        $this->inputOptions['inputStyle'] = 'style="' . $option[key($option)] . '"';
                    } elseif (in_array(key($option), static::ENABLE_FIELD_OPTION_ARRAY)){
                        if (in_array($option[key($option)], static::ENABLE_FIELD_OPTION_STRING)){
                            $this->inputOptions['inputOptions'] [$option[key($option)]] = $option[key($option)];
                        }
                    }
                } elseif (is_string($option) && in_array($option, static::ENABLE_FIELD_OPTION_STRING)){
                    $this->inputOptions['inputOptions'][] = $option;
                }
            }
        }
        if (!empty($options['labelOptions']) && is_array($options['labelOptions'])){
            foreach ($options['labelOptions'] as $option){
                if (is_array($option)){
                    if (key($option) === 'class'){
                        $this->inputOptions['labelClass'] = 'class="' . $option[key($option)] . '"';
                    } elseif (key($option) === 'style'){
                        $this->inputOptions['labelStyle'] = 'style="' . $option[key($option)] . '"';
                    } elseif (in_array(key($option), static::ENABLE_FIELD_OPTION_ARRAY)){
                        if (in_array($option[key($option)], static::ENABLE_FIELD_OPTION_STRING)){
                            $this->inputOptions['labelOptions'] [$option[key($option)]] = $option[key($option)];
                        }
                    }
                } elseif (is_string($option) && in_array($option, static::ENABLE_FIELD_OPTION_STRING)){
                    $this->inputOptions['labelOptions'][] = $option;
                }
            }
        }
        if (!empty($options['errorBlockOptions']) && is_array($options['errorOptions'])){
            foreach ($options['errorBlockOptions'] as $option){
                if (is_array($option)){
                    if (key($option) === 'class'){
                        $this->inputOptions['errorBlockClass'] = 'class="' . $option[key($option)] . '"';
                    } elseif (key($option) === 'style'){
                        $this->inputOptions['errorBlockStyle'] = 'style="' . $option[key($option)] . '"';
                    } elseif (in_array(key($option), static::ENABLE_FIELD_OPTION_ARRAY)){
                        if (in_array($option[key($option)], static::ENABLE_FIELD_OPTION_STRING)){
                            $this->inputOptions['errorBlockOptions'] [$option[key($option)]] = $option[key($option)];
                        }
                    }
                } elseif (is_string($option) && in_array($option, static::ENABLE_FIELD_OPTION_STRING)){
                    $this->inputOptions['errorBlockOptions'][] = $option;
                }
            }
        }
    }



    public function textInput($attribute, $options = [])
    {
        $this->getInputOptions($attribute, 'text', $options );
        $field = new ActiveFieldx($attribute, $this->inputOptions);
        return $field;
    }


    public function execute(){
    }

}