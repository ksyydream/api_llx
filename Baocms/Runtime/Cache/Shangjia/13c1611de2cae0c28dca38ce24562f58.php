<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>商家管理中心-<?php echo ($CONFIG["site"]["title"]); ?></title>
<meta name="description" content="<?php echo ($CONFIG["site"]["title"]); ?>商户中心" />
<meta name="keywords" content="<?php echo ($CONFIG["site"]["title"]); ?>商户中心" />
<link href="__TMPL__statics/css/newstyle.css" rel="stylesheet" type="text/css" />
 <link href="__PUBLIC__/js/jquery-ui.css" rel="stylesheet" type="text/css" />
<script>
var BAO_PUBLIC = '__PUBLIC__'; var BAO_ROOT = '__ROOT__';
</script>
<script src="__PUBLIC__/js/jquery.js"></script>
<script src="__PUBLIC__/js/jquery-ui.min.js"></script>
<script src="__PUBLIC__/js/web.js"></script>
<script src="__PUBLIC__/js/layer/layer.js"></script>

</head>

<body>
<iframe id="baocms_frm" name="baocms_frm" style="display:none;"></iframe>
<div class="sjgl_lead">
    <ul>
        <li><a href="#">系统设置</a> > <a href="">评价管理</a> > <a>点评管理</a></li>
    </ul>
</div>
<div class="tuan_content">
    <div class="radius5 tuan_top">
        <div class="tuan_top_t tuanfabu_top">
            <div class="left tuan_topser_l">如果收到恶意评价，可以联系网站客服：<?php echo ($CONFIG["site"]["tel"]); ?></div>
        </div>
    </div>
    <div class="tuanfabu_tab">
        <ul>
            <li class="tuanfabu_tabli on"><a href="<?php echo U('dianping/index');?>">商家点评</a></li>
            <!--<li class="tuanfabu_tabli"><a href="<?php echo U('dianping/tuan');?>">抢购点评</a></li>-->
            <?php if($open_mall == '1' ): ?><li class="tuanfabu_tabli"><a href="<?php echo U('dianping/mall');?>">商城点评</a></li><?php endif; ?>
            <!--<li class="tuanfabu_tabli"><a href="<?php echo U('dianping/waimai');?>">外卖点评</a></li>-->
            <!--<?php if($open_ding == '1' ): ?>-->
            <!--<li class="tuanfabu_tabli"><a href="<?php echo U('dianping/ding');?>">订座点评</a></li>-->
            <!--<?php endif; ?>-->
        </ul>
    </div> 
    
      <table class="tuan_table3" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr style="background-color:#F9F9F9;">
            <td width="10%">编号</td>
            <td width="20%">用户</td>
            <td width="5%">评分</td>
            <td width="5%">平均花费</td>
            <td width="30%">评价时间</td>
            <td width="20%">评价IP</td>
            <td width="10%">生效日期</td>
    </table>
    
    <?php if(is_array($list)): foreach($list as $key=>$var): ?><table class="dianping" width="100%" border="0">
      <tr class="tr_dianping_1">
        <td class="td_dianping_1"><?php echo ($var["dianping_id"]); ?></td>
        <td class="td_dianping_2"><?php echo ($users[$var['user_id']]['nickname']); ?>(ID:<?php echo ($var["user_id"]); ?>)</td>
        <td class="td_dianping_3"><?php echo ($var["score"]); ?></td>
        <td class="td_dianping_4"><?php echo ($var["cost"]); ?></td>
        <td class="td_dianping_5"><?php echo (date('Y-m-d H:i:s',$var["create_time"])); ?></td>
        <td class="td_dianping_6"><?php echo ($var["create_ip"]); ?>(来自<?php echo ($var["create_ip_area"]); ?>)</td>
        <td class="td_dianping_7"><?php echo ($var["show_date"]); ?></td>
      </tr>
      <tr class="tr_dianping_2">
        
        <td class="td_dianping_12" colspan="2">
        
        <?php $shop = D('Shop') -> where('shop_id ='.$var['shop_id']) -> find(); ?> 
         <!--商品展示开始-->
        <div class="index__production___yfP3y" >
        <a  target="_blank"  href="<?php echo U('pchome/shop/detail',array('shop_id'=>$shop['shop_id']));?>" class="index__pic___TScfk" >
        <img src="__ROOT__/attachs/<?php echo ($shop['photo']); ?>" ><span></span></a>
        <div class="index__infos___A6XLq" >
            <p ><a href="<?php echo U('pchome/shop/detail',array('shop_id'=>$shop['shop_id']));?>" target="_blank" ><span ></span><span><?php echo ($shop['shop_name']); ?></span><span ></span></a><span></span><span></span></p>
            <span></span>
            <p></p>
            <span></span>
        	</div>
		</div>
       <!--商品展示END-->
        
        </td>
        <td class="td_dianping_9" colspan="3">
        
        
        点评内容：<?php echo ($var["contents"]); ?>
        	<br/><br/>
            <?php if(!empty($var['pichave'])): if(is_array($pics)): foreach($pics as $key=>$item): if($var['order_id'] == $item['order_id']): ?><a target="_blank" href="__ROOT__/attachs/<?php echo ($item['pic']); ?>"><img src="__ROOT__/attachs/<?php echo ($item['pic']); ?>" width="60"/></a><?php endif; endforeach; endif; endif; ?>
        
        </td>
        <td class="td_dianping_10" colspan="2"><?php if(!empty($var['reply'])): ?><span style="color:#F00">商家回复：<?php echo ($var["reply"]); ?></span><?php else: ?><a mini="load" h="400" w="500"  class="td_btn" href="<?php echo U('dianping/reply',array('dianping_id'=>$var['dianping_id']));?>">点击回复</a><?php endif; ?></td>
      </tr>
      
      
      
    </table><?php endforeach; endif; ?>
    <br/>
    
    
  
    <?php echo ($page); ?>
</div>


<script>
function require() {
      var url = "{U('order1/checkNotify')}";
        　　
      $.get(url,null,function(data) {
        　　　　　　
            // 如果获得的数据不为空，则显示提醒
           if ($.trim(data) != '') {

               // 这里写提醒的方式
        　　　　alert('您有新订单来了，还在测试');
           }
      });

      // 每三秒请求一次
      setTimeout('require()',3000);
}
</script>
<!--<body onload="javascript:return require();">-->
</html>