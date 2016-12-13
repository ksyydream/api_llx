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
<link rel="stylesheet" href="/static/default/wap/css/housekeeping.css"/>  
	<link href="/static/default/wap/other/jquery-ui.css" rel="stylesheet" />
	<script src="/static/default/wap/other/jquery-ui.js"></script> 
	<header class="top-fixed bg-yellow bg-inverse">
		<div class="top-back">
			<a class="top-addr" href="<?php echo U('index/index');?>"><i class="icon-angle-left"></i></a>
		</div>
		<div class="top-title">
			提现申请
		</div>
	</header>



<style>
ul { padding-left: 0px;}
.layui-layer-molv .layui-layer-title {background-color: #F8F8F8;border-bottom: 1px solid #eee;color: #333;}
</style>
<!-- 筛选TAB -->
<ul id="shangjia_tab">
        <!--<li style="width:25%;"><a href="<?php echo U('money/index');?>">商家资金</a></li>-->
        <li style="width:33.3%;"><a href="<?php echo U('money/detail');?>">资金日志</a></li>
        <li style="width:33.3%;"><a href="<?php echo U('money/cashlogs');?>">提现日志</a></li>
        <li style="width:33.3%;"><a href="<?php echo U('money/cash');?>"   class="on">申请提现</a></li>

</ul> 



  
    <div class="blank-10 bg"></div> 
    <div class="line padding border-bottom" style="margin-top:2rem;">
        <span class="x12 text-gray">你好：<?php echo ($MEMBER['account']); ?></span>
		<span class="x12 text-gray">可提现余额：<?php echo round($gold/100,2);?>元<?php if(!empty($MEMBER['frozen'])): ?>， 冻结金：<?php echo round($MEMBER['frozen']/100,2);?>元。<?php endif; ?></span>
	</div>
    
    <div class="blank-10 bg"></div> 
    <form action="<?php echo U('mcenter/money/cash');?>" method="post" target="x-frame">
	<div class="line padding border-bottom">
		<span class="x3 text-gray">提现金额：</span>
		<span class="x5"><input type="text" name="gold" id="money" class="text-input" ></span>
		<span class="x4"><em class="text-small text-gray">
        <?php if(!empty($cash_money)): ?>单笔最少<?php echo ($cash_money); ?>元<br/><?php endif; ?>
        <?php if(!empty($cash_money_big)): ?>单笔最多<?php echo ($cash_money_big); ?>元<?php endif; ?>
        
        <em></span>
	</div>
	<div class="line padding border-bottom">
		<span class="x3 text-gray">开户银行：</span>
		<span class="x9"><input type="text" name="bank_name" id="bank_name" class="text-input"  value="<?php echo ($info["bank_name"]); ?>"  placeholder="请输入开户银行" ></span>

	</div>
    <div class="line padding border-bottom">
		<span class="x3 text-gray">银行账号：</span>
		<span class="x9"><input type="text" name="bank_num" id="bank_num" class="text-input"  value="<?php echo ($info["bank_num"]); ?>"   placeholder="请输入银行账户" ></span>

	</div>
    <div class="line padding border-bottom">
		<span class="x3 text-gray">具体支行：</span>
		<span class="x9"><input type="text" name="bank_branch" id="bank_branch" class="text-input"   value="<?php echo ($info["bank_branch"]); ?>"  placeholder="请输入具体支行名字" ></span>

	</div>
    <div class="line padding border-bottom">
		<span class="x3 text-gray">开户名：</span>
		<span class="x9"><input type="text" name="bank_realname" id="bank_realname" class="text-input"  value="<?php echo ($info["bank_realname"]); ?>"  placeholder="输入开户名" ></span>
	</div>
    
   <?php $mobile = substr_replace($MEMBER['mobile'],'****',3,4); ?> 
   
   <!--验证码--> 
   <?php if(!empty($MEMBER['mobile'])): ?><div class="line padding border-bottom">
		<span class="x3 text-gray">输入手机</span>
		<span class="x5">
        <input type="text" name="mobile" id="mobile" class="text-input" value="<?php echo ($MEMBER['mobile']); ?>" disabled="disabled">
        </span>
		<span class="x4"><a class="button button-small bg-dot" id="jq_send" href="javascript:void(0);">获取验证码</a></span>
	</div>
	<div class="line padding border-bottom">
		<span class="x3 text-gray">验证码</span>
		<span class="x5"><input type="text" name="yzm" id="yzm" class="text-input" placeholder="验证码"></span>
		<span class="x4"><em class="text-small text-gray">手机收到的验证码<em></span>
	</div>
   <?php else: ?> <!--绑卡流程--> 
   <div class="line padding border-bottom">
		<span class="x3 text-gray">输入手机</span>
		<span class="x9"> <a <?php if(!empty($res['mobile'])): ?>id="change_mobile"<?php else: ?>id="bind_mobile"<?php endif; ?> href="javascript:void(0);">
				绑定手机<?php if(!empty($res["mobile"])): ?><em class="text-green"><?php echo ($mobile); ?></em><?php else: ?><em class="text-gray">未绑定</em><?php endif; ?>
			</a></span>
	</div><?php endif; ?>
   <!--结束-->  
          
    
	<div class="container">
		<div class="blank-30"></div>
		<p><span class="text-dot">小提示：</span> 请您认真填写!</p>
	</div>
	<div class="container">
		<div class="blank-30"></div>
            <?php if(($money) == "0"): ?><button class="button button-big button-block bg-gray">您的余额不足</button>                                     
            <?php else: ?>
            <button class="button button-big button-block bg-dot">确认申请</button><?php endif; ?>   
		
		<div class="blank-30"></div>
	</div>
</form>

<?php if(!empty($MEMBER["mobile"])): ?><script>
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



<script type="text/javascript">
	var mobile_timeout;
	var mobile_count = 100;
	var mobile_lock = 0;
	$(function () {
		$("#jq_send").click(function () {
			if (mobile_lock == 0) {
				$.ajax({
					url: '<?php echo U("mcenter/money/sendsms");?>',
					data: 'mobile=' + $("#mobile").val(),
					type: 'post'
				});
				mobile_count = 100;
				BtnCount();
				mobile_lock = 1;
			}

		});
	});
	BtnCount = function () {
		if (mobile_count == 0) {
			$('#jq_send').html("重新发送");
			mobile_lock = 0;
			clearTimeout(mobile_timeout);
		}
		else {
			mobile_count--;
			$('#jq_send').html("重新发送(" + mobile_count.toString() + ")秒");
			mobile_timeout = setTimeout(BtnCount, 1000);
		}
	};
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