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
			<a class="top-addr" href="<?php echo U('index/index');?>"><i class="icon-angle-left"></i></a>
		</div>
		<div class="top-title">
			文章管理
		</div>
		<div class="top-share">
        <a href="<?php echo U('news/create');?>" class="top-addr icon-plus"> 增加</a>
		</div>
	</header>
<style>
.button-toolbar .button-group {padding: 0 10px;}
.list-media-x { margin-top: 0.0rem;}
.list-media-x p {margin-top: 0.0rem;}
</style>




<div class="line xiaoqu-search">
		<form method="post"  action="<?php echo U('news/index');?>" id="form1" class="form1">
			<div class="form-group">
				<div class="field">
					<div class="input-group">
						<span class="addbtn"><button type="button" class="button icon-search"></button></span>
						<input type="text" class="input" name="keyword" size="50" value="<?php echo ($keyword); ?>" placeholder="请输入关键字"  />
						<span class="addbtn"><button type="submit" class="button">搜索</button></span>
					</div>
				</div>
			</div>
		</form>
	</div>




<div class="blank-10 bg"></div>
<div class="list-media-x" id="list-media">

	<ul>

<?php if(is_array($list)): foreach($list as $key=>$var): ?><li class="line ">
      <dt><a class="x3">文章ID：<?php echo ($var["article_id"]); ?></a><a class="x9 text-right">分类：<?php echo ($cates[$var['cate_id']]['cate_name']); ?></a></dt>
        
      <dd class="zhong">
         <div class="12">
            <p class="text-small">标题：<?php echo ($var["title"]); ?></p>
            <p class="text-small">作者：<?php echo ($var['source']); ?>&nbsp;&nbsp;城市：<?php echo ($citys[$var['city_id']]['name']); ?>&nbsp;&nbsp;浏览：<?php echo ($var["views"]); ?>次</p>
            <p class="text-small">关键字：<?php echo ($var['keywords']); ?></p>
            <p class="text-small">发布日期：<?php echo (date('Y-m-d H:i:s ',$var["create_time"])); ?></a></p>
         </div>
      </dd>
       
      <dl>
         <p class="text-right x12"> 
         <?php if(($var["audit"]) == "0"): ?><a class="button button-small bg-gray">等待审核</a>
         <?php else: ?>
         <a class="button button-small bg-dot">正常</a>
         <a class="button button-small bg-dot" href="<?php echo U('mobile/news/detail',array('article_id'=>$var['article_id']));?>">详细</a><?php endif; ?>
         <a class="button button-small bg-dot" href="<?php echo U('news/edit',array('article_id'=>$var['article_id']));?>">编辑</a>
         <a  href="javascript:void(0);" rel="<?php echo ($var["article_id"]); ?>"  class="jquery-delete button button-small  margin-top bg-blue">删除</a>
         </p>
      </dl>
    </li>
 
    <div class="blank-10 bg"></div><?php endforeach; endif; ?>    
  </ul>
</div> 

<div class="blank-20"></div>
<div class="container login-open">
<h5 style="text-align:center"><?php echo ($page); ?><!--分页代码不要忘记加--> </h5>
</div>
<script>
	$(document).ready(function () {
		$(document).on('click', ".jquery-delete", function (e) {
			var article_id = $(this).attr('rel');
			layer.confirm('您确定要删除该文章？', {
				skin: 'layer-ext-demo', 
				area: ['50%', 'auto'], //宽高
				btn: ['是的', '不'], //按钮
				shade: false //不显示遮罩
			}, function () {
				$.post("<?php echo U('news/delete');?>", {article_id: article_id}, function (result) {
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