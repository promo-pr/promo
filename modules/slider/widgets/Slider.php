<?php
/**
 * Slider widget
 */
namespace app\modules\slider\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use app\modules\slider\models\backend\SliderItem;

/**
 * <?= \app\modules\slider\widgets\Slider::widget(['name' => 'front']) ?>
 */
class Slider extends Widget
{
    public $id = false;

    public $name = false;

    public $width;

    public $height;

    public $slidesToShow = 1;

    public $dots = false;

    public $infinite = false;

    public $centerMode = false;

    public $variableWidth = false;

    public $options = [];

    public $items;

    public function init()
    {
        parent::init();
        if (!$this->id) {
            $sliderId = \app\modules\slider\models\backend\Slider::findOne(['name' => $this->name]);
            $this->id = $sliderId->id;
        }
        Html::addCssClass($this->options, ['widget' => 'hidden widget-slider-' . $this->id]);
    }

    public function run()
    {
        $options = [
            'slidesToShow' => $this->slidesToShow,
            'dots' => $this->dots,
            'lazyLoad' => 'progressive',
            'infinite' => $this->infinite,
            'centerMode' => $this->centerMode,
            'variableWidth' => $this->variableWidth,
            'prevArrow' => '<i class="slick-prev material-icons">keyboard_arrow_left</i>',
            'nextArrow' => '<i class="slick-next material-icons">keyboard_arrow_right</i>',
            'customPaging' => 'function(slider, i) {return $("<i class=material-icons>radio_button_unchecked</i>")}',
        ];
        $value_arr = [];
        $replace_keys = [];
        foreach($options as $key => &$value){
            if(strpos($value, 'function(')===0){
                $value_arr[] = $value;
                $value = '%' . $key . '%';
                $replace_keys[] = '"' . $value . '"';
            }
        }
        $options = json_encode($options);
        $options = str_replace($replace_keys, $value_arr, $options);

        $this->items = SliderItem::findAll(['slider_id' => $this->id]);
        if ( $this->items ) {
            $view = $this->view;
            $view->registerJs("jQuery('.widget-slider-{$this->id}').removeClass('hidden').slick({$options});", $view::POS_LOAD);

            return implode("\n", [
                Html::beginTag('div', $this->options),
                $this->renderItems(),
                Html::endTag('div')
            ]) . "\n";
        }
    }

    public function renderItems()
    {
        $items = '';
        foreach ( $this->items as $i => $item ) {
            if ( $i > 0 ) {
                $img = "<img data-lazy={$item->files->getThumb($this->width, $this->height)}>";
            } else {
                $img = "<img src={$item->files->getThumb($this->width, $this->height)}>";
            }
            $title = $item->title == '' ? false : "<h3>$item->title</h3>";
            $body = $item->body == '' ? false : "<div class='widget-slider-item-body'>$item->body</div>";
            $content = $img . $title . $body;
            $items .= Html::tag('div', $content, ['class' => 'widget-slider-item']);
        }
        return $items;
    }

}