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
        <li class="li1">商家</li>
        <li class="li2">商家点评</li>
        <li class="li2 li3">发布点评</li>
    </ul>
</div>
<form  target="baocms_frm" action="<?php echo U('shopdianping/create');?>" method="post">
    <div class="mainScAdd">
        <div class="tableBox">
            <table bordercolor="#e1e6eb" cellspacing="0" width="100%" border="1px"  style=" border-collapse: collapse; margin:0px; vertical-align:middle; background-color:#FFF;" >
                <tr>
                    <td class="lfTdBt">用户：</td>
                    <td class="rgTdBt">
                        <div class="lt">
                            <input type="hidden" id="user_id" name="data[user_id]" value="<?php echo (($detail["user_id"])?($detail["user_id"]):''); ?>"/>
                            <input class="scAddTextName sj"  type="text" name="nickname" id="nickname"  value="" />
                        </div>
                        <a mini="select"  w="800" h="600" href="<?php echo U('user/select');?>" class="seleSj">选择用户</a>
                    </td>
                </tr>
                <tr>
                    <td class="lfTdBt">商家：</td>
                    <td class="rgTdBt">
                        <div class="lt">
                            <input type="hidden" id="shop_id" name="data[shop_id]" value="<?php echo (($detail["shop_id"])?($detail["shop_id"]):''); ?>"/>
                            <input type="text" id="shop_name" name="shop_name" value="" class="scAddTextName sj" />
                        </div>
                        <a mini="select"  w="1000" h="600" href="<?php echo U('shop/select');?>" class="seleSj">选择商家</a>
                    </td>
                </tr><tr>
                    <td class="lfTdBt">评分：</td>
                    <td class="rgTdBt"><input type="text" name="data[score]" value="<?php echo (($detail["score"])?($detail["score"]):''); ?>" class="scAddTextName w200" />
                        <code>最高5分</code>
                    </td>
                </tr><tr>
                    <td class="lfTdBt">平均花费：</td>
                    <td class="rgTdBt"><input type="text" name="data[cost]" value="<?php echo (($detail["cost"])?($detail["cost"]):''); ?>" class="scAddTextName w200" />

                    </td>
                </tr>

                <tr>
                    <td class="lfTdBt">评价内容：</td>
                    <td class="rgTdBt">
                        <textarea name="data[contents]" rows="5" cols="60"><?php echo (($detail["contents"])?($detail["contents"]):''); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td class="lfTdBt">
                <script type="text/javascript" src="__PUBLIC__/js/uploadify/jquery.uploadify.min.js"></script>
                <link rel="stylesheet" href="__PUBLIC__/js/uploadify/uploadify.css">
                上传图片：
                </td>
                <td class="rgTdBt">
                    <div>
                        <input id="logo_file" name="logo_file" type="file" multiple="true" value="" />
                    </div>
                    <div class="jq_uploads_img">
                        <?php if(is_array($photos)): foreach($photos as $key=>$item): ?><span style="width: 200px; height: 120px; float: left; margin-left: 5px; margin-top: 10px;"> 
                                <img width="200" height="100" src="__ROOT__/attachs/<?php echo ($item); ?>">  
                                <input type="hidden" name="photos[]" value="<?php echo ($item); ?>" />  
                                <a href="#">取消</a>  
                            </span><?php endforeach; endif; ?>
                    </div>
                    <script>
                        $("#logo_file").uploadify({
                            'swf': '__PUBLIC__/js/uploadify/uploadify.swf?t=<?php echo ($nowtime); ?>',
                            'uploader': '<?php echo U("app/upload/uploadify",array("model"=>"shopdianping"));?>',
                            'cancelImg': '__PUBLIC__/js/uploadify/uploadify-cancel.png',
                            'buttonText': '上传图片',
                            'fileTypeExts': '*.gif;*.jpg;*.png',
                            'queueSizeLimit': 5,
                            'onUploadSuccess': function (file, data, response) {
                                var str = '<span style="width: 200px; height: 120px; float: left; margin-left: 5px; margin-top: 10px;">  <img width="200" height="100" src="__ROOT__/attachs/' + data + '">  <input type="hidden" name="photos[]" value="' + data + '" />    <a href="#">取消</a>  </span>';
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
                    <td class="lfTdBt">商家回复：</td>
                    <td class="rgTdBt">
                        <textarea name="data[reply]" rows="5" cols="60"><?php echo (($detail["reply"])?($detail["reply"]):''); ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td class="lfTdBt">生效日期：</td>
                    <td class="rgTdBt"><input type="text" name="data[show_date]" value="<?php echo (($detail["show_date"])?($detail["show_date"]):''); ?>" onfocus="WdatePicker();"  class="inputData" />

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