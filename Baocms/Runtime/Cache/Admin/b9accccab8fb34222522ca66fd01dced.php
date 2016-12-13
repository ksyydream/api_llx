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
        <li class="li2 li3">分享列表</li>
    </ul>
</div>
<div class="main-jsgl main-sc">
    <p class="attention"><span>注意：</span>微型论坛，后期会扩展更多类似论坛插件的功能</p>
    <div class="jsglNr">
        <div class="selectNr" style="margin-top: 0px; border-top:none;">
            <div class="left">
                <?php echo BA('post/create','','添加内容');?>  
            </div>
            <div class="right">
                <form method="post" action="<?php echo U('post/index');?>">
                    <div class="seleHidden" id="seleHidden">
                        <span>分类</span>
                        <select id="cate_id" name="cate_id" class="select  w100">
                            <option value="0">请选择...</option>
                            <?php if(is_array($sharecate)): foreach($sharecate as $key=>$var): if(($var["parent_id"]) == "0"): ?><option value="<?php echo ($var["cate_id"]); ?>"  <?php if(($var["cate_id"]) == $cate_id): ?>selected="selected"<?php endif; ?> ><?php echo ($var["cate_name"]); ?></option>                
                                <?php if(is_array($sharecate)): foreach($sharecate as $key=>$var2): if(($var2["parent_id"]) == $var["cate_id"]): ?><option value="<?php echo ($var2["cate_id"]); ?>"  <?php if(($var2["cate_id"]) == $cate_id): ?>selected="selected"<?php endif; ?> > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($var2["cate_name"]); ?></option><?php endif; endforeach; endif; endif; endforeach; endif; ?>
                        </select>
                        <span>状态</span>

                        <select class="select w80" name="audit">
                            <option value="0"  >全部</option>
                            <option value="-1" <?php if(($audit) == "-1"): ?>selected="selected"<?php endif; ?> >等待审核</option>
                            <option value="1" <?php if(($audit) == "1"): ?>selected="selected"<?php endif; ?>>正常</option>
                        </select>
                        <span>  关键字：</span>   <input type="text" name="keyword" value="<?php echo (($keyword)?($keyword):''); ?>" class="inptText" /><input type="submit" class="inptButton" value="  搜索" />
                    </div>
                </form>
            </div>
        </div>
        <form  target="baocms_frm" method="post">
            <div class="tableBox">
                <table bordercolor="#e1e6eb" cellspacing="0" width="100%" border="1px"  style=" border-collapse: collapse; margin:0px; vertical-align:middle; background-color:#FFF;"  >
                    <tr>
                        <td class="w50"><input type="checkbox" class="checkAll" rel="post_id" /></td>
                        <td class="w50">ID</td>
                        <td>标题</td>
                        <td>用户</td>
                        <td>分类</td>
                        <td>浏览量</td>
                        <td>回复量</td>
                        <td>赞</td>
                        <td>创建时间</td>
                        <td>创建IP</td>
                        <td>审核</td>
                        <td>操作</td>
                    </tr>
					
                    <?php if(is_array($list)): foreach($list as $key=>$var): ?><tr>
                            <td><input class="child_post_id" type="checkbox" name="post_id[]" value="<?php echo ($var["post_id"]); ?>" /></td>
                            <td><?php echo ($var["post_id"]); ?></td>
                            <td><?php echo ($var["title"]); ?></td>
                            <td><?php echo ($users[$var['user_id']]['account']); ?>(<?php echo ($var["user_id"]); ?>)</td>
                            <td><?php echo ($sharecate[$var['cate_id']]['cate_name']); ?></td>
                            <td><?php echo ($var["views"]); ?></td>
                            <td><?php echo ($var["reply_num"]); ?></td>
                            <td><?php echo ($var["zan_num"]); ?></td>
                            <td><?php echo (date('Y-m-d H:i:s',$var["create_time"])); ?></td>
                            <td><?php echo ($var["create_ip"]); ?>(来自<?php echo ($var["create_ip_area"]); ?>)</td>
                            <td>
                        <?php if($var["audit"] == 1): ?><font style="color: green;">已审核</font>
                            <?php else: ?>
                            <font style="color: red;">待审核</font><?php endif; ?>
                        </td>
                        <td>
                            <?php echo BA('postreply/index',array("post_id"=>$var["post_id"]),'查看回复','','remberBtn');?>
                            <?php echo BA('post/edit',array("post_id"=>$var["post_id"]),'编辑','','remberBtn');?>
                            <?php echo BA('post/delete',array("post_id"=>$var["post_id"]),'删除','act','remberBtn');?>
                            <?php if(($var["audit"]) == "0"): echo BA('post/audit',array("post_id"=>$var["post_id"]),'审核','act','remberBtn'); endif; ?>

                        </td>
                        </tr><?php endforeach; endif; ?>
                </table>
                <?php echo ($page); ?>
            </div>
            <div class="selectNr" style="margin-bottom: 0px; border-bottom: none;">
                <div class="left">
                    <?php echo BA('post/delete','','批量删除','list','a2');?>
                    <?php echo BA('post/audit','','批量审核','list','remberBtn');?>
                </div>
            </div>
        </form>
    </div>
    
     
        
</div>
</body>
</html>