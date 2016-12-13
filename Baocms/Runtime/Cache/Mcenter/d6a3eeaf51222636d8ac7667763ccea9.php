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

		<a class="top-addr" href="<?php echo U('mcenter/index/index');?>"><i class="icon-angle-left"></i></a>

	</div>

		<div class="top-title">

			完成支付

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



<?php if(is_array($goods)): foreach($goods as $key=>$item): ?><div class="panel-list">

	<ul>

		<li>

			<a href="javascript:;">

				订单编号：

				<em class="text-gray"><?php echo ($item[0]["order_id"]); ?></em>

			</a>

		</li>

		<li>

			<a href="javascript:;">

				付款时间：<em><?php echo (date('Y-m-d H:i',$detail["create_time"])); ?></em>

			</a>

		</li>

	</ul>

</div>

<div class="blank-10 bg"></div>



<?php if(is_array($item)): foreach($item as $key=>$var): ?><div class="line padding border-bottom">

	<div class="x3">

		<img src="<?php echo config_img($good[$var['goods_id']]['photo']);?>" width="90%" />

	</div>

	<div class="x9">

		<p class="margin-small"><?php echo ($good[$var['goods_id']]['title']); ?></p>

		<p class="margin-small">

			<?php echo ($var["num"]); ?><span class="margin-left">x</span><span class="margin-left">￥<?php echo round($var['price']/100,2);?></span><span class="margin-left text-dot">=￥<?php echo round($var['total_price']/100,2);?></span>

		</p>

	</div>

</div><?php endforeach; endif; endforeach; endif; ?>

<div class="blank-10 bg"></div>



<div class="panel-list">

	<ul>

		<li>

			<a href="javascript:;">

				付款方式：

				<em class="text-gray"><?php echo ($paytype[$detail['code']]['name']); ?></em>

			</a>

		</li>

		<li>

			<a href="javascript:;">

				配送运费：<em class="text-dot">￥<?php echo round($detail['express']/100,2);?></em>

			</a>

		</li>

		<li>

			<a href="javascript:;">

				结算价格：<em class="text-dot">￥<?php echo round($detail['need_pay']/100,2);?></em>

			</a>

		</li>

		<li>

			<a href="javascript:;">

				地址：<em class="text-dot"><?php echo ($areas[$addr['area_id']]['area_name']); ?>&nbsp;<?php echo ($bizs[$addr['business_id']]['business_name']); ?>&nbsp;<?php echo ($addr['addr']); ?></em>

			</a>

		</li>

	</ul>

</div>



<div class="blank-20"></div>

<div class="line text-center">

	<a class="button bg-dot" href="<?php echo U('mcenter/goods/detail',array('order_id'=>$detail['order_id']));?>">查看详情</a>

	<a class="button bg-main" href="<?php echo U('mobile/mall/index');?>">继续逛逛</a>

</div>

<div class="blank-20"></div>




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