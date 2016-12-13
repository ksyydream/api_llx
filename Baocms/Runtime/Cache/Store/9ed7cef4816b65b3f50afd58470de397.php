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
		<a class="top-addr" href="<?php echo U('store/index/index');?>"><i class="icon-angle-left"></i></a>
	</div>
	<div class="top-title">
		添加文章
	</div>
</header>

<style>
.fabu-form .form-content {border: none;resize: none;width: 100%;height: 80px;padding: 10px;font-size: 12px;}
.fabu-form .form-content1 {border: none;resize: none;width: 100%;height: 150px;padding: 10px;font-size: 12px;}
</style>

<form class="fabu-form" method="post"  target="x-frame" action="<?php echo U('news/create');?>">

<div class="blank-10"></div>
<div class="Upload-img-box">
   <div class="Upload-btn"><input type="file" id="fileToUpload" name="fileToUpload" data-role="none">上传文章缩略图</div>
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
		<span class="x3">文章标题：</span>
		<span class="x9">
			<input type="text" class="text-input" name="data[title]" value="<?php echo (($detail["title"])?($detail["title"]):''); ?>" />
		</span>
	</div>
</div>

<div class="row">
	<div class="line">
		<span class="x3">文章分类</span>
		<span class="x4">
			<select name="parent_id" id="parent_id" class="text-select">
				<option value="0" selected="selected">请选择</option>
				<?php if(is_array($cates)): foreach($cates as $key=>$var): if(($var["parent_id"]) == "0"): ?><option value="<?php echo ($var["cate_id"]); ?>"><?php echo ($var["cate_name"]); ?></option><?php endif; endforeach; endif; ?>
			</select>
		</span>
		<span class="x5">
			<select name="data[cate_id]" id="cate_id" class="text-select">
				<option value="0" selected="selected">← 选择子分类</option>
			</select>
		</span>
                         <script>
                                $(document).ready(function (e) {
                                    $("#parent_id").change(function () {
                                        var url = '<?php echo U("store/news/child",array("parent_id"=>"0000"));?>';
                                        if ($(this).val() > 0) {
                                            var url2 = url.replace('0000', $(this).val());
                                            $.get(url2, function (data) {
                                                $("#cate_id").html(data);
                                            }, 'html');
                                        }
                                    });
                                });
                            </script>
	</div>
</div>


<div class="row">
	<div class="line">
		<span class="x3">关键字：</span>
		<span class="x9">
			<input type="text" class="text-input" name="data[keywords]" value="<?php echo (($detail["keywords"])?($detail["keywords"]):''); ?>" />
		</span>
	</div>
</div>
<div class="blank-10 bg"></div>
<div class="line border-bottom">
	<textarea class="form-content" name="data[profiles]" placeholder="添加简介,建议不超过30字"></textarea>
</div>

       
<div class="line border-bottom">
	<textarea class="form-content1" name="data[details]" placeholder="添加文章内容，建议不超过200字，如需上传文章详情图，请到使用电脑编辑！"></textarea>
</div> 
<div class="blank-10 bg"></div>        


	<div class="container">
		<div class="blank-30"></div>
		<button  type="submit" class="button button-block button-big bg-dot">添加文章</button>
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