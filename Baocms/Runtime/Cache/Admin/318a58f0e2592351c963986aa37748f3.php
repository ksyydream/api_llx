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
        <li class="li2 li3">新增商品</li>
    </ul>
</div>
<div class="mainScAdd ">

    <div class="tableBox">
        <form  target="baocms_frm" action="<?php echo U('cloudgoods/create');?>" method="post">
            <table  bordercolor="#dbdbdb" cellspacing="0" width="100%" border="1px"  style=" border-collapse: collapse; margin:0px; vertical-align:middle; background-color:#FFF;" >
 
                
                
                <tr>
                    <td class="lfTdBt">产品名称：</td>
                    <td class="rgTdBt"><input type="text" name="data[title]" value="<?php echo (($detail["title"])?($detail["title"]):''); ?>" class="manageInput" />

                    </td>
                </tr>   
                <tr>
                    <td class="lfTdBt">产品简介：</td>
                    <td class="rgTdBt"><input type="text" name="data[intro]" value="<?php echo (($detail["intro"])?($detail["intro"]):''); ?>" class="manageInput" />

                    </td>
                </tr>    
                <tr>
                    <td class="lfTdBt">商家：</td>
                    <td class="rgTdBt">
                        <div class="lt">
                            <input type="hidden" id="shop_id" name="data[shop_id]" value="<?php echo (($detail["shop_id"])?($detail["shop_id"]):''); ?>"/>
                            <input type="text" id="shop_name" name="shop_name" value="" class="manageInput" />
                        </div>
                        <a mini="select"  w="1000" h="600" href="<?php echo U('shop/select');?>" class="remberBtn">选择商家</a>
                    </td>
                </tr>
                <tr>
                    <td class="lfTdBt">类型：</td>
                    <td class="rgTdBt">
                        <select id="type" name="data[type]" class="manageSelect w100">
                            <?php if(is_array($types)): $index = 0; $__LIST__ = $types;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$var): $mod = ($index % 2 );++$index;?><option value="<?php echo ($index); ?>"><?php echo ($var["type_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </td>
                </tr>   
                <tr>
                    <td class="lfTdBt">
                <script type="text/javascript" src="__PUBLIC__/js/uploadify/jquery.uploadify.min.js"></script>
                <link rel="stylesheet" href="__PUBLIC__/js/uploadify/uploadify.css">
                缩略图：
                </td>
                <td class="rgTdBt">
                    <div style="width: 300px;height: 100px; float: left;">
                        <input type="hidden" name="data[photo]" value="<?php echo ($detail["photo"]); ?>" id="data_photo" />
                        <input id="photo_file" name="photo_file" type="file" multiple="true" value="" />
                    </div>
                    <div style="width: 300px;height: 100px; float: left;">
                        <img id="photo_img" width="80" height="80"  src="__ROOT__/attachs/<?php echo (($detail["photo"])?($detail["photo"]):'default.jpg'); ?>" />
                        <a href="<?php echo U('setting/attachs');?>">缩略图设置</a>
                        建议尺寸<?php echo ($CONFIG["attachs"]["goods"]["thumb"]); ?>
                    </div>
                    <script>
                        $("#photo_file").uploadify({
                            'swf': '__PUBLIC__/js/uploadify/uploadify.swf?t=<?php echo ($nowtime); ?>',
                            'uploader': '<?php echo U("app/upload/uploadify",array("model"=>"cloud"));?>',
                            'cancelImg': '__PUBLIC__/js/uploadify/uploadify-cancel.png',
                            'buttonText': '上传缩略图',
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
                    <td  class="lfTdBt">商品组图：</td>
                    <td class="rgTdBt">
                        <div>
                            <input id="thumb_file" name="logo_file" type="file" multiple="true" value="" />
                        </div>
                        <div class="jq_uploads_img">
                            <?php if(is_array($thumb)): foreach($thumb as $key=>$item): ?><span style="width: 200px; height: 120px; float: left; margin-left: 5px; margin-top: 10px;"> 
                                    <img width="200" height="100" src="__ROOT__/attachs/<?php echo ($item); ?>">  
                                    <input type="hidden" name="thumb[]" value="<?php echo ($item); ?>" />  
                                    <a href="javascript:void(0);">取消</a>  
                                </span><?php endforeach; endif; ?>
                        </div>
                        <script>
                            $("#thumb_file").uploadify({
                                'swf': '__PUBLIC__/js/uploadify/uploadify.swf?t=<?php echo ($nowtime); ?>',
                                'uploader': '<?php echo U("app/upload/uploadify",array("model"=>"cloud"));?>',
                                'cancelImg': '__PUBLIC__/js/uploadify/uploadify-cancel.png',
                                'buttonText': '上传图片',
                                'fileTypeExts': '*.gif;*.jpg;*.png',
                                'queueSizeLimit': 5,
                                'onUploadSuccess': function (file, data, response) {
                                    var str = '<span style="width: 200px; height: 120px; float: left; margin-left: 5px; margin-top: 10px;">  <img width="200" height="100" src="__ROOT__/attachs/' + data + '">  <input type="hidden" name="thumb[]" value="' + data + '" />    <a href="javascript:void(0);">取消</a>  </span>';
                                    $(".jq_uploads_img").append(str);
                                }
                            });

                            $(document).on("click", ".jq_uploads_img a", function () {
                                $(this).parent().remove();
                            });
                        </script>
                    </td>
                </tr>
                <tr>
                    <td class="lfTdBt">总需人次：</td>
                    <td class="rgTdBt"><input type="text" name="data[price]" value="<?php echo (($detail["price"])?($detail["price"]):''); ?>" class="manageInput" />
                        <code>一人次对应一元，不支持小数</code>
                    </td>
                </tr>
                <tr>
                    <td class="lfTdBt">单人最大购买次数：</td>
                    <td class="rgTdBt"><input type="text" name="data[max]" value="<?php echo (($detail["max"])?($detail["max"]):''); ?>" class="manageInput" />

                    </td>
                </tr>
                <tr>
                    <td class="lfTdBt">结算价格：</td>
                    <td class="rgTdBt"><input type="text" name="data[settlement_price]" value="<?php echo (($detail["settlement_price"])?($detail["settlement_price"]):''); ?>" class="manageInput" />
                        <code>结算价格必须填写，否则该产品不能设置通过审核。</code>
                    </td>
                </tr>

                <link rel="stylesheet" href="__PUBLIC__/umeditor/themes/default/css/umeditor.min.css" type="text/css">
                <script type="text/javascript" charset="utf-8" src="__PUBLIC__/umeditor/umeditor.config.js"></script>
                <script type="text/javascript" charset="utf-8" src="__PUBLIC__/umeditor/umeditor.min.js"></script>
                <script type="text/javascript" src="__PUBLIC__/umeditor/lang/zh-cn/zh-cn.js"></script>
                <tr>
                    <td class="lfTdBt">商品详情：</td>
                    <td class="rgTdBt">
                        <script type="text/plain" id="data_details" name="data[details]" style="width:800px;height:360px;"><?php echo ($detail["details"]); ?></script>
                    </td>
                </tr>
                <script>
                                    um = UM.getEditor('data_details', {
                                        imageUrl: "<?php echo U('app/upload/editor');?>",
                                        imagePath: '__ROOT__/attachs/editor/',
                                        lang: 'zh-cn',
                                        langPath: UMEDITOR_CONFIG.UMEDITOR_HOME_URL + "lang/",
                                        focus: false
                                    });
                </script>
            </table>
            <div style="margin-left:140px;margin-top:20px">
                <input type="submit" value="确认添加" class="smtQrIpt" />
                <div>
                    </form>
                </div>
            </div>
            
     
        
</div>
</body>
</html>