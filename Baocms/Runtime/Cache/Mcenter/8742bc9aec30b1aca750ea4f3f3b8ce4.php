<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<meta charset="utf-8">
		<title><?php if(!empty($seo_title)): echo ($seo_title); ?>_<?php endif; echo ($CONFIG["site"]["sitename"]); ?>会员中心</title>
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
		<?php if($CONFIG[site][concat] != 1): ?><link rel="stylesheet" href="/static/default/wap/css/base.css">
		<link rel="stylesheet" href="/static/default/wap/css/mcenter.css"/>
		<script src="/static/default/wap/js/jquery.js"></script>
		<script src="/static/default/wap/js/base.js"></script>
		<script src="/static/default/wap/other/layer.js"></script>
		<script src="/static/default/wap/other/roll.js"></script>
		<script src="/static/default/wap/js/public.js"></script>
		<?php else: ?>
		<link rel="stylesheet" href="/static/default/wap/css/??base.css,mcenter.css" />
		<script src="/static/default/wap/js/??jquery.js,base.js,roll.js,layer.js,public.js"></script><?php endif; ?>
	</head>
	<body>
<header class="top-fixed bg-yellow bg-inverse">
	<div class="top-back">
    
    
       <?php if($type == 1): ?><a class="top-addr" href="<?php echo U('mobile/ele/pay',array('order_id'=>$order_id));?>"><i class="icon-angle-left"></i></a>
       <?php elseif($type == 2): ?> 
       <a class="top-addr" href="<?php echo U('mobile/mall/pay',array('order_id'=>$order_id));?>"><i class="icon-angle-left"></i></a>
       <?php elseif($type == 3): ?> 
       <a class="top-addr" href="<?php echo U('mobile/mart/pay',array('order_id'=>$order_id));?>"><i class="icon-angle-left"></i></a>
       <?php else: ?>
       <a class="top-addr" href="<?php echo U('information/index');?>"><i class="icon-angle-left"></i></a><?php endif; ?>
        
        
	</div>
		<div class="top-title">
			收货地址设置
		</div>
	<div class="top-signed">
		<?php if($msg_day > 0): ?><a href="<?php echo U('mcenter/message/index');?>">
<i class="icon-envelope"></i>
<span class="badge bg-red jiaofei"><?php echo ($msg_day); ?></span>
</a>
<?php else: ?>
    <?php if(empty($sign_day)): ?><a href="<?php echo U('mobile/sign/signed');?>" class="top-addr icon-plus"> 签到</a>    
    <?php else: ?>
    <a href="<?php echo U('mobile/passport/logout');?>" class="top-addr icon-sign-out"></a><?php endif; endif; ?>
	</div>
