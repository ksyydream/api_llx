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
			<a class="top-addr" href="<?php echo U('mart/index');?>"><i class="icon-angle-left"></i></a>
		</div>
		<div class="top-title">
			微店产品分类
		</div>
		<div class="top-share">
            <a class="sh_waimai_cate_add  icon-plus" href="javascript:void(0);" id="cate-btn"> 分类</a>
		</div>
	</header>
<style>
ul {padding-left: 0px !important;}
</style>

<section>


	<div class="sh_mask_box sh_waimai_cate_add_mask_box" style="display:none;">
	    <div class="sh_mask_nr">
	        <div class="sh_mask_bt">添加产品分类</div>
            <div class="sh_waimai_cate_add_mask">
            	<div class="sh_waimai_cate_add_input mb10"><span>名称</span><input type="text" value="" name="cate_name" id="cate_name"></div>
                <div class="sh_waimai_cate_add_input mb10"><span>排序</span><input type="text" value="" name="orderby" id="orderby"></div>
            </div>
            <div class="sh_mask_btn">
            	<input class="reco" type="button" value="确认" id="add">
                <input class="cancel" type="button" value="取消" id="add_close">
            </div>
        </div>

		<script type="text/javascript" language="javascript">
        	$(document).ready(function(){
				$('#add').click(function(){
					var cate_name = $('.sh_waimai_cate_add_mask_box #cate_name').val();
					var orderby = $('.sh_waimai_cate_add_mask_box #orderby').val();
					$.post('<?php echo U("mart/create");?>',{cate_name:cate_name,orderby:orderby},function(result){
						if(result.status == 'success'){
							layer.msg(result.message,{icon:1});
							setTimeout(function(){
								location.reload(true);
							},2500)
						}else{
							layer.msg(result.message,{icon:2});
						}
					},'json')
				})
				$('#add_close').click(function(){
					$('.sh_waimai_cate_add_mask_box').hide();
				})
			})
        </script>


	</div>
    <div class="sh_mask_box sh_waimai_cate_edit_mask_box" style="display:none;">
	    <div class="sh_mask_nr">
	        <div class="sh_mask_bt">编辑产品分类</div>
            <div class="sh_waimai_cate_add_mask">
            	<div class="sh_waimai_cate_add_input mb10"><span>名称</span><input type="text" value="" name="cate_name" id="cate_name"></div>
                <div class="sh_waimai_cate_add_input mb10"><span>排序</span><input type="text" value="" name="orderby" id="orderby"></div>
            </div>
            <div class="sh_mask_btn">
            	<input class="reco" type="button" value="确认" id="edit">
                <input class="cancel edit_close" type="button" value="取消">
            </div>
        </div>
	</div>
    
	<script type="text/javascript" language="javascript">
        $(document).ready(function(){
            $('.edit_close').click(function(){
                $('.sh_waimai_cate_edit_mask_box').hide();
            })
        })
    </script>
	<script>
		$(function(){
			$(".sh_prompt_infor_closs").click(function(){
				$(".sh_prompt_infor_box").hide();
			});
		});
    </script>
	<div class="sh_prompt_infor_box">
        <div class="sh_prompt_infor_closs"></div>
    </div>
    
    <div class="blank-10 bg"></div>
    <div class="sh_buy_fabu">
        <div class="sh_list_public_box">
            <ul>
            	<?php if(is_array($autocates)): $i = 0; $__LIST__ = $autocates;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$a): $mod = ($i % 2 );++$i;?><li class="list_box mb10">
                	<div class="sh_waimai_cate_list">
                	    <div class="fl left">
                            <div class="nr">
                                <p>ID：<span class="black3"><?php echo ($a["cate_id"]); ?></span></p>
                                <p>名称：<span class="black3"><?php echo ($a["cate_name"]); ?></span></p>
                            </div>
                        </div>

                        <div class="fr right"><a href="javascript:void(0);" v="<?php echo ($a["cate_id"]); ?>" n="<?php echo ($a["cate_name"]); ?>" s="<?php echo ($a["orderby"]); ?>" class="btn sh_waimai_cate_edit">编辑</a></div>
                        <div class="clear"></div>
                    </div>
                </li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
    </div>
</section>

<script>
	$(function(){
		$(".sh_waimai_cate_add").click(function(){
			$(".sh_waimai_cate_add_mask_box").show();
		});
		$(".sh_waimai_cate_edit").click(function(){
			var v = $(this).attr('v');
			var n = $(this).attr('n');
			var s = $(this).attr('s');
			$(".sh_waimai_cate_edit_mask_box").show();
			$(".sh_waimai_cate_edit_mask_box").find('#cate_name').val(n);
			$(".sh_waimai_cate_edit_mask_box").find('#orderby').val(s);
			$('#edit').attr('cate_id',v);
		});
		$('#edit').click(function(){
			var cate_name = $('.sh_waimai_cate_edit_mask_box #cate_name').val();
			var orderby = $('.sh_waimai_cate_edit_mask_box #orderby').val();
			var v = $(this).attr('cate_id');
			$.post('<?php echo U("mart/edit");?>',{cate_name:cate_name,orderby:orderby,v:v},function(result){
					if(result.status == 'success'){
						$(".sh_waimai_cate_edit_mask_box").hide();
						layer.msg(result.message,{icon:1});
						setTimeout(function(){
							location.reload(true);
						},2500)
					}else{
						layer.msg(result.message,{icon:2});
					}
			},'json')
		})
	});

</script>
</body>
</html>