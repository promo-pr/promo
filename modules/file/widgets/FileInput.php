<?php

namespace app\modules\file\widgets;

use Yii;

use yii\base\Model;
use yii\base\Widget;
use yii\bootstrap\Html;
use yii\helpers\Json;
use yii\base\InvalidConfigException;
use yii\helpers\Url;

class FileInput extends Widget
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
     * @var string|null Selector pointing to input to initialize js for.
     * Defaults to null meaning that input does not exist yet and will be
     * rendered by this widget.
     */
    public $selector;
    /**
     * @var bool Multiple upload.
     */
    public $multiple = false;

    /**
     * @var array the HTML attributes for the input tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->name === null && !$this->hasModel()) {
            throw new InvalidConfigException("Either 'name', or 'model' and 'attribute' properties must be specified.");
        }
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->getId();
        }
        if ($this->selector === null) {
            $this->selector = '#' . $this->options['id'];
        }
        $this->options['multiple'] = $this->multiple;
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerClientScripts();

        if ($this->hasModel()) {
            $files = $this->model->getAttachFiles (str_replace([' ', '[', ']'], '', $this->attribute));
            $preview = '';
            foreach ( $files as $i => $file) {
                $del = Url::to(['/admin/files/upload/delete', 'fid'=>$file->fid]);
                $preview .= "<div data-fid='$file->fid' class='upload thumbnail' style='background-image: url($file->thumb)'>";
                $preview .= "<span data-href='{$del}' class='hidden upload-delete text-danger'><i class=\"material-icons\">delete_forever</i></span>";
                $preview .= '</div>';
            }
            return "<div class='preview'>{$preview}</div>" . Html::activeFileInput($this->model, $this->attribute, $this->options);
        } else {
            return "<div class='preview'></div>" . Html::fileInput($this->name, $this->value, $this->options);
        }

    }

    /**
     * Register widget asset.
     */
    protected function registerClientScripts()
    {
        $view = $this->getView();
        $selector = Json::encode($this->selector);
        $asset = Yii::$container->get(Asset::className());
        $asset::register($view);
        $view->registerJs("jQuery($selector).widgetFileInput();", $view::POS_READY);
    }

    /**
     * @return boolean whether this widget is associated with a data model.
     */
    protected function hasModel()
    {
        return $this->model instanceof Model && $this->attribute !== null;
    }
}
