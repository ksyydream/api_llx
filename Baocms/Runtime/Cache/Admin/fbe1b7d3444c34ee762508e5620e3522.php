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
        <li class="li2">一元云购</li>
        <li class="li2 li3">商品列表</li>
    </ul>
</div>
<div class="main-jsgl main-sc">
    <p class="attention"><span>注意：</span>新版一元云购支持多城市，如果要全站显示，则不选择城市。</p>
    <div class="jsglNr">
        <div class="selectNr" style="margin-top: 0px; border-top:none;">
            <div class="left">
                <?php echo BA('cloudgoods/create','','添加内容');?>  
            </div>
            <div class="right">
                <form method="post" action="<?php echo U('cloudgoods/index');?>">
                    <div class="seleHidden" id="seleHidden">
                        <div class="seleK">
                            <label>
                                <input type="hidden" id="shop_id" name="shop_id" value="<?php echo (($shop_id)?($shop_id):''); ?>"/>
                                <input type="text"   id="shop_name" name="shop_name" value="<?php echo ($shop_name); ?>" class="inptText w200" />
                                <a mini="select"  w="1000" h="600" href="<?php echo U('shop/select');?>" class="sumit">选择商家</a>
                            </label>
                        <span>分类</span>
                        <select id="type" name="type" class="selecttop w120">
                            <option value="0">请选择...</option>
                            <?php if(is_array($types)): $index = 0; $__LIST__ = $types;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$var): $mod = ($index % 2 );++$index;?><option <?php if(($type) == $index): ?>selected='selected'<?php endif; ?> value="<?php echo ($index); ?>"><?php echo ($var["type_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                        <span>  状态：</span>   

                        <select class="selecttop" name="audit">
                            <option value="0"  >全部</option>
                            <option value="-1" <?php if(($audit) == "-1"): ?>selected="selected"<?php endif; ?> >等待审核</option>
                            <option value="1" <?php if(($audit) == "1"): ?>selected="selected"<?php endif; ?>>正常</option>
                        </select>
                        <span>  关键字：</span>  
                        <input type="text" name="keyword" value="<?php echo (($keyword)?($keyword):''); ?>" class="inptText" /><input type="submit" class="inptButton" value="  搜索" />
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <form  target="baocms_frm" method="post">
            <div class="tableBox">
                <table bordercolor="#dbdbdb" cellspacing="0" width="100%" border="1px"  style=" border-collapse: collapse; margin:0px; vertical-align:middle; background-color:#FFF;"  >
                    <tr>
                        <td class="w50"><input type="checkbox" class="checkAll" rel="goods_id" /></td>
                        <td class="w50">ID</td>
                        <td>产品名称</td>
                        <td>商家</td>
                        <td>类型</td>
                        <td>缩略图</td>
                        <td>总需次数</td>
                        <td>已参加次数</td>
                        <td>结算价格</td>
                        <td>创建时间</td>
                        <td>创建IP</td>
                        <td>是否审核</td>
                        <td>操作</td>
                    </tr>
                    <?php if(is_array($list)): foreach($list as $key=>$var): ?><tr>
                            <td><input class="child_goods_id" type="checkbox" name="goods_id[]" value="<?php echo ($var["goods_id"]); ?>" /> </td>
                            <td><?php echo ($var["goods_id"]); ?></td>
                            <td><?php echo ($var["title"]); ?></td>
                            <td><?php echo (($shops[$var['shop_id']]['shop_name'])?($shops[$var['shop_id']]['shop_name']):'平台发布'); ?></td>
                            <td><?php echo ($types[$var['type']]['type_name']); ?></td>
                            <td><img src="__ROOT__/attachs/<?php echo ($var["photo"]); ?>" class="w80" /></td>
                            <td><?php echo ($var["price"]); ?></td>
                            <td><?php echo ($var["join"]); ?></td>
                            <td><?php echo round($var['settlement_price']/100,2);?></td>
                            <td><?php echo (date('Y-m-d H:i:s',$var["create_time"])); ?></td>
                            <td><?php echo ($var["create_ip"]); ?></td>
                            <td><?php if(($var["audit"]) == "0"): ?>等待审核<?php else: ?>正常<?php endif; ?></td>
                        <td>
                            <?php echo BA('cloudgoods/edit',array("goods_id"=>$var["goods_id"]),'编辑','','remberBtn');?>
                            <?php echo BA('cloudgoods/delete',array("goods_id"=>$var["goods_id"]),'删除','act','remberBtn');?>
                            <?php if(($var["audit"]) == "0"): echo BA('cloudgoods/audit',array("goods_id"=>$var["goods_id"]),'审核','act','remberBtn'); endif; ?>
                        </td>
                        </tr><?php endforeach; endif; ?>
                </table>
                <?php echo ($page); ?>
            </div>
            <div class="selectNr" style="margin-bottom: 0px; border-bottom: none;">
                <div class="left">
                    <?php echo BA('goods/delete','','批量删除','list','a2');?>
                    <?php echo BA('goods/audit','','批量审核','list','remberBtn');?>
                </div>
            </div>
        </form>
    </div>
    
     
        
</div>
</body>
</html>