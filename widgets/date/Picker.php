<?php

namespace app\widgets\date;

use yii;
use yii\base\Model;
use yii\bootstrap\Widget;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\base\InvalidConfigException;

class Picker extends Widget
{
    /**
     * @var Model the data model that this widget is associated with.
     */
    public $model;

    /**
     * @var string the model attribute that this widget is associated with.
     */
    public $attribute;

    /**
     * @var string the input name. This must be set if [[model]] and [[attribute]] are not set.
     */
    public $name;

    /**
     * @var string the input value.
     */
    public $value;

    /**
     * @var string the format DateTime.
     */
    public $format = 'dd.mm.yyyy - hh:ii';

    /**
     * @var boolean Time picker.
     */
    public $timepicker = true;

    /**
     * @var string|null Selector pointing to input to initialize js for.
     */
    public $selector;
    public $selectorHidden;

    public function init()
    {
        if ($this->name === null && !$this->hasModel()) {
            throw new InvalidConfigException("Either 'name', or 'model' and 'attribute' properties must be specified.");
        }
        if ($this->hasModel()) {
            $attr = $this->attribute;
            $this->value = $this->model->$attr;
            if ( $this->value == null ) {
                $this->value = time();
            }
        }
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->getId();
        }
        if ($this->selector === null) {
            $this->selector = '#' . $this->options['id'];
        }
        if ($this->selectorHidden === null) {
            $this->selectorHidden = '#picker-' . $this->options['id'];
        }
        $this->options['class'] = 'input-date-picker form-control';
        $this->options['readonly'] = true;
        parent::init();
    }

    public function run()
    {
        $this->registerClientScripts();

        if ($this->hasModel()) {
            $attr = $this->attribute;
            $this->value = $this->model->$attr;
            return Html::activeHiddenInput($this->model, $this->attribute, ['id' => 'picker-'.$this->options['id']])
            .Html::textInput($this->name, $this->value, $this->options);
        } else {
            return Html::textInput($this->name, $this->value, $this->options);
        }

    }

    /**
     * Register widget asset.
     */
    protected function registerClientScripts()
    {
        $time = $this->value.'000';
        $view = $this->getView();
        $asset = Yii::$container->get(DateAsset::className());
        $asset::register($view);
        $set = Json::encode([
            'timepicker' => $this->timepicker,
            'startDate' => '%start%',
            'altField' => $this->selectorHidden,
            'autoClose' => true,
            'onSelect' => '%ONSELECT%',
        ]);
        $js = <<<INIT
        var start = new Date({$time}),
            datepicker = $('{$this->selector}').datepicker({$set}).data('datepicker');
            datepicker.selectDate(start);
INIT;
        $js = str_replace('"%start%"', 'start', $js);
        $jsCallback = <<<CALLBACK
        if (d instanceof Date ){
        var timestamp = Math.round(d.getTime() / 1000);
        $('{$this->selectorHidden}').val(timestamp);
        } else {
        datepicker.selectDate(start);
        }
CALLBACK;
        $js = str_replace('"%ONSELECT%"', 'function(fd, d) {'.$jsCallback.'}', $js);
        $view->registerJs($js, $view::POS_READY);
    }

    /**
     * @return boolean whether this widget is associated with a data model.
     */
    protected function hasModel()
    {
        return $this->model instanceof Model && $this->attribute !== null;
    }
}