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
        <li><a href="#">系统设置</a> > <a href="">店铺管理</a> > <a>店铺环境图</a></li>
    </ul>
</div>
<div class="tuan_content">
    <div class="radius5 tuan_top">
        <div class="tuan_top_t">
            <div class="left tuan_topser_l">上传修改商家的店铺环境图，修改之后需要点下方的更新按钮才能生效</div>
        </div>
    </div> 
    <div class="tuanfabu_tab">
        <ul>
            <li class="tuanfabu_tabli tabli_change"><a href="<?php echo U('shop/about');?>">店铺文字资料</a></li>
            <li class="tuanfabu_tabli tabli_change"><a href="<?php echo U('shop/image');?>">店铺形象图</a></li>
            <li class="tuanfabu_tabli tabli_change"><a href="<?php echo U('shop/logo');?>">店铺LOGO</a></li>
            <li class="tuanfabu_tabli tabli_change on"><a href="<?php echo U('photo/index');?>">店铺环境图</a></li>
        </ul>
    </div>
    <div class="tabnr_change  show">
           <script type="text/javascript" src="__PUBLIC__/js/uploadify/jquery.uploadify.min.js"></script>
    <link rel="stylesheet" href="__PUBLIC__/js/uploadify/uploadify.css">
    <table  cellpadding="0"  cellspacing="0" width="100%" class="tuan_table" >
        <tr>
            <td width="400" style="border-top: none;">
                <input id="logo_file" name="logo_file" type="file" multiple="true" value="" />
            </td>
            <td style="border-top: none;">
                为了好看建议尺寸:<?php echo ($CONFIG["attachs"]["shopphoto"]["thumb"]); ?>
            </td>
        </tr> 
    </table>
    <script>
            $("#logo_file").uploadify({
                'swf': '__PUBLIC__/js/uploadify/uploadify.swf?t=<?php echo ($nowtime); ?>',
                'uploader': '<?php echo U("app/upload/shangjia",array("shop_id"=>$SHOP["shop_id"],"sig"=>$sig));?>',
                'cancelImg': '__PUBLIC__/js/uploadify/uploadify-cancel.png',
                'buttonText': '上传图片',
                'fileTypeExts': '*.gif;*.jpg;*.png',
                'queueSizeLimit': 1,
                'onUploadSuccess': function (file, data, response) {
                    location.href = '<?php echo U("photo/index");?>';
                }
            });

        
    </script>
    	<form  method="post" action="<?php echo U('photo/update');?>" target="baocms_frm">
    	<table class="tuan_table" width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr style="background-color:#eee;">
                <td>图片</td>
                <td>标题</td>
                <td>排序</td>
                <td>操作</td>
            </tr>
            <?php if(is_array($list)): foreach($list as $key=>$var): ?><tr>
                    <td style="height: 80px;"><img src="__ROOT__/attachs/<?php echo ($var["photo"]); ?>" style="width: 80px; margin: 0px auto;" /></td>
                    <td><input type="text" class="cjinput" name="title[<?php echo ($var["pic_id"]); ?>]" value="<?php echo ($var["title"]); ?>" /></td>
                    <td><input type="text" class="cjinput" style="width: 50px" name="orderby[<?php echo ($var["pic_id"]); ?>]" value="<?php echo ($var["orderby"]); ?>" /></td>
                    <td>
                        <a mini='confirm' href="<?php echo U('photo/delete',array('pic_id'=>$var['pic_id']));?>">删除图片</a>
                    </td>
                </tr><?php endforeach; endif; ?>
        </table>
        <div class="tuanfabu_an"><input type="submit" class="radius3 sjgl_an tuan_topbt" value="确认保存" /></div>

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