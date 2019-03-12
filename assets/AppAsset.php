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
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot/remark/dist/';
    public $baseUrl = '@web/remark/dist/';
    public $css = [
        'global/css/bootstrap.min.css',
        'global/css/bootstrap-extend.min.css',
        'assets/css/site.min.css',
        'global/vendor/animsition/animsition.css',
        'global/vendor/asscrollable/asScrollable.css',
        'global/vendor/switchery/switchery.css',
        'global/vendor/intro-js/introjs.css',
        'global/vendor/slidepanel/slidePanel.css',
        'global/vendor/flag-icon-css/flag-icon.css',
        'global/vendor/waves/waves.css',
        'global/vendor/chartist/chartist.css',
        'global/vendor/jvectormap/jquery-jvectormap.css',
        'global/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css',
        'assets/examples/css/dashboard/v1.css',

        'global/fonts/material-design/material-design.min.css',
        'global/fonts/brand-icons/brand-icons.min.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
