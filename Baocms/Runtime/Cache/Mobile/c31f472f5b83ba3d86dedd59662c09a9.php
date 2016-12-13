<?php if (!defined('THINK_PATH')) exit(); $mobile_title = $detail['title']; ?>
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
<style>
.top-fixed { background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0))!important;position: absolute;border: none;}
</style>
<script src="/static/default/wap/other/roll.js"></script>
	<header class="top-fixed bg-yellow bg-inverse">
		<div class="top-back">
			<a class="top-addr inner-back" href="<?php echo U('mall/index');?>"></a>
		</div>
		<div class="top-title">
			商品详情
		</div>
		<div class="top-share">
			<a href="<?php echo U('mall/cart');?>" class="inner-cart" id="share-btn"></a>
		</div>
	</header>
   
    
<div class="tuan-detail">
<div class="line banner">	
	<div id="focus" class="focus">
		<div class="hd">
			<ul></ul>
		</div>
		<div class="bd">
			<ul>
          		<li><a href="javascript:void(0);"><img src="<?php echo config_img($detail['photo']);?>" /></a></li>
                <?php if(is_array($pics)): foreach($pics as $key=>$item): ?><li><a href="javascript:void(0);"><img src="<?php echo config_img($detail['photo']);?>" /></a></li><?php endforeach; endif; ?>
			</ul>
		</div>
	</div>
   </div>
</div>             
	<script type="text/javascript">
		TouchSlide({ 
			slideCell:"#focus",
			titCell:".hd ul", 
			mainCell:".bd ul", 
			effect:"left", 
			autoPlay:true,//自动播放
			autoPage:true, //自动分页
			switchLoad:"_src" 
		});
	</script>

<div class="item-detail">
			<div class="detail-row bb">
				<div class="item-price">
                   <h1><?php echo bao_msubstr($detail['title'],0,24);?></h1>
					<p class="price">&yen; <?php echo round($detail['mall_price']/100,2);?> 
                        <span class="pre-price-tips">
                            <span class="dt-icon"><?php echo round($detail['mall_price']/$detail['price']*10,1);?>折</span>
                                <?php if(!empty($detail['use_integral'])): ?><span class="dt-icon" style="background-color:#ff9204;">积分抵扣 &yen;<?php echo round($detail['use_integral']/100,2);?></span><?php endif; ?>
                                <?php if(!empty($detail['mobile_fan'])): ?><span class="dt-icon" style="background-color: #F00;">下单立减 &yen;<?php echo round($detail['mobile_fan']/100,2);?></span><?php endif; ?>
                        </span>
                    </p>  
                                    
                    <div class="x12 price-tip">
                        <span class="text-gray">原价：<del>&yen; <?php echo round($detail['price']/100,2);?></del></span>
                        <span class="text-gray text-small">月售：<?php echo ($detail['sold_num']); ?>笔</span>
                        <span class="text-gray text-small">库存：<?php echo ($detail['num']); ?> <?php echo ($detail['guige']); ?> </span>
                    </div>

				</div>
			</div>
            <?php if(!empty($is_vs)): ?><div class="detail-row bb">
				<div class="item-tips">
					<?php if(($detail["is_vs1"]) == "1"): ?><em><span class="text-green"><i class="check-circle"></i></span>认证商家</em><?php endif; ?>
                    <?php if(($detail["is_vs2"]) == "1"): ?><em><span class="text-green"><i class="check-circle"></i></span>正品保证</em><?php endif; ?>
                    <?php if(($detail["is_vs3"]) == "1"): ?><em><span class="text-green"><i class="check-circle"></i></span>假一赔十</em><?php endif; ?>
                    <?php if(($detail["is_vs4"]) == "1"): ?><em><span class="text-green"><i class="check-circle"></i></span>当日送达</em><?php endif; ?>
                    <?php if(($detail["is_vs6"]) == "1"): ?><em><span class="text-green"><i class="check-circle"></i></span>货到付款</em><?php endif; ?>
                    <?php if(($detail["is_vs5"]) == "1"): ?><em><span class="text-green"><i class="check-circle"></i></span>免运费</em><?php endif; ?>
				</div>
			</div><?php endif; ?>
            
		</div>
       </div>
		<div class="blank-10 bg"></div>
        
       <div class="tuan-detail2">
       <div class="line status">
			<div class="x6">
				<span class="ui-starbar"><span style="width:<?php echo round($score*10,2);?>%"></span></span>
			</div>
			<div class="x6">
				<span class="float-right"><a href="<?php echo U('mall/dianping',array('goods_id'=>$detail['goods_id']));?>"><?php echo ($pingnum); ?>人评价了该商品 </a><i class="icon-angle-right"></i></span>
			</div>
		</div> 
       </div> 
        
		
		<div class="blank-10 bg"></div>
		
        
        <div class="item-intro">
			<h2>购买须知</h2>
			<div class="intro-bd"><?php echo cleanhtml($detail['instructions']);?></div>
		</div>
        <div class="blank-10 bg"></div>
        
		<div class="item-intro">
			<h2>商品介绍</h2>
            <div id="focus" class="global_focus intro-bd">
             <?php echo ($detail["details"]); ?>   
            </div>
		</div>		
		
        <?php if(!empty($recom)): ?><!--如果看了又看不等于空-->
          <div class="blank-10 bg"></div>
            <div class="item-list item-intro" id="item-list">
                <h2>看了又看</h2>
                <ul>
                <?php if(is_array($recom)): $index = 0; $__LIST__ = $recom;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($index % 2 );++$index;?><li class="line">
                    <a href="<?php echo U('mall/detail',array('goods_id'=>$item['goods_id']));?>">
                    <div class="x3">
                        <img src="<?php echo config_img($item['photo']);?>" />
                    </div>
                    <div class="x9">
                        <h5><?php echo ($item["title"]); ?></h5>
                        <p class="desc"><?php echo bao_Msubstr($item[instructions],0,60);?></p>
                        <p class="info">
                            <span>&yen;<?php echo round($item['price']/100,2);?></span><del>&yen;<?php echo round($item['mall_price']/100,2);?></del>
                            <em>已售<?php echo ($item["sold_num"]); ?></em>
                    </div>
                    </a>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div><?php endif; ?>
        
        
        

   <script>
        $(document).ready(function () {
            $(".cartadd2").click(function(){
               var url = "<?php echo U('mall/cartadd2');?>";
               var goods_id = "<?php echo ($detail["goods_id"]); ?>" ;
               var shop_id = "<?php echo ($detail["shop_id"]); ?>";
               $.post(url,{goods_id:goods_id,shop_id:shop_id},function(data){
                   if(data.status == 'success'){
                       layer.msg(data.msg, function () {
                            setTimeout(function () {
                                window.location.reload(true);
                            }, 1000)
                        });
                   }else{
                       layer.msg(data.msg);
                   }
               },'json')
           })
        });
    </script>
