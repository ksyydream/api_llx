<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
	<head>
		<meta charset="utf-8">
		<title><?php if(!empty($seo_title)): echo ($seo_title); ?>_<?php endif; echo ($CONFIG["site"]["sitename"]); ?>会员中心</title>
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
		<?php if($CONFIG[site][concat] != 1): ?><link rel="stylesheet" href="/static/default/wap/css/base.css">
		<link rel="stylesheet" href="/static/default/wap/css/mcenter.css"/>
		<script src="/static/default/wap/js/jquery.js"></script>
		<script src="/static/default/wap/js/base.js"></script>
		<script src="/static/default/wap/other/layer.js"></script>
		<script src="/static/default/wap/other/roll.js"></script>
		<script src="/static/default/wap/js/public.js"></script>
		<?php else: ?>
		<link rel="stylesheet" href="/static/default/wap/css/??base.css,mcenter.css" />
		<script src="/static/default/wap/js/??jquery.js,base.js,roll.js,layer.js,public.js"></script><?php endif; ?>
	</head>
	<body>
<script src="/static/default/wap/js/star.js"></script>
<link rel="stylesheet" type="text/css" href="/static/default/wap/other/webuploader.css"> 
<script src="/static/default/wap/other/webuploader.js"></script> 
<style>.list-media-x {margin-top: 0.0rem;}</style>
<header class="top-fixed bg-yellow bg-inverse">
	<div class="top-back">
		<a class="top-addr" href="javascript:history.back(-1);"><i class="icon-angle-left"></i></a>
	</div>
		<div class="top-title">
			商家点评
		</div>
	<div class="top-signed">
		<?php if($msg_day > 0): ?><a href="<?php echo U('mcenter/message/index');?>">
<i class="icon-envelope"></i>
<span class="badge bg-red jiaofei"><?php echo ($msg_day); ?></span>
</a>
<?php else: ?>
    <?php if(empty($sign_day)): ?><a href="<?php echo U('mobile/sign/signed');?>" class="top-addr icon-plus"> 签到</a>    
    <?php else: ?>
    <a href="<?php echo U('mobile/passport/logout');?>" class="top-addr icon-sign-out"></a><?php endif; endif; ?>
	</div>
</header>


<form method="post" action="<?php echo U('',array('shop_id'=>$detail['shop_id']));?>"  target="x-frame">

<div class="line padding">
		<div class="x12">
			<p class="margin-small-bottom text-gray"><span> 商家“<?php echo ($detail["shop_name"]); ?>”的点评</p>
		</div>
	</div>
 <div class="blank-10 bg"></div>   
<div class="list-media-x" id="list-media">
	<ul>
    <div class="line padding border-bottom">
		<div class="x3">
			<img src="__ROOT__/attachs/<?php echo ($detail['photo']); ?>" width="90%">
		</div>
		<div class="x9">
			<p><?php echo ($detail["shop_name"]); ?></p>
			<p class="text-gray"><?php echo ($detail["d"]); ?></p>
			<p class="text-gray"><?php echo ($detail["addr"]); ?></p>
		</div>
	</div>
   </ul>
</div>
<div class="blank-10 bg"></div>



	
	

	<div class="line padding border-bottom">
		<div class="x3">
			总体评价：
		</div>
		<div class="x9">
			<span id="jq_star"></span>
		</div>
	</div>

	<div class="line padding border-bottom">
		<div class="x3">
			<?php echo ($cate['d1']); ?>评价：
		</div>
		<div class="x9">
			<span id="jq_star1"></span>
		</div>
	</div>
	
	<div class="line padding border-bottom">
		<div class="x3">
			<?php echo ($cate['d2']); ?>评价：
		</div>
		<div class="x9">
			<span id="jq_star2"></span>
		</div>
	</div>
	
	<div class="line padding border-bottom">
		<div class="x3">
			<?php echo ($cate['d3']); ?>评价：
		</div>
		<div class="x9">
			<span id="jq_star3"></span>
		</div>
	</div>
