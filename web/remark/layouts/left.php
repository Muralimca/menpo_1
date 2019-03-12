<?php
$formatJs = <<< 'JS'
var links = document.getElementsByClassName("menu_link");
var url =document.location.href;
    url = url.split('&',1);
    url = url[0].split('#',1);
var flag = 0;
    for (var i = 0; i < links.length; i++) {
        if (links[i].href == url[0]) {
            jQuery(links[i]).parent('li').addClass('active');
            jQuery(links[i]).parent('li').parent().parent().addClass('open active');
            flag = 1;
            break;
        }
    }
    if(flag==0) {
        jQuery(links[0]).parent('li').parent().parent().addClass('open active');
    }
JS;
$this->registerJs($formatJs, \yii\web\View::POS_END);
if(isset(Yii::$app->user->identity->displayname) && !empty(Yii::$app->user->identity->displayname)) {
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image col-xs-3">
                <img src="<?= $directoryAsset ?>/img/common.png" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?=Yii::$app->user->identity->displayname ?></p>
                <!--<a href="#"><i class="fa fa-circle text-success"></i> Online</a>-->
            </div>
        </div>

        <?php
        $array_menu = array();
        $menu_param = array();
            if (Yii::$app->session->has('array_menus')) { //check if already menus in SESSION
                $array_menu = Yii::$app->session->get('array_menus');
                $menu_param = Yii::$app->session->get('menu_param');
            }
            else { //If First Time Login
                $user_id = Yii::$app->user->identity->id;
                $mst_menu = new \app\models\MstMenus();
                $user_role_setting = $mst_menu->getUserMenuListByRole($user_id); //get User Menus From Table
                if(!empty($user_role_setting)) {
                    foreach ($user_role_setting as $key => $value) {
                        if ($user_role_setting[$key]['menu_type'] == 'menu') {
                            $array_menu[$user_role_setting[$key]['parent_name']][$user_role_setting[$key]['menu_url']] = $user_role_setting[$key]['menu_name'];
                            $menu_param[$user_role_setting[$key]['parent_name']][$user_role_setting[$key]['menu_url']]['params'] = $user_role_setting[$key]['default_params'];
                        }
                    }
                    Yii::$app->session->set('array_menus', $array_menu);
                    Yii::$app->session->set('menu_param', $menu_param);
                }
            }
            //Display User Menus
            echo '<ul class="sidebar-menu">';
            foreach ($array_menu as $sdmenu => $array_menus) {
                if (!empty($sdmenu)) {
                    ?>
                    <li class="">
                        <a href="#">
                            <i class="fa fa-files-o"></i>
                            <span><?php echo $sdmenu; ?></span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <?php foreach ($array_menus as $url => $menus) {
                            $param = [];
                            $url_new = array();
                            array_push($url_new,$url);
                            if(!empty($menu_param[$sdmenu][$url]['params'])) {
                                $params = explode('&',$menu_param[$sdmenu][$url]['params']);
                                foreach($params as $r) {
                                    $u = explode('=',$r);
                                    $url_new[$u[0]] = $u[1];
                                }
                            }
                                ?>
                                <li><a  class="menu_link"href="<?php echo \yii\helpers\Url::to($url_new) ?>"><i class="fa fa-angle-right"></i><?php echo $menus; ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                    <?php
                } else {
                    ?>
                        <li class="treeview header active">
                            <?php foreach ($array_menus as $url => $menus) {
                                ?>
                                <li><a href="<?php echo \yii\helpers\Url::to([$url]); ?>"><i class="fa fa-angle-right"></i><?php echo $menus ?></a></li>
                            <?php } ?>
                        </li>
                    <?php
                }
            }
            echo '</ul>';
        ?>
    </section>

</aside>
<?php }
else {
//    header("Location:".\yii\helpers\Url::to(['site/login']));
}