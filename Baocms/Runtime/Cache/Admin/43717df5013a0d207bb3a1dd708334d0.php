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
        <li class="li1">智慧小区</li>
        <li class="li2">小区贴吧</li>
        <li class="li2 li3">帖子列表</li>
    </ul>
</div>
<div class="main-jsgl main-sc">
    <p class="attention"><span>注意：</span>这里是小区贴吧管理、后台不能添加帖子，帖子请去前台添加，记住这个是硬删除、非软删除。</p>
    <div class="jsglNr">
        <div class="selectNr" style="margin-top: 0px; border-top:none;">
            <div class="left">
                
            </div>
            <div class="right">
                <form method="post" action="<?php echo U('communityposts/index');?>">
                    <div class="seleHidden" id="seleHidden">
                       
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
                        <td style="background-color: #F8F8F8;">所属小区</td>  
                        <td>标题</td>
                        <td>用户</td>    
                                  
                        <td>创建时间</td>
                        
                        <td>审核</td>
                        <td>操作</td>
                    </tr>
					
                    <?php if(is_array($list)): foreach($list as $key=>$var): ?><tr>
                            <td><input class="child_post_id" type="checkbox" name="post_id[]" value="<?php echo ($var["post_id"]); ?>" /></td>
                            <td><?php echo ($var["post_id"]); ?></td>
                            <td style="background-color: #F8F8F8;"><?php echo ($communitys[$var['community_id']]['name']); ?></td>
                            <td><?php echo ($var["title"]); ?></td>
                            <td><?php echo ($users[$var['user_id']]['nickname']); ?>(<?php echo ($var["user_id"]); ?>)</td>
                            
                            <td><?php echo (date('Y-m-d H:i:s',$var["create_time"])); ?></td>
                            
                            <td>
                        <?php if($var["audit"] == 1): ?><font style="color: green;">已审核</font>
                            <?php else: ?>
                            <font style="color: red;">待审核</font><?php endif; ?>
                        </td>
                        <td>
                            <?php echo BA('communitypostsreply/index',array("post_id"=>$var["post_id"]),'查看回复','','remberBtn');?>
                            <?php echo BA('communityposts/edit',array("post_id"=>$var["post_id"]),'编辑','','remberBtn');?>
                            <?php echo BA('communityposts/delete',array("post_id"=>$var["post_id"]),'删除','act','remberBtn');?>
                            <?php if(($var["audit"]) == "0"): echo BA('communityposts/audit',array("post_id"=>$var["post_id"]),'审核','act','remberBtn'); endif; ?>

                        </td>
                        </tr><?php endforeach; endif; ?>
                </table>
                <?php echo ($page); ?>
            </div>
            <div class="selectNr" style="margin-bottom: 0px; border-bottom: none;">
                <div class="left">
                    <?php echo BA('communityposts/delete','','批量删除','list','a2');?>
                    <?php echo BA('communityposts/audit','','批量审核','list','remberBtn');?>
                </div>
            </div>
        </form>
    </div>
    
     
        
</div>
</body>
</html>