</header>
    
    <script src="<?php echo U('app/datas/cab',array('name'=>'cityareas'));?>"></script>  <!-- 获取下拉 -->
     
    
    <script type="text/javascript" language="javascript">
    	$(document).ready(function(){
			
			//添加
			$('.add_addr').click(function(){
			
				layer.open({
					type: 1,
					title:'新增地址',
					skin: 'layer-ext-default', //加上边框
					area: ['90%', '340px'], //宽高
					content: '<div class="form-x form-auto"><div class="line margin-top"><div class="x2 label text-center"><label>姓名</label></div><div class="x10 field"><input type="text" class="input input-auto" id="name" name="name" size="10"  value=""></div></div>   <div class="line margin-top"><div class="x2 label text-center"><label>地区</label></div><div class="x10 field form-inline"><select id="city_id" name="city_id"  class="input margin-small-right input-auto"><option value="0">请选择...</option></select><select id="area_id" name="area_id" class="input  margin-small-right input-auto"><option value="0">请选择...</option></select><select id="business_id" name="business_id" class="input input-auto"><option value="0">请选择...</option></select></div></div><div class="line margin-top"><div class="x2 label text-center"><label>手机</label></div><div class="x10 field"><input type="text" class="input input-auto" name="mobile" id="mobile" value=""></div></div><div class="line margin-top"><div class="x2 label text-center"><label>地址</label></div><div class="x10 field"><input type="text" class="input input-auto" size="25" name="addr" id="addr" value="" /></div></div><div class="line margin-top"><div class="x10 float-right"><input class="button bg-blue addr_post" type="submit" value="添加地址" /></div></div></div>'
				});
				$('.layui-layer-title').css('color','#ffffff').css('background','#2fbdaa');

				get_option();
				
				
				$('.addr_post').click(function(){
					var name = $('#name').val();
					var city_id = $('#city_id').val();
					var area_id = $('#area_id').val();
					var business_id = $('#business_id').val();
					var mobile = $('#mobile').val();
					var addr = $('#addr').val();
					
					$.post('<?php echo U("mobile/addr/add_addr");?>',{name:name,city_id:city_id,area_id:area_id,business_id:business_id,mobile:mobile,addr:addr},function(result){										
						if(result.status == 'success'){
							layer.msg(result.msg);
							setTimeout(function(){
								location.reload(true);
							},3000);
						}else{
							layer.msg(result.msg,{icon:2});
						}														
					},'json');
				
				})
				
			
			})
			
			
			
			//修改
			$('.edit_addr').click(function(){
			
				var val = $(this).attr('val');
				var a = $(this).attr('a');
				var b = $(this).attr('b');
				var c = $(this).attr('c');
				var n = $(this).attr('n');
				var m = $(this).attr('m');
				var addr = $(this).attr('addr');
				
				layer.open({
					type: 1,
					title:'修改地址',
					skin: 'layer-ext-demo', //加上边框
					area: ['90%', '340px'], //宽高
					content: '<div class="form-x form-auto"><div class="line margin-top"><div class="x2 label text-center"><label>姓名</label></div><div class="x10 field"><input type="text" class="input input-auto" id="name" name="name" size="10"  value="'+n+'"></div></div>   <div class="line margin-top"><div class="x2 label text-center"><label>地区</label></div><div class="x10 field form-inline"><select id="city_ids" name="city_id"  class="input margin-small-right input-auto"><option value="0">请选择...</option></select><select id="area_ids" name="area_id" class="input  margin-small-right input-auto"><option value="0">请选择...</option></select><select id="business_ids" name="business_id" class="input input-auto"><option value="0">请选择...</option></select></div></div><div class="line margin-top"><div class="x2 label text-center"><label>手机</label></div><div class="x10 field"><input type="text" class="input input-auto" name="mobile" id="mobile" value="'+m+'"></div></div><div class="line margin-top"><div class="x2 label text-center"><label>地址</label></div><div class="x10 field"><input type="text" class="input input-auto" size="25" name="addr" id="addr" value="'+addr+'" /></div></div><div class="line margin-top"><div class="x10 float-right"><input class="button bg-blue edit_post" type="submit" value="立即修改"  val="'+val+'" /></div></div></div>'
				});
				
				$('.layui-layer-title').css('color','#ffffff').css('background','#2fbdaa');
				
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
							layer.msg(result.msg);
							setTimeout(function(){
								location.reload(true);
							},3000);
						}else{
							layer.msg(result.msg,{icon:2});
						}														
					},'json');
				})
			})
		})

    </script>

 <style>
 .list-media-x{ margin-top:0rem;}
 </style>   
    
    <div class="list-media-x" id="list-media">
	<ul>
    
    <?php if(is_array($addr)): $i = 0; $__LIST__ = $addr;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><div class="line padding border-bottom">
		<div class="x12">
        <p class="text-gray"><?php echo ($item["name"]); ?>,<?php echo ($item["mobile"]); ?></p>
			<p class="text-gray"><?php echo ($citys[$item['city_id']]['name']); ?> <?php echo ($areas[$item['area_id']]['area_name']); ?> <?php echo ($business[$item['business_id']]['business_name']); ?> <?php echo ($item["addr"]); ?></p>
		</div>
	</div>
	<div class="line padding">
		<span class="text-right  x12">
        <?php if(($item["is_default"]) == "1"): ?><a class="button button-small bg-blue">当前默认</a>
        <?php else: ?>
        <a target="x-frame" class="button button-small bg-dot" href="<?php echo U('mobile/addr/update_addr',array('addr_id'=>$item['addr_id'],'type'=>$type,'order_id'=>$order_id));?>">
        <?php if(!empty($type)): ?>选择收货地址
        <?php else: ?>
        设为默认<?php endif; ?>
        </a><?php endif; ?>
        <a href="#" val="<?php echo ($item["addr_id"]); ?>" a="<?php echo ($item["area_id"]); ?>" b="<?php echo ($item["business_id"]); ?>" c="<?php echo ($item["city_id"]); ?>" n="<?php echo ($item["name"]); ?>" m="<?php echo ($item["mobile"]); ?>" addr="<?php echo ($item["addr"]); ?>" class="button button-small bg-blue edit_addr">修改地址</a>
        <a href="javascript:void(0);" rel="<?php echo ($item["addr_id"]); ?>" class="jquery-delete button button-small bg-gray">删除</a>
        
        </span>
	</div>
	<div class="blank-10 bg"></div><?php endforeach; endif; else: echo "" ;endif; ?>
  
  </ul>
