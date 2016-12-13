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
			我的团队
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

<style>
	.button-toolbar .button-group {padding: 0 10px;}
	.list-media-x { margin-top: 0.0rem;}
	.list-media-x p {margin-top: 0.0rem;}
	/*搜索框开始*/
	.xiaoqu-search1 {padding: 15px; background: #fafafa;border-bottom: thin solid #eee;}
	.xiaoqu-search1 select{width:100%;height: 50px;}
	/*搜索框结束*/
</style>


<div class="blank-10 bg"></div>

<div class="xiaoqu-search1">
	<form method="post" action="<?php echo U('team/index');?>">
		<div class="sh_search_more_time mb10">
			<select onchange="select_shop(this)" name="shop_id">
				<option value="">-请选择店铺-</option>
				<?php if(is_array($shops)): foreach($shops as $key=>$row): ?><option value="<?php echo ($row['shop_id']); ?>" <?php if($row['shop_id'] == $shop_id): ?>selected="selected"<?php endif; ?>><?php echo ($row['shop_name']); ?></option><?php endforeach; endif; ?>
			</select>
		</div>
	</form>
</div>

<div class="list-media-x" id="list-media">

	<ul>

		<li class="line ">
			<dt><a class="x8">一级会员</a><a class="x4 text-right" style="color: red">人数:<?php echo (count($team1_info)); ?></a></dt>
			<?php if(is_array($team1_info)): foreach($team1_info as $key=>$row): ?><dd class="zhong">
				<div class="x6">
					<img src="<?php echo config_img($row['face']);?>" width="50px" height="50px"/>
				</div>
					<div class="x6">
						<p>手机:<?php echo ($row['mobile']); ?></p>
						<p>昵称:<?php echo ($row['nickname']); ?></p>
					</div>
			</dd><?php endforeach; endif; ?>

		</li>


		<li class="line ">
			<dt><a class="x8">二级会员</a><a class="x4 text-right" style="color: red">人数:<?php echo (count($team2_info)); ?></a></dt>

			<?php if(is_array($team2_info)): foreach($team2_info as $key=>$row): ?><dd class="zhong">
					<div class="x6">
						<img src="<?php echo config_img($row['face']);?>" width="50px" height="50px"/>
					</div>
					<div class="x6">
						<p>手机:<?php echo ($row['mobile']); ?></p>
						<p>昵称:<?php echo ($row['nickname']); ?></p>
					</div>
				</dd><?php endforeach; endif; ?>
		</li>


		<li class="line ">
			<dt><a class="x8">三级会员</a><a class="x4 text-right" style="color: red">人数:<?php echo (count($team3_info)); ?></a></dt>

			<?php if(is_array($team3_info)): foreach($team3_info as $key=>$row): ?><dd class="zhong">
					<div class="x6">
						<img src="<?php echo config_img($row['face']);?>" width="50px" height="50px"/>
					</div>
					<div class="x6">
						<p>手机:<?php echo ($row['mobile']); ?></p>
						<p>昵称:<?php echo ($row['nickname']); ?></p>
					</div>
				</dd><?php endforeach; endif; ?>
		</li>



	</ul>
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

<script>
	function select_shop(obj){
		$('form').submit();
	}
</script>