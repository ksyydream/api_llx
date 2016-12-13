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
		<a class="top-addr" href="<?php echo U('mcenter/member/zijinguanli');?>"><i class="icon-angle-left"></i></a>
	</div>
		<div class="top-title">
			提现日志
		</div>
	<div class="top-signed">
		
	</div>
</header>

<style>ul { padding-left: 0px;}</style>
<!-- 筛选TAB -->
<ul id="shangjia_tab">
        <!--<li style="width:25%;"><a href="<?php echo U('money/index');?>">商家资金</a></li>-->
        <li style="width:33.3%;"><a href="<?php echo U('money/detail');?>">资金日志</a></li>
        <li style="width:33.3%;"><a href="<?php echo U('money/cashlogs');?>"  class="on">提现日志</a></li>
        <li style="width:33.3%;"><a href="<?php echo U('money/cash');?>">申请提现</a></li>

</ul> 

<div class="blank-40 bg"></div>
<table class="table">
	<tr>
		<th>ID</th>
		<th>金额</th>
		<th>日期</th>
        <th>状态</th>
	</tr> 
	<?php if(is_array($list)): $index = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$var): $mod = ($index % 2 );++$index;?><tr>
		<td><?php echo ($var["cash_id"]); ?></td>
		<td><?php echo round($var['money']/100,2);?></td>
		<td><?php echo (date('Y-m-d H:i:s', $var['addtime'])); ?></td>
        <td>
        <?php if($var["status"] == 0): ?>未审核
                        <?php elseif($var["status"] == 1): ?>
                        <font color="green">通过</font>
                        <?php else: ?>
                        <font color="red">拒绝</font><?php endif; ?>
        
        </td>
	</tr><?php endforeach; endif; else: echo "" ;endif; ?>                   
</table>
<div class="blank-10 bg"></div>
<div class="container login-open">
<h5 style="text-align:center"><?php echo ($page); ?><!--分页代码不要忘记加--> </h5>
<div class="blank-20"></div>
</div>

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