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
		<a class="top-addr" href="<?php echo U('information/index');?>"><i class="icon-angle-left"></i></a>
	</div>
		<div class="top-title">
			修改昵称
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

<div class="panel-list">
	<ul>
		<li>
			<a href="javascript:;">
				 当前昵称
				<em class="text-gray"><?php echo ($MEMBER['nickname']); ?></em>
			</a>
		</li>
	</ul>
</div>
<div class="container">
	<div class="blank-10"></div>
	<p class="text-small text-dot">昵称需要检测通过才能修改，不能与别人重复！</p>
	<form target="x-frame" id="nick-form" method="post" action="<?php echo U('info/nickname');?>">
	<input type="hidden" id="status" value="0" />
	<div class="blank-20"></div>
	<div class="form-group">
		<div class="field">
			<div class="input-group">
				<input type="text" id="nickname" class="input" name="nickname" size="50" value="" placeholder="请输入昵称" />
				<span id="check-nick" class="addbtn"><button type="button" class="button">检测</button></span>
			</div>
		</div>
	</div>
	<div class="blank-30"></div>
	<button id="check-form" type="button" class="button button-block button-big bg-dot text-center">立即使用</button>
	</form>
</div>

<script>
	$(document).ready(function () {
		$("#check-nick").click(function () {
			var nickname = $("#nickname").val();
			var page = "/mcenter/info/nickcheck/nickname/"+nickname+".html";
			if(nickname=="" || nickname=="请输入昵称"){
				layer.msg("昵称不能为空！",{icon:2});
				$("#status").val("0");
			}else{
				$.get(page, function (data) {
					if(data == "0"){
						layer.msg("已经有人使用了！",{icon:2});
						$("#status").val("0");
					}else{
						layer.msg("该昵称可以使用！",{icon:1});
						$("#status").val("1");
					}
				
				}, 'html')
			}
		});

		$("#check-form").click(function () {
			var status = $("#status").val();
			if( status == '0'){
				layer.msg("昵称没有检测通过！",{icon:2});
			}else{
				$("#nick-form").submit();
			}
		});
	});
</script>

<div class="blank-20"></div>
<!--<?php if($CONFIG[other][footer] == 1): ?>-->
	<!---->
    <!--<footer class="foot-fixed">-->
  <!---->
    <!--<a class="foot-item <?php if(($ctl == 'index') AND ($act != 'more')): ?>active<?php endif; ?>" href="<?php echo u('mobile/index/index');?>">		-->
    <!--<span class="icon icon-home"></span>-->
    <!--<span class="foot-label">首页</span>-->
    <!--</a>-->
   <!---->
    <!---->
    <!--<a class="foot-item   <?php if(($ctl == 'tuan') || ($ctl == 'goods') || ($ctl == 'eleorder') || ($ctl == 'ding') ): ?>active<?php endif; ?>" href="      <?php echo LinkTo('tuan/index');?>">			-->
    <!--<span class="icon icon-cart-plus"></span><span class="foot-label">订单</span></a>-->
    <!---->
     <!--<a class="foot-item  <?php if(($ctl == 'tuancode')): ?>active<?php endif; ?>" href="<?php echo u('mcenter/tuancode/index');?>">			-->
    <!--<span class="icon icon-tags"></span><span class="foot-label">抢购劵</span></a>-->
    <!---->
    <!---->
    <!---->
    <!--<a class="foot-item  <?php if(($ctl == 'message') ||($act == 'xiaoxizhongxin')): ?>active<?php endif; ?>" href="<?php echo u('mcenter/message/someone');?>">			-->
    <!--<span class="icon icon-volume-up"></span><span class="foot-label">消息</span></a>-->
    <!---->
    <!--<a class="foot-item  <?php if(($ctl == 'member') || ($ctl == 'logs') || ($ctl == 'cash') ||($act == 'zijinguanli')): ?>active<?php endif; ?>" href="<?php echo u('mcenter/member/index');?>">-->
    <!--<span class="icon icon-user"></span><span class="foot-label">会员中心</span></a>-->
    <!---->
   <!---->
    <!--</footer>-->
<!--<?php endif; ?>-->


<footer class="foot-fixed">

    <a class="foot-item <?php if(($ctl == 'mall') AND ($act != 'more')): ?>active<?php endif; ?>" href="<?php echo u('mobile/mall/index');?>">
    <span class="icon icon-home"></span>
    <span class="foot-label">首页</span>
    </a>


    <a class="foot-item   <?php if(($ctl == 'tuan') || ($ctl == 'goods') || ($ctl == 'eleorder') || ($ctl == 'ding') ): ?>active<?php endif; ?>" href="<?php echo LinkTo('goods/index');?>">
    <span class="icon icon-cart-plus"></span><span class="foot-label">我的订单</span></a>

    <a class="foot-item  <?php if(($ctl == 'pay')): ?>active<?php endif; ?>" href="<?php echo U('pay/index');?>">
    <span class="icon icon-tags"></span><span class="foot-label">优惠买单</span></a>



    <a class="foot-item  <?php if(($ctl == 'message') ||($act == 'xiaoxizhongxin')): ?>active<?php endif; ?>" href="<?php echo u('mcenter/message/someone');?>">
    <span class="icon icon-volume-up"></span><span class="foot-label">消息</span></a>

    <a class="foot-item  <?php if(($ctl == 'member') || ($ctl == 'logs') || ($ctl == 'cash') ||($act == 'zijinguanli')): ?>active<?php endif; ?>" href="<?php echo u('mcenter/member/index');?>">
    <span class="icon icon-user"></span><span class="foot-label">会员中心</span></a>


</footer>

<iframe id="x-frame" name="x-frame" style="display:none;">
</iframe>
</body>
</html>