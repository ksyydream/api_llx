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
			<a class="top-addr" href="<?php echo U('mall/index',array('cat'=>$detail['cate_id']));?>"><i class="icon-angle-left"></i></a>
		</div>
		<div class="top-title">
			订单设定
		</div>
	</header>

	<script src="<?php echo U('app/datas/cab',array('name'=>'cityareas'));?>"></script>  <!-- 获取下拉 -->
    
    <script>
    	$(document).ready(function(){
			//添加收货地址
			$('.add_addr').click(function(){
				var index = layer.open({
					type: 1,
					title:'新增收货地址',
					skin: 'layer-ext-demo', //加上边框
					area: ['90%', '340px'], //宽高
					content: '<div class="form-x form-auto"><div class="line margin-top"><div class="x2 label"><label>联系人</label></div><div class="x10 field"><input type="text" class="input input-auto" id="name" name="name" size="10"  value=""></div></div>   <div class="line margin-top"><div class="x2 label"><label>地区</label></div><div class="x10 field form-inline"><select id="city_id" name="city_id"  class="input margin-small-right input-auto"><option value="0">请选择...</option></select><select id="area_id" name="area_id" class="input  margin-small-right input-auto"><option value="0">请选择...</option></select><select id="business_id" name="business_id" class="input input-auto"><option value="0">请选择...</option></select></div></div><div class="line margin-top"><div class="x2 label"><label>手机</label></div><div class="x10 field"><input type="text" class="input input-auto" name="mobile" id="mobile" value=""></div></div><div class="line margin-top"><div class="x2 label"><label>地址</label></div><div class="x10 field"><input type="text" class="input input-auto" size="25" name="addr" id="addr" value="" /></div></div><div class="line margin-top"><div class="x10 float-right"><input class="button bg-dot addr_post" type="submit" value="添加地址" /></div></div></div>'
				});

				get_option();
				$('.layui-layer-content').css('padding','15px');
				
				$('.addr_post').click(function(){
					var name = $('#name').val();
					var city_id = $('#city_id').val();
					var area_id = $('#area_id').val();
					var business_id = $('#business_id').val();
					var mobile = $('#mobile').val();
					var addr = $('#addr').val();
					
					$.post('<?php echo U("mobile/addr/add_addr");?>',{name:name,city_id:city_id,area_id:area_id,business_id:business_id,mobile:mobile,addr:addr},function(result){										
						if(result.status == 'success'){
							layer.msg(result.msg,{icon:1});
							setTimeout(function(){
								location.reload(true);
							},2000);
						}else{
							layer.msg(result.msg,{icon:2});
						}														
					},'json');
				})
			});

			//修改
			$('.edit_addr').click(function(){
				var val = $(this).attr('val');
				var a = $(this).attr('a');
				var b = $(this).attr('b');
				var c = $(this).attr('c');
				var n = $(this).attr('n');
				var m = $(this).attr('m');
				var addr = $(this).attr('addr');
				var index = layer.open({
					type: 1,
					title:'修改收货地址',
					skin: 'layer-ext-demo', //加上边框
					area: ['90%', '340px'], //宽高
					content: '<div class="form-x form-auto"><div class="line margin-top"><div class="x2 label"><label>联系人</label></div><div class="x10 field"><input type="text" class="input input-auto" id="name" name="name" size="10"  value="'+n+'"></div></div>   <div class="line margin-top"><div class="x2 label"><label>地区</label></div><div class="x10 field form-inline"><select id="city_ids" name="city_id"  class="input margin-small-right input-auto"><option value="0">请选择...</option></select><select id="area_ids" name="area_id" class="input  margin-small-right input-auto"><option value="0">请选择...</option></select><select id="business_ids" name="business_id" class="input input-auto"><option value="0">请选择...</option></select></div></div><div class="line margin-top"><div class="x2 label"><label>手机</label></div><div class="x10 field"><input type="text" class="input input-auto" name="mobile" id="mobile" value="'+m+'"></div></div><div class="line margin-top"><div class="x2 label"><label>地址</label></div><div class="x10 field"><input type="text" class="input input-auto" size="25" name="addr" id="addr" value="'+addr+'" /></div></div><div class="line margin-top"><div class="x10 float-right"><input class="button  bg-blue edit_post" type="submit" value="立即修改"  val="'+val+'" /></div></div></div>'
				});
				$('.layui-layer-content').css('padding','15px');
				get_option();
				changeCAB(c,a,b);
				$('.edit_post').click(function(){
					var addr_id = $(this).attr('val');
					var name = $('#name').val();
					var city_id = $('#city_ids').val();
					var area_id = $('#area_ids').val();
					var business_id = $('#business_ids').val();
					var mobile = $('#mobile').val();
					var addr = $('#addr').val();
					$.post('<?php echo U("mobile/addr/edit_addr");?>',{name:name,city_id:city_id,area_id:area_id,business_id:business_id,mobile:mobile,addr:addr,addr_id:addr_id},function(result){										
						if(result.status == 'success'){
							layer.msg(result.msg,{icon:1});
							setTimeout(function(){
								location.reload(true);
							},2000);
						}else{
							layer.msg(result.msg,{icon:2});
						}														
					},'json');
				})
			})
			$("#pay-method li").click(function(){
				var code = $(this).attr("data-rel");
				$("#code").val(code);
				$("#pay-method li").each(function(){
					$(this).removeClass("active");
				});
				$(this).addClass("active");
			});
			
		});
    </script>
    
