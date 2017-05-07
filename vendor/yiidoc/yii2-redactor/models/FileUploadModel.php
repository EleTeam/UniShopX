<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\redactor\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\Inflector;

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */
class FileUploadModel extends \yii\base\Model
{
    /**
     * @var UploadedFile
     */
    public $file;
    private $_fileName;

    public function rules()
    {
        return [
            ['file', 'file', 'extensions' => Yii::$app->controller->module->fileAllowExtensions]
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            return $this->file->saveAs(Yii::$app->controller->module->getFilePath($this->getFileName()), true);
        }
        return false;
    }

    public function getResponse()
    {
        return [
            'filelink' => Yii::$app->controller->module->getUrl($this->getFileName()),
            'filename' => $this->getFileName()
        ];
    }

    public function getFileName()
    {
        if (!$this->_fileName) {
            $fileName = substr(uniqid(md5(rand()), true), 0, 10);
            $fileName .= '-' . Inflector::slug($this->file->baseName);
            $fileName .= '.' . $this->file->extension;
            $this->_fileName = $fileName;
        }
        return $this->_fileName;
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->file = UploadedFile::getInstanceByName('file');
            return true;
        }
        return false;
    }

}
