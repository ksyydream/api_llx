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
        <li class="li1">商家</li>
        <li class="li2">商家点评</li>
        <li class="li2 li3">发布点评</li>
    </ul>
</div>
<div class="main-jsgl main-sc">
    <p class="attention"><span>注意：</span>点评在生效日期生效后其他用户才能看到</p>
    <div class="jsglNr">
        <div class="selectNr" style="margin-top: 0px; border-top:none;">
            <div class="left">
                <?php echo BA('shopdianping/create','','添加点评');?>
            </div>
            <div class="right">
                <form class="search_form" method="post" action="<?php echo U('shopdianping/index');?>">
                    <div class="seleHidden" id="seleHidden">
                        <div class="seleK">
                            <label>
                                <input type="hidden" id="shop_id" name="shop_id" value="<?php echo (($shop_id)?($shop_id):''); ?>"/>
                                <input type="text"   id="shop_name" name="shop_name" value="<?php echo ($shop_name); ?>" class="text" />
                                <a mini="select"  w="1000" h="600" href="<?php echo U('shop/select');?>" class="sumit">选择商家</a>
                            </label>
                            <label>
                                <input type="hidden" id="user_id" name="user_id" value="<?php echo (($user_id)?($user_id):''); ?>"/>
                                <input type="text"   id="nickname" name="nickname" value="<?php echo ($nickname); ?>" class="text" />
                                <a mini="select"  w="1000" h="600" href="<?php echo U('user/select');?>" class="sumit">选择用户</a>
                                <input style="float: right;" type="submit" value="   搜索"  class="inptButton" />
                            </label>
                        </div>
                    </div> 
                </form>
                <div class="clear"></div>
            </div>
        </div>
        <form  target="baocms_frm" method="post">
            <div class="tableBox">
                <table bordercolor="#e1e6eb" cellspacing="0" width="100%" border="1px"  style=" border-collapse: collapse; margin:0px; vertical-align:middle; background-color:#FFF;"  >
                    <tr>
                        <td class="w50"><input type="checkbox" class="checkAll" rel="dianping_id" /></td>
                        <td class="w50">ID</td>
                        <td>用户</td>
                        <td>商家</td>
                        <td>评分</td>
                        <td>平均花费</td>
                        <td>创建时间</td>
                        <td>创建IP</td>
                        <td>生效日期</td>
                        <td>操作</td>
                    </tr>
                    <?php if(is_array($list)): foreach($list as $key=>$var): ?><tr>
                            <td><input class="child_dianping_id" type="checkbox" name="dianping_id[]" value="<?php echo ($var["dianping_id"]); ?>" /></td>
                            <td><?php echo ($var["dianping_id"]); ?></td>
                            <td><?php echo ($users[$var['user_id']]['account']); ?>(ID:<?php echo ($var["user_id"]); ?>)</td>
                            <td><?php echo ($shops[$var['shop_id']]['shop_name']); ?></td>
                            <td><?php echo ($var["score"]); ?></td>
                            <td><?php echo ($var["cost"]); ?></td>
                            <td><?php echo (date('Y-m-d H:i:s',$var["create_time"])); ?></td>
                            <td><?php echo ($var["create_ip"]); ?>(来自<?php echo ($var["create_ip_area"]); ?>)</td>
                            <td><?php echo ($var["show_date"]); ?></td>
                            <td>
                                <?php echo BA('shopdianping/edit',array("dianping_id"=>$var["dianping_id"]),'编辑','','remberBtn');?>
                                <?php echo BA('shopdianping/delete',array("dianping_id"=>$var["dianping_id"]),'删除','act','remberBtn');?>
                            </td>
                        </tr><?php endforeach; endif; ?>
                </table>
                <?php echo ($page); ?>
            </div>
            <div class="selectNr" style="margin-bottom: 0px; border-bottom: none;">
                <div class="left">
                    <?php echo BA('shopdianping/delete','','批量删除','list',' a2');?>
                </div>
            </div>
        </form>
    </div>
</div>

     
        
</div>
</body>
</html>