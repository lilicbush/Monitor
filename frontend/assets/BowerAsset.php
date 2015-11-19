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
class BowerAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    public $css = [
        'metisMenu/dist/metisMenu.min.css',
        'morrisjs/morris.css',
        'font-awesome/css/font-awesome.min.css'
    ];

    public $js = [
        'bootstrap/dist/js/bootstrap.min.js',
        'metisMenu/dist/metisMenu.min.js',
        'raphael/raphael-min.js',
        'morrisjs/morris.min.js',
        'json3/lib/json3.min.js'
    ];

    public $depends = [
        'yii\web\YiiAsset'
    ];

    public $jsOptions = ['position' => View::POS_HEAD];
}
