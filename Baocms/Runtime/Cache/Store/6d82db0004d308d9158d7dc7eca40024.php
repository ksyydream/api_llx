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
<style>
.xiaoqu-search1 { margin-top:2rem;}
.list-media-x { margin-top: 0.0rem !important;}
.list-media-x p {margin-top: .01rem; line-height:20px;font-size: 12px;font-weight: normal;}
</style>

<script src="__PUBLIC__/js/my97/WdatePicker.js"></script>
	<header class="top-fixed bg-yellow bg-inverse">
		<div class="top-back">
			<a class="top-addr" href="<?php echo U('store/index/index');?>"><i class="icon-angle-left"></i></a>
		</div>
		<div class="top-title">
			全部订单
		</div>
		<div class="top-share">
        <a  href="javascript:void(0);" id="cate-btn" class="top-addr icon-chevron-down"> 添加</a>
		</div>
	</header>

     <div class="serch-bar-mask" id="cate_menu" style="display:none;top:50px;">
		<div class="serch-bar-mask-list">
			<ul>
            <li><a href="<?php echo U('store/goods/create');?>">添加商品</a></li>
            <li><a href="<?php echo U('store/mart/goodscate');?>">添加商品分类</a></li>
			</ul>
		</div>
	</div>
	<script>
		$(document).ready(function () {
			$("#cate-btn").click(function () {
				$("#cate_menu").toggle();
			});

			$("#cate_menu ul li a").click(function () {
				$("#cate_menu").toggle();
			});

		});
	</script>

