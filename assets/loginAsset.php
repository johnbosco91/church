<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class loginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'plugins/fontawesome/css/fontawesome.min.css',
        'plugins/fontawesome/css/fontawesome.min.css',
        'plugins/fontawesome/css/all.min.css',
        'css/line-awesome.min.css',
        'css/material.css',
        'css/font-awesome.min.css',
        'css/style.css',
        'css/custom.css',
    ];
    public $js = [
        'js/app.js',
        'js/layout.js',
        'js/lang.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}
