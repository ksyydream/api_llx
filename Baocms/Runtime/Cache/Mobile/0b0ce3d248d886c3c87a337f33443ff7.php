<?php if (!defined('THINK_PATH')) exit(); $mobile_title = $detail['shop_name']; ?>
<!DOCTYPE html>
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
<link href="/static/default/wap/css/main.css" rel="stylesheet">

<!--左侧可滑动特效-->
<script src="/static/default/wap/js/diyScroll.js"></script>
<script src="/static/default/wap/js/jquery.easing.min.js"></script>
<script src="/static/default/wap/js/function.js"></script>


	<header class="top-fixed bg-yellow bg-inverse">
		<div class="top-back">
			<a class="top-addr" href="<?php echo U('ele/index');?>"><i class="icon-angle-left"></i></a>
		</div>
		<div class="top-title">
			<?php echo ($detail["shop_name"]); ?>
		</div>
	</header>

    
<script>
    $(function () {
        if ($('#shangjia_tab').length > 0)/*判断是否存在这个html代码*/
        {
            $('#shangjia_tab li').width(100 / $('#shangjia_tab li').length + '%');
            $('.page-center-box').css('top', '0.9rem');
        }//头部切换tab结束
        if ($('.elePrompt').length > 0 && $('#shangjia_tab').length > 0)/*判断是否存在这个html代码*/
        {
            $('#shangjia_tab').css('top', '5.0rem');
            $('.page-center-box').css('top', '8.0rem');
        } else if ($('.elePrompt').length > 0 || $('#shangjia_tab').length > 0) {
            $('.page-center-box').css('top', '6.0rem');
        }//头部提示结束
        $(".frame-set-left ul li").click(function () {
            $(".frame-set-left ul li").removeClass('active');
            $(this).addClass('active');
            var cate = $(this).attr('rel');
            if (cate == 'all') {
                $('.list-box').show();
            } else {
                $('.list-box').hide();
                $('.' + cate).show();
            }
        });
    });
</script>

