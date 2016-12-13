<?php if (!defined('THINK_PATH')) exit();?><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> 拉拉秀电商平台</title>
<meta name="keywords" content="<{if $seo_keywords}><?php echo ($seo_keywords); ?><{elseif $SEO.keywords}><?php echo ($SEO["keywords"]); ?><{/if}>" />
<meta name="description" content="<{if $seo_description}><?php echo ($seo_description); ?><{elseif $SEO.description}><?php echo ($SEO["description"]); ?><{/if}>" />
<meta name="viewport" content="initial-scale=1.0,user-scalable=no,maximum-scale=1,width=device-width" />
<link rel="stylesheet" type="text/css" href="__TMPL__help/static/css/mobile_module.css?<?php echo ($VER); ?>"/> 
<link rel="stylesheet" type="text/css" href="__TMPL__help/static/css/font-awesome.css?<?php echo ($VER); ?>"/> 
<link rel="stylesheet" type="text/css" href="__TMPL__help/static/css/Coupon.css?<?php echo ($VER); ?>"/> 
<script type="text/javascript"  src="__TMPL__help/static/js/jquery-2.0.3.min.js?<?php echo ($VER); ?>"></script>
   <script type="text/javascript"  src="__TMPL__/static/js/web.js?<?php echo ($VER); ?>"></script>
<script type="text/javascript"  src="__TMPL__help/static/js/admin_common.js?<?php echo ($VER); ?>"></script>
<script type="text/javascript"  src="__TMPL__help/static/js/prefixfree.min.js?<?php echo ($VER); ?>"></script>
<script type="text/javascript"  src="__TMPL__help/static/js/m/dialog.js?<?php echo ($VER); ?>"></script>
<script type="text/javascript"  src="__TMPL__help/static/js/m/flipsnap.min.js?<?php echo ($VER); ?>"></script>
<script type="text/javascript"  src="__TMPL__help/static/js/m/mobile_module.js?<?php echo ($VER); ?>"></script>
<body id="scratch">
	<div class="container body" style="position:relative">
    	<div class="scr_top" style=" text-align:center">
            	<img src="<?php echo ($img_url); ?>"/>
        </div>
        <div class="over_text">
        	<h3 style=" text-align:center">请先关注我的公众号</h3>
            <p style=" text-align:center">长按以上二维码识别</p>
        </div>
        <p class="copyright" style="position:absolute; bottom:20px; width:100%"><?php echo ($CONFIG["site"]["title"]); ?></p>
        </div>
    </div>
</body>
<script type="text/javascript">
var h=$(document).height();
$('.container').height(h);
</script>