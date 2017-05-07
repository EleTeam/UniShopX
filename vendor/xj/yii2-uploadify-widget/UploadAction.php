<?php

namespace xj\uploadify;

use Closure;
use Yii;
use yii\base\Action;
use yii\helpers\VarDumper;
use yii\validators\FileValidator;
use yii\web\HttpException;
use yii\web\UploadedFile;
use yii\base\Exception;

/**
 * @author xjflyttp <xjflyttp@gmail.com>
 */
class UploadAction extends Action
{

    /**
     * SavePath
     * @var string
     */
    public $basePath = '@webroot/upload';

    /**
     * WebUrl
     * @var string
     */
    public $baseUrl = '@web/upload';

    /**
     * @var bool
     */
    public $enableCsrf = true;

    /**
     * @var array | Closure
     * @example
     * // [$object, 'methodName']
     * // function(){}
     */
    public $format;

    /**
     * file validator options
     * @var []
     * @see http://stuff.cebe.cc/yii2docs/yii-validators-filevalidator.html
     * @example
     * [
     * 'maxSize' => 1000,
     * 'extensions' => ['jpg', 'png']
     * ]
     */
    public $validateOptions;

    /**
     * @var string
     */
    public $postFieldName = 'Filedata';

    /**
     * @var UploadedFile
     */
    public $uploadfile;

    /**
     * Save Relative File Name
     * image/yyyymmdd/xxx.jpg
     * @var string
     */
    public $filename;

    /**
     * @var bool
     */
    public $overwriteIfExist = false;

    /**
     * @var int
     */
    public $fileChmod = 0644;

    /**
     * @var int
     */
    public $dirChmod = 0755;

    /**
     * throw yii\base\Exception will break
     * @var Closure
     * beforeValidate($UploadAction)
     */
    public $beforeValidate;

    /**
     * throw yii\base\Exception will break
     * @var Closure
     * afterValidate($UploadAction)
     */
    public $afterValidate;

    /**
     * throw yii\base\Exception will break
     * @var Closure
     * beforeSave($UploadAction)
     */
    public $beforeSave;

    /**
     * throw yii\base\Exception will break
     * @var Closure
     * afterSave($filename, $fullFilename, $UploadAction)
     */
    public $afterSave;

    /**
     * OutputBuffer
     * @var []
     */
    public $output = ['error' => false];


    public function init()
    {
        $this->initCsrf();

        if (empty($this->basePath)) {
            throw new Exception('basePath not exist');
        }
        $this->basePath = Yii::getAlias($this->basePath);

        if (empty($this->baseUrl)) {
            throw new Exception('baseUrl not exist');
        }
        $this->baseUrl = Yii::getAlias($this->baseUrl);

        if (false === is_callable($this->format) && false === is_array($this->format)) {
            throw new Exception('format is invalid');
        }

        return parent::init();
    }

    public function run()
    {
        try {
            //instance uploadfile
            $this->uploadfile = UploadedFile::getInstanceByName($this->postFieldName);
            if (null === $this->uploadfile) {
                throw new Exception("uploadfile {$this->postFieldName} not exist");
            }

            if (null !== $this->beforeValidate) {
                call_user_func($this->beforeValidate, $this);
            }
            $this->validate();
            if (null !== $this->afterValidate) {
                call_user_func($this->afterValidate, $this);
            }
            if (null !== $this->beforeSave) {
                call_user_func($this->beforeSave, $this);
            }
            $this->save();
            if ($this->afterSave !== null) {
                call_user_func($this->afterSave, $this);
            }
        } catch (Exception $e) {
            $this->output['error'] = true;
            $this->output['msg'] = $e->getMessage();
        }
        Yii::$app->response->format = 'json';
        return $this->output;
    }

    /**
     * @throws Exception
     */
    protected function save()
    {
        $filename = $this->getFilename();
        $basePath = $this->basePath;
        $saveFilename = $basePath . '/' . $filename;
        $dirPath = dirname($saveFilename);
        if (false === is_dir($dirPath) && false === file_exists($dirPath)) {
            if (false === mkdir($dirPath, $this->dirChmod, true)) {
                throw new Exception("Create Directory Fail: {$dirPath}");
            }
        }
        $saveResult = $this->uploadfile->saveAs($saveFilename);
        if (true === $saveResult) {
            if (false === chmod($saveFilename, $this->fileChmod)) {
                throw new Exception("SetChmod Fail: {$this->fileChmod} {$saveFilename}");
            }
        } else {
            throw new Exception("SaveAsFile Fail: {$saveFilename}");
        }
    }

    /**
     * 取得没有碰撞的FileName
     * @return string
     * @throws Exception
     */
    protected function getSaveFileNameWithNotExist()
    {
        $retryCount = 10;
        $currentCount = 0;
        $basePath = $this->basePath;
        $filename = '';
        do {
            ++$currentCount;
            $filename = $this->getSaveFileName();
            $filepath = $basePath . DIRECTORY_SEPARATOR . $filename;
        } while ($currentCount < $retryCount && file_exists($filepath));
        if ($currentCount == $retryCount) {
            throw new Exception(__FUNCTION__ . " try {$currentCount} times");
        }
        return $filename;
    }

    /**
     * @return string
     * @throws Exception
     */
    protected function getSaveFileName()
    {
        return call_user_func($this->format, $this);
    }

    /**
     * @throws Exception
     */
    protected function validate()
    {
        if (empty($this->validateOptions)) {
            return;
        }
        $file = $this->uploadfile;
        $error = [];
        $validator = new FileValidator($this->validateOptions);
        if (!$validator->validate($file, $error)) {
            throw new Exception($error);
        }
    }

    protected function initCsrf()
    {
        $session = Yii::$app->getSession();
        $request = Yii::$app->getRequest();
        if (false === $this->enableCsrf) {
            return;
        }
        $request->enableCsrfValidation = true;
        $request->enableCsrfCookie = false; //verify with session
        $sessionName = $session->getName();
        $postSessionId = $request->post($sessionName);
        if ($postSessionId != $session->getId()) {
            $session->destroy();
            $session->setId($postSessionId);
            $session->open();
        }
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getFilename()
    {
        if (null === $this->filename) {
            if ($this->overwriteIfExist) {
                $this->filename = $this->getSaveFileName();
            } else {
                $this->filename = $this->getSaveFileNameWithNotExist();
            }
        }
        return $this->filename;
    }

    /**
     * @return string
     */
    public function getSavePath()
    {
        return rtrim($this->basePath, '\\/') . '/' . $this->filename;
    }

    /**
     * @return string
     */
    public function getWebUrl()
    {
        return rtrim($this->baseUrl, '\\/') . '/' . $this->filename;
    }
}
