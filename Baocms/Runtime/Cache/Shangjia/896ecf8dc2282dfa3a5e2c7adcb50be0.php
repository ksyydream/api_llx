<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>商家管理中心-<?php echo ($CONFIG["site"]["title"]); ?></title>
<meta name="description" content="<?php echo ($CONFIG["site"]["title"]); ?>商户中心" />
<meta name="keywords" content="<?php echo ($CONFIG["site"]["title"]); ?>商户中心" />
<link href="__TMPL__statics/css/newstyle.css" rel="stylesheet" type="text/css" />
 <link href="__PUBLIC__/js/jquery-ui.css" rel="stylesheet" type="text/css" />
<script>
var BAO_PUBLIC = '__PUBLIC__'; var BAO_ROOT = '__ROOT__';
</script>
<script src="__PUBLIC__/js/jquery.js"></script>
<script src="__PUBLIC__/js/jquery-ui.min.js"></script>
<script src="__PUBLIC__/js/web.js"></script>
<script src="__PUBLIC__/js/layer/layer.js"></script>

</head>

<body>
<iframe id="baocms_frm" name="baocms_frm" style="display:none;"></iframe>
<div class="sjgl_lead">
    <ul>
        <li><a href="#">系统设置</a> > <a href="">店铺管理</a> > <a>店铺LOGO</a></li>
    </ul>
</div>
<div class="tuan_content">
    <div class="radius5 tuan_top">
        <div class="tuan_top_t">
            <div class="left tuan_topser_l">这里修改或上传店铺logo图片</div>
        </div>
    </div> 
    <div class="tuanfabu_tab">
        <ul>
            <li class="tuanfabu_tabli tabli_change"><a href="<?php echo U('shop/about');?>">店铺文字资料</a></li>
            <li class="tuanfabu_tabli tabli_change "><a href="<?php echo U('shop/service');?>">其他设置</a></li>
            <li class="tuanfabu_tabli tabli_change"><a href="<?php echo U('shop/image');?>">店铺形象图</a></li>
            <li class="tuanfabu_tabli tabli_change on"><a href="<?php echo U('shop/logo');?>">店铺LOGO</a></li>
            <li class="tuanfabu_tabli tabli_change"><a href="<?php echo U('photo/index');?>">店铺环境图</a></li>
        </ul>
    </div>
    <div class="tabnr_change  show">
    	<form method="post"  action="<?php echo U('shop/logo');?>"  target="baocms_frm">
        <script type="text/javascript" src="__PUBLIC__/js/uploadify/jquery.uploadify.min.js"></script>
        <link rel="stylesheet" href="__PUBLIC__/js/uploadify/uploadify.css">
    	<table class="tuanfabu_table" width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="120"><p class="tuanfabu_t">商铺LOGO：</p></td>
                <td><div class="tuanfabu_nr">
                <div style="width: 300px;height: 100px; float: left;">
                    <input type="hidden" name="logo" value="<?php echo ($SHOP["logo"]); ?>" id="data_logo" />
                    <input id="logo_file" name="logo_file" type="file" multiple="true" value="" />
                </div>
                <div style="width: 300px;height: 100px; float: left;">
                    <img id="logo_img" width="80" height="80"  src="__ROOT__/attachs/<?php echo (($SHOP["logo"])?($SHOP["logo"]):'default.jpg'); ?>" />

                    建议尺寸:<?php echo ($CONFIG["attachs"]["shoplogo"]["thumb"]); ?>
                </div>
                <script>
                        $("#logo_file").uploadify({
                            'swf': '__PUBLIC__/js/uploadify/uploadify.swf?t=<?php echo ($nowtime); ?>',
                            'uploader': '<?php echo U("app/upload/uploadify",array("model"=>"shoplogo"));?>',
                            'cancelImg': '__PUBLIC__/js/uploadify/uploadify-cancel.png',
                            'buttonText': '上传商铺LOGO',
                            'fileTypeExts': '*.gif;*.jpg;*.png',
                            'queueSizeLimit': 1,
                            'onUploadSuccess': function (file, data, response) {
                                $("#data_logo").val(data);
                                $("#logo_img").attr('src', '__ROOT__/attachs/' + data).show();
                            }
                        });

                </script>
                </div></td>
            </tr>
        </table>
        <div class="tuanfabu_an">
        <input type="submit" class="radius3 sjgl_an tuan_topbt" value="确认保存" />
        </div>
        </form>
    </div> 
</div>


<script>
function require() {
      var url = "{U('order1/checkNotify')}";
        　　
      $.get(url,null,function(data) {
        　　　　　　
            // 如果获得的数据不为空，则显示提醒
           if ($.trim(data) != '') {

               // 这里写提醒的方式
        　　　　alert('您有新订单来了，还在测试');
           }
      });

      // 每三秒请求一次
      setTimeout('require()',3000);
}
</script>
<!--<body onload="javascript:return require();">-->
</html>