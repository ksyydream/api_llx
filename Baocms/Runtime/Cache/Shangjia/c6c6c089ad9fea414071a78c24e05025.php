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
        <li><a href="#">系统设置</a> > <a href="">店铺管理</a> > <a>其他资料设置</a></li>
    </ul>
</div>
<div class="tuan_content">
    <div class="radius5 tuan_top">
        <div class="tuan_top_t">
            <div class="left tuan_topser_l">店铺文字资料介绍店铺的基本信息 </div>
        </div>
    </div> 
    <div class="tuanfabu_tab">
        <ul>
            
            <li class="tuanfabu_tabli tabli_change"><a href="<?php echo U('shop/about');?>">店铺文字资料</a></li>
            <li class="tuanfabu_tabli tabli_change on"><a href="<?php echo U('shop/service');?>">其他设置</a></li>
            <li class="tuanfabu_tabli tabli_change"><a href="<?php echo U('shop/image');?>">店铺形象图</a></li>
            <li class="tuanfabu_tabli tabli_change"><a href="<?php echo U('shop/logo');?>">店铺LOGO</a></li>
            <li class="tuanfabu_tabli tabli_change"><a href="<?php echo U('photo/index');?>">店铺环境图</a></li>
        </ul>
    </div>
    <div class="tabnr_change  show">
    	<form method="post"  action="<?php echo U('shop/service');?>" target="baocms_frm">
    	<table class="tuanfabu_table" width="100%" border="0" cellspacing="0" cellpadding="0">
        <!---->
            <!--<tr>-->
                <!--<td width="120"><p class="tuanfabu_t">打印标识(apiKey)</p></td>-->
                <!--<td><div class="tuanfabu_nr">-->
                <!--<input type="text" name="data[apiKey]" value="<?php echo ($detail["apiKey"]); ?>" class="tuanfabu_int tuanfabu_intw2" style="width: 400px;" />-->
                <!--<code>打印标识</code></div></td>-->
            <!--</tr>-->
            <!--<tr>-->
                <!--<td><p class="tuanfabu_t">密钥(mKey)</p></td>-->
                <!--<td><div class="tuanfabu_nr">-->
                <!--<input type="text" name="data[mKey]" value="<?php echo ($detail["mKey"]); ?>" class="tuanfabu_int tuanfabu_intw2" style="width: 400px;" />-->
                <!--<code>你在易连云打印平台注册的ID</code></div></td>-->
            <!--</tr>-->

             <!--<tr>-->
                <!--<td width="120"><p class="tuanfabu_t">用户id(partner)</p></td>-->
                <!--<td><div class="tuanfabu_nr">-->
                <!--<input type="text" name="data[partner]" value="<?php echo ($detail["partner"]); ?>" class="tuanfabu_int tuanfabu_intw2" />-->
                <!--<code>打印标识</code></div></td>-->
            <!--</tr>-->
            <!--<tr>-->
                <!--<td><p class="tuanfabu_t">打印机终端号(machine_code)</p></td>-->
                <!--<td><div class="tuanfabu_nr">-->
                <!--<input type="text" name="data[machine_code]" value="<?php echo ($detail["machine_code"]); ?>" class="tuanfabu_int tuanfabu_intw2" />-->
                <!--<code>打印机终端号，一般购买打印机后打印机后面都有此号码。</code>-->
                <!--</div></td>-->
            <!--</tr>-->

             <!--<tr>-->
                <!--<td><p class="tuanfabu_t">客服代码：</p></td>-->
                <!--<td><div class="tuanfabu_nr">-->
                <!--<textarea name="data[service]" cols="100" rows="15"><?php echo (($detail["service"])?($detail["service"]):''); ?></textarea>-->
                <!--<code>这里是你再其他地方的客服代码添加到这里，只在商家首页展示，建议是一段完整的JS代码</code></div></td>-->
            <!--</tr>-->

            <tr>
                <td width="120"><p class="">本店优惠券</p></td>
                <td><div class="tuanfabu_nr">
                    满100可抵<input type="text" name="yhk1" value="<?php echo ($detail["yhk1"]); ?>" class="tuanfabu_int tuanfabu_intw2" style="width: 40px;" />优惠券
                    </div>
                </td>
            </tr>

            <tr>
                <td width="120"><p class="">其他店优惠券</p></td>
                <td><div class="tuanfabu_nr">
                    满100可抵<input type="text" name="yhk2" value="<?php echo ($detail["yhk2"]); ?>" class="tuanfabu_int tuanfabu_intw2" style="width: 40px;" />优惠券
                </div>
                </td>
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