<?php if (!defined('THINK_PATH')) exit(); $mobile_title = $detail['title'].'团购'; ?>
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
<script src="/static/default/wap/other/roll.js"></script>
	<header class="top-fixed bg-yellow bg-inverse">
		<div class="top-back">
			<a class="top-addr" href="<?php echo U('tuan/index');?>"><i class="icon-angle-left"></i></a>
		</div>
		<div class="top-title">
			团购详情
		</div>
		<div class="top-search" style="display:none;">
			<form method="post" action="<?php echo U('tuan/index');?>">
				<input name="keyword" placeholder="输入团购的关键字"  />
				<button type="submit" class="icon-search"></button> 
			</form>
		</div>
		<div class="top-signed">
			<a id="search-btn" href="javascript:void(0);"><i class="icon-search"></i></a>
		</div>
	</header> 

    

    <script type="text/javascript">

	$(function(){

		$("#search-btn").click(function(){

			if($(".top-search").css("display")=='block'){

				$(".top-search").hide();

				$(".top-title").show(200);

			}

			else{

				$(".top-search").show();

				$(".top-title").hide(200);

			}

		});

		$("#search-bar li").each(function(e){

			$(this).click(function(){

				if($(this).hasClass("on")){

					$(this).parent().find("li").removeClass("on");

					$(this).removeClass("on");

					$(".serch-bar-mask").hide();

				}

				else{

					$(this).parent().find("li").removeClass("on");

					$(this).addClass("on");

					$(".serch-bar-mask").show();

				}

				$(".serch-bar-mask .serch-bar-mask-list").each(function(i){

					

					if(e==i){

						$(this).parent().find(".serch-bar-mask-list").hide();

						$(this).show();

					}

					else{

						$(this).hide();

					}

					$(this).find("li").click(function(){

						$(this).parent().find("li").removeClass("on");

						$(this).addClass("on");

					});

				});

			});

		});

	});

	</script>	 

	

    <div class="tuan-detail">

    <div class="line banner">	

    

        <div id="focus" class="focus">

            <div class="hd"><ul></ul></div>

            <div class="bd">

                <ul>

                    <li><a href="<?php echo U('tuan/pic',array('tuan_id'=>$detail['tuan_id']));?>"><img src="__ROOT__/attachs/<?php echo ($detail["photo"]); ?>" /></a></li>

                    <?php if(is_array($thumb)): foreach($thumb as $key=>$item): ?><li><a href="<?php echo U('tuan/pic',array('tuan_id'=>$detail['tuan_id']));?>"><img src="__ROOT__/attachs/<?php echo ($item); ?>" /></a></li><?php endforeach; endif; ?>

                </ul>

            </div>

        </div>

    		<div class="title">

				<h1><?php echo bao_Msubstr($detail['title'],0,48,false);?>  </h1>

				<p><?php echo bao_Msubstr($detail['intro'],0,88,false);?></p>

			</div>

		</div>