<div class="blank-10 bg"></div>
	
	
	<script>
		$(document).ready(function () {
			$("#jq_star").raty({
				numberMax: 5,
				path: '/static/default/wap/image/',
				starOff: 'star-off.png',
				starOn: 'star-on.png',
				scoreName: 'data[score]'
			});
					
			$("#jq_star1").raty({
				numberMax: 5,
				path: '/static/default/wap/image/',
				starOff: 'star-off.png',
				starOn: 'star-on.png',
				scoreName: 'data[d1]'
			});
	
			$("#jq_star2").raty({
				numberMax: 5,
				path: '/static/default/wap/image/',
				starOff: 'star-off.png',
				starOn: 'star-on.png',
				scoreName: 'data[d2]'
			});
			$("#jq_star3").raty({
				numberMax: 5,
				path: '/static/default/wap/image/',
				starOff: 'star-off.png',
				starOn: 'star-on.png',
				scoreName: 'data[d3]'
			});
		});
	</script>
	
	
	<div class="line padding border-bottom">
		<div class="x3">
			平均消费：
		</div>
		<div class="x9">
			<input type="text"  name="data[cost]" style="width:80px;" />（元）以平均消费为准
		</div>
	</div>
    
    
    <div class="blank-10 bg"></div>
    
	
	<div class="line padding ">
		<div class="blank-10"></div>
		<textarea cols="33" rows="5" name="data[contents]" placeholder="还记得这家店吗？写点评记录生活、分享体验" style="border:thin solid #eee;width:100%;resize:none;padding:10px;"></textarea>
		<div class="blank-10"></div>
	</div>
	<div class="blank-10 bg"></div>
	
	<div class="line padding ">
		<div class="x3">
			上传图片：
		</div>
	</div>
			
	<div class="blank-10"></div>
	
	<div class="Upload-img-box">
            	<div class="Upload-btn"><input type="file" id="fileToUpload" name="fileToUpload" >上传图片</div>
                <div class="Upload-img" id="jq_imgs">
                </div>
                
                <script type="text/javascript" src="/static/default/wap/js/ajaxfileupload.js"></script>
                <script>
                    function ajaxupload() {
                        $.ajaxFileUpload({
                            url: '<?php echo U("app/upload/upload",array("model"=>"dianping"));?>',
                            type: 'post',
                            fileElementId: 'fileToUpload',
                            dataType: 'text',
                            secureuri: false, //一般设置为false
                            success: function (data, status) {
								var str = '<div class="list-img"><img width="200" height="100" src="__ROOT__/attachs/' + data + '">  <input type="hidden" name="photos[]" value="' + data + '" />  <a href="javascript:void(0);">取消</a></div>';
                                $("#jq_imgs").append(str);
                                $("#fileToUpload").unbind('change');
                                $("#fileToUpload").change(function () {
                                    ajaxupload();
                                });
                            }
                        });
                    }

                    $(document).ready(function () {
                        $("#fileToUpload").change(function () {
                            ajaxupload();
                        });
                        $(document).on("click", "#jq_imgs a", function () {
                            $(this).parent().remove();
                        });
                    });
                </script>
                
                
            </div>		
			
	
			
	<div class="container">
		<div class="blank-20"></div>
		<button class="button button-big button-block bg-dot">提交评价</button>
		<div class="blank-20"></div>
	</div>
</form>
    

<div class="blank-20"></div>
<!--<?php if($CONFIG[other][footer] == 1): ?>-->
	<!---->
    <!--<footer class="foot-fixed">-->
  <!---->
    <!--<a class="foot-item <?php if(($ctl == 'index') AND ($act != 'more')): ?>active<?php endif; ?>" href="<?php echo u('mobile/index/index');?>">		-->
    <!--<span class="icon icon-home"></span>-->
    <!--<span class="foot-label">首页</span>-->
    <!--</a>-->
   <!---->
    <!---->
    <!--<a class="foot-item   <?php if(($ctl == 'tuan') || ($ctl == 'goods') || ($ctl == 'eleorder') || ($ctl == 'ding') ): ?>active<?php endif; ?>" href="      <?php echo LinkTo('tuan/index');?>">			-->
    <!--<span class="icon icon-cart-plus"></span><span class="foot-label">订单</span></a>-->
    <!---->
     <!--<a class="foot-item  <?php if(($ctl == 'tuancode')): ?>active<?php endif; ?>" href="<?php echo u('mcenter/tuancode/index');?>">			-->
    <!--<span class="icon icon-tags"></span><span class="foot-label">抢购劵</span></a>-->
    <!---->
    <!---->
    <!---->
    <!--<a class="foot-item  <?php if(($ctl == 'message') ||($act == 'xiaoxizhongxin')): ?>active<?php endif; ?>" href="<?php echo u('mcenter/message/someone');?>">			-->
    <!--<span class="icon icon-volume-up"></span><span class="foot-label">消息</span></a>-->
    <!---->
    <!--<a class="foot-item  <?php if(($ctl == 'member') || ($ctl == 'logs') || ($ctl == 'cash') ||($act == 'zijinguanli')): ?>active<?php endif; ?>" href="<?php echo u('mcenter/member/index');?>">-->
    <!--<span class="icon icon-user"></span><span class="foot-label">会员中心</span></a>-->
    <!---->
   <!---->
    <!--</footer>-->
<!--<?php endif; ?>-->


<footer class="foot-fixed">

    <a class="foot-item <?php if(($ctl == 'mall') AND ($act != 'more')): ?>active<?php endif; ?>" href="<?php echo u('mobile/mall/index');?>">
    <span class="icon icon-home"></span>
    <span class="foot-label">首页</span>
    </a>


    <a class="foot-item   <?php if(($ctl == 'tuan') || ($ctl == 'goods') || ($ctl == 'eleorder') || ($ctl == 'ding') ): ?>active<?php endif; ?>" href="<?php echo LinkTo('goods/index');?>">
    <span class="icon icon-cart-plus"></span><span class="foot-label">我的订单</span></a>

    <a class="foot-item  <?php if(($ctl == 'pay')): ?>active<?php endif; ?>" href="<?php echo U('pay/index');?>">
    <span class="icon icon-tags"></span><span class="foot-label">优惠买单</span></a>



    <a class="foot-item  <?php if(($ctl == 'message') ||($act == 'xiaoxizhongxin')): ?>active<?php endif; ?>" href="<?php echo u('mcenter/message/someone');?>">
    <span class="icon icon-volume-up"></span><span class="foot-label">消息</span></a>

    <a class="foot-item  <?php if(($ctl == 'member') || ($ctl == 'logs') || ($ctl == 'cash') ||($act == 'zijinguanli')): ?>active<?php endif; ?>" href="<?php echo u('mcenter/member/index');?>">
    <span class="icon icon-user"></span><span class="foot-label">会员中心</span></a>


</footer>

<iframe id="x-frame" name="x-frame" style="display:none;">
</iframe>
</body>
</html>