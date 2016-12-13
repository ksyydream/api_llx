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
        <li class="li1">频道</li>
        <li class="li2">分类信息</li>
        <li class="li2 li3">分类管理</li>
    </ul>
</div>
<div class="main-jsgl main-sc">
    <p class="attention"><span>注意：</span>不需要启用的字段就不需要填写</p>
    <div class="jsglNr">
        <div class="selectNr" style="margin-top: 0px; border-top:none;">
            <div class="left">
                <?php echo BA('lifecate/create','','添加内容');?>  
            </div>
            <div class="right">
                <form method="post" action="<?php echo U('lifecate/index');?>">
                    <input type="text"  class="inptText" name="keyword" value="<?php echo ($keyword); ?>"  /><input type="submit" value="   搜索"  class="inptButton" />
                </form>
            </div>
        </div>
        <form  target="baocms_frm" method="post">
            <div class="tableBox">
                <table bordercolor="#e1e6eb" cellspacing="0" width="100%" border="1px"  style=" border-collapse: collapse; margin:0px; vertical-align:middle; background-color:#FFF;"  >
                    <tr>
                        <td class="w50"><input type="checkbox" class="checkAll" rel="cate_id" /></td>
                        <td class="w50">分类ID</td>
                        <td>所属频道</td>
                        <td>分类名称</td>
                        <td>信息数</td>
                        <td>文本字段1</td>
                        <td>文本字段2</td>
                        <td>文本字段3</td>
                        <td>数字字段1</td>
                        <td>数字字段2</td>
                        <td>单选字段1</td>
                        <td>单选字段2</td>
                        <td>单选字段3</td>
                        <td>单选字段4</td>
                        <td>单选字段5</td>

                        <td>操作</td>
                    </tr>
                    <?php if(is_array($list)): foreach($list as $key=>$var): ?><tr>
                            <td><input class="child_cate_id" type="checkbox" name="cate_id[]" value="<?php echo ($var["cate_id"]); ?>" /></td>
                            <td><?php echo ($var["cate_id"]); ?></td>
                            <td><?php echo ($channelmeans[$var['channel_id']]); ?></td>
                            <td><?php echo ($var["cate_name"]); ?></td>
                            <td><?php echo ($var["num"]); ?></td>
                            <td><?php echo ($var["text1"]); ?></td>
                            <td><?php echo ($var["text2"]); ?></td>
                            <td><?php echo ($var["text3"]); ?></td>
                            <td><?php echo ($var["num1"]); ?></td>
                            <td><?php echo ($var["num2"]); ?></td>
                            <td><?php echo ($var["select1"]); ?></td>
                            <td><?php echo ($var["select2"]); ?></td>
                            <td><?php echo ($var["select3"]); ?></td>
                            <td><?php echo ($var["select4"]); ?></td>
                            <td><?php echo ($var["select5"]); ?></td>

                            <td>

                                <?php if(($var["is_hot"]) == "0"): echo BA('lifecate/hots',array("cate_id"=>$var["cate_id"],'p'=>$p),'设为热门','act','remberBtn');?>
                        <?php else: ?>
                        <?php echo BA('lifecate/hots',array("cate_id"=>$var["cate_id"],'p'=>$p),'取消热门','act','remberBtn'); endif; ?>
                        <?php echo BA('lifecate/edit',array("cate_id"=>$var["cate_id"]),'编辑','','remberBtn');?>
                        <?php echo BA('lifecate/delete',array("cate_id"=>$var["cate_id"]),'删除','act','remberBtn');?>
                        <?php echo BA('lifecate/setting',array("cate_id"=>$var["cate_id"]),'配置分类','','remberBtn');?>
                        </td>
                        </tr><?php endforeach; endif; ?>
                </table>
                <?php echo ($page); ?>
            </div>
            <div class="selectNr" style="margin-bottom: 0px; border-bottom: none;">
                <div class="left">
                    <?php echo BA('lifecate/delete','','批量删除','list','a2');?>
                </div>
            </div>
        </form>
    </div>
</div>

     
        
</div>
</body>
</html>