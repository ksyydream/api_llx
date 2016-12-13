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
		<a class="top-addr" href="<?php echo U('pay/index');?>"><i class="icon-angle-left"></i></a>
	</div>
	<div class="top-title">
		创建支付
	</div>
</header>

<form class="fabu-form" method="post"  target="x-frame" action="<?php echo U('store/pay/create');?>">


	<div class="blank-10 bg border-top"></div>



	<div class="row">
		<div class="line">
			<span class="x3">会员手机</span>
		<span class="x9">
			<input type="number" class="text-input" name="data[mobile]" id="mobile" onblur="get_zp()"/>
		</span>
		</div>
	</div>

	<div class="row">
		<div class="line">
			<span class="x3">消费金额</span>
		<span class="x9">
			<input type="number" class="text-input" name="data[total]" id="total" onblur="yhk_dikou()"/>
		</span>
		</div>
	</div>

	<div id="yhk">

	</div>

	<div class="row">
		<div class="line">
			<span class="x3">备注</span>
		<span class="x9">
			<input type="text" class="text-input" name="data[remark]" />
		</span>
		</div>
	</div>

	<div class="row">
		<div class="line">
			<span class="x3">赠品消费</span>
		<span class="x9">
		</span>
		</div>
	</div>

	<div id="zp_info">

	</div>


	<div class="container">
		<div class="blank-30"></div>
		<button  type="submit" class="button button-block button-big bg-dot" onclick="return check_qty()">确认保存</button>
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

<script>
	window.yhk = false;
	function get_zp(){
		if(!$("#mobile").val()){
			alert('请输入手机号码');
			return false;
		}
		$.getJSON("http://llx.asmzs.com/store/pay/get_zp/mobile/"+$("#mobile").val(),function(data){
			if(data != -1 && data['zp']['<?php echo ($shop_id); ?>']){
				content = '<div class="row">';
				content += '<div class="line">';
				content += '<span class="x6" style="color:#999">';
				content += '赠品';
				content += '</span>';
				content += '<span class="x3">';
				content += '数量';
				content += '</span>';
				content += '<span class="x3">';
				content += '本次消费';
				content += '</span>';
				content += '</div>';
				content += '</div>';

				for(var key in data['zp']['<?php echo ($shop_id); ?>']){
					content += '<div class="row">';
					content += '<div class="line">';
					content += '<span class="x6" style="color:#999"><input type="hidden" name="desc[]" value="'+key+'">';
					content += key;
					content += '</span>';
					content += '<span class="x3">';
					content += data['zp']['<?php echo ($shop_id); ?>'][key];
					content += '</span>';
					content += '<span class="x3">';
					content += '<input type="number" class="text-input" name="qty[]" />';
					content += '</span>';
					content += '</div>';
					content += '</div>';
				}

				$("#zp_info").html(content)
			}else{
				$("#zp_info").html('')
			}


			if(data != -1){
				window.yhk = data['yhk']

			}

		})
	}

	function check_qty(){
		err = 0
		$("[name='qty[]']").each(function(){
			limit_qty = parseInt($(this).parent().prev().html())
			qty = parseInt($(this).val());
			if(qty > limit_qty){

				err++;
			}
		})

		if(err > 0){
			alert('赠品消费数量不能大于赠品数量');
			return false;
		}
	}

	function yhk_dikou(){
		if(window.yhk){
			total = parseInt($("#total").val()) ? parseInt($("#total").val()) : 0;
			if(window.yhk['<?php echo ($shop_id); ?>'] > 0){
				if(parseInt(total/100) * parseInt('<?php echo ($yhk1); ?>')  <= window.yhk['<?php echo ($shop_id); ?>']){
					allow_yhk = parseInt(total/100) * parseInt('<?php echo ($yhk1); ?>')
				}else{
					allow_yhk = window.yhk['<?php echo ($shop_id); ?>']
				}
			}else{
				total_yhk = 0;
				for(var key in window.yhk){
					total_yhk += window.yhk[key]
				}
				if(parseInt(total/100) * parseInt('<?php echo ($yhk2); ?>')  <= total_yhk){
					allow_yhk = parseInt(total/100) * parseInt('<?php echo ($yhk2); ?>')
				}else{
					allow_yhk = total_yhk
				}
			}
			yhk_html = '<div class="row">'
			yhk_html += '<div class="line">'
			yhk_html += '<span class="x3">优惠券抵扣</span>'
			yhk_html += '<span class="x9">'
			yhk_html += '<input type="hidden" name="data[yhk]" value="'+ allow_yhk +'">'
			yhk_html += '-'+allow_yhk
			yhk_html += '</span>'
			yhk_html += '</div>'
			yhk_html += '</div>'
			$("#yhk").html(yhk_html)
		}else{
			$("#yhk").html('')
		}
	}
</script>