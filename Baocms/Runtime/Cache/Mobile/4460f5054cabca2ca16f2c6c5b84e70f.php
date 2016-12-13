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
<!--<script src="/static/default/mobile/js/zepto.js"></script>
<script src="/static/default/mobile/js/frozen.js"></script>-->

<style>
ul{ padding-left:0px;}
li {list-style: none;}
.container { margin-top:3rem;}
.container2 {margin: 0 auto; }
.coupon-list .item {  padding: 5px 0px 0px 5px;}
.coupon-list .item .intro { height: initial;}
.panel-head { background-color: #fff;}
p, .p {margin-bottom: 0px; }
</style>
	<header class="top-fixed bg-yellow bg-inverse">
		<div class="top-back">
			<a class="top-addr" href="<?php echo U('shop/index');?>"><i class="icon-angle-left"></i></a>
		</div>
		<div class="top-title">
			<?php echo ($detail["shop_name"]); ?>
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
	
	

<ul id="shangjia_tab">
        <li style="width:16.66666667%;"><a href="<?php echo U('shop/detail',array('shop_id'=>$detail['shop_id']));?>" class="on">首页</a></li>
        <li style="width:16.66666667%;"><a href="<?php echo U('shop/tuan',array('shop_id'=>$detail['shop_id']));?>">团购</a></li>
        <li style="width:16.66666667%;"><a href="<?php echo U('shop/goods',array('shop_id'=>$detail['shop_id']));?>">信息</a></li>
        <li style="width:16.66666667%;"><a href="<?php echo U('shop/coupon',array('shop_id'=>$detail['shop_id']));?>">优惠</a></li>
        <li style="width:16.66666667%;"><a href="<?php echo U('shop/news',array('shop_id'=>$detail['shop_id']));?>">新闻</a></li>
        <li style="width:16.66666667%;"><a href="<?php echo U('shop/dianping',array('shop_id'=>$detail['shop_id']));?>">评价</a></li>
</ul>
      
 
 <script>
		var news = new fz.Scroll('.scroller-news', {
			scrollY: false,
			scrollX: true
		});
		news.scrollToElement("li:nth-child(1)", 120, true, true);
		
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
           



	<div class="container">
		<div class="line detail-base">
			<div class="x4">
				<div class="pic">
					<a href="<?php echo U('shop/pic',array('shop_id'=>$detail['shop_id']));?>">
                    
                    <img src="<?php echo config_img($detail['photo']);?>" /></a> 				<?php if(!empty($pic)): ?><span class="album"><?php echo ($pic); ?></span>
                    <?php else: endif; ?>
				</div>
			</div>
			<div class="x5">
				<h1><?php echo ($detail["shop_name"]); ?></h1>
				<p><span class="ui-starbar"><span style="width:<?php echo round($detail['score']*2,2);?>%"></span></span></p>
				<p>浏览量: <?php echo ($detail["view"]); ?> 次</p>
				<p class="text-small"><span class="text-yellow"><?php echo ($ex["business_time"]); ?> </span></p>
			</div>
			<div class="x3">
				<?php if(($detail["niu_date"]) > $today): ?><p class="text-center"><img src="/static/default/wap/image/shop/icon-cx.png" /></p><?php endif; ?>
				<div class="blank-10"></div>
				<p class="text-center"><a class="text-dot" href="#ping">商铺评价</a></p>
				<p class="text-small text-center">( <em class="text-yellow"><?php echo ($totalnum); ?></em>人评价 )</p>
                <?php if($detail['is_renzheng'] == 1): ?><p class="text-small text-center"><em class="text-yellow">该商家已认证</em></p><?php endif; ?>
                <?php if($detail['recognition'] == 0): ?><p class="text-small text-center"><em class="text-yellow"><a href="<?php echo U('shop/recognition',array('shop_id'=>$detail['shop_id']));?>">我要认领</a></em></p><?php endif; ?>
			</div>
		</div>
       </div>
       
       
		<div class="blank-10 bg"></div>
	<div class="container2">
		<div class="line detail-contact">
			<div class="x9">
				<p class="addr"><i class="icon icon-map-marker"></i> <?php echo ($detail["addr"]); ?> </p>
				<p class="margin-top"><i class="icon icon-phone"></i> 
                <?php if(!empty($detail['tel'])): ?><a class="text-large" href="tel:<?php echo ($detail["tel"]); ?>"><?php echo ($detail["tel"]); ?></a>
                <?php else: ?>
                <a class="text-large">暂无联系方式</a><!--该商家暂无联系方式--><?php endif; ?>
                </p>
			</div>
			<div class="x3">
				<a class="favor" href="<?php echo U('shop/favorites',array('shop_id'=>$detail['shop_id']));?>">
					<div class="txt radius-circle bg-green"><i class="icon-heart"></i></div>
					<p>关注该商家</p>
					<p class="text-small">粉丝<em class="text-yellow"><?php echo ($favnum); ?></em>人</p>
				</a>
			</div>
		</div>
		
        
        <?php $sb = D('ShopBranch');$rsb = $sb -> where('shop_id ='.$detail['shop_id']) -> count(); ?>
        <?php if(!empty($rsb)): ?><div class="list-link detail-link radius-none">
		    <a href="<?php echo U('shop/branch/',array('shop_id'=>$detail['shop_id']));?>">
				<span class="txt txt-little radius-little bg-yellow">店</span> 查看另外<?php echo ($rsb); ?>家分店
				<span class="float-right icon-angle-right"></span>
			</a>
           </div>
        <?php else: ?>
       <!--该商家无分店--><?php endif; ?>
       </div> 
        
        <div class="blank-10 bg"></div>
        
        
        <?php if(!empty($shopyouhui)): ?><div class="container2" style="margin:10px;">
				<div class="form-button"><a  href="<?php echo U('shop/breaks',array('shop_id'=>$detail['shop_id']));?>" class="button button-block button-big bg-dot text-center" type="submit">优惠买单</a></div>
			</div><?php endif; ?>    
            
        
      <div class="container2"> 
        <div class="list-link detail-link radius-none">
			<div class="line border-bottom">
				<div class="x6 border-right text-center">
					<a href="<?php echo U('shop/gps',array('shop_id'=>$detail['shop_id']));?>"><i class="icon icon-send"></i> 导航到这去</a>
				</div>
				<div class="x6 text-center">
					<a href="<?php echo U('shop/qrcode',array('shop_id'=>$detail['shop_id']));?>"><i class="icon icon-qrcode"></i> 二维码名片</a>
				</div>
			</div>
		    <?php if(!empty($tuans)): ?><a href="<?php echo U('tuan/index',array('shop_id'=>$detail['shop_id']));?>">
				   	<span class="txt txt-little radius-little bg-green">团</span> 去逛逛商家抢购
			    	<span class="float-right icon-angle-right"></span>
			    </a><?php endif; ?>		           
           
            <?php if(!empty($coupon)): ?><!--显示近期优惠券数据$detail['shop_id-->			
                <a href="<?php echo U('mobile/coupon/main',array('coupon'=>$detail['coupon_id']));?>">
				    <span class="txt txt-little radius-little bg-red">劵</span> 商家优惠券下载
				    <span class="float-right icon-angle-right"></span>
			    </a><?php endif; ?>            
            <!--显示近期优惠劵结束-->
            
            <?php if(!empty($work)): ?><div class="blank-10 bg"></div>
            <div class="panel-head"><b>商家招聘信息</b></div>
            <?php $i=0; ?>	
            <?php if(is_array($work)): $index = 0; $__LIST__ = $work;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($index % 2 );++$index;?><!--循环输出的一条数据-->
            <?php $i++; ?>	
            <a href="<?php echo U('nearwork/detail',array('work_id'=>$item['work_id']));?>">
				 <span class="txt txt-little radius-little bg-yellow"><?php echo ($i); ?></span> 
                 <?php echo bao_msubstr($item['title'],0,12,false);?>
                 <em style="color:#999; font-size:12px;">
                 <?php if(!empty($item['money1'])): ?>月薪：<?php echo ($item["money1"]); endif; ?>
                 <?php if(!empty($item['money2'])): ?>-<?php echo ($item["money2"]); ?> &nbsp;<?php endif; ?>
                 <?php if(!empty($item['num'])): ?>需：<?php echo ($item["num"]); ?>人<?php endif; ?>
                 </em>
				 <span class="float-right icon-angle-right"></span>
			</a><?php endforeach; endif; else: echo "" ;endif; ?>
            <div class="blank-10 bg"></div><?php endif; ?><!--显示近期招聘结束-->           
            <?php if(!empty($huodong)): ?><!--显示近期活动数据-->			
                <a href="<?php echo U('mobile/huodong/index',array('activity_id'=>$activity_id['activity_id']));?>">
				    <span class="txt txt-little radius-little bg-red">活</span> 商家近期活动
				    <span class="float-right icon-angle-right"></span>
			    </a><?php endif; ?><!--显示近期活动结束-->          
            <?php if(!empty($ele_menu)): ?><!--显示近期外卖数据-->			
                <a href="<?php echo U('mobile/ele/shop/',array('shop_id'=>$detail['shop_id']));?>">
			     	<span class="txt txt-little radius-little bg-dot">外</span> 商家外卖精选
        		    <span class="float-right icon-angle-right"></span>
			    </a><?php endif; ?><!--显示近期外卖结束-->                
                       
            <?php if(!empty($goods)): ?><a href="<?php echo U('mart/lists',array('id'=>$weidian_id));?>">
				    <span class="txt txt-little radius-little bg-yellow">商</span> 去逛逛商家微店
				    <span class="float-right icon-angle-right"></span>
		        </a><?php endif; ?><!--显示近期商品结束-->    
                       
			<a href="<?php echo U('shop/book',array('shop_id'=>$detail['shop_id']));?>">
				<span class="txt txt-little radius-little bg-blue">约</span> 预约去消费
				<span class="float-right icon-angle-right"></span>
			</a>
		</div>
	</div>
        
        
        <div class="blank-10 bg"></div>
     <div class="container2">
		<div class="panel detail-intro radius-none">
			<div class="panel-head">商家介绍</div>
			<div class="panel-body">
				<?php echo cleanhtml($ex['details']);?>
				<?php if(($detail["niu_date"]) > $today): ?><span class="niu"><img src="/static/default/wap/image/shop/icon-niu.png" /></span><?php endif; ?>
			</div>
		</div>		
	</div>
        
        
        <div class="blank-10 bg"></div>
		
        
     
	<div class="container2">
        <div class="panel detail-intro radius-none">
			<div class="panel-head">附近抢购</div>
		    <div class="main-tuan" id="main-tuan" style="padding:0 10px;">
            <?php if(is_array($tuans)): $i = 0; $__LIST__ = $tuans;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><li>
			<a class="line" href="<?php echo U('tuan/detail',array('tuan_id'=>$item['tuan_id']));?>" >
				<div class="container1">
					<img class="x4" src="<?php echo config_img($item['photo']);?>" />	
					<div class="des x8">
						<h5><?php echo ($item["title"]); ?></h5>
						<p class="intro">
							<?php echo msubstr($item['intro'],0,20);?>
						</p>
						<p class="info">
							<span>￥ <em><?php echo round($item['tuan_price']/100,2);?></em></span> <del>¥ <?php echo round($item['price']/100,2);?></del>
							<span class="text-little float-right badge bg-yellow margin-small-top padding-right">立省<?php echo round($item['price']/100 - $item['tuan_price']/100,2);?>元</span>
						</p>
					</div>
				</div>
			</a>
		</li><?php endforeach; endif; else: echo "" ;endif; ?>
                
                
                </div>
		</div>
       </div>
       
 
<div class="blank-10"></div>	





<style>
.footer-search{padding:15px;background:#fff;border-bottom:thin solid #eee;padding-bottom:5px}
</style>
	<!--<div class="line footer-search">
		<form method="post"  action="<?php echo U('all/index');?>" id="form1" class="form1">
			<div class="form-group">
				<div class="field">
					<div class="input-group">
						<input type="text" class="input" name="keyword" size="50" value="<?php echo ($keyword); ?>" placeholder="搜您所需"  />
                        <span class="addbtn"><button type="submit" class="button icon-search"></button></span>
					</div>
				</div>
			</div>
		</form>
	</div>-->

    
    
    
<div class="footer">
    <a href="<?php echo U('mcenter/member/index');?>">会员中心</a> &nbsp;  &nbsp;
    <?php if(!empty($is_shop)): ?><a href="<?php echo U('store/index/index');?>" title="管理商家">管理商家</a>   &nbsp; &nbsp;<?php endif; ?>
    城市：<a class="button button-small text-yellow" href="<?php echo U('city/index');?>"  title="<?php echo bao_msubstr($city_name,0,2,false);?>"><?php echo bao_msubstr($city_name,0,2,false);?></a>                          
</div>
<div class="blank-20"></div>
<footer class="foot-fixed">

    <a class="foot-item <?php if(($ctl == 'mall') AND ($act != 'more')): ?>active<?php endif; ?>" href="<?php echo u('mobile/mall/index');?>">
    <span class="icon icon-home"></span>
    <span class="foot-label">首页</span>
    </a>


    <a class="foot-item   <?php if(($ctl == 'tuan') || ($ctl == 'goods') || ($ctl == 'eleorder') || ($ctl == 'ding') ): ?>active<?php endif; ?>" href="<?php echo u('mcenter/goods/index');?>">
    <span class="icon icon-cart-plus"></span><span class="foot-label">我的订单</span></a>

    <a class="foot-item  <?php if(($ctl == 'pay')): ?>active<?php endif; ?>" href="<?php echo u('mcenter/pay/index');?>">
    <span class="icon icon-tags"></span><span class="foot-label">优惠买单</span></a>



    <a class="foot-item  <?php if(($ctl == 'message') ||($act == 'xiaoxizhongxin')): ?>active<?php endif; ?>" href="<?php echo u('mcenter/message/someone');?>">
    <span class="icon icon-volume-up"></span><span class="foot-label">消息</span></a>

    <a class="foot-item  <?php if(($ctl == 'member') || ($ctl == 'logs') || ($ctl == 'cash') ||($act == 'zijinguanli')): ?>active<?php endif; ?>" href="<?php echo u('mcenter/member/index');?>">
    <span class="icon icon-user"></span><span class="foot-label">会员中心</span></a>


</footer>

<iframe id="x-frame" name="x-frame" style="display:none;"></iframe>
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
</body>
</html>

<!--客服代码-->  
<?php if(!empty($detail['service']) and $detail['service_audit'] == 1): echo ($detail["service"]); endif; ?>