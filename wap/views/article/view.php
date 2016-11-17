<?php
/**
 * Shop-PHP-Yii2
 *
 * @author Tony Wong
 * @date 2016-11-17
 * @email 908601756@qq.com
 * @copyright Copyright © 2016年 EleTeam
 * @license The MIT License (MIT)
 */

/**
 * @var $this yii\web\View
 * @var $article common\models\CmsArticle
 */
?>

<!-- Top Navbar-->
<div class="navbar">
    <div class="navbar-inner">
        <div class="left">
            <a href="#" class="back link">
                <i class="icon icon-back"></i>
                <span>返回</span>
            </a>
        </div>
        <div class="center sliding">文章详情</div>
    </div>
</div>
<div data-page="article-view" class="page">
    <div class="page-content">
        <?=$article->title?>
    </div>
</div>
