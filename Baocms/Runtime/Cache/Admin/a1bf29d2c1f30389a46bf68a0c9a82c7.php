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
         <li class="li1">设置</li>
        <li class="li2">区域设置</li>
        <li class="li2 li3">城市站点</li>
    </ul>
</div>
<form  target="baocms_frm" action="<?php echo U('city/create');?>" method="post">
    <div class="mainScAdd">
        <div class="tableBox">
            <table  bordercolor="#dbdbdb" cellspacing="0" width="100%" border="1px"  style=" border-collapse: collapse; margin:0px; vertical-align:middle; background-color:#FFF;" >
                
                <tr>
                    <td class="lfTdBt">城市名称：</td>
                    <td class="rgTdBt"><input type="text" name="data[name]" value="<?php echo (($detail["name"])?($detail["name"]):''); ?>" class="manageInput" />

                    </td>
                </tr><tr>
                    <td class="lfTdBt">城市拼音：</td>
                    <td class="rgTdBt"><input type="text" name="data[pinyin]" value="<?php echo (($detail["pinyin"])?($detail["pinyin"]):''); ?>" class="manageInput" />

                    </td>
                </tr>
                
                
                <tr>
                    <td class="lfTdBt">
                <script type="text/javascript" src="__PUBLIC__/js/uploadify/jquery.uploadify.min.js"></script>
                <link rel="stylesheet" href="__PUBLIC__/js/uploadify/uploadify.css">
                上传城市logo：
                </td>
                <td class="rgTdBt">
                    <div style="width: 300px;height: 100px; float: left;">
                        <input type="hidden" name="data[photo]" value="<?php echo ($detail["photo"]); ?>" id="data_photo" />
                        <input id="photo_file" name="photo_file" type="file" multiple="true" value="" />
                    </div>
                    <div style="width: 300px;height: 100px; float: left;">
                        <img id="photo_img" width="80" height="80"  src="__ROOT__/attachs/<?php echo (($detail["photo"])?($detail["photo"]):'default.jpg'); ?>" />
                        <a href="<?php echo U('setting/attachs');?>">缩略图设置</a>
                        建议尺寸<?php echo ($CONFIG["attachs"]["city_logo"]["thumb"]); ?>
                    </div>
                    <script>
                        $("#photo_file").uploadify({
                            'swf': '__PUBLIC__/js/uploadify/uploadify.swf?t=<?php echo ($nowtime); ?>',
                            'uploader': '<?php echo U("app/upload/uploadify",array("model"=>"city_logo"));?>',
                            'cancelImg': '__PUBLIC__/js/uploadify/uploadify-cancel.png',
                            'buttonText': '上传城市logo',
                            'fileTypeExts': '*.gif;*.jpg;*.png',
                            'queueSizeLimit': 1,
                            'onUploadSuccess': function (file, data, response) {
                                $("#data_photo").val(data);
                                $("#photo_img").attr('src', '__ROOT__/attachs/' + data).show();
                            }
                        });
                    </script>
                </td>
                </tr>
                
                
                <tr>
                    <td class="lfTdBt">城市模板风格：</td>
                    <td class="rgTdBt">
                        <select name="data[theme]" class="select">
                            <option value="">请选择</option>
                            <?php if(is_array($themes)): foreach($themes as $key=>$item): ?><option <?php if(($detail["theme"]) == $item["theme"]): ?>selected="selected"<?php endif; ?> value="<?php echo ($item["theme"]); ?>"><?php echo ($item["name"]); ?></option><?php endforeach; endif; ?>
                        </select>
                    </td>
                </tr>
                 <tr>
                    <td class="lfTdBt">首字母：</td>
                    <td class="rgTdBt"><input type="text" name="data[first_letter]" value="<?php echo (($detail["first_letter"])?($detail["first_letter"]):''); ?>" class="manageInput" />
                        <code>大写字母</code>
                    </td>
                </tr>
                  <tr>
                    <td class="lfTdBt">城市中心坐标：</td>
                    <td class="rgTdBt">
                        <div class="lt">
                            经度<input type="text" name="data[lng]" id="data_lng" value="<?php echo (($detail["lng"])?($detail["lng"]):''); ?>" class="scAddTextName w200" />
                            纬度 <input type="text" name="data[lat]" id="data_lat" value="<?php echo (($detail["lat"])?($detail["lat"]):''); ?>" class="scAddTextName w200" />
                        </div>
                        <a style="margin-left: 10px;" mini="select"  w="600" h="600" href="<?php echo U('public/maps');?>" class="seleSj">百度地图</a>
                </tr>
                <tr>
                    <td class="lfTdBt">排序：</td>
                    <td class="rgTdBt"><input type="text" name="data[orderby]" value="<?php echo (($detail["orderby"])?($detail["orderby"]):''); ?>" class="manageInput" />

                    </td>
                </tr>
                 <tr>
                    <td class="lfTdBt">是否启用：</td>
                    <td class="rgTdBt">
                        <label>
                            <input type="radio" <?php if($detail['is_open'] == 0) echo "checked='checked'";?> name="data[is_open]" value="0"  />
                                   不启用
                        </label>
                        <label>
                            <input type="radio" <?php if($detail['is_open'] == 1) echo "checked='checked'";?> name="data[is_open]" value="1"  />
                                   启用
                        </label>
                    </td>
                </tr>
                                                 <tr>
                    <td class="lfTdBt">启用二级域名：</td>
                    <td class="rgTdBt">
                        <label>
                            <input type="radio" <?php if($detail['domain'] == 0) echo "checked='checked'";?> name="data[domain]" value="0"  />
                                   不启用
                        </label>
                        <label>
                            <input type="radio" <?php if($detail['domain'] == 1) echo "checked='checked'";?> name="data[domain]" value="1"  />
                                   启用
                        </label>
                        &nbsp;&nbsp;<code>无权限修改服务器配置的。选择不启用</code>
                    </td>
                </tr>
            </table>
        </div>
        <div class="smtQr"><input type="submit" value="确认添加" class="smtQrIpt" /></div>
    </div>
</form>

     
        
</div>
</body>
</html>