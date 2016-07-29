<?php

namespace xj\uploadify;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\web\View;
use yii\helpers\ArrayHelper;
use yii\widgets\InputWidget;

/**
 * Uploadify Widget
 * @author xjflyttp <xjflyttp@gmail.com>
 */
class Uploadify extends InputWidget
{

    /**
     * upload file to URL
     * @var string
     * @example
     * http://xxxxx/upload.php
     * ['article/upload']
     * ['upload']
     */
    public $url;

    /**
     * @var bool
     */
    public $csrf = true;

    /**
     * 是否渲染Tag
     * @var bool
     */
    public $renderTag = true;

    /**
     * uploadify js options
     * @var array
     * @example
     * [
     * 'height' => 30,
     * 'width' => 120,
     * 'swf' => '/uploadify/uploadify.swf',
     * 'uploader' => '/uploadify/uploadify.php',
     * ]
     * @see http://www.uploadify.com/documentation/
     */
    public $jsOptions = [];

    /**
     * @var int
     */
    public $registerJsPos = View::POS_LOAD;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        //init var
        if (empty($this->url)) {
            throw new InvalidConfigException('Url must be set');
        }
        if (empty($this->id)) {
            $this->id = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->getId();
        }
        $this->options['id'] = $this->id;
        if (empty($this->name)) {
            $this->name = $this->hasModel() ? Html::getInputName($this->model, $this->attribute) : $this->id;
        }

        //register Assets
        $assets = UploadifyAsset::register($this->view);

        $this->initOptions($assets);
        $this->initCsrfOption();

        parent::init();
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $this->registerScripts();
        if ($this->renderTag === true) {
            echo $this->renderTag();
        }
    }

    /**
     * init Uploadify options
     * @param [] $assets
     * @return void
     */
    protected function initOptions($assets)
    {
        $baseUrl = $assets->baseUrl;

        $this->jsOptions['uploader'] = $this->url;
        $this->jsOptions['swf'] = $baseUrl . '/uploadify.swf';

    }

    /**
     * @return void
     */
    protected function initCsrfOption()
    {
        if (false === $this->csrf) {
            return;
        }
        $request = Yii::$app->request;
        $request->enableCsrfValidation = true;
        $csrfParam = $request->csrfParam;
        $csrfValue = $request->getCsrfToken();
        $session = Yii::$app->session;
        $session->open();

        //write csrfValue to session
        if ($request->enableCookieValidation) {
            $cookieCsrfValue = Yii::$app->getRequest()->getCookies()->getValue($csrfParam);
            if (null === $cookieCsrfValue) {
                $cookieCsrfValue = Yii::$app->getResponse()->getCookies()->getValue($csrfParam);
            }
            $session->set($csrfParam, $cookieCsrfValue);
        }

        $sessionIdName = $session->getName();
        $sessionIdValue = $session->getId();
        $this->jsOptions = ArrayHelper::merge($this->jsOptions, [
            'formData' => [
                $sessionIdName => $sessionIdValue,
                $csrfParam => $csrfValue,
            ]
        ]);
    }

    /**
     * render file input tag
     * @return string
     */
    protected function renderTag()
    {
        return Html::fileInput($this->name, null, $this->options);
    }

    /**
     * register script
     */
    protected function registerScripts()
    {
        $jsonOptions = Json::encode($this->jsOptions);
        $script = <<<EOF
\$('#{$this->id}').uploadify({$jsonOptions});
EOF;
        $this->view->registerJs($script, $this->registerJsPos);
    }

}
