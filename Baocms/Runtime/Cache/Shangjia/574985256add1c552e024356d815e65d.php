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
        <li><a href="#">系统设置</a> > <a href="">基础资料</a> > <a>修改密码</a></li>
    </ul>
</div>
<div class="tuan_content">
    <div class="radius5 tuan_top">
        <div class="tuan_top_t">
            <div class="left tuan_topser_l">修改密码 </div>
        </div>
    </div> 
    <div class="tuanfabu_tab">
        <ul>
          <li class="tuanfabu_tabli tabli_change on"><a href="<?php echo U('info/password');?>">修改密码</a></li>
        </ul>
    </div>
    <div class="tabnr_change  show">
    	<form method="post" class="password"  action="<?php echo U('info/password');?>"  target="baocms_frm">
    	<table class="tuanfabu_table" width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td width="120"><p class="tuanfabu_t"><em>·</em>输入原密码：</p></td>
                <td><div class="tuanfabu_nr"><input type="password" name="oldpwd" class="tuanfabu_int tuanfabu_intw2" /></div></td>
            </tr>
            <tr>
                <td><p class="tuanfabu_t"><em>·</em>输入新密码：</p></td>
                <td><div class="tuanfabu_nr"><input type="password" name="newpwd" class="tuanfabu_int tuanfabu_intw2" /></div></td>
            </tr>
            <tr>
                <td><p class="tuanfabu_t"><em>·</em>确认新密码：</p></td>
                <td><div class="tuanfabu_nr"><input type="password" name="pwd2" class="tuanfabu_int tuanfabu_intw2" /></div></td>
            </tr>
        </table>
        <div class="tuanfabu_an">
        <input type="submit" class="radius3 sjgl_an tuan_topbt" value="确认修改" />
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