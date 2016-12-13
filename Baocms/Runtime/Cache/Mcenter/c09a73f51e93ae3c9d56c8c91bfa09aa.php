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
			优惠买单
		</div>
		<div class="top-share">
		</div>
	</header>
<style>
.button-toolbar .button-group {padding: 0 10px;}
.list-media-x { margin-top: 0.0rem;}
.list-media-x p {margin-top: 0.0rem;}
</style>





<div class="blank-10 bg"></div>
<div class="list-media-x" id="list-media">

	<ul>

<?php if(is_array($list)): foreach($list as $key=>$var): ?><li class="line ">
      <dt><a class="x3">ID：<?php echo ($var["id"]); ?></a><a class="x9 text-right">创建时间:<?php echo (date('Y-m-d H:i',$var["create_time"])); ?></a></dt>

      <dd class="zhong">
         <div class="12">
            <p>商家：<?php echo ($var["shop_name"]); ?></p>
            <p>消费金额：<?php echo ($var["total"]); ?></p>
            <p>优惠券抵扣：-<?php echo ($var["yhk"]); ?></p>
			 <?php if($var['integral']): ?><p>使用秀币：<?php echo ($var["integral"]); ?>(抵扣:-<?php echo round($var['integral']/100,2);?>)</p><?php endif; ?>
            <p>备注：<?php echo ($var['remark']); ?></p>
            <p>赠品消费：<?php echo ($var['keywords']); ?></p>
			 <?php if(is_array($var['zp'])): foreach($var['zp'] as $key=>$row): ?><p><?php echo ($key); ?> x <?php echo ($row); ?></a></p><?php endforeach; endif; ?>
		 </div>
      </dd>

      <dl>
		  <p class="text-left x8">
			  <a class="margin-top">实付:&nbsp;<font color="red"><?php echo round($var['total'] - $var['yhk'] - $var['integral']/100,2);?></font></a>
			  <br>
			  <?php if($var['pay_time']): ?><a class="margin-top">付款时间:&nbsp;<font color="#999"><?php echo (date('Y-m-d H:i',$var["create_time"])); ?></font></a><?php endif; ?>
		  </p>

         <p class="text-right x4">
         <?php if(($var["status"]) == "1"): ?><a class="button button-small bg-gray margin-top" href="<?php echo U('pay/pay',array('id'=>$var['id']));?>">付款</a>
         <?php else: ?>
			 <?php if(($var["is_offline"]) == "1"): ?><a class="button button-small bg-green margin-top">已完成</a>
				 <?php else: ?>
				 <a class="button button-small bg-green margin-top">已完成(线下)</a><?php endif; endif; ?>


         </p>
      </dl>
    </li>

    <div class="blank-10 bg"></div><?php endforeach; endif; ?>
  </ul>
</div>

<div class="blank-20"></div>
<div class="container login-open">
<h5 style="text-align:center"><?php echo ($page); ?><!--分页代码不要忘记加--> </h5>
</div>
<script>
	$(document).ready(function () {
		$(document).on('click', ".jquery-delete", function (e) {
			var id = $(this).attr('rel');
			layer.confirm('您确定要删除？', {
				skin: 'layer-ext-demo',
				area: ['50%', 'auto'], //宽高
				btn: ['是的', '不'], //按钮
				shade: false //不显示遮罩
			}, function () {
				$.post("<?php echo U('pay/delete');?>", {id: id}, function (result) {
					if (result.status == "success") {
						layer.msg(result.msg);
						setTimeout(function () {
							location.reload();
						}, 1000);
					} else {
						layer.msg(result.msg);
					}
				}, 'json');
			});
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