<?php
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;
//app\assets\jQueryAsset::register($this);
?>
<div class="content-wrapper">
    <!--<section class="content-header">
       <?php /*echo Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        ) */?>
    </section>-->

    <section class="content">
        <?= Alert::widget() ?>
        <?= $content ?>
    </section>
</div>
<?php
$formatJs = <<< 'JS'
       $ (document) .on ('focus', '.select2', function () {
            $ (this) .siblings('select').select2('open');
       });
JS;
// Register the formatting script
$this->registerJs($formatJs, \yii\web\View::POS_READY);
?>

<footer class="main-footer no-print">
    <div class="pull-right hidden-xs">
        <b>Version</b> 2.0
    </div>
    <strong>Copyright &copy; <?=(date('Y')-1).' - '.date('Y');?> <a href="javascript: void(0);">HMiS</a>.</strong> All rights
    reserved.
</footer>

<div id="page_loading">
    <div>
        <img src="<?= Yii::$app->request->getBaseUrl() ?>/images/loader.gif" alt="Please Wait"><br><br>
        <span style="color: rgba(0, 0, 0, 0.72);" class="h4">Please Wait...</span></div>
</div>
<span id="snackbar"></span>
<style>
    #page_loading{
        width: 100%;
        min-height: 100%;
        height: 200vh;
        background-color:rgba(0, 0, 0, 0.18);
        z-index: 4;
        top:0;
        text-align: center;
        display: none;
        position: absolute;
    }
    #page_loading div{
        margin: 0 auto;
        padding: 22% 0;
    }
    .form-element {
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
        color: #555;
        /*display: block;*/
        font-size: 14px;
        height: 34px;
        line-height: 1.42857;
        padding: 6px 12px;
        transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
    }
    #snackbar {
        visibility: hidden;
        min-width: 250px;
        margin-left: -125px;
        background-color: #333;
        color: #fff;
        text-align: center;
        border-radius: 2px;
        padding: 16px;
        position: fixed;
        z-index: 1;
        left: 50%;
        bottom: 30px;
        font-size: 17px;
    }

    #snackbar.show {
        visibility: visible;
        -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
        animation: fadein 0.5s, fadeout 0.5s 2.5s;
    }

    @-webkit-keyframes fadein {
        from {bottom: 0; opacity: 0;}
        to {bottom: 30px; opacity: 1;}
    }

    @keyframes fadein {
        from {bottom: 0; opacity: 0;}
        to {bottom: 30px; opacity: 1;}
    }

    @-webkit-keyframes fadeout {
        from {bottom: 30px; opacity: 1;}
        to {bottom: 0; opacity: 0;}
    }

    @keyframes fadeout {
        from {bottom: 30px; opacity: 1;}
        to {bottom: 0; opacity: 0;}
    }
</style>
<div class='control-sidebar-bg'></div>
<script>
    function format(num){
        var n = num.toString(), p = n.indexOf('.');
        return n.replace(/\d(?=(?:\d{3})+(?:\.|$))/g, function($0, i){
            return p<0 || i<p ? ($0+',') : $0;
        });
    }

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if(charCode != 46 && charCode != 37 && charCode != 39 && charCode != 36 && charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
    function inWords (num) {
        var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
        var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];
        if ((num = num.toString()).length > 9) return 'overflow';
        n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
        if (!n) return; var str = '';
        str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
        str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
        str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
        str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
        str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
        document.getElementById('converted_word').innerHTML = str;
        return str;
    }
    // accepts Character with space
    function ValidateChar(evt)
    {
        var key = window.event ? evt.keyCode : evt.which;
        var keychar = String.fromCharCode(key);
        reg = /[^0-9']$/;
        //reg = /\s/;
        return reg.test(keychar);
    }
    function checkUncheckAllByDivItems(theElement,myDiv) {
        var z = 0;
        var divElement= $(myDiv).getElementsByTagName('*');
        for(z=0; z<divElement.length;z++){

            if(divElement[z].type == 'checkbox' && divElement[z].name != theElement.name){
                divElement[z].checked = theElement.checked;
            }
        }
    }
    function checkUncheckAllByNameLike(theElement,myDiv) {
        var z = 0;
        var divElement= jQuery("input[name^='"+myDiv+"']");
        for(z=0; z<divElement.length;z++) {
            if(divElement[z].type == 'checkbox' && divElement[z].name != theElement.name){
                divElement[z].checked = theElement.checked;
            }
        }
    }
    function checkUncheckAllByIdLike(theElement,myDiv) {
        var z = 0;
        var divElement= jQuery("input[id^='"+myDiv+"']");
        for(z=0; z<divElement.length;z++) {
            if(divElement[z].type == 'checkbox' && divElement[z].name != theElement.name){
                divElement[z].checked = theElement.checked;
            }
        }
    }

    function copyToClipboard(elementId) {
        var aux = document.createElement("input");
        var targetText = document.getElementById(elementId).innerHTML;
        aux.setAttribute("value", targetText);
        document.body.appendChild(aux);
        aux.select();
        document.execCommand("copy");
        document.body.removeChild(aux);

//        var snackbar = document.createElement("span");
//        snackbar.textContent = targetText+" Copied to Clipboard";
//        snackbar.setAttribute("id", "snackbar");
        var x = document.getElementById("snackbar");
        x.innerHTML = targetText+" Copied to Clipboard";
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 2000);
    }

</script>
<?php
    $formatJs = <<< 'JS'
    $(function () {
        $(document).ajaxStart(function() {
            $('#page_loading').show();
        });
        $(document).ajaxStop(function() {
            $('#page_loading').hide();
        });
    });

  /*(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-99913015-1', 'auto');
  ga('send', 'pageview');*/
JS;
$this->registerJs($formatJs, \yii\web\View::POS_READY);
?>


<style>
    .ref_dr {
        color: mediumvioletred;
        font-size: 11px;
        font-style: italic;
    }
    .ref_dr_caption {
        font-size: 11px;
        font-style: italic;
    }
    .table.fixed-header-table >td {
        font-size: 13px;
    }
    .reported {
        color: #ff5722;
    }

    @media print {
        html, body {
            height: auto !important;
            overflow: visible !important;
            display: block !important; 
        }
    }
</style>