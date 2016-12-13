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

        <li class="li2">基本设置</li>

        <li class="li2 li3">短信设置</li>

    </ul>

</div>

<p class="attention"><span>注意：</span>万能短信接口，不知道怎么使用可以询问技术售后！QQ:120585022</p>

<form  target="baocms_frm" action="<?php echo U('setting/sms');?>" method="post">

    <div class="mainScAdd">

        <div class="tableBox">

            <table  bordercolor="#dbdbdb" cellspacing="0" width="100%" border="1px"  style=" border-collapse: collapse; margin:0px; vertical-align:middle; background-color:#FFF;" >

                
                <tr>

                    <td class="lfTdBt">短信接口选择：</td>
                    <td class="rgTdBt">
                        <select name="data[dxapi]">
                            <option value="dy" 
                                <?php if($CONFIG['sms']['dxapi'] == dy): ?>selected='selected'<?php endif; ?>
                            >大鱼短信</option>
                            <option value="bo"
                                <?php if($CONFIG['sms']['dxapi'] == bo): ?>selected='selected'<?php endif; ?>
                            >短信宝</option>
                        </select>

                        <code>接口选择</code></td>

                </tr>

                <tr>

                    <td class="lfTdBt">短信URL：</td>

                    <td class="rgTdBt">

                        <input type="text" name="data[url]" value="<?php echo ($CONFIG["sms"]["url"]); ?>" style="width: 700px;" class="scAddTextName " />

                        <code>填写短信服务商的HTTP请求接口，需要将发送给的人的参数替换成{mobile}，内容替换成{content}，记住前面不能留空格！</code>

                    </td>

                </tr>



                <tr>

                    <td class="lfTdBt">内容编码：</td>

                    <td class="rgTdBt">

                        <label><input type="radio" name="data[charset]" <?php if(($CONFIG["sms"]["charset"]) == "1"): ?>checked="checked"<?php endif; ?> value="1"  />GBK</label>

                        <label><input type="radio" name="data[charset]"  <?php if(($CONFIG["sms"]["charset"]) == "0"): ?>checked="checked"<?php endif; ?>  value="0"  />UTF-8</label>

                        <code>如果短信那边编码是GBK 就需要选择GBK！</code>

                    </td>

                </tr>

                <tr>

                    <td class="lfTdBt">成功状态值：</td>

                    <td class="rgTdBt">

                        <input type="text" name="data[code]" value="<?php echo ($CONFIG["sms"]["code"]); ?>"  class="scAddTextName " />

                        <code>填写对方HTTP接口请求的正确返回值</code>

                    </td>

                </tr>

                <tr>

                    <td class="lfTdBt">大鱼短信：</td>

                    <td class="rgTdBt">Key: <input type="text" name="data[dykey]" value="<?php echo ($CONFIG["sms"]["dykey"]); ?>" class="scAddTextName " />&nbsp;&nbsp;Secret: <input type="text" name="data[dysecret]" value="<?php echo ($CONFIG["sms"]["dysecret"]); ?>" class="scAddTextName " />

                        <code>大鱼短信配置</code></td>

                </tr>

            </table>

        </div>

        <div class="smtQr"><input type="submit" value="确认保存" class="smtQrIpt" /></div>

    </div>

</form>


     
        
</div>
</body>
</html>