<style>
.icon-angle-right{ float:right; font-size:20px;}
</style>    
	<form class="pay-form" action="<?php echo U('mall/pay2',array('order_id'=>$order['order_id']));?>" method="post" target="x-frame">
		<div class="row">
			<span class="float-left">购物费用：</span>
			<span class="float-right">￥ <?php echo round($order['total_price']/100,2);?> 元</span>
		</div>
		<hr />
		<div class="row">
			<span class="float-left">配送费用：</span>
			<span class="float-right"> <?php if($order['total_express'] == 0): ?>免邮<?php else: ?>￥ <?php echo round($order['total_express']/100,2);?> 元<?php endif; ?></span>
		</div>
		<hr />
		<div class="row">
			<span class="float-left">请选择收货地址</span>
		</div>
		<hr />
        
        
		<?php if(!empty($useraddr)): if(is_array($useraddr)): foreach($useraddr as $key=>$item): ?><div class="row">
        <span class="x10">
			<input type="radio" name="addr_id" id="addr_id" value="<?php echo ($item['addr_id']); ?>" <?php if(($item["is_default"]) == "1"): ?>checked="checked"<?php endif; ?> />
			<?php echo ($item["name"]); ?> <?php echo ($item["mobile"]); ?> <a class="text-dot edit_addr" href="#" val="<?php echo ($item["addr_id"]); ?>" a="<?php echo ($item["area_id"]); ?>" b="<?php echo ($item["business_id"]); ?>" c="<?php echo ($item["city_id"]); ?>" n="<?php echo ($item["name"]); ?>" m="<?php echo ($item["mobile"]); ?>" addr="<?php echo ($item["addr"]); ?>">修改地址</a>
            <p onclick="location='<?php echo U("mcenter/addrs/index",array('type'=>2,'order_id'=>$order['order_id']));?>'"><?php echo ($citys[$item['city_id']]['name']); ?> <?php echo ($areas[$item['area_id']]['area_name']); ?> <?php echo ($business[$item['business_id']]['business_name']); ?> <?php echo ($item["addr"]); ?></p>
         </span>
          <span class="x2" onclick="location='<?php echo U("mcenter/addrs/index",array('type'=>2,'order_id'=>$order['order_id']));?>'"><i class="icon-angle-right padding-top"></i></span>
		</div>
		<hr /><?php endforeach; endif; ?>

        
        
        
		<?php else: ?>
		<div class="row">
			您还没有设置收货地址，赶紧添加一个吧！ <a class="text-dot add_addr" href="javascript:void(0);" >新增收货地址</a>
		</div>
		<hr /><?php endif; ?>
		
		<div class="blank-10 bg"></div>
		
		<ul id="pay-method" class="pay-method">
			<?php if(is_array($payment)): foreach($payment as $key=>$var): ?><li data-rel="<?php echo ($var["code"]); ?>" class="media media-x payment">
				<a class="float-left"  href="javascript:;">
					<img src="/static/default/wap/image/pay/<?php echo ($var["mobile_logo"]); ?>">
				</a>
				<div class="media-body">
					<div class="line">
						<div class="x10">
						<?php echo ($var["name"]); ?><p>推荐已安装<?php echo ($var["name"]); echo ($var["id"]); ?>客户端的用户使用</p>
						</div>
						<div class="x2">
							<span class="radio txt txt-small radius-circle bg-green"><i class="icon-check"></i></span>
						</div>
					</div>
				</div>
			</li><?php endforeach; endif; ?>
			<li data-rel="wait" class="media media-x payment">
				<a class="float-left" href="javascript:;">
					<img src="/static/default/wap/image/pay/dao.png">
				</a>
				<div class="media-body">
					<div class="line">
						<div class="x10">
						货到付款<p>如果您没有网银，可以到店付</p>
						</div>
						<div class="x2">
							<span class="radio txt txt-small radius-circle bg-green"><i class="icon-check"></i></span>
						</div>
					</div>
				</div>
			</li>
		</ul>
		<input id="code" type="hidden" name="code" value="" />
		
		<div class="text-center padding-left padding-right margin-large-top">
			<button type="submit" class="button button-big button-block bg-yellow">提交订单</button>
		</div>
		
		<div class="blank-20"></div>
	</form>
