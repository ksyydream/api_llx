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
        <li class="li1">新功能</li>
        <li class="li2">分成管理</li>
        <li class="li2 li3">团购订单</li>
    </ul>
</div>
<div class="main-jsgl main-sc">
    <p class="attention"><span>注意：</span>管理员在此处理团购订单分成</p>
    <div class="jsglNr">
        <div class="selectNr" style="margin-top: 0px; border-top:none;">
            <div class="right">
                <form action="<?php echo U('profit/tuanorder');?>" method="post" >
                    <div class="seleHidden" id="seleHidden">
                        <span>状态</span>
                        <select name="status" class="selecttop w100">
                            <option value="-1">全部</option>
                            <option <?php if(($status) == "0"): ?>selected="selected"<?php endif; ?> value="0">待分成</option>
                            <option <?php if(($status) == "1"): ?>selected="selected"<?php endif; ?> value="1">已分成</option>
                            <option <?php if(($status) == "2"): ?>selected="selected"<?php endif; ?> value="2">已取消</option>
                        </select>
                        <input type="submit" value="   搜索"  class="inptButton" />
                    </div> 
                    <a style="display: inline-block;" href="#" class="searchG">高级搜索</a>
                </form>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
        <form>
            <form action="<?php echo U('profit/tuanorder');?>"  method="post" >
                <div class="selectNr selectNr2">
                    <div class="left">
                        <div class="seleK">
                            <label>
                                <span>开始时间</span>
                                <input type="text"    name="bg_date" value="<?php echo (($bg_date)?($bg_date):''); ?>"  onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd HH:mm:ss'});"  class="text w150" />
                                <span>结束时间</span>
                                <input type="text" name="end_date" value="<?php echo (($end_date)?($end_date):''); ?>" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd HH:mm:ss'});"  class="text w150" />
                            </label>
                            <label>
                                <span>用户</span>
                                <input type="hidden" id="user_id" name="user_id" value="<?php echo (($user_id)?($user_id):''); ?>" />
                                <input type="text" name="nickname" id="nickname"  value="<?php echo ($nickname); ?>"   class="text" />
                                <a  href="<?php echo U('user/select');?>" w="800" h="600" mini="select" class="sumit">选择用户</a>
                            </label>
                        </div>
                    </div>
                    <div class="right">
                        <input type="submit" value="   搜索"  class="inptButton" />
                    </div>
            </form>
            <div class="clear"></div>
    </div>
    <form  target="baocms_frm" method="post">         
        <div class="tableBox">
            <table bordercolor="#dbdbdb" cellspacing="0" width="100%" border="1px"  style=" border-collapse: collapse; margin:0px; vertical-align:middle; background-color:#FFF;"  >
                <tr>
                    <td class="w50">订单ID</td>
                    <td>用户</td>
                    <td>金额</td>
                    <td>创建时间</td>
                    <!--<td>创建IP</td>-->
                    <td style="background-color: #F8F8F8;">订单状态</td>
                    <td>操作状态</td>
                    <td>操作信息</td>
                    <td>操作</td>
                </tr>
                <?php if(is_array($list)): foreach($list as $key=>$var): ?><tr>
                        <td><?php echo ($var["order_id"]); ?></td>
                        <td><?php echo ($var["account"]); ?>(UID:<?php echo ($var["user_id"]); ?>)</td>
                        <td><?php echo round($var['total_price']/100,2);?></td>
                        <td><?php echo (date('Y-m-d H:i:s',$var["create_time"])); ?></td>
                       <!-- <td><?php echo ($var["create_ip"]); ?></td>-->
                        <td style="background-color: #F8F8F8;">
                            <?php if(($var["status"]) == "0"): ?>等待付款
                            <?php else: ?>
                                <?php if(($var["status"]) == "-1"): ?>到店付
                                <?php else: ?>
                                    已完成<?php endif; endif; ?>
                            <br/>
                             <?php $statuss = D('TuanCode') -> where('order_id ='.$var['order_id']) -> find(); $status = $statuss['status']; ?> 
                            <?php if($status == 1): ?><a style="color:#f60;">【退款中】</a><?php endif; ?>
                            <?php if($status == 2): ?><a style="color:#000;">【已退款】</a><?php endif; ?>
                        </td>
                        <td>
                            <?php switch($var["is_separate"]): case "0": ?>待分成<?php break;?>
                                <?php case "1": ?>已分成<?php break;?>
                                <?php case "2": ?>已撤消<?php break;?>
                                <?php case "3": ?>已取消<?php break; endswitch;?>
                        </td>
                        <td>
                            <?php if(($var["is_separate"]) == "2"): ?><del><?php endif; ?>
                            <?php if(is_array($profitLogs[$var['order_id']])): foreach($profitLogs[$var['order_id']] as $key=>$v): ?>用户ID: <?php echo ($v["user_id"]); ?>(<?php echo ($v["account"]); ?>), 分成: <?php echo round($v['money']/100, 2);?><br /><?php endforeach; endif; ?>
                            <?php if(($var["is_separate"]) == "2"): ?></del><?php endif; ?>
                        </td>
                        <td>
                            <?php if($var['is_separate'] == 0 and $var['fuid1'] > 0): echo BA('profit/ok',array("order_id"=>$var["order_id"]),'分成','act','remberBtn');?>
                                <?php echo BA('profit/cancel',array("order_id"=>$var["order_id"]),'取消','act','remberBtn');?>
                            <?php elseif($var['is_separate'] == 1): ?>
                                <?php echo BA('profit/rollback',array("order_id"=>$var["order_id"]),'撤消','act','remberBtn');?>
                            <?php else: ?>
                                -<?php endif; ?>
                        </td>
                    </tr><?php endforeach; endif; ?>
            </table>
            <?php echo ($page); ?>
        </div>
    </form>
</div>
</div>

     
        
</div>
</body>
</html>