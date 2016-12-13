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
<!--左侧可滑动特效-->
<script src="/static/default/wap/js/diyScroll.js"></script>
<script src="/static/default/wap/js/jquery.easing.min.js"></script>
<script src="/static/default/wap/js/function.js"></script>

	<header class="top-fixed bg-yellow bg-inverse">
		<div class="top-back">
			<a class="top-addr" href="<?php echo U('mart/index');?>"><i class="icon-angle-left"></i></a>
		</div>
		<div class="top-title">
			<?php echo ($detail["weidian_name"]); ?>
		</div>
		<div class="top-share">
			<a href="javascript:void(0);" id="share-btn"><i class="icon-share"></i></a>
		</div>
	</header>
	<div id="share-box" class="share-box">
		<div class="dialog-mask"></div>
			<ul class="line">
				<li class="-mob-share-weibo x3"><img src="/static/default/wap/image/share/share-weibo.png" /><p>新浪微博</p></li>
				<li class="-mob-share-tencentweibo x3"><img src="/static/default/wap/image/share/share-twb.png" /><p>腾讯微博</p></li>
				<li class="-mob-share-qzone x3"><img src="/static/default/wap/image/share/share-qzone.png" /><p>QQ空间</p></li>				
				<li class="-mob-share-qq x3"><img src="/static/default/wap/image/share/share-py.png" /><p>QQ好友</p></li>
				<li class="-mob-share-weixin x3"><img src="/static/default/wap/image/share/share-weixin.png" /><p>微信</p></li>
				<li class="-mob-share-renren x3"><img src="/static/default/wap/image/share/share-renren.png" /><p>人人网</p></li>
				<li class="-mob-share-kaixin x3"><img src="/static/default/wap/image/share/share-kaixin.png" /><p>开心网</p></li>
				<li id="mui-card-close" class="mui-card-close x3"><img src="/static/default/wap/image/share/share-close.png" /><p>关闭</p></li>
			</ul>
		<script id="-mob-share" src="http://f1.webshare.mob.com/code/mob-share.js?appkey=890ab8bbdb3c"></script>
	</div>
	<script>
		$(document).ready(function () {
			$("#share-box").hide();
			$("#share-btn").click(function () {
				$("#share-box").toggle();
				$('html,body').animate({scrollTop:0}, 'slow');
			});
			$("#mui-card-close").click(function () {
				$("#share-box").hide();
			});
		});
	</script>
    
<!-- 筛选TAB -->
<ul id="shangjia_tab">
        <li style="width: 33.3333333333%;"><a href="<?php echo U('mart/lists',array('id'=>$detail['id']));?>" class="on">商品</a></li>
        <li style="width: 33.3333333333%;"><a href="<?php echo U('mart/shopdetail',array('id'=>$detail['id']));?>">详情</a></li>
        <li style="width: 33.3333333333%;"><a href="<?php echo U('mart/dianping',array('id'=>$detail['id']));?>">评价</a></li>
</ul>

    
<script>
    $(function () {
        if ($('#shangjia_tab').length > 0)/*判断是否存在这个html代码*/
        {
            $('#shangjia_tab li').width(100 / $('#shangjia_tab li').length + '%');
            $('.page-center-box').css('top', '0.9rem');
        }//头部切换tab结束
        if ($('.elePrompt').length > 0 && $('#shangjia_tab').length > 0)/*判断是否存在这个html代码*/
        {
            $('#shangjia_tab').css('top', '0.9rem');
            $('.page-center-box').css('top', '1.3rem');
        } else if ($('.elePrompt').length > 0 || $('#shangjia_tab').length > 0) {
            $('.page-center-box').css('top', '6.0rem');
        }//头部提示结束
        $(".frame-set-left ul li").click(function(){
            $(".frame-set-left ul li").removeClass('active');
            $(this).addClass('active');
            var cate = $(this).attr('rel');
            if(cate == 'all'){
                $('.list-box').show();
            }else{
                $('.list-box').hide();
                $('.'+ cate).show();
            }
        }); 
    });
