<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\redactor\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Url;
use yii\redactor\RedactorModule;
use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\JsExpression;
use yii\web\AssetBundle;
use yii\helpers\ArrayHelper;

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */

/**
 * Class Redactor
 * @package yii\redactor\widgets
 * @property AssetBundle $assetBundle
 * @property string $sourcePath
 * @property RedactorModule $module
 */
class Redactor extends InputWidget
{
    /**
     * @var string Module Id already configured for Application Module
     */
    public $moduleId = 'redactor';
    /**
     * @var array HTML attributes for textarea tag
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];
    /**
     * @var array The options underlying for setting up Redactor plugin.
     * @see http://imperavi.com/redactor/docs/settings
     */
    public $clientOptions = [];

    private $_assetBundle;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->defaultOptions();
        $this->registerAssetBundle();
        $this->registerRegional();
        $this->registerPlugins();
        $this->registerScript();
    }
    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->hasModel()) {
            echo Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textarea($this->name, $this->value, $this->options);
        }
    }

    /**
     * Sets default options
     */
    protected function defaultOptions()
    {
        $this->options = ArrayHelper::merge($this->options, $this->module->widgetOptions);
        $this->clientOptions = ArrayHelper::merge($this->clientOptions, $this->module->widgetClientOptions);
        if (!isset($this->options['id'])) {
            if ($this->hasModel()) {
                $this->options['id'] = Html::getInputId($this->model, $this->attribute);
            } else {
                $this->options['id'] = $this->getId();
            }
        }
        Html::addCssClass($this->options, 'form-control');

        $this->setOptionsKey('imageUpload', $this->module->imageUploadRoute);
        $this->setOptionsKey('fileUpload', $this->module->fileUploadRoute);

        $this->clientOptions['imageUploadErrorCallback'] = ArrayHelper::getValue($this->clientOptions, 'imageUploadErrorCallback', new JsExpression("function(json){alert(json.error);}"));
        $this->clientOptions['fileUploadErrorCallback'] = ArrayHelper::getValue($this->clientOptions, 'fileUploadErrorCallback', new JsExpression("function(json){alert(json.error);}"));

        if (isset($this->clientOptions['plugins']) && array_search('imagemanager', $this->clientOptions['plugins']) !== false) {
            $this->setOptionsKey('imageManagerJson', $this->module->imageManagerJsonRoute);
        }
        if (isset($this->clientOptions['plugins']) && array_search('filemanager', $this->clientOptions['plugins']) !== false) {
            $this->setOptionsKey('fileManagerJson', $this->module->fileManagerJsonRoute);
        }
    }

    /**
     * Register language for Redactor
     */
    protected function registerRegional()
    {
        $this->clientOptions['lang'] = ArrayHelper::getValue($this->clientOptions, 'lang', Yii::$app->language);
        $langAsset = 'lang/' . $this->clientOptions['lang'] . '.js';
        if (file_exists($this->sourcePath . DIRECTORY_SEPARATOR . $langAsset)) {
            $this->assetBundle->js[] = $langAsset;
        } else {
            ArrayHelper::remove($this->clientOptions, 'lang');
        }

    }

    /**
     * Register plugins for Redactor
     */
    protected function registerPlugins()
    {
        if (isset($this->clientOptions['plugins']) && count($this->clientOptions['plugins'])) {
            foreach ($this->clientOptions['plugins'] as $plugin) {
                $js = 'plugins/' . $plugin . '/' . $plugin . '.js';
                if (file_exists($this->sourcePath . DIRECTORY_SEPARATOR . $js)) {
                    $this->assetBundle->js[] = $js;
                }
                $css = 'plugins/' . $plugin . '/' . $plugin . '.css';
                if (file_exists($this->sourcePath . DIRECTORY_SEPARATOR . $css)) {
                    $this->assetBundle->css[] = $css;
                }
            }
        }
    }

    /**
     * Register clients script to View
     */
    protected function registerScript()
    {
        $clientOptions = (count($this->clientOptions)) ? Json::encode($this->clientOptions) : '';
        $this->getView()->registerJs("jQuery('#{$this->options['id']}').redactor({$clientOptions});");
    }

    /**
     * Register assetBundle
     */
    protected function registerAssetBundle()
    {
        $this->_assetBundle = RedactorAsset::register($this->getView());
    }

    /**
     * @return AssetBundle
     */
    public function getAssetBundle()
    {
        if (!($this->_assetBundle instanceof AssetBundle)) {
            $this->registerAssetBundle();
        }
        return $this->_assetBundle;
    }

    /**
     * @return bool|string The path of assetBundle
     */
    public function getSourcePath()
    {
        return Yii::getAlias($this->getAssetBundle()->sourcePath);
    }

    /**
     * @return RedactorModule
     * @throws InvalidConfigException
     */
    public function getModule()
    {
        if (is_null(Yii::$app->getModule($this->moduleId))) {
            throw new InvalidConfigException('Invalid config Redactor module with "$moduleId"');
        }
        return Yii::$app->getModule($this->moduleId);
    }

    /**
     * @param $key
     * @param mixed $defaultValue
     */
    protected function setOptionsKey($key, $defaultValue = null)
    {
        $this->clientOptions[$key] = Url::to(ArrayHelper::getValue($this->clientOptions, $key, $defaultValue));
    }
}
