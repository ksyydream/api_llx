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
<link href="/static/default/wap/other/jquery-ui.css" rel="stylesheet">
<script src="/static/default/wap/other/jquery-ui.js"></script>

<link rel="stylesheet" type="text/css" href="/static/default/wap/other/webuploader.css"> 
<script src="/static/default/wap/other/webuploader.js"></script> 

<header class="top-fixed bg-yellow bg-inverse">
	<div class="top-back">
		<a class="top-addr" href="<?php echo U('store/index/index');?>"><i class="icon-angle-left"></i></a>
	</div>
		<div class="top-title">
			商户认证中心
		</div>
	<div class="top-signed">

	</div>
</header>
<div class="blank-10 bg"></div>

<?php if(empty($shop_audit)): ?><form class="fabu-form" method="post"  target="x-frame" action="<?php echo U('audit/index');?>">

<div class="blank-10"></div>
<div class="container">
	<div id="uploader" class="uploader">
		<div id="filepicker">上传营业执照</div> 
		<div id="filelist" class="uploader-list"></div>
	</div>
	<div class="blank-10"></div>
</div>



<div class="blank-10 bg border-top"></div>
<div class="row">
	<div class="line">
		<span class="x3">企业名称：</span>
		<span class="x9">
			<input type="text" class="text-input" name="data[name]" value="<?php echo (($detail["name"])?($detail["name"]):''); ?>" />
		</span>
	</div>
</div>
<div class="row">
	<div class="line">
		<span class="x3">注册号：</span>
		<span class="x9">
			<input type="text" class="text-input" name="data[zhucehao]" value="<?php echo (($detail["zhucehao"])?($detail["zhucehao"]):''); ?>" />
		</span>
	</div>
</div>
<div class="row">
	<div class="line">
		<span class="x3">营业地址：</span>
		<span class="x9">
			<input type="text" class="text-input" name="data[addr]" value="<?php echo (($detail["addr"])?($detail["addr"]):''); ?>" />
		</span>
	</div>
</div>
<div class="row">
	<div class="line">
		<span class="x3">营业期限：</span>
		<span class="x9">
         <input type="text" class="text-input line-input datepicker" id="svctime" name="data[end_date]" size="30"  readonly="readonly"  value="<?php echo ($detail['end_date']); ?>" placeholder="选择营业期限" />
		</span>
	</div>
</div>
<div class="row">
	<div class="line">
		<span class="x3">组织机构代码证：</span>
		<span class="x9">
			<input type="text" class="text-input" name="data[zuzhidaima]" value="<?php echo (($detail["zuzhidaima"])?($detail["zuzhidaima"]):''); ?>" />
		</span>
	</div>
</div>
<div class="blank-10 bg"></div>

<div class="blank-10"></div>
<div class="container">
	<div id="uploader2" class="uploader2">
		<div id="filepicker2">上传员工身份证</div> 
		<div id="filelist2" class="uploader-list"></div>
	</div>
	<div class="blank-10"></div>
</div>
<div class="blank-10 bg"></div>


<div class="row">
	<div class="line">
		<span class="x3">员工姓名：</span>
		<span class="x9">
			<input type="text" class="text-input" name="data[user_name]" value="<?php echo (($detail["user_name"])?($detail["user_name"]):''); ?>" />
		</span>
	</div>
</div>
<div class="row">
	<div class="line">
		<span class="x3">员工手机：</span>
		<span class="x9">
			<input type="text" class="text-input" name="data[mobile]" value="<?php echo (($detail["mobile"])?($detail["mobile"]):''); ?>" />
		</span>
	</div>
</div>

	<div class="container">
		<div class="blank-30"></div>
		<button  type="submit" class="button button-block button-big bg-dot">添加认证信息</button>
		<div class="blank-30"></div>
	</div>
