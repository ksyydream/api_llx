<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<meta charset="utf-8">
		<title><?php if(!empty($mobile_title)): echo ($mobile_title); ?>_<?php endif; echo ($CONFIG["site"]["sitename"]); ?></title>
        <meta name="keywords" content="<?php echo ($mobile_keywords); ?>" />
        <meta name="description" content="<?php echo ($mobile_description); ?>" />
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="stylesheet" href="/static/default/wap/css/base.css">
		<link rel="stylesheet" href="/static/default/wap/css/<?php echo ($ctl); ?>.css?V=2"/>
		<script src="/static/default/wap/js/jquery.js"></script>
		<script src="/static/default/wap/js/base.js"></script>
		<script src="/static/default/wap/other/layer.js"></script>
		<script src="/static/default/wap/other/roll.js"></script>
		<script src="/static/default/wap/js/public.js"></script>
	    <script src="/static/default/wap/js/mobile_common.js"></script>
        <script src="/static/default/wap/js/iscroll-probe.js"></script>
        
        
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
	<script src="/static/default/wap/other/cookie.js"></script>
	<script src="/static/default/wap/js/ele.js"></script>
	<header class="top-fixed bg-yellow bg-inverse">
		<div class="top-back">
			<a class="top-addr" href="<?php echo U('ele/shop',array('shop_id'=>$shop_id));?>"><i class="icon-angle-left"></i></a>
		</div>
		<div class="top-title">
			我的点餐
		</div>
	</header>
    
    <?php $tt = ($detail['since_money'])-$total['money']*100; ?>
    <div class="line padding border-bottom">
		<span class="text-gray">点餐来自：</span><?php echo ($detail["shop_name"]); ?> <span class="margin-left text-small text-yellow">(满<?php echo round($detail['since_money']/100,2);?>元起送)</span>
	</div>
	
    <form method="post" id="cart-form"  action="<?php echo U('ele/order',array('t'=>$nowtime));?>"  target="x-frame">
    <?php $total_money = 0; ?>
    <div class="cart-list">
		<ul>
			<?php if(is_array($cartgoods)): foreach($cartgoods as $key=>$item): ?><li class="line">
				<div class="x3">
					<img src="__ROOT__/attachs/<?php echo ($item["photo"]); ?>" />
				</div>
				<div class="x9">
					<h5><a target="_blank" href="<?php echo U('ele/detail',array('goods_id'=>$item['goods_id']));?>"><?php echo ($item["product_name"]); ?></a></h5>
					<p><span class="margin-right">单价：￥<?php echo round($item['price']/100,2);?></span> 合计：<span class="text-dot">￥<?php echo round($item['price'] * $item['cart_num']/100,2);?></span></p>
					<div class="num-input" rel="<?php echo ($item["product_id"]); ?>">
						<div class="txt txt-small radius-small bg-gray jian" rel="<?php echo round($item['price']/100,2);?>" onClick="dec(this,<?php echo ($item['product_id']); ?>)">-</div>
						<input value="<?php echo ($item['cart_num']); ?>" name="num[<?php echo ($item['product_id']); ?>]" id="jquery-num" class="txt txt-small num" type="text" readonly="true"/>
						<div class="txt txt-small radius-small bg-yellow jia" rel="<?php echo round($item['price']/100,2);?>" onClick="inc(this,<?php echo ($item['product_id']); ?>)">+</div>
					</div>
					<div class="del float-right" onClick="removeby(<?php echo ($item['product_id']); ?>)"><i class="icon-remove text-dot"></i></div>
				</div>
			</li>
			<?php $total_money+= $item['price'] * $item['cart_num']; endforeach; endif; ?>
		</ul>
	</div>



	<nav class="cart-bar">
		<span class="cart" >
			<i class="icon-shopping-cart"></i> 
			<em class=" float-left">已点 <span class="cart-num" id="num"><?php echo ($total['num']); ?></span> </em>
			<em class="margin-left float-left"><div class="price" id="jquery-total">￥<span class='totalprice'><?php echo round($total_money/100,2);?></span> <?php $cha = round($tt/100,2); ?><span id="jquery-last" class="jquery-last"><?php if(($cha) > "0"): ?>还差<span class='cha'><?php echo ($cha); ?></span>元起送<?php endif; ?></span></div></em>
		</span>
		<div class="result">
			<a href="javascript:void(0);" onClick="$('#cart-form').submit();">
				<button class="button bg-dot">
				  进入结算
				</button>
			</a>
		</div>
	</nav>
	</form>
	<iframe id="x-frame" name="x-frame" style="display:none;"></iframe>

<script>
	var since = "<?php echo ($detail['since_money']); ?>";
	function dec(o,product_id){
		var shop_id = "<?php echo ($shop_id); ?>", price = $(o).attr('rel'), cha = 0;
		window.ele.dec(shop_id,product_id);
		var count = window.ele.itemcount(product_id);
		var price = count*price;
		var totalprice = window.ele.totalprice();
			cha=(since-totalprice)/100;
			cha=cha<=0?0:cha;
		$(o).parent().prev().find('.price').text(price);
		$(o).parent().find("input[type='text']").val(count);
		$('.totalprice').text(totalprice);
		$('.cart-num').text(window.ele.count());
		var exp = since/100-totalprice;
		if( exp > 0){
			$('.jquery-last').html('还差<span class="cha">'+exp+'</span>元起送');
		}else{
			$('.jquery-last').text('');
		}
		
	}
	function inc(o,product_id){
	 var shop_id = "<?php echo ($shop_id); ?>", price = $(o).attr('rel');
		window.ele.inc(shop_id,product_id);
		var count = window.ele.itemcount(product_id);
		var price = count*price;
		var totalprice = window.ele.totalprice();
			cha=since-totalprice;
			cha=cha<=0?0:cha;
		$(o).parent().prev().find('.price').text(price);
		$(o).parent().find("input[type='text']").val(count);
		$('.totalprice').text(totalprice);
		$('.cart-num').text(window.ele.count());
		
		var exp = since/100-totalprice;
		if( exp > 0){
			$('.cha').text(exp);
		}else{
			$('.jquery-last').text('');
		}
		
	 }
	function removeby(pid){
	   if(window.ele.removeby(pid)){
			window.location.reload();
		}else{
			alert('删除商品失败！');
		}
	}
</script>
</body>
</html>