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
        <li class="li1">功能</li>
        <li class="li2">消费分享</li>
        <li class="li2 li3">回复帖子</li>
    </ul>
</div>
<div class="main-jsgl main-sc">
    <p class="attention"><span>注意：</span> 可以在后台模拟用户回复，JUST 你懂的！</p>
    <div class="jsglNr">
        <div class="selectNr" style="margin-top: 0px; border-top:none;">
            <div class="left">
                <?php echo BA('postreply/create','','添加内容');?>  
            </div>
            <div class="right">
                <form method="post" action="<?php echo U('postreply/index');?>">
                    <div class="seleHidden" id="seleHidden">
                        <span>帖子ID</span>
                        <input type="text" name="post_id" value="<?php echo (($post_id)?($post_id):''); ?>" class="inptText w120" />
                        <span>状态</span>
                        <select class="select w120" name="audit">
                            <option value="0"  >全部</option>
                            <option value="-1" <?php if(($audit) == "-1"): ?>selected="selected"<?php endif; ?> >等待审核</option>
                            <option value="1" <?php if(($audit) == "1"): ?>selected="selected"<?php endif; ?>>正常</option>
                        </select>
                        <span>  用户ID：</span>   <input type="text" name="user_id" value="<?php echo (($user_id)?($user_id):''); ?>" class="inptText w150" />
                        <input type="submit" class="inptButton" value="  搜索" />
                    </div>
                </form>
            </div>
        </div>
        <form  target="baocms_frm" method="post">
            <div class="tableBox">
                <table bordercolor="#e1e6eb" cellspacing="0" width="100%" border="1px"  style=" border-collapse: collapse; margin:0px; vertical-align:middle; background-color:#FFF;"  >
                    <tr>
                        <td class="w50"><input type="checkbox" class="checkAll" rel="reply_id" /></td>
                        <td class="w50">ID</td>
                        <td>帖子</td>
                        <td>用户</td>
                        <td>创建时间</td>
                        <td>创建IP</td>
                        <td>是否审核</td>
                        <td>操作</td>
                    </tr>
                    <?php if(is_array($list)): foreach($list as $key=>$var): ?><tr>
                            <td><input class="child_reply_id" type="checkbox" name="reply_id[]" value="<?php echo ($var["reply_id"]); ?>" /></td>
                            <td><?php echo ($var["reply_id"]); ?></td>
                            <td><?php echo ($posts[$var['post_id']]['title']); ?></td>
                            <td><?php echo ($users[$var['user_id']]['account']); ?>(<?php echo ($var["user_id"]); ?>)</td>
                            <td><?php echo (date("Y-m-d H:i:s",$var["create_time"])); ?></td>
                            <td><?php echo ($var["create_ip"]); ?>(<?php echo ($var["create_ip_area"]); ?>)</td>
                            <td>
                        <?php if($var["audit"] == 1): ?><font style="color: green;">已审核</font>
                            <?php else: ?>
                            <font style="color: red;">待审核</font><?php endif; ?>
                        </td>
                        <td>
                            <?php echo BA('postreply/edit',array("reply_id"=>$var["reply_id"]),'编辑','','remberBtn');?>
                            <?php echo BA('postreply/delete',array("reply_id"=>$var["reply_id"]),'删除','act','remberBtn');?>
                            <?php if(($var["audit"]) == "0"): echo BA('postreply/audit',array("reply_id"=>$var["reply_id"]),'审核','act','remberBtn'); endif; ?>
                        </td>
                        </tr><?php endforeach; endif; ?>
                </table>
                <?php echo ($page); ?>
            </div>
            <div class="selectNr" style="margin-bottom: 0px; border-bottom: none;">
                <div class="left">
                    <?php echo BA('postreply/delete','','批量删除','list','a2');?>
                    <?php echo BA('postreply/audit','','批量审核','list','remberBtn');?>
                </div>
            </div>
        </form>
    </div>
    
     
        
</div>
</body>
</html>