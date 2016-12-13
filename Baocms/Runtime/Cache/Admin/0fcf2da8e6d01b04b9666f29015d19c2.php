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
        <li class="li1">会员</li>
        <li class="li2">收货地址</li>
        <li class="li2 li3">地址列表</li>
    </ul>
</div>
<div class="main-jsgl main-sc">
    <div class="jsglNr">
        <div class="selectNr" style="margin-top: 0px; border-top:none;">
            <div class="left">
                <?php echo BA('useraddr/create','','添加内容');?>
            </div>
            <div class="right">
                <form class="search_form" method="post" action="<?php echo U('useraddr/index');?>">
                    <div class="seleHidden" id="seleHidden">
                        <span>关键字</span>
                        <input type="text" name="keyword" value="<?php echo ($keyword); ?>" class="inptText" /><input type="submit" value="   搜索"  class="inptButton" />
                    </div> 
                </form>
                <a href="javascript:void(0);" class="searchG">高级搜索</a>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
        <form method="post" action="<?php echo U('useraddr/index');?>">
            <div class="selectNr selectNr2">
                <div class="left">
                    <div class="seleK">
                        <label>
                            <span>区域：</span>
                            <select name="area_id" id="area_id" class="select w100">
                                <option value="0">请选择...</option>
                                <?php if(is_array($areas)): foreach($areas as $key=>$var): ?><option value="<?php echo ($var["area_id"]); ?>"  <?php if(($var["area_id"]) == $area_id): ?>selected="selected"<?php endif; ?> ><?php echo ($var["area_name"]); ?></option><?php endforeach; endif; ?>   
                            </select>
                        </label>
                        <label>
                            <span>商圈：</span>
                            <select name="business_id" id="business_id" class="select w100">
                                <option value="0">请选择...</option>
                                <?php if(is_array($business)): foreach($business as $key=>$var): ?><option value="<?php echo ($var["business_id"]); ?>"  <?php if(($var["business_id"]) == $business_id): ?>selected="selected"<?php endif; ?> ><?php echo ($var["business_name"]); ?></option><?php endforeach; endif; ?>   
                            </select>
                        </label>
                        <script>
                            $(document).ready(function (e) {
                                $("#area_id").change(function () {
                                    var url = '<?php echo U("business/child",array("area_id"=>"0000"));?>';
                                    if ($(this).val() > 0) {
                                        var url2 = url.replace('0000', $(this).val());
                                        $.get(url2, function (data) {
                                            $("#business_id").html(data);
                                        }, 'html');
                                    }
                                });
                            });
                        </script>
                        <label>
                            <input type="hidden" id="user_id" name="user_id" value="<?php echo (($user_id)?($user_id):''); ?>"/>
                            <input class="text" type="text"   name="nickname" id="nickname"  value="<?php echo ($nickname); ?>" />
                            <a mini="select"  w="1000" h="800" href="<?php echo U('user/select');?>" class="sumit">选择用户</a>
                        </label>
                        <label>
                            <span>关键字:</span>
                            <input type="text" name="keyword" value="<?php echo ($keyword); ?>" class="inptText" />
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
            <table bordercolor="#e1e6eb" cellspacing="0" width="100%" border="1px"  style=" border-collapse: collapse; margin:0px; vertical-align:middle; background-color:#FFF;"  >
                <tr>
                    <td class="w50"><input type="checkbox" class="checkAll" rel="addr_id" /></td>
                    <td class="w50">ID</td>
                    <td>用户</td>
                    <td>地区</td>
                    <td>收货人</td>
                    <td>手机号码</td>
                    <td>具体地址</td>
                    <td>操作</td>
                </tr>
                <?php if(is_array($list)): foreach($list as $key=>$var): ?><tr>
                        <td><input class="child_addr_id" type="checkbox" name="addr_id[]" value="<?php echo ($var["addr_id"]); ?>" /></td>
                        <td><?php echo ($var["addr_id"]); ?></td>
                        <td><?php echo ($users[$var['user_id']]['account']); ?>(<?php echo ($var["user_id"]); ?>)</td>
                        <td><?php echo ($areas[$var['area_id']]['area_name']); ?>-<?php echo ($business[$var['business_id']]['business_name']); ?></td>
                        <td><?php echo ($var["name"]); ?></td>
                        <td><?php echo ($var["mobile"]); ?></td>
                        <td><?php echo ($var["addr"]); ?></td>
                        <td>
                            <?php echo BA('useraddr/edit',array("addr_id"=>$var["addr_id"]),'编辑','','remberBtn');?>
                            <?php echo BA('useraddr/delete',array("addr_id"=>$var["addr_id"]),'删除','act','remberBtn');?>
                        </td>
                    </tr><?php endforeach; endif; ?>
            </table>
            <?php echo ($page); ?>
        </div>
        <div class="selectNr" style="margin-bottom: 0px; border-bottom: none;">
            <div class="left">
                <?php echo BA('useraddr/delete','','批量删除','list',' a2');?>
            </div>
        </div>
    </form>
</div>
</div>

     
        
</div>
</body>
</html>