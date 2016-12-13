<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<meta charset="utf-8">
		<title><?php if(!empty($seo_title)): echo ($seo_title); ?>_<?php endif; echo ($CONFIG["site"]["sitename"]); ?>会员中心</title>
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
		<?php if($CONFIG[site][concat] != 1): ?><link rel="stylesheet" href="/static/default/wap/css/base.css">
		<link rel="stylesheet" href="/static/default/wap/css/mcenter.css"/>
		<script src="/static/default/wap/js/jquery.js"></script>
		<script src="/static/default/wap/js/base.js"></script>
		<script src="/static/default/wap/other/layer.js"></script>
		<script src="/static/default/wap/other/roll.js"></script>
		<script src="/static/default/wap/js/public.js"></script>
		<?php else: ?>
		<link rel="stylesheet" href="/static/default/wap/css/??base.css,mcenter.css" />
		<script src="/static/default/wap/js/??jquery.js,base.js,roll.js,layer.js,public.js"></script><?php endif; ?>
	</head>
	<body>
<header class="top-fixed bg-yellow bg-inverse">
    <div class="top-back">
        <a class="top-addr" href="<?php echo U('yhk/index');?>"><i class="icon-angle-left"></i></a>
    </div>
    <div class="top-title">
        分销优惠卡
    </div>
    <div class="top-signed">
        <?php if($msg_day > 0): ?><a href="<?php echo U('mcenter/message/index');?>">
<i class="icon-envelope"></i>
<span class="badge bg-red jiaofei"><?php echo ($msg_day); ?></span>
</a>
<?php else: ?>
    <?php if(empty($sign_day)): ?><a href="<?php echo U('mobile/sign/signed');?>" class="top-addr icon-plus"> 签到</a>    
    <?php else: ?>
    <a href="<?php echo U('mobile/passport/logout');?>" class="top-addr icon-sign-out"></a><?php endif; endif; ?>
    </div>
</header>
<body>
	<header>
		<a href="<?php echo U('index/index');?>"><i class="icon-goback"></i></a>
		<!--<div class="title">分销优惠卡</div>-->
		<i class="icon-menu"></i>
	</header>

 <div id="life" class="page-center-box">
    <div id="scroll">
        <div class="natnalEco_box">

            <div class="weixin_sm">
                <p style="margin-left:25px;">点击右上角分享或者让朋友扫描以下二维码</p>
              
                <div id="code" style="display: none"></div>
                <div id="imagQrDiv" style="margin-left:25px;"></div>

            </div>
            <script type="text/javascript" src="/static/default/mobile/js/jquery-1.7.1.min.js"></script>
            <script type="text/javascript" src="/static/default/mobile/js/jquery.qrcode.min.js"></script>

                <script>
                    url = "http://<?php echo ($_SERVER['HTTP_HOST']); ?>__ROOT__<?php echo U('/mobile/shop/detail',array('shop_id'=>$shop_id));?>?uid=<?php echo ($uid); ?>"
                    $('#code').qrcode(url);

                    function convertCanvasToImage(canvas) {
                        //新Image对象，可以理解为DOM
                        var image = new Image();
                        // canvas.toDataURL 返回的是一串Base64编码的URL，当然,浏览器自己肯定支持
                        // 指定格式 PNG
                        image.src = canvas.toDataURL("image/png");
                        return image;
                    }

                    //获取网页中的canvas对象

                    var mycanvas1=document.getElementsByTagName('canvas')[0];

                    //将转换后的img标签插入到html中

                    var img=convertCanvasToImage(mycanvas1);
//                    alert(img);
                    $('#imagQrDiv').append(img);//imagQrDiv表示你要插入的容器id


                </script>

            <!--<div class="nr">-->
            	<!--<h3><span>活动内容</span></h3>-->
                <!--<p>活动内容</p>-->
            <!--</div>-->
            <!--<div class="nr">-->
            	<!--<h3><span>活动规则</span></h3>-->
                <!--<p>活动规则</p>-->
            <!--</div>-->
        </div>
    </div>
</div>