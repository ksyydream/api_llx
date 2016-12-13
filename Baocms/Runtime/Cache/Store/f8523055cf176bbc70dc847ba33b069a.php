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
        <a class="top-addr" href="<?php echo U('pay/index');?>"><i class="icon-angle-left"></i></a>
    </div>
    <div class="top-title">
        线下支付
    </div>
</header>

<form class="fabu-form" method="post" target="x-frame" action="<?php echo U('pay/check_pay');?>">
    <input type="hidden" name="id" value="<?php echo ($detail["id"]); ?>">
    <div class="blank-10 bg border-top"></div>

    <div class="row">
        <div class="line">
            <span class="x3">商家</span>
		<span class="x9">
			<?php echo ($detail['shop_name']); ?>
		</span>
        </div>
    </div>

    <div class="row">
        <div class="line">
            <span class="x3">消费金额</span>
            <span class="x9">
                <?php echo ($detail['total']); ?>
            </span>
        </div>
    </div>

    <div class="row">
        <div class="line">
            <span class="x3">优惠券抵扣</span>
		<span class="x9">
			-<?php echo ($detail['yhk']); ?>
		</span>
        </div>
    </div>



    <div class="row">
        <div class="line">
            <span class="x3">备注</span>
		<span class="x9">
			<?php echo ($detail['remark']); ?>
		</span>
        </div>
    </div>

    <div class="row">
        <div class="line">
            <span class="x3">赠品消费</span>
		<span class="x9">
		</span>
        </div>
    </div>

    <?php if($detail['zp']): ?><div id="zp_info">

            <div class="row">
                <div class="line">
                    <span class="x6" style="color:#999">赠品</span>
                    <span class="x6" style="color:#999">数量</span>
                </div>
            </div>

            <?php if(is_array($detail['zp'])): foreach($detail['zp'] as $key=>$var): ?><div class="row">
                    <div class="line">
                        <span class="x6" style="color:#999"><?php echo ($key); ?></span>
                        <span class="x6" style="color:#999"><?php echo ($var); ?></span>
                    </div>
                </div><?php endforeach; endif; ?>
        </div><?php endif; ?>

    <div class="row">
        <div class="line">
            <span class="x3">使用秀币</span>
            <span class="x3">
                <input type="number" name="integral" value="0" onblur="xiubi_blur()" class="text-input">
            </span>
            <span class="x6">
                秀币余额:<a onclick="use_integral(this)" style="color:blue;"><?php echo ($integral); ?></a>
            </span>
        </div>
    </div>

    <div class="row">
        <div class="line">
            <span class="x3">实付</span>
		<span class="x9" id="shifu" style="color:red">
            <?php echo round($detail["total"] - $detail["yhk"],2);?>
		</span>
        </div>
    </div>

    <div class="container">
        <div class="blank-30"></div>
        <?php if($detail['status'] == 1): ?><button type="submit" class="button button-block button-big bg-dot" onclick="return check_pay()">线下支付</button>
        <?php else: ?>
            <button type="submit" class="button button-block button-big bg-green" onclick="return false">已完成</button><?php endif; ?>
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

<script>
    function use_integral(obj){
        integral = parseInt('<?php echo ($integral); ?>');
        total = (parseInt('<?php echo ($detail["total"]); ?>') - parseInt('<?php echo ($detail["yhk"]); ?>')) * 100;
        if(integral <= total){
            $("[name='integral']").val(integral)
        }else{
            $("[name='integral']").val(total)
        }
        shifu = parseInt('<?php echo round($detail["total"] - $detail["yhk"],2);?>');
        shifu = shifu - parseInt($("[name='integral']").val())/100
        $("#shifu").html(shifu);
    }

    function check_pay(){
        integral = parseInt('<?php echo ($integral); ?>');
        total = (parseInt('<?php echo ($detail["total"]); ?>') - parseInt('<?php echo ($detail["yhk"]); ?>')) * 100;
        integral_input = $("[name='integral']").val()
        if(integral_input < 0 || integral < integral_input || integral_input > total){
            alert('请输入正确数量的秀币');
            return false;
        }
    }

    function xiubi_blur(){
        integral_input = $("[name='integral']").val()?parseInt($("[name='integral']").val()):0
//        $("[name='integral']").val(0)
        integral = parseInt('<?php echo ($integral); ?>');
        total = (parseInt('<?php echo ($detail["total"]); ?>') - parseInt('<?php echo ($detail["yhk"]); ?>')) * 100;
        if(integral_input < 0 || integral < integral_input || integral_input > total){
            alert('请输入正确数量的秀币');
            $("[name='integral']").val(0)
        }
        shifu = parseInt('<?php echo round($detail["total"] - $detail["yhk"],2);?>');
        shifu = parseInt('<?php echo round($detail["total"] - $detail["yhk"],2);?>') - parseInt($("[name='integral']").val())/100
        $("#shifu").html(shifu.toFixed(2));
    }
</script>