</form>

	<script>
		jQuery(function() {
			var $ = jQuery,
				$list = $('#filelist'),
				ratio = window.devicePixelRatio || 1,
				thumbnailWidth = 100 * ratio,
				thumbnailHeight = 100 * ratio,
				uploader;
			var uploader = WebUploader.create({
				auto: true,
				swf: '/static/default/wap/other/Uploader.swf',
				server: '<?php echo U("public/upload",array("model"=>"shop_audit"));?>',
				pick: '#filepicker',
				accept: {
					title: 'Images',
					extensions: 'gif,jpg,jpeg,bmp,png',
					mimeTypes: 'image/*'
				}
			});
			uploader.on( 'fileQueued', function( file ) {
				var $li = $('<div id="' + file.id + '" class="file-item thumbnail"><img></div>'),
					$img = $li.find('img');
					$list.append( $li );
				uploader.makeThumb( file, function( error, src ) {
					if ( error ) {
						$img.replaceWith('<span>不能预览</span>');
						return;
					}
					$img.attr( 'src', src );
				}, thumbnailWidth, thumbnailHeight );
			});
			

			uploader.on( 'uploadSuccess', function( file,response ) {
				$( '#'+file.id ).addClass('upload-state-done');
				var pic = response['_raw'];
				var str = '<input type="hidden" name="photo[]" value="' + pic + '" />';
				$("#uploader").append(str);
			});

			uploader.on( 'uploadError', function( file ) {
				var $li = $( '#'+file.id ),
					$error = $li.find('div.error');
				if ( !$error.length ) {
					$error = $('<div class="error"></div>').appendTo( $li );
				}
				$error.text('上传失败');
			});
		});	
	</script>
    
    
    
    <script>
		jQuery(function() {
			var $ = jQuery,
				$list = $('#filelist2'),
				ratio = window.devicePixelRatio || 1,
				thumbnailWidth = 100 * ratio,
				thumbnailHeight = 100 * ratio,
				uploader;
			var uploader = WebUploader.create({
				auto: true,
				swf: '/static/default/wap/other/Uploader.swf',
				server: '<?php echo U("public/upload",array("model"=>"shop_audit"));?>',
				pick: '#filepicker2',
				accept: {
					title: 'Images',
					extensions: 'gif,jpg,jpeg,bmp,png',
					mimeTypes: 'image/*'
				}
			});
			uploader.on( 'fileQueued', function( file ) {
				var $li = $('<div id="' + file.id + '" class="file-item thumbnail"><img></div>'),
					$img = $li.find('img');
					$list.append( $li );
				uploader.makeThumb( file, function( error, src ) {
					if ( error ) {
						$img.replaceWith('<span>不能预览</span>');
						return;
					}
					$img.attr( 'src', src );
				}, thumbnailWidth, thumbnailHeight );
			});
			

			uploader.on( 'uploadSuccess', function( file,response ) {
				$( '#'+file.id ).addClass('upload-state-done');
				var pic = response['_raw'];
				var str = '<input type="hidden" name="pic[]" value="' + pic + '" />';
				$("#uploader2").append(str);
			});

			uploader.on( 'uploadError', function( file ) {
				var $li = $( '#'+file.id ),
					$error = $li.find('div.error');
				if ( !$error.length ) {
					$error = $('<div class="error"></div>').appendTo( $li );
				}
				$error.text('上传失败');
			});
		});	
	</script>





<script>
		jQuery(function($){
			$.datepicker.regional['zh-CN'] = {
				closeText: '关闭',
				prevText: '&#x3c;上月',
				nextText: '下月&#x3e;',
				currentText: '今天',
				monthNames: ['一月','二月','三月','四月','五月','六月',
				'七月','八月','九月','十月','十一月','十二月'],
				monthNamesShort: ['一','二','三','四','五','六',
				'七','八','九','十','十一','十二'],
				dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],
				dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],
				dayNamesMin: ['日','一','二','三','四','五','六'],
				weekHeader: '周',
				dateFormat: 'yy-mm-dd',
				firstDay: 1,
				isRTL: false,
				showMonthAfterYear: true,
				yearSuffix: '年'};
			$.datepicker.setDefaults($.datepicker.regional['zh-CN']);
		});
		$(function() {
			$( ".datepicker" ).datepicker();
		});
	</script>
<?php else: ?>

<div class="container">
		<div class="line" style="padding:10px">
	
			<div class="x12">
            
             <?php if($shop_audit['audit'] == 0): ?><h1>未审核 <a class="button button-small bg-dot" href="<?php echo U('audit/edit',array('audit_id'=>$shop_audit['audit_id']));?>">编辑</a></h1>
             <?php else: ?>
             <a class="button button-block button-big bg-gray text-center">已审核无法编辑</a><?php endif; ?>
			</div>
			
		</div>
       </div>
<div class="blank-10 bg"></div><?php endif; ?>


    
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