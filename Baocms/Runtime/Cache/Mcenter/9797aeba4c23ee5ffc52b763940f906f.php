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
		<a class="top-addr" href="<?php echo U('goods/index',array('aready'=>1));?>"><i class="icon-angle-left"></i></a>
	</div>
		<div class="top-title">
			订单详情
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
				订单编号
				<em><?php echo ($detail["order_id"]); ?></em>
			</a>
		</li>
		<li>
			<a href="javascript:;">
				订单金额
				<em>¥ <?php echo round($detail['total_price']/100,2);?> 元</em>
			</a>
		</li>
        
        
		<!--<li>-->
			<!--<a href="javascript:;">-->
				<!--配送费用-->
                <!--<?php if($detail['total_express'] == 0): ?>-->
                <!--<em class="text-dot">免邮</em>-->
                <!--<?php else: ?>-->
                <!--<em class="text-dot">¥ <?php echo round($detail['total_express']/100,2);?> 元</em>-->
                <!--<?php endif; ?>-->
				<!---->
			<!--</a>-->
		<!--</li>-->
        
        <?php if($detail['can_use_integral'] > 0): ?><li><a href="javascript:;">秀币抵现 <em class="text-dot">¥ <?php echo round($detail['can_use_integral']/100,2);?> 元</em></a></li><?php endif; ?>
        
        <?php if($detail['mobile_fan'] > 0): ?><li><a href="javascript:;">手机下单立减 <em class="text-dot">¥ <?php echo round($detail['mobile_fan']/100,2);?> 元</em></a></li><?php endif; ?>
        
        
		<li>
			<a href="javascript:;">
				实际支付
				<em class="text-dot">¥ <?php echo round($detail['total_express']/100 + $detail['need_pay']/100 ,2);?> 元</em>
			</a>
		</li>
		<li>
			<a href="javascript:;">
				下单时间
				<em><?php echo (date('Y-m-d H:i',$detail["create_time"])); ?></em>
			</a>
		</li>
	</ul>
</div>
<div class="blank-10 bg"></div>
<!--<div class="panel-list">-->
	<!--<ul>-->
		<!--<li>-->
			<!--<a href="javascript:;">-->
				<!--收货姓名-->
				<!--<em><?php echo ($addr['name']); ?></em>-->
			<!--</a>-->
		<!--</li>-->
		<!--<li>-->
			<!--<a href="javascript:;">-->
				<!--手机号码-->
				<!--<em><?php echo ($addr["mobile"]); ?></em>-->
			<!--</a>-->
		<!--</li>-->
		<!--<li>-->
			<!--<a href="javascript:;">-->
				<!--配送地址-->
				<!--<small class="text-small margin-left text-gray"><?php echo ($citys[$addr['city_id']]['name']); ?> <?php echo ($areas[$addr['area_id']]['area_name']); ?> <?php echo ($bizs[$addr['business_id']]['business_name']); ?> <?php echo ($addr["addr"]); ?></small>-->
			<!--</a>-->
		<!--</li>-->
	<!--</ul>-->
<!--</div>-->
		
<div class="blank-10 bg"></div>
<div class="list-media-x">
	<ul>
		<?php if(is_array($ordergoods)): foreach($ordergoods as $key=>$item): ?><li class="line padding">
			<div class="x3">
				<img style="width:90%;" src="__ROOT__/attachs/<?php echo ($goods[$item['goods_id']]['photo']); ?>" />
			</div>
			<div class="x9">
				<p><?php echo ($goods[$item['goods_id']]['title']); ?></p>
				<p class="text-small padding-top">小计：<span class="text-dot">￥<?php echo round($item['price']/100,2);?> x <?php echo ($item["num"]); ?> = <?php echo round($item['total_price']/100,2);?> 元</span></p>
			</div>
		</li><?php endforeach; endif; ?>  
	</ul>
</div>

<div class="blank-30"></div>
	<div class="container text-center">
		<?php if(($detail["is_daofu"]) == "0"): if(($detail["status"]) == "0"): ?><a class="button button-block button-big bg-dot" href="<?php echo U('mobile/mall/pay',array('order_id'=>$detail['order_id']));?>">去付款</a>
                <?php else: ?>
                <!--<a class="button button-block button-big bg-blue"><?php echo ($types[$detail['status']]); ?></a>-->
                <a class="button button-block button-big bg-blue">已完成</a><?php endif; ?>
            <?php else: ?>
                <?php if(($detail["status"]) == "0"): ?><a class="button button-block button-big bg-blue">货到付款</a>
                <?php else: ?>
                <a class="button button-block button-big bg-blue"><?php echo ($types[$detail['status']]); ?></a><?php endif; endif; ?>
	</div>
<div class="blank-20"></div>


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