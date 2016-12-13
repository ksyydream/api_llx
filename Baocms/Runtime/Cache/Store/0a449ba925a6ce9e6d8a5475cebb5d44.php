<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<meta charset="utf-8">
		<title>商家管理中心-<?php echo ($CONFIG["site"]["title"]); ?></title>
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" href="/static/default/wap/css/base.css">
		<link rel="stylesheet" href="/static/default/wap/css/<?php echo ($ctl); ?>.css"/>
        <link rel="stylesheet" href="/static/default/wap/css/store.css">
		<script src="/static/default/wap/js/jquery.js"></script>
		<script src="/static/default/wap/js/base.js"></script>
		<script src="/static/default/wap/other/layer.js"></script>
		<script src="/static/default/wap/other/roll.js"></script>
		<script src="/static/default/wap/js/public.js"></script>


        <script src="/static/default/wap/js/dingwei.js"></script>
		 <script>
            function bd_encrypt(gg_lat, gg_lon)   // 百度地图测距偏差 问题修复
            {
                var x_pi = 3.14159265358979324 * 3000.0 / 180.0;
                var x = gg_lon;
                var y = gg_lat;
                var z = Math.sqrt(x * x + y * y) + 0.00002 * Math.sin(y * x_pi);
                var theta = Math.atan2(y, x) + 0.000003 * Math.cos(x * x_pi);
                var bd_lon = z * Math.cos(theta) + 0.0065;
                var bd_lat = z * Math.sin(theta) + 0.006;
                dingwei('<?php echo U("mobile/index/dingwei",array("t"=>$nowtime,"lat"=>"llaatt","lng"=>"llnngg"));?>', bd_lat, bd_lon);

            }

            navigator.geolocation.getCurrentPosition(function (position) {
                bd_encrypt(position.coords.latitude, position.coords.longitude);
            });
        </script>
	</head>
	<body>  
	<header class="top-fixed bg-yellow bg-inverse">
		<div class="top-back">
			<a class="top-addr" href="<?php echo U('fans/index');?>"><i class="icon-angle-left"></i></a>
		</div>
		<div class="top-title">
			增加秀币
		</div>
		<div class="top-share">
			<a  href="javascript:void(0);" id="cate-btn"></a>
		</div>
	</header>

<style>
.tab-bar {padding:0; }

</style>  
 <div class="line tab-bar">
	<div class="button-toolbar">
		<div class="button-group">
			<a class="block button bg-dot active" style="border-radius:0px;">注意：亲，您给粉丝所加的秀币必须不大于自己的秀币额！</a>
		</div>
	</div>
</div>   

  
<form class="fabu-form" method="post"  target="x-frame" action="<?php echo U('fans/add',array('user_id'=>$user['user_id']));?>">
<div class="blank-10 bg border-top"></div>

<div class="row">
	<div class="line">
		<span class="x3">您的秀币：</span>
		<span class="x9">
			<input type="text" class="text-input"  disabled="disabled" value=""  placeholder="<?php echo ($shop['shop_name']); ?>您的秀币：<?php echo ($jifen); ?>" />
		</span>
	</div>
</div>


<div class="row">
	<div class="line">
		<span class="x3">用户名：</span>
		<span class="x9">
			<input type="text" class="text-input"  disabled="disabled" value="" placeholder="用户名：<?php echo ($user['nickname']); ?>"/>
		</span>
	</div>
</div>


<div class="row">
	<div class="line">
		<span class="x3">用户秀币：</span>
		<span class="x9">
			<input type="text" class="text-input"  disabled="disabled" value=""  placeholder="用户秀币：<?php echo ($user['integral']); ?>" />
		</span>
	</div>
</div>

<div class="row">
	<div class="line">
		<span class="x3">赠送秀币：</span>
		<span class="x9">
			<input type="text" class="text-input"  name="integral"  value=""  placeholder="输入您要赠送的秀币" />
		</span>
	</div>
</div>


<div class="container">
		<div class="blank-30"></div>
		<button  type="submit" class="button button-block button-big bg-dot">确认赠送</button>
		<div class="blank-30"></div>
</div>  
</form>  

    <footer class="foot-fixed">		
           <a class="foot-item <?php if(($ctl == 'index') AND ($act != 'more')): ?>active<?php endif; ?>" href="<?php echo U('index/index');?>">		
    	    <span class="icon icon-home"></span>		
        	<span class="foot-label">商户中心</span>
            </a>		

            <a class="foot-item <?php if(($ctl) == "tuan"): ?>active<?php endif; ?>" href="<?php echo U('index/index/index');?>">
            	<span class="icon icon-plus"></span>
                <span class="foot-label">商城首页</span>
            </a>
            
           <a class="foot-item <?php if(($ctl) == "mart"): ?>active<?php endif; ?>" href="<?php echo U('store/mart/index');?>">		
            	<span class="icon icon-recycle"></span>			
                <span class="foot-label">微店</span>
            </a>
            
            <a class="foot-item <?php if(($ctl) == "money"): ?>active<?php endif; ?>" href="<?php echo U('store/money/index');?>">		
            	<span class="icon icon-calendar"></span>			
                <span class="foot-label">资金结算</span>
            </a>
            
            <a class="foot-item <?php if(($ctl) == "pay"): ?>active<?php endif; ?>" href="<?php echo U('store/pay/index');?>">
            	<span class="icon icon-tags"></span>
                <span class="foot-label">优惠买单</span>
            </a>

            </footer>	
            <iframe id="x-frame" name="x-frame" style="display:none;"></iframe>
        </body>
 </html>