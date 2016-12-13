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
		<a class="top-addr" href="<?php echo U('index/index');?>"><i class="icon-angle-left"></i></a>
	</div>
		<div class="top-title">
			账户信息
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
<?php $mobile = substr_replace($res['mobile'],'****',3,4); ?>
<style>
.layui-layer-molv .layui-layer-title {background-color: #F8F8F8;border-bottom: 1px solid #eee;color: #333;}
</style>
<div class="container">
		<div class="blank-10"></div>
		<p><span class="text-dot">小提示：</span> 如果您是微信登录的用户，请绑定手机后都改登录密码，然后就可以登录电脑版了！</p>
	</div>
<div class="panel-list border-top">
	<ul>
		<li>
			<a href="<?php echo U('info/face');?>">
				上传头像
				<i class="icon-angle-right"></i>
			</a>
		</li>
		<li>
			<a href="<?php echo U('info/nickname');?>">
				用户昵称<em><?php echo ($res["nickname"]); ?></em>
			</a>
		</li>
		<li>
			<a href="<?php echo U('mcenter/addrs/index');?>">
				收货地址<em><?php echo ($addr_count); ?>个</em>
			</a>
		</li>
	</ul>
</div>
<div class="blank-10 bg"></div>

<div class="panel-list border-top">
	<ul>
		<li>
			<a <?php if(!empty($res['mobile'])): ?>id="change_mobile"<?php else: ?>id="bind_mobile"<?php endif; ?> href="javascript:void(0);">
				绑定手机<?php if(!empty($res["mobile"])): ?><em class="text-green"><?php echo ($mobile); ?></em><?php else: ?><em class="text-gray">未绑定</em><?php endif; ?>
			</a>
		</li>
		<!--<li>
			<?php if(!isset($bind['weixin'])){?>
			<a href="<?php echo U('mobile/passport/wxlogin');?>">
				绑定微信<em class="text-gray">未绑定</em>
			</a>
			<?php }else{?>
			<a href="javascript:;">
				绑定微信<em class="text-green">已绑定</em>
			</a>
			<?php }?>
		</li>
		<li>
			<?php if(!isset($bind['qq'])){?>
			<a href="<?php echo U('mobile/passport/qqlogin');?>">
				绑定QQ<em class="text-gray">未绑定</em>
			</a>
			<?php }else{?>
			<a href="javascript:;">
				绑定QQ<em class="text-green">已绑定</em>
			</a>
			<?php }?>
		</li>
		<li>
			<?php if(!isset($bind['weibo'])){?>
			<a href="<?php echo U('mobile/passport/wblogin');?>">
				绑定微博<em class="text-gray">未绑定</em>
			</a>
			<?php }else{?>
			<a href="javascript:;">
				绑定微博<em class="text-green">已绑定</em>
			</a>
			<?php }?>
		</li>-->
        
        <li>
			<a href="<?php echo U('info/password');?>">
				修改密码登录
				<i class="icon-angle-right"></i>
			</a>
		</li>
	</ul>
</div>



<?php if(!empty($res["mobile"])): ?><script>
	$('#change_mobile').click(function(){
		change_user_mobile('<?php echo U("mobile/tuan/tuan_sendsms");?>','<?php echo U("mobile/tuan/tuan_mobile");?>');
	})
</script>
<?php else: ?>
<script>
	check_user_mobile('<?php echo U("mobile/tuan/tuan_sendsms");?>','<?php echo U("mobile/tuan/tuan_mobile");?>');
	$('#bind_mobile').click(function(){
		check_user_mobile('<?php echo U("mobile/tuan/tuan_sendsms");?>','<?php echo U("mobile/tuan/tuan_mobile");?>');
	})
</script><?php endif; ?>

<div class="blank-20"></div>
<?php if($CONFIG[other][footer] == 1): ?><footer class="foot-fixed">
  
    <a class="foot-item <?php if(($ctl == 'index') AND ($act != 'more')): ?>active<?php endif; ?>" href="<?php echo u('mobile/index/index');?>">		
    <span class="icon icon-home"></span>
    <span class="foot-label">首页</span>
    </a>
   
    
    <a class="foot-item   <?php if(($ctl == 'tuan') || ($ctl == 'goods') || ($ctl == 'eleorder') || ($ctl == 'ding') ): ?>active<?php endif; ?>" href="      <?php echo LinkTo('tuan/index');?>">			
    <span class="icon icon-cart-plus"></span><span class="foot-label">订单</span></a>
    
     <a class="foot-item  <?php if(($ctl == 'tuancode')): ?>active<?php endif; ?>" href="<?php echo u('mcenter/tuancode/index');?>">			
    <span class="icon icon-tags"></span><span class="foot-label">抢购劵</span></a>
    
    
    
    <a class="foot-item  <?php if(($ctl == 'message') ||($act == 'xiaoxizhongxin')): ?>active<?php endif; ?>" href="<?php echo u('mcenter/message/someone');?>">			
    <span class="icon icon-volume-up"></span><span class="foot-label">消息</span></a>
    
    <a class="foot-item  <?php if(($ctl == 'money') || ($ctl == 'logs') || ($ctl == 'cash') ||($act == 'zijinguanli')): ?>active<?php endif; ?>" href="<?php echo u('mcenter/information/index');?>">			
    <span class="icon icon-gears"></span><span class="foot-label">设置</span></a>
    
   
    </footer><?php endif; ?>

<iframe id="x-frame" name="x-frame" style="display:none;">
</iframe>
</body>
</html>