</div>            

            

  

	<script type="text/javascript">

		TouchSlide({ 

			slideCell:"#focus",

			titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层

			mainCell:".bd ul", 

			effect:"left", 

			autoPlay:true,//自动播放

			autoPage:true, //自动分页

			switchLoad:"_src" //切换加载，真实图片路径为"_src" 

		});

	</script>



	<!--小区广告结束-->

	

	<div class="tuan-detail">



        <?php if(!empty($detail['xiangou'])): ?><div class="line info">

			<div class="x12">

                <h4 class="se">每天限购：<?php echo ($detail["xiangou"]); ?> 份，剩余：<?php echo ($detail["num"]); ?> 份。</h4>

			</div> 

		</div><?php endif; ?>

		<div class="line info">

			<div class="x6">

				<span class="txt-border txt-little radius-circle border-green"><div class="txt radius-circle bg-green">退</div></span>

				<span class="text-green">支持随时退款</span>

			</div>

			<div class="x6">

				<span class="txt-border txt-little radius-circle border-gray"><div class="txt radius-circle bg-gray"><i class="icon-user"></i></div></span>

				<span class="text-gray">已售 <?php echo ($detail["sold_num"]); ?> 份</span>

			</div>

            

            <!--小灰灰增加开始-->

            <div class="x6">

            <?php if($detail['freebook'] == 1): ?><span class="txt-border txt-little radius-circle border-green"><div class="txt radius-circle bg-green">预</div></span>

			<span class="text-green">免预约</span>

            <?php else: ?>

			<span class="txt-border txt-little radius-circle border-green"><div class="txt radius-circle bg-green">预</div></span>

			<span class="text-green">需要预约哦</span><?php endif; ?>

			</div>

            <div class="x6">

				<span class="txt-border txt-little radius-circle border-gray"><div class="txt radius-circle bg-gray">距</div></span>

				<span class="text-gray"><?php echo ($detail["d"]); ?></span>

			</div>

           <!--小灰灰增加结束-->

			<?php if($detail['use_integral'] > 0): ?><div class="x12 margin-top">

				<span class="txt-border txt-little radius-circle border-dot"><div class="txt radius-circle bg-dot"><i class="icon-database"></i></div></span>

				<span class="text-dot">该抢购可以使用<?php echo ($detail["use_integral"]); ?>积分</span>

			</div><?php endif; ?>

		</div>

		<hr />

		<div class="line status">

			<div class="x6">

				<span class="ui-starbar"><span style="width:<?php echo round($score*10,2);?>%"></span></span>

			</div>

			<div class="x6">

				<span class="float-right margin-small-top"><a href="<?php echo U('tuan/dianping',array('tuan_id'=>$detail['tuan_id']));?>"><?php echo ($pingnum); ?>人评价了该抢购 </a><i class="icon-angle-right"></i></span>

			</div>

		</div>

		<hr />

		<div class="line shop">

			<div class="x9 border-right">

				<h2> <a href="<?php echo U('shop/detail',array('shop_id'=>$detail['shop_id']));?>"><?php echo ($shop["shop_name"]); ?> </a>

                <?php if($shop['is_renzheng'] == 1): ?><a style="font-size:12px; background:#F00; padding:0 3px; color:#fff;" href="<?php echo U('shop/detail',array('shop_id'=>$detail['shop_id']));?>">已认证 </a><?php endif; ?>

                </h2>

				<p><?php echo ($shop["addr"]); ?> &nbsp;<a  style="color:#F00; font-size:12px "href="<?php echo U('shop/gps',array('shop_id'=>$detail['shop_id']));?>"> (导航)</a></p>

			</div>

			<div class="x3">

				<a class="tel" href="tel:<?php echo ($shop["tel"]); ?>"><i class="icon-phone text-main"></i></a>

			</div>

		</div>

		<hr />

		<div class="blank-10 bg"></div>

		<hr />

		<div class="line status">

			<div class="x5">

				<span><a >抢购须知 </a></span>

			</div>

			<div class="x7">

				<span class="float-right"> <a href="<?php echo U('tuan/tuwen',array('tuan_id'=>$detail['tuan_id']));?>">更多图文详情 </a><i class="icon-angle-right"></i></span>

			</div>

		</div>

        <hr />

        <div class="blank-10"></div>

        <div class="container">

        <?php echo ($tuandetails["instructions"]); ?>

        </div>

        <hr />



  <div class="blank-10 bg"></div>   

  <hr />

         <div class="line-title">

		<h5>本店其他抢购</h5>

	    </div>

    

        <div class="main-tuan">

        <?php if(is_array($tuans)): $index = 0; $__LIST__ = $tuans;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($index % 2 );++$index;?><ul id="tuan-list">   

        <li class="x12">

		<a class="line" href="<?php echo U('tuan/detail',array('tuan_id'=>$item['tuan_id']));?>">

			<div class="container">

				<img class="x4" src="__ROOT__/attachs/<?php echo (($item["photo"])?($item["photo"]):'default.jpg'); ?>">	

				<div class="des x8">

					<h5><?php echo bao_msubstr($item['title'],0,18);?></h5>

					<p class="intro">

						<?php echo bao_msubstr($item['intro'],0,28);?></p>

					<p class="info">

						<span>￥ <em><?php echo round($item['tuan_price']/100,2);?></em></span> <del>￥<?php echo round($item['price']/100,2);?></del>

						<span class="text-little float-right badge bg-gray margin-small-top">已售：<?php echo ($item["sold_num"]); ?></span>

					</p>

				</div>

			</div>

		</a>

	</li><?php endforeach; endif; else: echo "" ;endif; ?>

    </ul>

	</div>

   </div>

</div>



<div class="blank-10 bg"></div>





<section class="buy-btn-wrap" id="j-buy-segment">

    <div class="buy-segment">

            <span class="old-current-price">

            	<em class="price-value"><?php echo ($detail["tuan_price"]); ?></em>

            </span>

            <span class="original-price">

            	<del><?php echo ($detail["price"]); ?></del>

            </span>

        <!--判断开始-->

        

                        

                        

                        

        <?php if($detail['bg_date'] > $today): ?><div class="buy-wrapper">

            <div class="privilege-btn">

                <a href="<?php echo U('tuan/buy',array('tuan_id'=>$detail['tuan_id']));?>" class="buy-btn" data-role="buy-btn" >

                    <span class="text">即将开始</span>

                </a>

            </div>

        </div> 

        <?php else: ?>

        <?php if($detail["num"] < 1 ): ?><div class="buy-wrapper">

            <div class="privilege-btn">

                <a href="<?php echo U('tuan/buy',array('tuan_id'=>$detail['tuan_id']));?>" class="buy-btn" data-role="buy-btn" >

                    <span class="text">卖光了</span>

                </a>

            </div>

        </div>

        <?php else: ?>

        <div class="buy-wrapper">

            <div class="privilege-btn">

                <a href="<?php echo U('tuan/buy',array('tuan_id'=>$detail['tuan_id']));?>" class="buy-btn" data-role="buy-btn" >

                    <span class="text">立即抢购</span>

                </a>

            </div>

        </div><?php endif; endif; ?>           

    </div>

</section>
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