</div>
    


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
    <a href="<?php echo U('mcenter/member/index');?>">客户端</a> &nbsp;  &nbsp;
    <?php if(!empty($is_shop)): ?><a href="<?php echo U('store/index/index');?>" title="管理商家">管理商家</a>   &nbsp; &nbsp; 
    <?php else: ?>
    <a href="<?php echo U('mcenter/apply/index');?>" title="商家入驻">商家入驻</a>   &nbsp; &nbsp;<?php endif; ?>
    城市：<a class="button button-small text-yellow" href="<?php echo U('city/index');?>"  title="<?php echo bao_msubstr($city_name,0,2,false);?>"><?php echo bao_msubstr($city_name,0,2,false);?></a>                          
</div>
<div class="blank-20"></div>
<?php if($CONFIG[other][footer] == 1): ?><footer class="foot-fixed">
<a class="foot-item <?php if(($ctl == 'index') AND ($act != 'more')): ?>active<?php endif; ?>" href="<?php echo U('index/index');?>">		
<span class="icon icon-home"></span>
<span class="foot-label">首页</span>
</a>

<a class="foot-item <?php if(($ctl) == "life"): ?>active<?php endif; ?>" href="<?php echo U('life/index');?>">			
<span class="icon icon-paw"></span><span class="foot-label">分类</span></a>

<a class="foot-item <?php if(($ctl) == "community"): ?>active<?php endif; ?>" href="<?php echo U('mobile/community/index');?>">			
<span class="icon icon-map-marker"></span><span class="foot-label">小区</span></a>

<a class="foot-item <?php if(($ctl) == "mcenter"): ?>active<?php endif; ?>" href="<?php echo U('mcenter/index/index');?>">			
<span class="icon icon-user"></span><span class="foot-label">我的</span></a>

<a class="foot-item <?php if(($ctl) == "biz"): ?>active<?php endif; ?>" href="<?php echo U('index/more');?>">			
<span class="icon icon-ellipsis-h"></span><span class="foot-label">更多</span></a>



</footer>
<?php else: endif; ?>

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