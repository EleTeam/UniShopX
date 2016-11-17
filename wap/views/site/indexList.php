<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-09-30
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var $this yii\web\View
 * @var $articles
 * @var $article common\models\CmsArticle
 */
?>

<?php foreach($articles as $article):?>
    <li class="card">
        <a href="<?=$article->link?>">
            <div class="card-header"><?=$article->title?></div>
            <div class="card-content">
                <div class="card-content-inner"><?=Html::img($article->image)?></div>
            </div>
        </a>
    </li>
<?php endforeach;?>

