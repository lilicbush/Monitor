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
class AngularAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    public $css = [
        'angular-loading-bar/build/loading-bar.min.css',
        'font-awesome/css/font-awesome.min.css'
    ];

    public $js = [
        'angular/angular.js',
        'angular-route/angular-route.js',
        'angular-ui-router/release/angular-ui-router.js',
        'angular-resource/angular-resource.js',
        'angular-animate/angular-animate.js',
        'angular-strap/dist/angular-strap.js',
        'angular-bootstrap/ui-bootstrap.min.js',
        'angular-bootstrap/ui-bootstrap-tpls.min.js',
        'angular-cookies/angular-cookies.js',
        'angular-sanitize/angular-sanitize.js',
        'angular-touch/angular-touch.js',
        'angular-loading-bar/build/loading-bar.js',
        'angular-toggle-switch/angular-toggle-switch.js',
        'angular-mocks/angular-mocks.js',
        'angular-scenario/angular-scenario.js',
        'oclazyload/dist/ocLazyLoad.min.js',
        'angular-file-upload/dist/angular-file-upload.min.js',
        'angular-permission/dist/angular-permission.js',
        'angular-highlightjs/angular-highlightjs.min.js',
    ];

    public $jsOptions = ['position' => View::POS_HEAD];
}
