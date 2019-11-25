<?php

namespace App\Widgets\Models;


class ActiveFieldx
{
    public $attribute;
    public $id;
    public $name;
    public $type;
    public $value;
    public $wrapClass;

    public $inputClass = '';
    public $inputStyle = '';
    public $inputOptions = '';

    public $labelContent = '';
    public $labelClass = '';
    public $labelStyle = '';
    public $labelOptions = '';

    public $errorBlockId;
    public $errorBlockClass = '';
    public $errorBlockStyle = '';
    public $errorBlockOptions = '';



    public function __construct($attribute, $options = [])
    {
        $i = 1;
        $this->attribute = $attribute;
        $this->id = $options['id'];
        $this->name = $options['name'];
        $this->type = $options['type'];
        $this->value = $options['value'];
        $this->wrapClass = $options['wrapClass'] ?? '';

        $this->inputClass = $options['inputClass'] ?? '';
        $this->inputStyle = $options['inputStyle']?? '';

        $this->labelContent = $options['labelContent'] ?? '';
        $this->labelClass = $options['labelClass'] ?? '';
        $this->labelStyle = $options['labelStyle']?? '';

        $this->errorBlockId = $options['errorBlockId'] ?? '';
        $this->errorBlockClass = $options['errorBlockClass'] ?? '';
        $this->errorBlockStyle = $options['errorBlockStyle'] ?? '';


        if (!empty( $options['inputOptions'])){
            foreach ($options['inputOptions'] as $option){
                if (is_array($option)){
                    if (key($option) != 'class' && key($option) != 'style'){
                        $this->inputOptions .= ' ' . key($option) . '"=' . $option[key($option)] . '"';
                    }
                } elseif (is_string($option)){
                    $this->inputOptions .= ' ' . $option;
                }
            }
        }
        if (!empty( $options['labelOptions'])){
            foreach ($options['labelOptions'] as $option){
                if (is_array($option)){
                    $this->labelOptions .= ' ' . key($option) . '"=' . $option[key($option)] . '"';
                } elseif (is_string($option)){
                    $this->labelOptions .= ' ' . $option;
                }
            }
        }
        if (!empty( $options['errorBlockOptions'])){
            foreach ($options['errorBlockOptions'] as $option){
                if (is_array($option)){
                    $this->errorBlockOptions .= ' ' . key($option) . '"=' . $option[key($option)] . '"';
                } elseif (is_string($option)){
                    $this->errorBlockOptions .= ' ' . $option;
                }
            }
        }

    }

    public function label($text)
    {
        if ($text && is_string($text)){
            $this->labelContent = $text;
        }  else {
            $this->labelContent = '';
        }
        return $this;
    }


    public function getContent()
    {
        $label = (!empty($this->labelContent))
            ?  '<label'
            . ' for="' . $this->id . '"'
            . ' ' . $this->labelClass
            . ' ' . $this->labelStyle
            . ' ' . $this->labelOptions
            .'>'
            . $this->labelContent
            . '</label>' . PHP_EOL
            : '';
        $ret = '
            <div class="' . $this->wrapClass . '">' . PHP_EOL
                . $label . PHP_EOL
                . $this->getInputContent() . PHP_EOL
                . '<p'
                      . ' ' . $this->errorBlockClass
                      . ' ' . $this->errorBlockStyle
                      . ' ' . $this->errorBlockOptions
                      . '>'
                . '</p>' . PHP_EOL
            . '</div>';
        return $ret;

    }

    private function getInputContent()
    {
        $ret = "<b>undefened type</b>";
        switch ($this->type){
            case 'text':
                $ret = '
                    <input type="text" id="' . $this->id . '"'
                    . ' ' . $this->inputClass
                    . ' ' . $this->inputStyle
                    . ' value="' . $this->value . '"'
                    . ' ' . $this->inputOptions . '>
                ';
                break;
        }
        return $ret;
    }

    public function __toString()
    {
        /*
        $ret = view('Widgets::activeFormx.activeFieldx', [
            'attribute' => $this->attribute,
        ]);
        return $ret->render();
        */
        $ret = $this->getContent();
        return $ret;
    }
}