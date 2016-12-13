<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo ($CONFIG["site"]["title"]); ?>管理后台</title>
        <meta name="description" content="<?php echo ($CONFIG["site"]["title"]); ?>管理后台" />
        <meta name="keywords" content="<?php echo ($CONFIG["site"]["title"]); ?>管理后台" />
        <!-- <link href="__TMPL__statics/css/index.css" rel="stylesheet" type="text/css" /> -->
        <link href="__TMPL__statics/css/style.css" rel="stylesheet" type="text/css" />
        <link href="__TMPL__statics/css/land.css" rel="stylesheet" type="text/css" />
        <link href="__TMPL__statics/css/pub.css" rel="stylesheet" type="text/css" />
        <link href="__TMPL__statics/css/main.css" rel="stylesheet" type="text/css" />
        <link href="__PUBLIC__/js/jquery-ui.css" rel="stylesheet" type="text/css" />
        <script> var BAO_PUBLIC = '__PUBLIC__'; var BAO_ROOT = '__ROOT__'; </script>
        <script src="__PUBLIC__/js/jquery.js"></script>
        <script src="__PUBLIC__/js/jquery-ui.min.js"></script>
        <script src="__PUBLIC__/js/my97/WdatePicker.js"></script>
        <script src="/Public/js/layer/layer.js"></script>
        <script src="__PUBLIC__/js/admin.js?v=20150409"></script>
    </head>
    
    
    </head>


<!--[if lte IE 9]>
<div id="ie9-warning">您正在使用 Internet Explorer 9以下的版本，请用谷歌浏览器访问后台、部分浏览器可以开启极速模式访问！不懂点击这里！ <a href="http://www.abc.com/10478.html" target="_blank">查看为什么？</a>
</div>
<script type="text/javascript">
function position_fixed(el, eltop, elleft){  
       // check if this is IE6  
       if(!window.XMLHttpRequest)  
              window.onscroll = function(){  
                     el.style.top = (document.documentElement.scrollTop + eltop)+"px";  
                     el.style.left = (document.documentElement.scrollLeft + elleft)+"px";  
       }  
       else el.style.position = "fixed";  
}
       position_fixed(document.getElementById("ie9-warning"),0, 0);
</script>
<![endif]-->


    <body>
         <iframe id="baocms_frm" name="baocms_frm" style="display:none;"></iframe>
   <div class="main">
<div class="mainBt">
    <ul>
        <li class="li1">餐饮管理</li>
        <li class="li2">订单管理</li>
    </ul>