</div>
	
	<div class="container">
		<div class="blank-30"></div>
		<a href="javascript:void(0);" id="add_addr" class="button button-block button-big bg-blue text-center add_addr">新增收货地址</a>
	</div>
</ul>

 <script>
	$(document).ready(function () {
		$(document).on('click', ".jquery-delete", function (e) {
			var addr_id = $(this).attr('rel');
			layer.confirm('您确定要删除该地址？', {
				skin: 'layer-ext-demo', 
				area: ['50%', 'auto'], //宽高
				btn: ['是的', '不'], //按钮
				shade: false //不显示遮罩
			}, function () {
				$.post("<?php echo U('addrs/delete');?>", {addr_id: addr_id}, function (result) {
					if (result.status == "success") {
						layer.msg(result.msg);
						setTimeout(function () {
							location.reload();
						}, 1000);
					} else {
						layer.msg(result.msg);
					}
				}, 'json');
			});
		});
	});
</script>  

<div class="blank-20"></div>
<!--<?php if($CONFIG[other][footer] == 1): ?>-->
	<!---->
    <!--<footer class="foot-fixed">-->
  <!---->
    <!--<a class="foot-item <?php if(($ctl == 'index') AND ($act != 'more')): ?>active<?php endif; ?>" href="<?php echo u('mobile/index/index');?>">		-->
    <!--<span class="icon icon-home"></span>-->
    <!--<span class="foot-label">首页</span>-->
    <!--</a>-->
   <!---->
    <!---->
    <!--<a class="foot-item   <?php if(($ctl == 'tuan') || ($ctl == 'goods') || ($ctl == 'eleorder') || ($ctl == 'ding') ): ?>active<?php endif; ?>" href="      <?php echo LinkTo('tuan/index');?>">			-->
    <!--<span class="icon icon-cart-plus"></span><span class="foot-label">订单</span></a>-->
    <!---->
     <!--<a class="foot-item  <?php if(($ctl == 'tuancode')): ?>active<?php endif; ?>" href="<?php echo u('mcenter/tuancode/index');?>">			-->
    <!--<span class="icon icon-tags"></span><span class="foot-label">抢购劵</span></a>-->
    <!---->
    <!---->
    <!---->
    <!--<a class="foot-item  <?php if(($ctl == 'message') ||($act == 'xiaoxizhongxin')): ?>active<?php endif; ?>" href="<?php echo u('mcenter/message/someone');?>">			-->
    <!--<span class="icon icon-volume-up"></span><span class="foot-label">消息</span></a>-->
    <!---->
    <!--<a class="foot-item  <?php if(($ctl == 'member') || ($ctl == 'logs') || ($ctl == 'cash') ||($act == 'zijinguanli')): ?>active<?php endif; ?>" href="<?php echo u('mcenter/member/index');?>">-->
    <!--<span class="icon icon-user"></span><span class="foot-label">会员中心</span></a>-->
    <!---->
   <!---->
    <!--</footer>-->
<!--<?php endif; ?>-->


<footer class="foot-fixed">

    <a class="foot-item <?php if(($ctl == 'mall') AND ($act != 'more')): ?>active<?php endif; ?>" href="<?php echo u('mobile/mall/index');?>">
    <span class="icon icon-home"></span>
    <span class="foot-label">首页</span>
    </a>


    <a class="foot-item   <?php if(($ctl == 'tuan') || ($ctl == 'goods') || ($ctl == 'eleorder') || ($ctl == 'ding') ): ?>active<?php endif; ?>" href="<?php echo LinkTo('goods/index');?>">
    <span class="icon icon-cart-plus"></span><span class="foot-label">我的订单</span></a>

    <a class="foot-item  <?php if(($ctl == 'pay')): ?>active<?php endif; ?>" href="<?php echo U('pay/index');?>">
    <span class="icon icon-tags"></span><span class="foot-label">优惠买单</span></a>



    <a class="foot-item  <?php if(($ctl == 'message') ||($act == 'xiaoxizhongxin')): ?>active<?php endif; ?>" href="<?php echo u('mcenter/message/someone');?>">
    <span class="icon icon-volume-up"></span><span class="foot-label">消息</span></a>

    <a class="foot-item  <?php if(($ctl == 'member') || ($ctl == 'logs') || ($ctl == 'cash') ||($act == 'zijinguanli')): ?>active<?php endif; ?>" href="<?php echo u('mcenter/member/index');?>">
    <span class="icon icon-user"></span><span class="foot-label">会员中心</span></a>


</footer>

<iframe id="x-frame" name="x-frame" style="display:none;">
</iframe>
</body>
</html>