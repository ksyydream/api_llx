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
        <li class="li1">分站</li>
        <li class="li2">分站设置</li>
        <li class="li2 li3">分站城市列表</li>
    </ul>
</div>
<div class="main-jsgl">
    <p class="attention"><span>注意：</span>这里只是显各个分站的所有管理员列表，登录状态等信息。</p>
    <div class="jsglNr">
        <div class="selectNr" style="margin: 10px 20px;">
            <div class="left">
                <?php echo BA('city/create','','添加分站');?>
            </div>
            <form method="post" action="<?php echo U('city/index');?>">
                <div class="right">
                    <input type="text" name="keyword" value="<?php echo ($keyword); ?>" class="inptText" /><input type="submit" value="  搜索"  class="inptButton" />
                </div>
            </form>
        </div>
        <form target="baocms_frm" method="post">
            <div class="tableBox">
                <table bordercolor="#e1e6eb" cellspacing="0" width="100%" border="1px"  style=" border-collapse: collapse; margin:0px; vertical-align:middle; background-color:#FFF;"  >
                    <tr>
                        <td class="w50"><input type="checkbox" class="checkAll" rel="city_id" /></td>
                        <td class="w50">ID</td>
                        <td>站点名称/拼音</td>
                        <td>模板</td>
                        <td>分站管理员列表</td>
                        <td class="w120">站点状态</td>
                    </tr>
                    <?php if(is_array($list)): foreach($list as $key=>$var): ?><tr>
                            <td><input class="child_city_id" type="checkbox" name="city_id[]" value="<?php echo ($var["city_id"]); ?>"/></td>
                            <td><?php echo ($var["city_id"]); ?></td>
                            <td><?php echo ($var["name"]); ?>/<?php echo ($var["pinyin"]); ?></td>
                            <td><?php echo ($var["theme"]); ?></td>
                            <td>
                            
                            <?php $city_ids = D('Admin') -> where('city_id ='.$var['city_id']) -> select(); ?> 
                            
               				<?php if(is_array($city_ids)): $i = 0; $__LIST__ = $city_ids;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$var2): $mod = ($i % 2 );++$i;?>账户名称：<a style="color:#0099cc; font-size:14px; font-weight:bold;"><?php echo ($var2["username"]); ?></a> &nbsp;&nbsp;/&nbsp;&nbsp;手机号码：<?php echo ($var2["mobile"]); ?><br/>
                            申请时间：<?php echo (date('Y-m-d H:i:s',$var2["create_time"])); ?><br/>
                            最后登录时间：<?php echo (date('Y-m-d H:i:s',$var2["last_time"])); ?><br/>
                            <?php if(!empty($var2['last_ip'])): ?>最后登录IP：<?php echo ($var2["last_ip"]); endif; ?>
                            <br/><?php endforeach; endif; else: echo "" ;endif; ?>
                            </td>
                           

                            <td>
                                <?php if(($var["is_open"]) == "0"): ?><a class="remberBtn ">关闭中</a>
                                <?php else: ?>
                                  <a class="remberBtn ">已开启</a><?php endif; ?> 
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