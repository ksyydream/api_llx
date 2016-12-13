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
<header class="top-fixed bg-yellow bg-inverse">
	<div class="top-back">
		<a class="top-addr" href="<?php echo U('store/mart/index');?>"><i class="icon-angle-left"></i></a>
	</div>
	<div class="top-title">
		添加商品
	</div>
    <div class="top-share">
        <a href="<?php echo U('store/mart/goodscate');?>" class="top-addr icon-plus"> 分类</a>
	</div>
</header>

<style>
.fabu-form .form-content {border: none;resize: none;width: 100%;height: 80px;padding: 10px;font-size: 12px;}
.fabu-form .form-content1 {border: none;resize: none;width: 100%;height: 150px;padding: 10px;font-size: 12px;}
.shuxing{width: 20px; height: 20px;margin-bottom: 10px;}
</style>

<form class="fabu-form" method="post"  target="x-frame" action="<?php echo U('goods/create');?>">

<div class="blank-10"></div>
<div class="Upload-img-box">
   <div class="Upload-btn"><input type="file" id="fileToUpload" name="fileToUpload" data-role="none">上传缩略图</div>
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
		<span class="x3">商品名称：</span>
		<span class="x9">
			<input type="text" class="text-input" name="data[title]" value="<?php echo (($detail["title"])?($detail["title"]):''); ?>" />
		</span>
	</div>
</div>

<div class="row">
	<div class="line">
		<span class="x3">商品简介：</span>
		<span class="x9">
			<input type="text" class="text-input" name="data[intro]" value="<?php echo (($detail["intro"])?($detail["intro"]):''); ?>" />
		</span>
	</div>
</div>

<div class="row">
	<div class="line">
		<span class="x3">产品规格：</span>
		<span class="x9">
			<input type="text" class="text-input" name="data[guige]" value="<?php echo (($detail["guige"])?($detail["guige"]):''); ?>" />
		</span>
	</div>
</div>

<div class="row">
	<div class="line">
		<span class="x3">商品库存：</span>
		<span class="x9">
			<input type="text" class="text-input" name="data[num]" value="<?php echo (($detail["num"])?($detail["num"]):''); ?>" />
		</span>
	</div>
</div>

<div class="row">
	<div class="line">
		<span class="x3">商品分类</span>
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
                                        var url = '<?php echo U("store/goods/child",array("parent_id"=>"0000"));?>';
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
		<span class="x3">自定分类：</span>
		<span class="x9">
			<select id="shopcate_id"  name="data[shopcate_id]"  class="text-select">
				<option value="0" selected="selected">请选择</option>
				<?php if(is_array($autocates)): foreach($autocates as $key=>$var): ?><option value="<?php echo ($var["cate_id"]); ?>"  <?php if(($var["cate_id"]) == $detail["cate_id"]): ?>selected="selected"<?php endif; ?> ><?php echo ($var["cate_name"]); ?></option><?php endforeach; endif; ?>
			</select>
		</span>
	</div>
</div>


<div class="row">
     <div class="line">
        <span class="x3">属性：</span>
        <span class="x9">
        <label><input class="shuxing" type="checkbox" name="data[is_vs1]" value="1"/>认证商家&nbsp;&nbsp;</label>
        <label><input class="shuxing" type="checkbox" name="data[is_vs1]" value="2"/>正品保证&nbsp;&nbsp;</label><br/>
        <label><input class="shuxing" type="checkbox" name="data[is_vs1]" value="3"/>假一赔十&nbsp;&nbsp;</label>
        <!--<label><input class="shuxing" type="checkbox" name="data[is_vs1]" value="4"/>当日送达&nbsp;&nbsp;</label><br/>-->
        <!--<label><input class="shuxing" type="checkbox" name="data[is_vs1]" value="5"/>免运费&nbsp;&nbsp;</label>-->
        <!--<label><input class="shuxing" type="checkbox" name="data[is_vs1]" value="6"/>货到付款&nbsp;&nbsp;</label>-->
        </span>
    </div>
  </div>
  
  


<div class="row">
	<div class="line">
		<span class="x3">市场价格：</span>
		<span class="x9">
			<input type="text" class="text-input" name="data[price]" value="<?php echo (($detail["price"])?($detail["price"]):''); ?>" />
		</span>
	</div>
</div>

<div class="row">
	<div class="line">
		<span class="x3">商城价格：</span>
		<span class="x9">
			<input type="text" class="text-input" name="data[mall_price]" value="<?php echo (($detail["mall_price"])?($detail["mall_price"]):''); ?>" />
		</span>
	</div>
</div>

<div class="row" style="display: none">
	<div class="line">
		<span class="x3">可使用积分：</span>
		<span class="x9">
			<input type="text" class="text-input" name="data[use_integral]" value="0" />
		</span>
	</div>
</div>


<!--下面是时间-->
<div class="blank-10" bg></div>  
<div class="blank-20"></div>  
<div class="row">
   <div class="line">
     <span class="x3">过期时间：</span>
     <span class="x9">
     <input type="text" class="text-input line-input datepicker" id="svctime1" name="data[end_date]" size="30"  readonly="readonly"  value="<?php echo ($detail['end_date']); ?>" placeholder="选择过期时间" />
     </span>
   </div>
  <div class="blank-20"></div>  
</div>
<div class="blank-10 bg"></div>


<div class="line border-bottom">
	<textarea class="form-content" name="data[instructions]" placeholder="购买须知,建议不超过100字！"><?php echo ($detail["instructions"]); ?></textarea>
</div>

       
<div class="line border-bottom">
	<textarea class="form-content1" name="data[details]" placeholder="添加商品详情，建议不超过200字，如需上传文章详情图，请到使用电脑编辑！"><?php echo ($detail["details"]); ?></textarea>
</div> 
<div class="blank-10 bg"></div>        


	<div class="container">
		<div class="blank-30"></div>
		<button  type="submit" class="button button-block button-big bg-dot">添加商品</button>
		<div class="blank-30"></div>
	</div>
</form>

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