<div data-spm="action" class="item-action">
    <div class="toggle-collect">
        <a data-spm="dstore" href="<?php echo U('mall/cart');?>">
        <span class="badge bg-red icon"><?php echo ($cartnum); ?></span>已购</a>
    </div>
    <div class="go-store">
        <a data-spm="dstore" href="<?php echo U('shop/detail',array('shop_id'=>$detail['shop_id']));?>">
        <span class="icon"></span>店铺</a>
    </div>
    <div id="bottom-cart-entrance" class="add-to-cart cartadd2">加入购物车</div>
     <?php if($detail['num'] <= 0): ?><div class="buy-now ">缺货</div>
     <?php else: ?>
     <div class="buy-now"><a href="<?php echo U('mall/buy',array('goods_id'=>$detail['goods_id']));?>">立即购买</a></div><?php endif; ?>
</div>


	
</body>
</html>
<script> var BAO_PUBLIC = '__PUBLIC__'; var BAO_ROOT = '__ROOT__'; var BAO_SURL = '<?php echo ($CONFIG['site']['host']); ?>__SELF__'</script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
<script>
$(function(){
	var newurl = BAO_SURL.replace(/\?\S+/,'');
	var stitle = "<?php echo ($config['title']); ?>"; 
	var surl = newurl+'?fuid=<?php echo getuid();?>';	
	var catchpic = $('img');
	var lcatchpic = "<?php echo ($CONFIG['site']['host']); ?>" + $('img').eq(0).attr("src");
	$('img').each(function(){
		if($(this).width() >= 60){
			lcatchpic = $(this).attr("src");
			if(lcatchpic.indexOf("http://") < 0){
				lcatchpic = "<?php echo ($CONFIG['site']['host']); ?>" + lcatchpic;
			}
			return false;
		};
	});
	
	var spic = "<?php echo ($CONFIG['site']['host']); ?>"+BAO_PUBLIC+'/img/logo.jpg';
	if(catchpic.length > 0){
		spic = lcatchpic;
		
	}
	console.log(lcatchpic);
	//alert(spic);
	wx.config({
	debug: false,
	appId: '<?php echo ($signPackage["appId"]); ?>',
    timestamp: '<?php echo ($signPackage["timestamp"]); ?>',
    nonceStr: '<?php echo ($signPackage["nonceStr"]); ?>',
    signature: '<?php echo ($signPackage["signature"]); ?>',
	jsApiList: [
	'checkJsApi',
	'onMenuShareTimeline',
	'onMenuShareAppMessage',
	'onMenuShareQQ',
	'onMenuShareWeibo',
	'onMenuShareQZone'
	]
	});
	wx.ready(function(){
		wx.onMenuShareTimeline({
			title: stitle, 
			link: surl, 
			imgUrl: spic,
			success: function () { 
				alert("分享成功!");
			},
			cancel: function () { 
				alert("分享失败!");
			}
		});
		wx.onMenuShareAppMessage({		
			title: stitle,
			desc: stitle, // 分享描述
			link: surl, 
			imgUrl: spic,
			type: '', // 分享类型,music、video或link，不填默认为link
			dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
			success: function () { 
				alert("分享成功!");
			},
			cancel: function () { 
				alert("分享失败!");
			}
		});
		wx.onMenuShareQQ({
			title: stitle,
			desc: stitle, // 分享描述
			link: surl, 
			imgUrl: spic,
			success: function () { 
			   alert("分享成功!");
			},
			cancel: function () { 
			   alert("分享失败!");
			}
		});
		wx.onMenuShareWeibo({
			title: stitle,
			desc: stitle, // 分享描述
			link: surl, 
			imgUrl: spic,
			success: function () { 
			  alert("分享成功!");
			},
			cancel: function () { 
				alert("分享失败!");
			}
		});	
		wx.onMenuShareQZone({
			title: stitle,
			desc: stitle, // 分享描述
			link: surl, 
			imgUrl: spic,
			success: function () { 
			   alert("分享成功!");
			},
			cancel: function () { 
				alert("分享失败!");
			}
		});	
	});
})	
</script>