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
		<a class="top-addr" href="<?php echo U('mcenter/member/index');?>"><i class="icon-angle-left"></i></a>
	</div>
		<div class="top-title">
			我的快递
		</div>
	<div class="top-signed">
		<a href="<?php echo U('express/create');?>"><i class="icon-plus-square"></i> 发布</a>
	</div>
</header>
<style>
ul { padding-left: 0px !important;}
</style>
<!-- 筛选TAB -->
<ul id="shangjia_tab">
        <li style="width: 33.33333367%;"><a href="<?php echo LinkTo('express/index');?>"  <?php if($status ==null){echo 'class=on';} ?>>全部</a></li>
        <li style="width: 33.33333367%;"><a href="<?php echo LinkTo('express/index',array('status'=>1));?>" <?php if(($status) == "1"): ?>class="on"<?php endif; ?>>未完成</a></li>
        <li style="width: 33.33333367%;"><a href="<?php echo LinkTo('express/index',array('status'=>2));?>"<?php if(($status) == "2"): ?>class="on"<?php endif; ?>>已完成</a></li>
        
</ul>


<div class="list-media-x" id="list-media">
	<ul></ul>
</div>	

    
<script>
	$(document).ready(function () {	 
	
		loaddata('<?php echo U("mcenter/express/load",array("t"=>$nowtime,"p"=>"0000","status"=>$status));?>', $("#list-media ul"), true);
	});
</script>

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