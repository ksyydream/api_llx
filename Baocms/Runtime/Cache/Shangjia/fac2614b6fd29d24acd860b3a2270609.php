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
        <li><a href="">粉丝</a>><a>购卡会员</a></li>
    </ul>
</div>
<div class="tuan_content">
    <form  method="post" action="<?php echo U('fans/yhk_users');?>">
    <div class="radius5 tuan_top">
        <div class="tuan_top_t">
            昵称：<input type="text" name="keyword" value="<?php echo ($keyword); ?>"  class="radius3 tuan_topser" />
            <input type="submit" style="margin-left:10px;" class="radius3 sjgl_an tuan_topbt" value="搜 索"/>     
        </div>
    </div>
    </form>
    <div class="tuanfabu_tab">
        
    </div>
    <table class="tuan_table" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr style="background-color:#eee;">
            <td>昵称</td>
			<td>电话号码</td>
            <td>秀币</td>
            <td>优惠卡余额</td>
            <td>赠品余额</td>
            <td>上级</td>
        </tr>
        <?php if(is_array($list)): foreach($list as $key=>$var): ?><tr>
                <td><img width="50px" height="50px" src="<?php echo config_img($var['face']);?>" /><p><?php echo ($var['nickname']); ?></p></td>
				<td><?php echo ($var['mobile']); ?></td>
                <td><?php echo ($var['integral']); ?></td>
                <td><?php echo ($var['yhk']); ?></td>
                <td>
                    <?php if(is_array($var["zp"])): foreach($var["zp"] as $key=>$row): ?><p><?php echo ($key); ?>:<?php echo ($row); ?></p><?php endforeach; endif; ?>
                </td>
                <td>
                    <?php if($parent_users[$var['user_id']][$shop_id]): ?><span>
                            <img width="50px" height="50px" src="<?php echo config_img($users_map[$parent_users[$var['user_id']][$shop_id]]['face']);?>" />
                        </span>
                        <span>
                            <p>昵称:<?php echo ($users_map[$parent_users[$var['user_id']][$shop_id]]['nickname']); ?></p>
                            <p>手机:<?php echo ($users_map[$parent_users[$var['user_id']][$shop_id]]['mobile']); ?></p>
                        </span>
                    <?php else: ?>
                        --<?php endif; ?>
                </td>
            </tr><?php endforeach; endif; ?>
    </table>
    <div class="paging">
        <?php echo ($page); ?>
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