</div>
<div class="main-jsgl main-sc">
    <div class="jsglNr">
        <div class="selectNr" style="border-top: none; margin-top: 0px;">
            <div class="right">
                <form method="post" action="<?php echo U('eleorder/index');?>">
                    <div class="seleHidden" id="seleHidden">
                        <div class="seleK">
                            <label>
                                <input type="hidden" id="shop_id" name="shop_id" value="<?php echo (($shop_id)?($shop_id):''); ?>"/>
                                <input type="text"   id="shop_name" name="shop_name" value="<?php echo ($shop_name); ?>" class="text " />
                                <a mini="select"  w="1000" h="600" href="<?php echo U('shop/select');?>" class="sumit">选择商家</a>
                            </label>
                            <label>
                                <input type="hidden" id="user_id" name="user_id" value="<?php echo (($user_id)?($user_id):''); ?>" />
                                <input type="text" name="nickname" id="nickname"  value="<?php echo ($nickname); ?>"   class="text " />
                                <a mini="select"  w="800" h="600" href="<?php echo U('user/select');?>" class="sumit">选择用户</a>
                            </label>
                            <label>
                                <span>状态：</span>
                                <select class="select w120" name="st">
                                    <option <?php if(($st) == "999"): ?>selected="selected"<?php endif; ?> value="999">请选择</option>
                                    <option <?php if(($st) == "0"): ?>selected="selected"<?php endif; ?>  value="0">等待付款</option>
                                    <option <?php if(($st) == "1"): ?>selected="selected"<?php endif; ?>  value="1">等待审核</option>
                                    <option <?php if(($st) == "2"): ?>selected="selected"<?php endif; ?>  value="2">正在配送</option>
                                    <option <?php if(($st) == "3"): ?>selected="selected"<?php endif; ?>  value="2">等待退款</option>
                                    <option <?php if(($st) == "4"): ?>selected="selected"<?php endif; ?>  value="2">退款完成</option>
                                    <option <?php if(($st) == "8"): ?>selected="selected"<?php endif; ?>  value="8">已完成</option>
                                </select>
                            </label>
                            <label>
                                <span>  订单ID：</span>   <input type="text" name="order_id" value="<?php echo (($order_id)?($order_id):''); ?>" class="inptText" /><input type="submit" class="inptButton" value="搜索" /></label>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <form  target="baocms_frm" method="post">
            <div class="tableBox">
                <table bordercolor="#e1e6eb" cellspacing="0" width="100%" border="1px"  style=" border-collapse: collapse; margin:0px; vertical-align:middle; background-color:#FFF;"  >
                    <tr>
                        <td class="w50"><input type="checkbox" class="checkAll" rel="order_id" /></td>
                        <td class="w50">ID</td>
                        <td>商家</td>
                        <td>用户</td>
                        <td>地址</td>
                        <td>订单金额</td>
                        <td>支付金额</td>
                        <td>数量</td>
                        <!--<td>减多少钱</td>
                        <td>返利金额</td>
                        <td>结算价格</td>-->
                        <td>状态</td>
                        <td>支付方式</td>
                        <td>创建时间</td>
                        <td>操作</td>
                    </tr>
                    <?php if(is_array($list)): foreach($list as $key=>$var): ?><tr>
                            <td><input class="child_order_id" type="checkbox" name="order_id[]" value="<?php echo ($var["order_id"]); ?>" /></td>
                            <td><?php echo ($var["order_id"]); ?></td>
                            <td><?php echo ($shops[$var['shop_id']]['shop_name']); ?></td>
                            <td><?php echo ($users[$var['user_id']]['nickname']); ?></td>
                            <td><?php echo ($areas[$addrs[$var['addr_id']]['area_id']]['area_name']); ?>、
                                <?php echo ($business[$addrs[$var['addr_id']]['business_id']]['business_name']); ?>、
                                <?php echo ($addrs[$var['addr_id']]['addr']); ?>
                                <br/>
                                <?php echo ($addrs[$var['addr_id']]['name']); ?>
                                <?php echo ($addrs[$var['addr_id']]['mobile']); ?></td>
                            <td><?php echo round($var['total_price']/100,2);?></td>
                            <td><?php echo round($var['need_pay']/100,2);?></td>
                            <td><?php echo ($var["num"]); ?></td>
                            <!--<td><?php echo round($var['new_money']/100,2);?></td>
                            <td><?php echo round($var['fan_money']/100,2);?></td>
                            <td><?php echo round($var['settlement_price']/100,2);?></td>-->
                            <td><?php echo ($cfg[$var['status']]); ?></td>
                            <td><?php if($var['is_pay'] == 0): ?>餐到付款 <?php else: ?>在线支付<?php endif; ?></td>
                        <td><?php echo (date("Y-m-d H:i:s",$var["create_time"])); ?></td>
                        <td>
                        <?php if($var['status'] >= 4): echo BA('eleorder/delete',array("order_id"=>$var["order_id"]),'删除订单','act','remberBtn'); endif; ?>
                        <?php if($var['status'] == 3): echo BA('eleorder/tui',array("order_id"=>$var["order_id"]),'同意退款','act','remberBtn'); endif; ?>
                        </td>
                        </tr><?php endforeach; endif; ?>
                </table>
                <?php echo ($page); ?>
            </div>
            <div class="selectNr" style="margin-bottom: 0px; border-bottom: none;">
                <div class="left">
                    <?php echo BA('eleorder/delete','','批量取消订单','list','a2');?>
                </div>
            </div>
        </form>
    </div>
</div>

     
        
</div>
</body>
</html>