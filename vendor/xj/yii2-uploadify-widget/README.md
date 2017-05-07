# yii2-uploadify-widget
===

## composer.json
---
```json
"require": {
    "xj/yii2-uploadify-widget": "~2.0.0"
},

"require": {
    "xj/yii2-uploadify-widget": "~1.0.0"
},
```

## example:
### version 2.0
---
```php
//Remove Events Auto Convert

use yii\web\JsExpression;

//外部TAG
echo Html::fileInput('test', NULL, ['id' => 'test']);
echo Uploadify::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'width' => 120,
        'height' => 40,
        'onUploadError' => new JsExpression(<<<EOF
function(file, errorCode, errorMsg, errorString) {
    console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
}
EOF
),
        'onUploadSuccess' => new JsExpression(<<<EOF
function(file, data, response) {
    data = JSON.parse(data);
    if (data.error) {
        console.log(data.msg);
    } else {
        console.log(data.fileUrl);
    }
}
EOF
),
    ]
]);
```

### version 1.0
---
```php
//外部TAG
echo Html::fileInput('test', NULL, ['id' => 'test']);
echo Uploadify::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'width' => 120,
        'height' => 40,
        'onUploadError' => "function(file, errorCode, errorMsg, errorString) {
            console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
        }",
        'onUploadSuccess' => "function(file, data, response) {
            data = JSON.parse(data);
            if (data.error) {
                console.log(data.msg);
            } else {
                console.log(data.fileUrl);
            }
        }"
    ]
]);

//直接渲染
echo Html::activeLabel($model, 'file');
echo Uploadify::widget([
    'url' => yii\helpers\Url::to(['s-upload']),
    'attribute' => 'file',
    'model' => $model,
    'csrf' => true,
    'jsOptions' => [
        'width' => 120,
        'height' => 40,
        'onUploadError' => "function(file, errorCode, errorMsg, errorString) {
        console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
    }",
        'onUploadSuccess' => "function(file, data, response) {
        console.log('The file ' + file.name + ' was successfully uploaded with a response of ' + response + ':' + data);
    }"
    ]
]);
```

Action:
---
### version 2.0
----
```php
use xj\uploadify\UploadAction;

public function actions() {
    return [
        's-upload' => [
            'class' => UploadAction::className(),
            'basePath' => '@webroot/upload',
            'baseUrl' => '@web/upload',
            'enableCsrf' => true, // default
            'postFieldName' => 'Filedata', // default
            //BEGIN METHOD
            'format' => [$this, 'methodName'], 
            //END METHOD
            //BEGIN CLOSURE BY-HASH
            'overwriteIfExist' => true,
            'format' => function (UploadAction $action) {
                $fileext = $action->uploadfile->getExtension();
                $filename = sha1_file($action->uploadfile->tempName);
                return "{$filename}.{$fileext}";
            },
            //END CLOSURE BY-HASH
            //BEGIN CLOSURE BY TIME
            'format' => function (UploadAction $action) {
                $fileext = $action->uploadfile->getExtension();
                $filehash = sha1(uniqid() . time());
                $p1 = substr($filehash, 0, 2);
                $p2 = substr($filehash, 2, 2);
                return "{$p1}/{$p2}/{$filehash}.{$fileext}";
            },
            //END CLOSURE BY TIME
            'validateOptions' => [
                'extensions' => ['jpg', 'png'],
                'maxSize' => 1 * 1024 * 1024, //file size
            ],
            'beforeValidate' => function (UploadAction $action) {
                //throw new Exception('test error');
            },
            'afterValidate' => function (UploadAction $action) {},
            'beforeSave' => function (UploadAction $action) {},
            'afterSave' => function (UploadAction $action) {
                $action->output['fileUrl'] = $action->getWebUrl();
                $action->getFilename(); // "image/yyyymmddtimerand.jpg"
                $action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
                $action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
            },
        ],
    ];
}
```


### version 1.0
----
```php
use xj\uploadify\UploadAction;

public function actions() {
    return [
        's-upload' => [
            'class' => UploadAction::className(),
            'uploadBasePath' => '@webroot/upload', //file system path
            'uploadBaseUrl' => '@web/upload', //web path
            'csrf' => true,
//            'format' => 'image/{yyyy}{mm}{dd}/{time}{rand:6}', // OR Closure
            'format' => function(UploadAction $action) {
                $fileext = $action->uploadFileInstance->getExtension();
                $filehash = sha1(uniqid() . time());
                $p1 = substr($filehash, 0, 2);
                $p2 = substr($filehash, 2, 2);
                return "{$p1}/{$p2}/{$filehash}.{$fileext}";
            },
            'validateOptions' => [
                'extensions' => ['jpg', 'png'],
                'maxSize' => 1 * 1024 * 1024, //file size
            ],
            'beforeValidate' => function(UploadAction $action) {},
            'afterValidate' => function(UploadAction $action) {},
            'beforeSave' => function(UploadAction $action) {},
            'afterSave' => function(UploadAction $action) {
                //$action->filename;  //   image/yyyymmdd/xxx.jpg
                //$action->$fullFilename //  /var/www/htdocs/image/yyyymmddtimerand.jpg
            },
        ],
    ];
}
```
