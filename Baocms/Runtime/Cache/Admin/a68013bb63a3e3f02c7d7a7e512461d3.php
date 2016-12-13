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
        <li class="li1">家政</li>
        <li class="li2">家政管理</li>
        <li class="li2 li3">家政服务列表</li>
    </ul>
</div>
<div class="main-jsgl main-sc">
    <p class="attention"><span>注意：</span> </p>
    <div class="jsglNr">
        <div class="selectNr" style="margin-top: 0px; border-top:none;">
            <div class="left">
                <?php echo BA('housework/create','','添加家政内容可关联商家');?>
            </div>
            <div class="right">
                <form  method="post"  action="<?php echo U('housework/setting');?>"> 

                    <div class="seleHidden" id="seleHidden">
                        <div class="seleK">
                            <span>家政标题</span>
                            <input type="text"  class="inptText" name="keyword" value="<?php echo ($keyword); ?>"  />
                            <input type="submit" value=" 搜索"  class="inptButton" />
                        </div>
                    </div> 
                </form>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
        <form  target="baocms_frm" method="post">
            <div class="tableBox">
                <table bordercolor="#e1e6eb" cellspacing="0" width="100%" border="1px"  style=" border-collapse: collapse; margin:0px; vertical-align:middle; background-color:#FFF;"  >
                    <tr>

                        <td class="w50"><input type="checkbox" class="checkAll" rel="id" /></td>
                        <td class="w50">活动ID</td>  
                        <td>家政项目</td>
                        <td>商家名称</td>
                        <td class="w80">活动标题</td>
                        <td>活动图片</td>
                        <td>价格</td>
                        <td>工具</td>
                        <td>联系方式</td>
                        <td>操作</td>
                    <?php if(is_array($list)): foreach($list as $key=>$var): ?><tr>
                            <td><input class="child_id" type="checkbox" name="id[]" value="<?php echo ($var["id"]); ?>" /> </td>
                            <td><?php echo ($var["id"]); ?></td>
                            <td><?php echo ($cates[$var['cate_id']]['cate_name']); ?></td>
                            <td><?php echo ($shops[$var['shop_id']]['shop_name']); ?></td>
                            <td><?php echo ($var["title"]); ?></td>
                            <td><img src="__ROOT__/attachs/<?php echo (($var["photo"])?($var["photo"]):'default.jpg'); ?>" class="w120" /></td>
                            <td><?php echo round($var['price']/100,2);?>/<?php echo ($var["unit"]); ?></td>
                            <td><?php echo ($var["gongju"]); ?></td>
                        <td><?php echo ($var["user"]); ?>/<?php echo ($var["tel"]); ?></td>
                        <td>
     
                            <?php echo BA('housework/setting2',array("id"=>$var["id"]),'编辑','','remberBtn');?>
                            <?php echo BA('housework/delete2',array("id"=>$var["id"]),'删除','act','remberBtn');?>
                           、

                        </td>
                        </tr><?php endforeach; endif; ?>
                </table>
                <?php echo ($page); ?>
            </div>
            <div class="selectNr" style="margin-bottom: 0px; border-bottom: none;">
                <div class="left">
                    <?php echo BA('housework/delete2','','批量删除','list',' a2');?>
                </div>
            </div>

        </form>
    </div>
</div>

     
        
</div>
</body>
</html>