</script>

   
   
   <div id="ele" class="page-center-box mt10">
    <div class="frame-set-left">
        <ul style="margin-top:1.2rem;">
            <li class="active" rel="all"><a href="javascript:void(0);">全部分类</a></li>
            <?php if(is_array($autocates)): foreach($autocates as $key=>$item): ?><li rel="cate_<?php echo ($item["cate_id"]); ?>"><a href="javascript:void(0);"><?php echo ($item["cate_name"]); ?></a></li><?php endforeach; endif; ?>
        </ul>
    </div>
    <div class="frame-set-right">
        <div id="scroll">
            <div class="list-have-pic">
                <div class="eleList_box">
                    <?php if(is_array($list)): foreach($list as $key=>$var): ?><div class="list-box cate_<?php echo ($var["shopcate_id"]); ?>">
                        <?php $save = $var['price'] - $var['mall_price']; ?>
                            <div class="list-img">
                                <img src="__ROOT__/attachs/<?php echo ($var["photo"]); ?>">
                            </div>
                            
                            <div class="list-content">
                                <p class="overflow_clear" onclick="location='<?php echo U('mall/detail',array('goods_id'=>$var['goods_id']));?>'"><?php echo ($var["title"]); ?></p>
                                <p class="overflow_clear">下单立减<?php echo round($var['mobile_fan']/100,2);?>元</p>
                                <p class="price fontcl1"><?php echo round($var['mall_price']/100,2);?>元<del><?php echo round($var['price']/100,2);?>元</del></p>
                                <div class="num-input">
                                    <div class="btn" val="<?php echo round($var['mall_price']/100,2);?>" gid="<?php echo ($var["goods_id"]); ?>" onclick="dec(this);">-</div>
                                    <div class="input"><input type="text" readonly="readonly" class="ordernum" value="<?php echo (($var["cart_num"])?($var["cart_num"]):'0'); ?>" /></div>
                                    <div class="btn active jq_addcart" val="<?php echo round($var['mall_price']/100,2);?>" gid="<?php echo ($var["goods_id"]); ?>" onclick="addcart(this);" >+</div>
                                </div>
                            </div>
                        </div><?php endforeach; endif; ?>
                </div>
                
            </div>                
        </div>
    </div>
</div>
	
	
<footer class="footer-cart eleFooter-cart">
    <div class="cart">
        <a href="<?php echo U('mart/cart',array('id'=>$detail['id']));?>"><div class="cart-num" id="num"></div></a>
    </div>
    <div class="price">￥<span id="total_price"></span></div>
    <div class="btn"><a href="<?php echo U('mart/cart',array('id'=>$detail['id']));?>" style="color:#FFFFFF;">确认下单</a></div>
</footer>
    
    
 <!--JS 购物车-->
<script type="text/javascript">
    function addcart(o) {
        var data = {}, shop_id = "<?php echo ($detail['shop_id']); ?>";
        data['goods_id'] = $(o).attr('gid');
        data['price'] = $(o).attr('val');
        var v = $(o).parent().find(".ordernum").val();
        if(v < 99){
            v++;
            $(o).parent().find(".ordernum").val(v);
        }
        window.mall.addcart(shop_id, data);
        $("#num").text(window.mall.count(shop_id));
        $("#total_price").html(window.mall.totalprice(shop_id));
    }
    
    function dec(e) {
        var goods_id = $(e).attr('gid'), shop_id = "<?php echo ($detail['shop_id']); ?>";
        window.mall.dec(shop_id, goods_id);
        var v = $(e).parent().find(".ordernum").val();
        if(v > 0){
            v--;
            $(e).parent().find(".ordernum").val(v);
        }
        $("#num").text(window.mall.count(shop_id));
        $("#total_price").html(window.mall.totalprice(shop_id));
    }
//初始化购物城数据
    ~function () {
        var count = window.mall.count("<?php echo ($detail['shop_id']); ?>");
        var totalprice = window.mall.totalprice("<?php echo ($detail['shop_id']); ?>");
        $("#num").text(count);
        $("#total_price").html(totalprice);
    }();
	
	//左侧可滑动特效
	$(".frame-set-left:eq(0)").Frame({type:[0,0],background:"#efefef",color:"#999999",topfunc:"history.go(0)",botfunc:"",id:"left_Scroll",ScrollWidth:1});
	$(function(){
		if(PhoneType()=='Android'){
			setTimeout(function(){$(".frame-set-left:eq(0) .left_Scroll_to_top").css({marginTop:-50});},100);
		}
	});
	
	
	/*
	$(".frame-set-right:eq(0)").Frame({type:[0,0],background:"#efefef",color:"#999999",topfunc:"history.go(0)",botfunc:"",id:"left_Scroll",ScrollWidth:1});
	$(function(){
		if(PhoneType()=='Android'){
			setTimeout(function(){$(".frame-set-right:eq(0) .left_Scroll_to_top").css({marginTop:-50});},100);
		}
	});*/
	
	
</script>
	</body>
</div>