<style>
/*搜索框开始*/
.right {float: right;}.fr {float: right;}.fl {float: left;}.mb10 {margin-bottom: 0.5rem !important;}
.xiaoqu-search1 {padding: 15px; background: #fafafa;border-bottom: thin solid #eee;}
.sh_search_box{}
.sh_search_int{ border:1px solid #dedede;  border-radius:3px;  position:relative; padding-left:0.3rem; background:#fff url(../img/search02.png) 0.1rem center no-repeat; background-size:0.2rem 0.2rem;}
.sh_search_int span{font-size:0.14rem; line-height:0.34rem; color:#333; margin:0px 0.05rem;}
.sh_search_int input{ height:0.34rem; background:none; border:none 0px; width:1.5rem;}
.sh_search_int .btn{ position:absolute; right:0; top:0; font-size:0.15rem;  width:0.5rem; border-left:1px solid #dedede; text-align:center; color:#2fbdaa;}

/*搜索框结束*/

/*商户中心-抢购优惠-抢购管理-订单管理*/
.sh_search_more_time .left{ width:49%;}
.sh_search_more_time .right{ width:49%;}
.sh_search_more_time .left input,.sh_search_more_time .right input{ width:100%; border:1px solid #dedede;  border-radius:3px; background-color:#fff; text-indent:0.3rem; padding: 0.5rem;}
.sh_search_more_int .left{ width:35%;}
.sh_search_more_int .center{ width:45%; position:relative; z-index:1;}
.sh_search_more_int .right{ width:20%; text-align:right;}
.sh_search_more_int .left input,.sh_search_more_int .center input{width:96%; border:1px solid #dedede; border-radius:3px; background-color:#fff;text-indent:0.3rem; padding: 0.5rem;}
.sh_search_more_int .center input{ background:#fff url(../img/buy_int_ico.png) no-repeat 90% center; background-size:0.11rem 0.07rem;}
.sh_search_more_pull{ position:absolute; left:0;  width:96%; background-color:#fff; border:1px solid #dedede; border-top:none 0px;}
.sh_search_more_pull li{ display:block; text-align:center; color:#666;padding: 0.8rem;}
.sh_search_more_int .right .btn{ background-color:#2fbdaa;  border-radius:3px; color:#fff;  border:none 0px;padding: 0.55rem 0.95rem;}

/*****/
</style>

   <script>
	$(function(){
		$(".sh_search_more_int .center").click(function(){
				$(this).find(".sh_search_more_pull").toggle();
		});
		$(".sh_search_more_pull li").click(function(){
				$(".sh_search_more_int .center input").val($(this).html());
				v = $(this).attr('v');
				$('#st').val(v);
		});
	});
</script>





	<div class="xiaoqu-search1">
		<form method="get" action="<?php echo U('mart/all');?>">
        <div class="sh_search_more">
            <div class="sh_search_more_time mb10">
                <div class="fl left"><input type="text" placeholder="开始时间" onBlur="if (!value) { value = defaultValue; this.style.color = '#999' }" onClick="if (value == defaultValue) { value = ''; this.style.color = '#000' }" name="bg_date" value="<?php echo (($bg_date)?($bg_date):''); ?>" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd HH:mm:ss'});"></div>
                <div class="fr right"><input type="text" placeholder="结束时间"  onBlur="if (!value) { value = defaultValue; this.style.color = '#999' }" onClick="if (value == defaultValue) { value = ''; this.style.color = '#000' }" name="end_date" value="<?php echo (($end_date)?($end_date):''); ?>" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd HH:mm:ss'});"></div>

                <div class="clear"></div>
            </div>
            <div class="sh_search_more_int">
                <div class="fl left"><input type="text" placeholder="订单编号" name="keyword" value="<?php echo ($keyword); ?>" ></div>
                <div class="fl center">
                	<input type="text" value="状态"> <input value="" name="st" id="st" type="hidden" />
                    <div class="sh_search_more_pull" style="display:none;">
                        <ul>
                            <li v="0">等待付款</li>
                            <li v="8">已完成</li>
                        </ul>
                    </div>
                </div>
                <div class="fr right"><input class="btn" type="submit" value="搜索"></div>
                <div class="clear"></div>
            </div>
        </div>
        </form>
	</div>

 <style>ul { padding-left: 0px;}</style>
<!-- 筛选TAB -->
<ul id="shangjia_tab">
        <li style="width:50%;" ><a href="<?php echo U('mart/index');?>">商城商品</a></li>
        <li style="width:50%;"><a href="<?php echo U('mart/all');?>"  class="on">全部订单</a></li>
</ul>


<div class="list-media-x" id="list-media">
	<ul>
    <div class="blank-10 bg"></div>

    <?php if(is_array($list)): foreach($list as $key=>$order): ?><li class="line" <?php if(($order["is_daofu"]) == "1"): ?>style="background:#FFE5E5"<?php endif; ?> >
      <dt><a class="x4">订单ID：<?php echo ($order["order_id"]); ?></a><a class="x8 text-right">交易时间：<?php echo (date('Y-m-d H:i:s',$order["create_time"])); ?> </a></dt>

    <?php if(is_array($goods)): foreach($goods as $key=>$good): if(($good["order_id"]) == $order["order_id"]): ?><!--循环商品开始-->
      <dd class="zhong">
        <div class="x2">
               <img src="__ROOT__/attachs/<?php echo ($products[$good['goods_id']]['photo']); ?>"  style="width:90%;">
         </div>
         <div class="10">
            <p class="text-gray">名称<?php echo ($order['use_integral']); ?>：<?php echo ($products[$good['goods_id']]['title']); ?></p>
            <p class="text-gray">单价：<?php echo round($good['price']/100,2);?> * <?php echo ($good['num']); ?> = <?php echo round($good['total_price']/100,2);?></p>
            <p class="text-gray"><?php if($order['status'] != 0 && $order['is_daofu'] != 0): echo ($goodtypes[$good['status']]); endif; ?></p>
         </div>
      </dd><?php endif; endforeach; endif; ?>
     <!--循环商品开始-->




      <!--如果不是到付就显示-->
      <dt>
         <div class="x12">
          <p class="text-small">总价：<?php echo round($order['total_price']/100,2);?>
           <?php if($order['use_integral'] > 0): ?>- 秀币抵现：<?php echo round($order['use_integral']/100,2);?>元（消耗<?php echo ($order['use_integral']); ?>秀币）<?php endif; ?>
           <?php if($order['mobile_fan'] > 0): ?>-手机优惠：<?php echo round($order['mobile_fan']/100,2);?>元<?php endif; ?>
           =实付金额：<a class="text-dot"><?php echo round($order['need_pay']/100,2);?></a>元
           </p>
         </div>
      </dt>

      <!--信息end-->


     <!--收货地址开始-->
      <!--<dt>-->
         <!--<div class="x12">-->
           <!--<p class="text-gray">买家姓名：<?php echo ($users[$order['user_id']]['account']); ?></p>-->

           <!--<p class="text-gray">收货地址：-->
           <!--<?php echo ($citys[$addrs[$order['addr_id']]['city_id']]['name']); ?>- -->
           <!--<?php echo ($areas[$addrs[$order['addr_id']]['area_id']]['area_name']); ?>- -->
           <!--<?php echo ($business[$addrs[$order['addr_id']]['business_id']]['business_name']); ?>- -->
           <!--<?php echo ($addrs[$order['addr_id']]['addr']); ?>- -->
           <!--<?php echo ($addrs[$order['addr_id']]['name']); ?>- -->
           <!--<?php echo ($addrs[$order['addr_id']]['mobile']); ?></p>-->


         <!--</div>-->
      <!--</dt>-->
      <!--地址end-->
      <dl>
        <p class="text-right padding-top x12">
        <?php if(($order["is_mobile"]) == "1"): ?><a class="button button-small bg-main">手机订单</a><?php endif; ?>

 		<?php if(($order["is_daofu"]) == "1"): ?><a class="button button-small bg-blue">货到付款</a>
        <?php else: ?>
        <a class="button button-small bg-dot"><?php echo ($types[$order['status']]); ?></a><?php endif; ?>

       <!--配送逻辑代码开始-->
       <?php $delivery_id = D('DeliveryOrder')->where('type_order_id ='.$order['order_id'].' and type =0')->getField('delivery_id'); $delivery_user = D('Delivery')->where($delivery_id)->find(); $is_pei = D('DeliveryOrder')->where('type_order_id ='.$order['order_id'].' and type =0')->find(); $delivery_status = $is_pei['status']; ?>
      <!--配送逻辑代码结束-->


        <?php if(!empty($delivery_id)): ?><a id="is_pei<?php echo ($order["order_id"]); ?>" class="button button-small bg-yellow">配送员资料</a>
                    <script type="text/javascript">
                    $('#is_pei<?php echo ($order["order_id"]); ?>').mouseover(function(){
						var n = '<?php echo ($delivery_user["name"]); ?>';
						var m = '<?php echo ($delivery_user["mobile"]); ?>';
						layer.tips('配送员姓名：'+n+'<br>电话：'+m+'',$(this),{
						 tips: [2, '#7a7a7a']
						});
					})
                    </script><?php endif; ?>
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