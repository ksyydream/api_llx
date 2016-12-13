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
<script src="/static/default/wap/js/elecart.js"></script>  
<script src="/static/default/wap/js/dialog.js"></script>
	<header class="top-fixed bg-yellow bg-inverse">
		<div class="top-back">
			<a class="top-addr" href="<?php echo U('index/index');?>"><i class="icon-angle-left"></i></a>
		</div>
		<div class="top-title">
			微店购物车
		</div>
	</header>
<style>
.list-box a {background-color: transparent; height: auto;padding:0px 5px 0px 0px;}
.list-have-pic .num-input input{ border:none; background:none;}
body {background: #fafafa;}
</style>
<form method="post" id="bao_buy_form"  action="<?php echo U('mart/order',array('t'=>$nowtime));?>">
        <input id="shop_id" type="hidden" name="shop_ids" value=""/><input id="goods_id" type="hidden" name="goods_ids" value=""/>
        <div id="life" class="page-center-box">
            <div id="scroll">
                <!-- 列表 -->
                <div class="list-have-pic list-have-pic-btn">
                    <?php if(is_array($cart_goods)): foreach($cart_goods as $key=>$item): ?><div class="list-box list-box-integral">
                            <div class="list-img">
                                <img src="__ROOT__/attachs/<?php echo ($item["photo"]); ?>" />
                            </div>
                            <div class="list-content">
                                <p class="h15"><a target="_blank" href="<?php echo U('mart/detail',array('goods_id'=>$item['goods_id']));?>"><?php echo ($item["title"]); ?></a></p>
                                <p class="c_h"><span class="mr20">单价：￥<?php echo round($item['mall_price']/100,2);?></span> 合计<span class="price">￥<span id="jq_total_<?php echo ($item["goods_id"]); ?>"><?php echo round($item['total_price']/100,2);?></span></span></p>
                                <div class="num-input">
                                    <div class="btn jq_jian" val="<?php echo round($item['mall_price']/100,2);?>" gid="<?php echo ($item["goods_id"]); ?>" onClick="dec(this);">-</div>
                                    <div class="input">
                                        <input data-role="none" type="text" value="<?php echo ($item["cart_num"]); ?>" readonly name="num[<?php echo ($item['goods_id']); ?>]" class="ordernum" />
                                    </div>
                                    <div class="btn active jq_jia" val="<?php echo round($item['mall_price']/100,2);?>" gid="<?php echo ($item["goods_id"]); ?>" onClick="addcart(this);">+</div>
                                </div>
                            </div>
                        </div><?php endforeach; endif; ?>

                </div>
            </div>
        </div>
        <footer class="footer-cart">
            <a style="color: #fff;" href="<?php echo U('mart/cart',array('id'=>$detail['id']));?>"><div class="cart">
                    <div class="cart-num" id="num"></div>
                </div></a>
            <div class="price">￥<span id="jq_total"></span></div>
            <div class="btn"><a href="javascript:void(0);" onClick="$('#bao_buy_form').submit();" style="color:#FFFFFF;">结算</a></div>
        </footer>
    </form>
</body>
<script type="text/javascript">
    function addcart(o) {
        var data = {}, shop_id = "<?php echo ($detail['shop_id']); ?>";
        data['goods_id'] = $(o).attr('gid');
        data['price'] = $(o).attr('val');
        var p = $(o).attr('val');
        var tp = $("#jq_total_"+$(o).attr('gid')).html();
        var v = $(o).parent().find(".ordernum").val();
        if (v < 99) {
            v++;
            tp = parseInt(tp)+parseInt(p);
            $("#jq_total_"+$(o).attr('gid')).html(tp);
            $(o).parent().find(".ordernum").val(v);
        }
        window.mall.addcart(shop_id, data);
        $("#num").text(window.mall.count(shop_id));
        $("#jq_total").html(window.mall.totalprice(shop_id));
    }

    function dec(e) {
        var goods_id = $(e).attr('gid'), shop_id = "<?php echo ($detail['shop_id']); ?>";
        window.mall.dec(shop_id, goods_id);
        var p = $(e).attr('val');
        var tp = $("#jq_total_"+$(e).attr('gid')).html();
        var v = $(e).parent().find(".ordernum").val();
        if (v > 0) {
            v--;
            tp = parseInt(tp)-parseInt(p);
            $("#jq_total_"+$(e).attr('gid')).html(tp);
            $(e).parent().find(".ordernum").val(v);
        }
        $("#num").text(window.mall.count(shop_id));
        $("#jq_total").html(window.mall.totalprice(shop_id));
    }
    //初始化购物城数据
    ~function () {
        var count = window.mall.count("<?php echo ($detail['shop_id']); ?>");
        var totalprice = window.mall.totalprice("<?php echo ($detail['shop_id']); ?>");
        $("#num").text(count);
        $("#jq_total").html(totalprice);
    }();

</script>
</body>
</html>