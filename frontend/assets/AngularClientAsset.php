<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AngularClientAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [];

    public $js = [
        'js/libs/oi.file.js',
        'js/libs/jquery.format.js',
        'js/app.js'
    ];

    public $depends = [
        'frontend\assets\AppAsset',
        'frontend\assets\AngularAsset',
    ];

    public $jsOptions = ['position' => View::POS_HEAD];
}
