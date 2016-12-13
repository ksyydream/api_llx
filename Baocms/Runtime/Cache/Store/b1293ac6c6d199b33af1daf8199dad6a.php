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
<header class="top-fixed bg-yellow bg-inverse">
	<div class="top-back">
		<a class="top-addr" href="<?php echo U('store/shop/photo');?>"><i class="icon-angle-left"></i></a>
	</div>
	<div class="top-title">
		添加环境图
	</div>
</header>

<form class="fabu-form" method="post"  target="x-frame" action="<?php echo U('shop/photo_create');?>">

<div class="blank-10"></div>
<div class="Upload-img-box">
   <div class="Upload-btn"><input type="file" id="fileToUpload" name="fileToUpload" data-role="none">上传环境图</div>
   <div class="Upload-img">
   <div class="list-img loading" style="display:none;"><img src=""></div>
   <div class="list-img jq_photo" style="display:none;"></div>
  </div>
</div>

 <script type="text/javascript" src="/static/default/wap/js/ajaxfileupload.js"></script>
                    <script>
                        function ajaxupload() {
                            $(".loading").show();
                            $.ajaxFileUpload({
                                url: '<?php echo U("app/upload/upload",array("model"=>"life"));?>',
                                type: 'post',
                                fileElementId: 'fileToUpload',
                                dataType: 'text',
                                secureuri: false, //一般设置为false
                                success: function (data, status) {
                                    $(".loading").hide();
                                    var str = '<img src="__ROOT__/attachs/' + data + '"><input type="hidden" name="data[photo]" value="' + data + '" />';
                                    $(".jq_photo").show().html(str);
                                    $("#fileToUpload").unbind('change');
                                    $("#fileToUpload").change(function () {
                                        ajaxupload();
                                    });
                                }
                            });
                        }
                        $(document).ready(function () {
                            $("#fileToUpload").change(function () {
                                ajaxupload();
                            });
                            $(document).on("click", ".photo img", function () {
                                $(this).parent().remove();
                            });
                        });
                    </script>
                    



<div class="blank-10 bg border-top"></div>
<div class="row">
	<div class="line">
		<span class="x3">标题：</span>
		<span class="x9">
			<input type="text" class="text-input" name="data[title]" placeholder="填写图标名称" />
		</span>
	</div>
</div>

<div class="row">
	<div class="line">
		<span class="x3">排序：</span>
		<span class="x9">
			<input type="text" class="text-input" name="data[orderby]" />
		</span>
	</div>
</div>


	<div class="container">
		<div class="blank-30"></div>
		<button  type="submit" class="button button-block button-big bg-dot">确认添加</button>
		<div class="blank-30"></div>
	</div>
</form>
   
   
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