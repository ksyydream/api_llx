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
        <li class="li2"> 广告</li>
      
    </ul>
</div>
<div class="main-jsgl main-sc">
    <p class="attention"><span>注意：</span>广告删除是软删除,图片广告需要上传图片，代码广告可以不用上传图片，文字广告不需要填写图片和代码两项！</p>
    <div class="jsglNr">
        <div class="selectNr" style="margin-top: 0px; border-top:none;">
            <div class="left">
         <?php echo BA('ad/create',array('site_id'=>$site_id),'添加内容');?>
            </div>
            <div class="right">
                <form class="" method="post"  action="<?php echo U('plugin/index');?>"> 

                    <div class="seleHidden" id="seleHidden">
                        <span>搜索</span>
                        <input type="text"  class="inptText" name="keyword" value="<?php echo ($keyword); ?>"  />

                        <input type="submit" value=" 搜索"  class="inptButton" />
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
                <td><input type="checkbox" class="checkAll" rel="ad_id" /></td>
                  <td>ID</td>
                <td>所属广告位</td>
                <td>所属城市</td>
                <td>广告名称</td>
                <td>链接地址</td>
                <td>开始时间</td>
                <td>结束时间</td>
                <td>排序</td>
                <td>操作</th

                    </tr>
                    <?php if(is_array($list)): foreach($list as $key=>$var): ?><tr>
                    <td><input class="child_ad_id" type="checkbox" name="ad_id[]" value="<?php echo ($var["ad_id"]); ?>" /> </td>
                    <td><?php echo ($var["ad_id"]); ?></td>
                    <td><?php echo ($sites[$var['site_id']]['site_name']); ?></td>
                    <td><?php echo (($citys[$var['city_id']]['name'])?($citys[$var['city_id']]['name']):'通用'); ?></td>
                    <td><?php echo ($var["title"]); ?></td>
                    <td><?php echo ($var["link_url"]); ?></td>
                    <td><?php echo ($var["bg_date"]); ?></td>
                    <td><?php echo ($var["end_date"]); ?></td>
                    <td><?php echo ($var["orderby"]); ?></td>
                    <td>
                        <?php echo BA('ad/edit',array("ad_id"=>$var["ad_id"]),'编辑','','remberBtn');?>
                        <?php echo BA('ad/delete',array("ad_id"=>$var["ad_id"]),'删除','act','remberBtn');?>
                    </td>
                </tr><?php endforeach; endif; ?>
                    <tr>
                        <td colspan="20">

                            <?php echo BA('ad/delete','','批量删除','list',' piliangcaozuo');?>

                        </td>
                    </tr>
                </table>
                <?php echo ($page); ?>

            </div>


        </form>
    </div>
</div>

     
        
</div>
</body>
</html>