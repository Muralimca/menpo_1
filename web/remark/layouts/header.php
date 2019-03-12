<?php
use yii\helpers\Html;
use app\models\TrnOtBookingRequests;

/* @var $this \yii\web\View */
/* @var $content string */
if(isset(Yii::$app->user->identity->displayname) && !empty(Yii::$app->user->identity->displayname)) {
    ?>

    <header class="main-header">

<?= Html::a('<span class="logo-mini">KGH</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

        <nav class="navbar navbar-static-top" role="navigation">
            <div class="container1">
                <?php //echo  Html::a( Yii::$app->name , Yii::$app->homeUrl, ['class' => 'navbar-brand']) ?>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <i class="fa fa-bars"></i>
                </button>

                <?php
                /*$array_menu = array();
                if (Yii::$app->session->has('array_menus')) { //check if already menus in SESSION
                    $array_menu = Yii::$app->session->get('array_menus');
                }
                else { //If First Time Login
                    $user_id = Yii::$app->user->identity->id;
                    $mst_menu = new \app\models\MstMenus();
                    $user_role_setting = $mst_menu->getUserMenuListByRole($user_id); //get User Menus From Table
                    if(!empty($user_role_setting)) {
                        foreach ($user_role_setting as $key => $value) {
                            if ($user_role_setting[$key]['menu_type'] == 'menu')
                                $array_menu[$user_role_setting[$key]['parent_name']][$user_role_setting[$key]['menu_url']] = $user_role_setting[$key]['menu_name'];
                        }
                        Yii::$app->session->set('array_menus', $array_menu);
                    }
                }*/
                ?>
<!--                <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                    <ul class="nav navbar-nav">
                        <?php
/*                        foreach ($array_menu as $sdmenu => $array_menus) {
                            if (!empty($sdmenu)) {
                                */?>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true" ><?php /*echo $sdmenu; */?> <span class="caret"></span></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <?php /*foreach ($array_menus as $url => $menus) {
                                            */?>
                                            <li><a  class="menu_link"href="<?php /*echo Yii::$app->urlManager->createUrl([$url]); */?>"><?php /*echo $menus; */?></a></li>
                                        <?php /*} */?>
                                    </ul>
                                </li>
                                <?php
/*                            }
                        }
                        */?>
                    </ul>
                </div>-->

        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <?php
                        $user_role_id = \app\models\TrnUserroleSettings::find()->where(['mst_user_id'=>Yii::$app->user->identity->id])->select(['mst_role_id'])->one();
                        $ward_station_id = \app\models\MstUser::find()->where(['id'=>Yii::$app->user->identity->id])->select(['station_id'])->one();
                        $notify_admin_role = \app\models\TrnSiteconfigs::find()->where(['var_name'=>'ot_notification_admin_roles'])->select(['var_value'])->one();
                        $notify_ward_role = \app\models\TrnSiteconfigs::find()->where(['var_name'=>'ot_notification_ward_role'])->select(['var_value'])->one();
                        $notify_opd_role = \app\models\TrnSiteconfigs::find()->where(['var_name'=>'ot_notification_opd_roles'])->select(['var_value'])->one();
                        $date = date('Y-m-d');
                        $hidden_notify_admin_roles = explode(',',$notify_admin_role->var_value);
                        $hidden_notify_opd_roles = explode(',',$notify_opd_role->var_value);
                        $hidden_notify_ward_roles = explode(',',$notify_ward_role->var_value);
                        $ot_book = 0;
                        if(!empty($user_role_id)) {
                            if ($user_role_id->mst_role_id == $notify_admin_role->var_value || in_array($user_role_id->mst_role_id, $hidden_notify_admin_roles)) {
                                $ot_booking = new \yii\db\Query();
                                $ot_booking->select(['trn_ot_booking_requests.id', 'trn_ot_booking_requests.trn_visit_id', 'trn_ot_booking_requests.patient_code', 'trn_ot_booking_requests.patient_name', 'trn_ot_booking_requests.room_no', 'trn_ot_booking_requests.age', 'trn_ot_booking_requests.gender', 'trn_ot_booking_requests.surgery_name', 'trn_ot_booking_requests.surgery_datetime', 'trn_ot_booking_requests.surgery_to_time', 'trn_ot_booking_requests.surgeon', 'trn_ot_booking_requests.surgeon_id', 'trn_ot_booking_requests.ot_name', 'trn_ot_booking_requests.checkin_time', 'trn_ot_booking_requests.checkout_time', 'trn_ot_booking_requests.status', 'trn_ot_booking_requests.complete_remarks', 'other_requirements'])
                                    ->from('trn_ot_booking_requests')
                                    ->andWhere(['between', 'trn_ot_booking_requests.surgery_datetime', "$date 00:00:00", "$date 23:59:59"])->andWhere(['<>', 'trn_ot_booking_requests.status', 'Cancelled'])->orderBy(['trn_ot_booking_requests.surgery_datetime' => SORT_ASC])
                                    ->all();
                                $ot_book = $ot_booking->createCommand()->queryAll();
                                //$ot_book = TrnOtBookingRequests::find()->andWhere(['between', 'surgery_datetime', "$date 00:00:00", "$date 23:59:59"])->andWhere(['<>', 'status', 'Cancelled'])->orderBy(['surgery_datetime' => SORT_ASC])->select(['id', 'trn_visit_id', 'patient_code', 'patient_name', 'room_no', 'age', 'gender', 'surgery_name', 'surgery_datetime', 'surgery_to_time', 'surgeon', 'surgeon_id', 'ot_name', 'checkin_time', 'checkout_time', 'status', 'complete_remarks'])->all();
                            }
                            if ($user_role_id->mst_role_id == $notify_opd_role->var_value || in_array($user_role_id->mst_role_id, $hidden_notify_opd_roles)) {
                                $ot_booking = new \yii\db\Query();
                                $ot_booking->select(['trn_ot_booking_requests.id', 'trn_ot_booking_requests.trn_visit_id', 'trn_ot_booking_requests.patient_code', 'trn_ot_booking_requests.patient_name', 'trn_ot_booking_requests.room_no', 'trn_ot_booking_requests.age', 'trn_ot_booking_requests.gender', 'trn_ot_booking_requests.surgery_name', 'trn_ot_booking_requests.surgery_datetime', 'trn_ot_booking_requests.surgery_to_time', 'trn_ot_booking_requests.surgeon', 'trn_ot_booking_requests.surgeon_id', 'trn_ot_booking_requests.ot_name', 'trn_ot_booking_requests.checkin_time', 'trn_ot_booking_requests.checkout_time', 'trn_ot_booking_requests.status', 'trn_ot_booking_requests.complete_remarks', 'other_requirements'])
                                    ->from('trn_ot_booking_requests')
                                    ->andWhere(['created_by'=>Yii::$app->user->identity->id])
                                    ->andWhere(['between', 'trn_ot_booking_requests.surgery_datetime', "$date 00:00:00", "$date 23:59:59"])->andWhere(['<>', 'trn_ot_booking_requests.status', 'Cancelled'])->orderBy(['trn_ot_booking_requests.surgery_datetime' => SORT_ASC])
                                    ->all();
                                $ot_book = $ot_booking->createCommand()->queryAll();
                                //$ot_book = TrnOtBookingRequests::find()->where(['created_by' => Yii::$app->user->identity->id])->andWhere(['between', 'surgery_datetime', "$date 00:00:00", "$date 23:59:59"])->andWhere(['<>', 'status', 'Cancelled'])->orderBy(['surgery_datetime' => SORT_ASC])->select(['id', 'trn_visit_id', 'patient_code', 'patient_name', 'room_no', 'age', 'gender', 'surgery_name', 'surgery_datetime', 'surgery_to_time', 'surgeon', 'surgeon_id', 'ot_name', 'checkin_time', 'checkout_time', 'status','complete_remarks'])->all();
                            }
                            if(!empty($ward_station_id)) {
                                if ($user_role_id->mst_role_id == $notify_ward_role->var_value || in_array($user_role_id->mst_role_id, $hidden_notify_ward_roles)) {
                                    $station_id = ltrim($ward_station_id->station_id, '{');
                                    $station_id = rtrim($station_id, '}');
                                    //print_r($ward_station_id); exit;
                                    $visit_id = \app\models\TrnBedStatus::find()->where('mst_floor_id IN('.$station_id.')')->select(['trn_visit_id'])->one();
                                    $ot_booking = new \yii\db\Query();
                                    $ot_booking->select(["trn_ot_booking_requests.id", "trn_ot_booking_requests.trn_visit_id", "trn_ot_booking_requests.patient_code", "trn_ot_booking_requests.patient_name", "mst_rooms.room_name::text||' - '||COALESCE(mst_beds.bed_name,'') AS room_no", "trn_ot_booking_requests.age", "trn_ot_booking_requests.gender", "trn_ot_booking_requests.surgery_name", "trn_ot_booking_requests.surgery_datetime", "trn_ot_booking_requests.surgery_to_time", "trn_ot_booking_requests.surgeon", "trn_ot_booking_requests.surgeon_id", "trn_ot_booking_requests.ot_name", "trn_ot_booking_requests.checkin_time", "trn_ot_booking_requests.checkout_time", "trn_ot_booking_requests.status", "trn_ot_booking_requests.complete_remarks", "other_requirements"])
                                        ->from('trn_ot_booking_requests')
                                        ->innerJoin('trn_bed_status', 'trn_bed_status.trn_visit_id = trn_ot_booking_requests.trn_visit_id')
                                        ->innerJoin('mst_rooms', 'mst_rooms.id = trn_bed_status.mst_room_id')
                                        ->innerJoin('mst_beds', 'mst_beds.id = trn_bed_status.mst_bed_id')
                                        ->andWhere('trn_bed_status.mst_floor_id IN ('.$station_id.')')
                                        ->andWhere(['between', 'trn_ot_booking_requests.surgery_datetime', "$date 00:00:00", "$date 23:59:59"])->andWhere(['<>', 'trn_ot_booking_requests.status', 'Cancelled'])->orderBy(['trn_ot_booking_requests.surgery_datetime' => SORT_ASC])
                                        ->all();
                                    $ot_book = $ot_booking->createCommand()->queryAll();
                                }
                            }
                        }
                        //$ot_book  =[];
                        if(!empty($user_role_id)) {
                            if (($user_role_id->mst_role_id == $notify_admin_role->var_value || in_array($user_role_id->mst_role_id, $hidden_notify_admin_roles)) || ($user_role_id->mst_role_id == $notify_opd_role->var_value || in_array($user_role_id->mst_role_id, $hidden_notify_opd_roles)) || ($user_role_id->mst_role_id == $notify_ward_role->var_value || in_array($user_role_id->mst_role_id, $hidden_notify_ward_roles))) { ?>
                                <!-- Messages: style can be found in dropdown.less-->
                                <li class="dropdown notifications-menu" id="ot_notification_bar">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-bell-o"></i>
                                        <span class="label label-danger">OT - <?php echo(!empty($ot_book) ? count($ot_book) : 0) ?></span>
                                    </a>
                                    <?php if (!empty($ot_book)) {
                                        //echo "<pre>"; print_r($data); exit; ?>
                                        <ul class="dropdown-menu">
                                            <li class="header">You
                                                have <?php echo(!empty($ot_book) ? count($ot_book) : 0) ?> notifications
                                            </li>
                                            <li>
                                                <ul class="menu">
                                                    <?php foreach ($ot_book AS $key => $data) { ?>
                                                        <li class="pointer" onClick="view_more_detail_ot_booked_request('<?php echo $data['id']; ?>')"><!-- start message -->
                                                            <!--<a href="#"
                                                               onClick="view_more_detail_ot_booked_request('<?php /*echo $data['id']; */?>')">-->
                                                            <h6>
                                                                <i class="fa fa-angle-double-right text-black"></i><span class="bolder font_size_08em"> <?php echo $data['patient_name'] . ' - ' . $data['patient_code'] . ' - ' . (!empty($data['room_no']) ? $data['room_no'] : 'OP') ?></span>
                                                                <br><span class="bolder font_size_08em text-navy"><?php echo $data['ot_name']; ?></span>
                                                                -
                                                                <small><i class="fa fa-clock-o"></i> <?php echo date('h:i A', strtotime($data['surgery_datetime'])) . ' - ' . date('h:i A', strtotime($data['surgery_to_time'])) ?>
                                                                </small>
                                                                <?php if(!empty($data['checkout_time'])) { ?><span class="bolder font_size_08em text-red"><?php echo ' - '.$data['status']; ?></span> <?php } ?>
                                                                <br><span class="text-blue font_size_07em"><?= $data['surgery_name']; ?></span>
                                                                <br><i class="text-purple fa fa-user-md"></i><span class="text-purple bolder font_size_07em">&nbsp;<?= $data['surgeon']; ?></span>
                                                            </h6>
                                                            <!--</a>-->
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </li>
                                            <!--<li class="footer"><a href="#">View all</a></li>-->
                                        </ul>
                                    <?php } ?>
                                </li>
                            <?php }
                        } ?>

                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="<?= $directoryAsset ?>/img/common.png" class="user-image" alt="User Image"/>
                                <span class="hidden-xs"><?=Yii::$app->user->identity->displayname; ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="<?= $directoryAsset ?>/img/common.png" class="img-circle"
                                         alt="User Image"/>

                                    <p>
                                        <?=Yii::$app->user->identity->displayname; ?>
                                        <small></small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <!--<li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>-->
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <?= Html::a(
                                            'Change Password',
                                            \yii\helpers\Url::to(['/site/change-password']),
                                            [ 'class' => 'btn btn-flat']
                                        ) ?>
                                    </div>
                                    <div class="pull-right">
                                        <?= Html::a(
                                            'Sign out',
                                            ['/site/logout'],
                                            ['data-method' => 'post', 'class' => 'btn btn-danger btn-flat']
                                        ) ?>
                                    </div>
                                </li>
                            </ul>
                        </li>

                        <!-- User Account: style can be found in dropdown.less -->
                        <li>
                            <!--                    <a href="#" data-toggle="control-sidebar" ><i class="fa fa-gears"></i></a>-->
                            <a href="#"><i class="fa fa-gears"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
<?php }
else {
    echo Html::a('',\yii\helpers\Url::to(['site/login']),['id'=>'login']);
    echo "<script> document.getElementById('login').click();</script>";
}
?>
<div id="view_booked_modal" class="modal fade"  tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div id="view_popup_size" class="modal-dialog modal-large" align="center">
        <div class="modal-content">
            <div class="modal-header" id="modal_header">
                <button type="button" class="close close_popup_btn" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="smaller lighter blue no-margin">
                    <center><span id="view_booked_title"></span></center>
                </h3>
            </div>
            <div class="modal-body row">
                <div class="col-sm-12 " id="view_booked_allocate"></div>
            </div>
        </div>
    </div>
</div>
<script>
    function view_more_detail_ot_booked_request(id)
    {
        $('#view_booked_allocate').html('Loading...');
        $.ajax({
            url: '<?= Yii::$app->urlManager->createUrl(['trn-ot-booking-requests/view-more-details-ot-booked-request']);?>',
            type: 'POST',
            data: { book_id:id, flag: '1' },
            beforeSend: function () {
                $("#view_booked_title").html('<span style="color: blue; font-weight: bolder;"> OT Booking Request Detailed List </span> <span class="pull-right"></span>');
                $("#view_booked_modal").modal();
            },
            success: function (data) {
                $('#view_booked_allocate').html(data);
            },
            error: function (data) {
                $('#view_booked_allocate').html('Error Occurred');
            }
        });
    }
</script>