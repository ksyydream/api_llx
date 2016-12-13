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
	<header class="top-fixed bg-yellow bg-inverse">
		<div class="top-back">
			<a class="top-addr" href="<?php echo U('mall/detail',array('goods_id'=>$back));?>"><i class="icon-angle-left"></i></a>
		</div>
		<div class="top-title">
			购物车
		</div>
	</header>
	
    <form method="post" id="bao_buy_form"  action="<?php echo U('mall/order',array('t'=>$nowtime));?>" target="x-frame">
 	<?php $total_money = 0; ?>
	<div id="life" class="page-center-box">
		<div id="scroll">
			<!-- 列表 -->
			<div class="list-have-pic list-have-pic-btn">
            	<?php if(is_array($cart_goods)): foreach($cart_goods as $key=>$item): ?><div class="list-box2 list-box-integral">
					<div class="list-img">
						<img src="<?php echo config_img($item['photo']);?>" />
					</div>
					<div class="list-content">
						<p class="h15 overflow_clear"><a  href="<?php echo U('mall/detail',array('goods_id'=>$item['goods_id']));?>"><?php echo ($item["title"]); ?></a></p>
						<p class="c_h"><span class="mr20">单价：￥<?php echo round($item['mall_price']/100,2);?></span> 合计：<span id="jq_total_<?php echo ($item["goods_id"]); ?>" class="price">￥<?php echo round($item['mall_price'] * $item['buy_num']/100,2);?></span></p>
						<div class="num-input changeNum2" rel="<?php echo ($item["product_id"]); ?>">
							<div class="btn jq_jian" data="<?php echo ($item["goods_id"]); ?>">-</div>
							<div class="input">
                            <input data-role="none" data="<?php echo ($item["goods_id"]); ?>"  type="text" value="<?php echo ($item["buy_num"]); ?>" rel="<?php echo round($item['mall_price']/100,2);?>" name="num[<?php echo ($item['goods_id']); ?>]" class="ordernum" /><strong></strong>
                            </div>
							<div class="btn active jq_jia" data="<?php echo ($item["goods_id"]); ?>">+</div>
						</div>
						<a href="<?php echo U('mall/cartdel2',array('goods_id'=>$item['goods_id'],'t'=>$nowtime));?>"><div class="icon-del"></div></a>
					</div>
				</div>
				
                <?php $total_money+= $item['mall_price'] * $item['buy_num']; endforeach; endif; ?>
                
                
        <script>
            function changetotal(obj){
                var money = obj.parent().find('.ordernum').attr('rel');
                var num = obj.parent().find('.ordernum').val();
                var total =  Math.round(money*num*100)/100;
                $("#jq_total_"+obj.attr('data')).html('￥'+total);
                changealltotal();
            }
            
            function changealltotal(){
     
                var total_price = 0;
				var num = 0;
                $(".ordernum").each(function(){
                    total_price += $(this).val() * $(this).attr('rel');
					num += parseInt($(this).val());
                });
                $("#jq_total").html('￥'+Math.round(total_price*100)/100);
				 $(".cart-num").html(num);
            }
             $(document).ready(function(e){
                 $(".jq_jian").click(function(){
                    var v = $(this).parent().find(".ordernum").val() ;
                    if(v>1){
                        v--;                       
                        $(this).parent().find(".ordernum").val(v);

                    }
                     
                     changetotal($(this));
                     
                 });
                 $(".jq_jia").click(function(){
                     var v = $(this).parent().find(".ordernum").val();
                    if(v<99){
                        v++;
                        $(".jq_jian").attr("style","border:1px solid #2fbdaa;");
                        $(this).parent().find(".ordernum").val(v);
                    }
                     changetotal($(this));
                 });
                 
                 $(".ordernum").change(function(){
                     if($(this).val()<1){
                         $(this).val('1');
                     }
                     if($(this).val()>99){
                         $(this).val('99');
                     }
                     changetotal($(this));
                 });
                 
             });
        </script>
                
                
                
			</div>
		</div>
	</div>
	<footer class="footer-cart">
		<div class="cart">
			<div class="cart-num"><?php echo ($cartnum); ?></div>
		</div>
		<div class="price" id="jq_total">￥<?php echo round($total_money/100,2); $cha = round($tt/100,2); ?><span id="jq_last" class="jq_last"><?php if(($cha) > "0"): ?>还差<?php echo ($cha); ?>元起送<?php endif; ?></span></div>
		<div class="btn"><a href="javascript:void(0);" onClick="$('#bao_buy_form').submit();" style="color:#FFFFFF;">结算</a></div>
	</footer>
</form>
<iframe id="x-frame" name="x-frame" style="display:none;">