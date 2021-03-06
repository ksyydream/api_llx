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
<script src="__PUBLIC__/js/my97/WdatePicker.js"></script>  
	<header class="top-fixed bg-yellow bg-inverse">
		<div class="top-back">
			<a class="top-addr" href="<?php echo U('index/index');?>"><i class="icon-angle-left"></i></a>
		</div>
		<div class="top-title">
			资金记录
		</div>
		<div class="top-share">
			<a href="javascript:void(0);" id="cate-btn"></a>
		</div>
	</header>
    <style>
.xiaoqu-search1 { margin-top:2rem;}
.list-media-x { margin-top: 0.0rem;}
.list-media-x p {margin-top: .01rem; line-height:20px;font-size: 12px;}
</style>

	<style>
/*搜索框开始*/
.right {float: right;}.fr {float: right;}.fl {float: left;}.mb10 {margin-bottom: 0.5rem !important;}
.xiaoqu-search1 {padding: 15px; background: #fafafa;border-bottom: thin solid #eee;}
.sh_search_box{}
.sh_search_int{ border:1px solid #dedede;  border-radius:3px;  position:relative; padding-left:0.3rem; background:#fff url(../img/search02.png) 0.1rem center no-repeat; background-size:0.2rem 0.2rem;}
.sh_search_int span{font-size:0.14rem; line-height:0.34rem; color:#333; margin:0px 0.05rem;}
.sh_search_int input{ height:0.34rem; background:none; border:none 0px; width:1.5rem;}
.sh_search_int .btn{ position:absolute; right:0; top:0; font-size:0.15rem;  width:0.5rem; border-left:1px solid #dedede; text-align:center; color:#2fbdaa;}

/*搜索框结束*/

/*商户中心-抢购优惠-抢购管理-订单管理*/
.sh_search_more_time .left{ width:49%;}
.sh_search_more_time .right{ width:49%;}
.sh_search_more_time .left input,.sh_search_more_time .right input{ width:100%; border:1px solid #dedede;  border-radius:3px; background-color:#fff; text-indent:0.3rem; padding: 0.5rem;}
.sh_search_more_int .left{ width:35%;}
.sh_search_more_int .center{ width:45%; position:relative; z-index:1;}
.sh_search_more_int .right{ width:20%; text-align:right;}
.sh_search_more_int .left input,.sh_search_more_int .center input{width:96%; border:1px solid #dedede; border-radius:3px; background-color:#fff;text-indent:0.3rem; padding: 0.5rem;}
.sh_search_more_int .center input{ background:#fff url(../img/buy_int_ico.png) no-repeat 90% center; background-size:0.11rem 0.07rem;}
.sh_search_more_pull{ position:absolute; left:0;  width:96%; background-color:#fff; border:1px solid #dedede; border-top:none 0px;}
.sh_search_more_pull li{ display:block; text-align:center; color:#666;padding: 0.8rem;}
.sh_search_more_int .right .btn{ background-color:#2fbdaa;  border-radius:3px; color:#fff;  border:none 0px;padding: 0.55rem 0.95rem;}

/*****/
</style>


	<div class="xiaoqu-search1">
		<form method="post" action="<?php echo U('money/detail');?>">
     <script src="__PUBLIC__/js/my97/WdatePicker.js"></script>
        <div class="sh_search_more_time mb10">
            <div class="fl left"><input  type="text" name="bg_date" placeholder="开始时间"  value="<?php echo ($bg_date); ?>" onFocus="WdatePicker({startDate: '%y-%M-01', dateFmt: 'yyyy-MM-dd', alwaysUseStartDate: true});"  class="inputData" ></div>
            <div class="fr right"><input type="text" name="end_date" placeholder="结束时间"  value="<?php echo ($end_date); ?>" onFocus="WdatePicker({startDate: '%y-%M-01', dateFmt: 'yyyy-MM-dd', alwaysUseStartDate: true});"  class="inputData"></div>
            <div class="clear"></div>
        </div>
        <div class="sh_login_nr"><input class="button button-block button-big bg-dot" type="submit" value="搜索"></div>
 </form>
</div>

<style>ul { padding-left: 0px;}</style>
<!-- 筛选TAB -->
<ul id="shangjia_tab">
        <li style="width:33.3%;"><a href="<?php echo U('money/integral_detail');?>" class="on">资金日志</a></li>
         <li style="width:33.3%;"><a href="<?php echo U('money/integral_cashlogs');?>">提现日志</a></li>
        <li style="width:33.3%;"><a href="<?php echo U('money/integral');?>">申请提现</a></li>
</ul>



<div class="xiaoqu-list">
		<ul id="xiaoqu-list">
        <?php if(is_array($list)): foreach($list as $key=>$var): ?><li class="line">
            <div class="x12">
                <p class="addr">说明：<?php echo ($var["intro"]); ?></p>
                
                <p class="addr">
               &nbsp;&nbsp;秀币：<?php echo ($var['integral']); ?>
                </p>
               <p class="addr">创建时间：<?php echo (date('Y-m-d H:i:s',$var["create_time"])); ?></p>
            </div>
		</li><?php endforeach; endif; ?>

</ul>  
</div>



<div class="blank-20"></div>
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