<style>
.menu_detail img {max-height: 230px;}
.tag1 {font-size: 75%;padding: 0.1em 0.5em 0.2em;color: #fff;}
.tag1 em {padding: 0.1em 0.5em 0.2em;color: #fff;}
.list-have-pic .list-content em {padding: 0 .22rem;}
</style>

<!--头部切换开始-->
<!-- 筛选TAB -->
<ul id="shangjia_tab">
        <li style="width: 33.3333333333%;"><a href="<?php echo U('ele/shop',array('shop_id'=>$detail['shop_id']));?>" class="on">商品</a></li>
        <li style="width: 33.3333333333%;"><a href="<?php echo U('ele/detail',array('shop_id'=>$detail['shop_id']));?>">详情</a></li>
        <li style="width: 33.3333333333%;"><a href="<?php echo U('ele/dianping',array('shop_id'=>$detail['shop_id']));?>">评价</a></li>
</ul>

<!--头部切换结束-->
<div id="ele" class="page-center-box mt10">
    <div class="frame-set-left">
        <ul style="margin-top:0.9rem;">
        <?php $ele_count = D('Eleproduct') ->where(array('shop_id'=>$detail['shop_id']))->count(); ?>
            <li class="active" rel="all" style="border-top:0.1rem solid #dedede;"><a href="javascript:void(0);">全部分类(<?php echo ($ele_count); ?>)</a></li>
            <?php if(is_array($cates)): foreach($cates as $key=>$item): $count = D('Eleproduct') ->where(array('shop_id'=>$detail['shop_id'],'cate_id'=>$item['cate_id']))->count(); ?>
                <li rel="cate_<?php echo ($item["cate_id"]); ?>"><a href="javascript:void(0);"><?php echo ($item["cate_name"]); ?>(<?php echo ($count); ?>)</a></li><?php endforeach; endif; ?>
        </ul>
    </div>
    <div class="frame-set-right">
        <div id="scroll">
            <div class="list-have-pic">
                <div class="eleList_box">
                    <?php if(is_array($list)): foreach($list as $key=>$var): ?><div class="list-box cate_<?php echo ($var["cate_id"]); ?>">
                            <div class="list-img ac" onclick="liclick(this);" href="javascript:;"><!--增加触发事件-->
                                <img  url="__ROOT__/attachs/<?php echo ($var["photo"]); ?>" src="__ROOT__/attachs/<?php echo ($var["photo"]); ?>">
                            </div>
                            <div class="list-content">
                                <p class="overflow_clear"><h5><?php echo ($var["product_name"]); ?></h5></p>
                                <h1 style="display:none" class="salenum"><?php echo bao_msubstr($var['desc'],0,56,false);?>...</h1>
                                <p class="overflow_clear">
                                <?php if($var['is_new'] == 1): ?><em class="tag1 bg-yellow">新</em><?php endif; ?>
                                <?php if($var['is_hot'] == 1): ?><em class="tag1 bg-dot">热</em><?php endif; ?>
                                <?php if($var['is_tuijian'] == 1): ?><em class="tag1 bg-blue">荐</em><?php endif; ?>
                                </p>
                                <p class="price fontcl1"><span class="unit_price">&yen;<?php echo round($var['price']/100,2);?></span>元</p>
                                <div class="num-input">
                                    <div class="btn jq_jian" val="<?php echo round($var['price']/100,2);?>" did="<?php echo ($var["product_id"]); ?>" onclick="dec(this);">-</div>
                                    <div class="input"><input type="text" class="ordernum" readonly="readonly" value="<?php echo ($var["cart_num"]); ?>" /></div>
                                    <div class="btn active jq_addcart" val="<?php echo round($var['price']/100,2);?>" did="<?php echo ($var["product_id"]); ?>" onclick="addcart(this);" >+</div>
                                </div>
                            </div>
                        </div><?php endforeach; endif; ?>
                </div>
              <div class="blank-40"></div>
            </div>                
        </div>
    </div>
</div>
<footer class="footer-cart eleFooter-cart">
    <div class="cart">
        <a id="cart_1" href="javascript:void(0);"><div class="cart-num" id="num"></div></a>
    </div>
    <div class="price">￥<span id="total_price"></span><p>(<?php echo round($detail['since_money']/100,2);?>元起送,<?php if(empty($detail['logistics'])): ?>免费配送<?php else: ?>配送费:￥<?php echo round($detail['logistics']/100,2); endif; ?>)</p></div>
    <div id="cart_2" class="disable"><a href="javascript:void(0);" style="color:#FFFFFF;">确认下单</a></div>
</footer>
</body>


   <!--弹出 start-->
   <div id="menuDetail" class="menu_detail">
    <img style="display: none;">
    <div class="nopic"></div>
    <a id="detailBtn" class="comm_btn jq_addcart" onclick="addcart(this);"  did="<?php echo ($var["product_id"]); ?>" href="javascript:void(0);">来一份</a>
        <dl><dt>价格：</dt><dd class="highlight"><span class="price"></span></dd></dl>
        <dl style=" margin-top:15px;"><dt>介绍：</dt><dd class="info"></dd></dl>
    </div>
   <!--end-->
<script type="text/javascript">
//添加弹出
	var _wraper = $('#menuDetail');
	var dialogTarget;
	function liclick(l){
		var _this = $(l),
			F = function(str){return _this.parent().find(str);},
			title = F('h5').text(),
			imgUrl = F('img').attr('url'),
			val = _this.parent().find('.jq_jian').attr('val'),
			did = _this.parent().find('.jq_jian').attr('did'),
			price = F('.unit_price').text(),
			sales = F('.sales strong').attr('class'),
			saleNum = F('.sale_num').text(),
			info = F('h1').text(),
			saleDesc = F('.salenum').html(),
			unit=F('.theunit').text(),
			_detailImg = _wraper.find('img');
			_wraper.find('.price').text(price).end()
			.find('.sales strong').attr('class', sales).end()
			//.find('.sale_desc').html(saleNum).end()
			.find('.info').text(info);
		_wraper.parents('.dialog').find('.dialog_tt').text(title);
			$('#detailBtn').removeClass('disabled').text('来一份');
			$('#detailBtn').attr('val',val);
			$('#detailBtn').attr('did',did);
		if(imgUrl){
			_detailImg.attr('src', imgUrl).show().next().hide();
		}else{
			_detailImg.hide().next().show();
		}

		dialogTarget = _this;
		_wraper.dialog({title: title, closeBtn: true});
		}

		//添加弹出的商品到购物车
		function addcart(o){
			var data = {}, shop_id = "<?php echo ($_GET['shop_id']); ?>";
			data['product_id'] = $(o).attr('did');
			data['price']      = $(o).attr('val');
			
			var v = $(o).parent().find(".ordernum").val();
			if(v < 99){
				v++;
				$(o).parent().find(".ordernum").val(v);
			}
			window.ele.addcart(shop_id,data);
			$("#num").text(window.ele.count());
		}
</script>

<!--JS 购物车-->
<script type="text/javascript">
	
    $(document).ready(function () {
        var price = window.ele.totalprice("<?php echo ($detail['shop_id']); ?>");
        var since_money = "<?php echo round($detail['since_money']/100,2);?>";
        if(price > since_money){
            $('#cart_1').attr('href', "<?php echo U('ele/cart');?>");
            $('#cart_2').find('a').attr('href', "<?php echo U('ele/cart');?>");
            $('#cart_2').removeClass('disable');
            $('#cart_2').addClass('btn');
        }else{
            $('#cart_1').attr('href', "javascript:void(0);");
            $('#cart_2').find('a').attr('href', "javascript:void(0);");
            $('#cart_2').addClass('disable');
            $('#cart_2').removeClass('btn');
        }
        
    })



    function addcart(o) {
        var data = {}, shop_id = "<?php echo ($detail['shop_id']); ?>";
        data['product_id'] = $(o).attr('did');
        data['price'] = $(o).attr('val');
        var v = $(o).parent().find(".ordernum").val();
        if(v < 99){
            v++;
            $(o).parent().find(".ordernum").val(v);
        }
        window.ele.addcart(shop_id, data);
        $("#num").text(window.ele.count("<?php echo ($detail['shop_id']); ?>"));
        $("#total_price").html(window.ele.totalprice("<?php echo ($detail['shop_id']); ?>"));
        var since_money = "<?php echo round($detail['since_money']/100,2);?>";
        if (window.ele.totalprice("<?php echo ($detail['shop_id']); ?>") < since_money) {
            $('#cart_2').addClass('disable');
        } else {
            $('#cart_1').attr('href', "<?php echo U('ele/cart');?>");
            $('#cart_2').find('a').attr('href', "<?php echo U('ele/cart');?>");
            $('#cart_2').removeClass('disable');
            $('#cart_2').addClass('btn');
        }
    }
    function dec(e) {
        var product_id = $(e).attr('did'), shop_id = "<?php echo ($detail['shop_id']); ?>";
        window.ele.dec(shop_id, product_id);
        var v = $(e).parent().find(".ordernum").val();
        if(v > 0){
            v--;
            $(e).parent().find(".ordernum").val(v);
        }
        $("#num").text(window.ele.count("<?php echo ($detail['shop_id']); ?>"));
        $("#total_price").html(window.ele.totalprice("<?php echo ($detail['shop_id']); ?>"));
        var since_money = "<?php echo round($detail['since_money']/100,2);?>";
        if (window.ele.totalprice("<?php echo ($detail['shop_id']); ?>") < since_money) {
            $('#cart_1').attr('href', "javascript:void(0);");
            $('#cart_2').find('a').attr('href', "javascript:void(0);");
            $('#cart_2').addClass('disable');
            $('#cart_2').removeClass('btn');
        } else {
            $('#cart_1').attr('href', "<?php echo U('ele/cart');?>");
            $('#cart_2').find('a').attr('href', "<?php echo U('ele/cart');?>");
            $('#cart_2').removeClass('disable');
            $('#cart_2').addClass('btn');
        }
    }

//初始化购物城数据
    ~function () {
        var count = window.ele.count("<?php echo ($detail['shop_id']); ?>");
        var totalprice = window.ele.totalprice("<?php echo ($detail['shop_id']); ?>");
        $("#num").text(count);
        $("#total_price").html(totalprice);
    }();
	
	//左侧可滑动特效

	$(".frame-set-left:eq(0)").Frame({type:[0,0],background:"#fff",color:"#999999",topfunc:"history.go(0)",botfunc:"",id:"left_Scroll",ScrollWidth:1});
	$(function(){
		if(PhoneType()=='Android'){
			setTimeout(function(){$(".frame-set-left:eq(0) .left_Scroll_to_top").css({marginTop:-50});},100);
		}
	});
</script>
</html>