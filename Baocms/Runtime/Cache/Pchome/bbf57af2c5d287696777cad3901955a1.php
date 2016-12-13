<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php echo ($CONFIG['site']['headinfo']); ?>
    <title><?php if($config['title'])echo $config['title'];else echo $seo_title; ?></title>
    <meta name="keywords" content="<?php echo ($seo_keywords); ?>" />
    <meta name="description" content="<?php echo ($seo_description); ?>" />
    <link href="__TMPL__statics/css/style.css?v=20150718" rel="stylesheet" type="text/css">
    <script> var BAO_PUBLIC = '__PUBLIC__'; var BAO_ROOT = '__ROOT__';</script>
    <script src="__TMPL__statics/js/jquery.js?v=20150718"></script>
    <script src="__PUBLIC__/js/layer/layer.js?v=20150718"></script>
    <script src="__TMPL__statics/js/jquery.flexslider-min.js?v=20150718"></script>
    <script src="__TMPL__statics/js/js.js?v=20150718"></script>
    <script src="__PUBLIC__/js/web.js?v=20150718"></script>
    <script src="__TMPL__statics/js/baocms.js?v=20150718"></script>
</head>
<body style="background-color:#fff;">
<div class="Erreur_box">
    <div class="Erreur">
        <p><img src="__TMPL__statics/images/erreur_404.png" width="470" height="274"></p>
        <p><span>Sorry!</span>您访问的页面不见了！</p>
        <p class="clo">你可以访问<a href="<?php echo U('pchome/index/index');?>"><?php echo ($CONFIG["site"]["sitename"]); ?>首页</a>或<a href="javascript:location.reload(true);">刷新页面</a></p>
    </div>
</div>
</body>
</html>