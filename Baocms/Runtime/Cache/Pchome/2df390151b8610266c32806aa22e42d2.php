<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="renderer" content="webkit">
		<title><?php echo ($seo_title); ?></title>
		<meta name="keywords" content="<?php echo ($seo_keywords); ?>" />
		<meta name="description" content="<?php echo ($seo_description); ?>" />
		<link rel="stylesheet" href="/static/default/pc/css/base.css" />
		<link rel="stylesheet" href="/static/default/pc/css/<?php echo ($ctl); ?>.css" />
		<script src="/static/default/pc/js/jquery.js"></script>
		<script src="/static/default/pc/js/respond.js"></script>
		<script src="/static/default/pc/js/load.js"></script>
		<script src="/static/default/pc/js/base.js"></script>
        <!-- 兼容搜索下拉的写法 -->
        <script src="__TMPL__statics/js/js.js"></script>
        <!-- 兼容搜索下拉的写法  -->
	</head>
	<body>
		<iframe id="x-frame" name="x-frame" style="display:none;"></iframe>
		<!-- 顶部导航 -->
		<!-- LOGO栏 -->
		<div class="topOne">
    <div class="nr">
        <?php if(empty($MEMBER)): ?><div class="left">您好，欢迎访问<?php echo ($CONFIG["site"]["sitename"]); ?>
        <a href="javascript:void(0);" class="on login_kuaijie" id="login">登陆</a>
        <script>
         $(document).ready(function () {
           $(".login_kuaijie").click(function(){
             ajaxLogin();
           })
         })
        </script>
        |<a href="<?php echo U('passport/register');?>">注册</a>
        <?php else: ?>
        <div class="left">欢迎 <b style="color: red;font-size:14px;"><?php echo ($MEMBER["nickname"]); ?></b> 来到<?php echo ($CONFIG["site"]["sitename"]); ?>&nbsp;&nbsp; 
        <a href="<?php echo u('member/index/index');?>" class="maincl" >个人中心</a>
        <a href="<?php echo u('message/index');?>" class="maincl toponeCart" >消息中心
        <?php if(!empty($msg_day)): ?><i id="num" class="radius100"><?php echo ($msg_day); endif; ?></i></a>
        <a href="<?php echo u('pchome/passport/logout');?>" class="maincl" >退出登录</a><?php endif; ?>
        <a href="<?php echo U('download/index');?>" class="topSm blackcl6">下载手机客户端</a>
    </div>
    <div class="right">
        <ul>
            <li class="liOne"><a class="liOneB" href="<?php echo u('member/order/index');?>" >我的订单</a></li>
            <li class="liOne"><a class="liOneA" href="javascript:void(0);">我的服务<em>&nbsp;</em></a>
                <div class="list">
                    <ul>
                        <li><a href="<?php echo u('member/order/index');?>">我的订单</a></li>
                        <li><a href="<?php echo u('member/ele/index');?>">我的外卖</a></li>
                        <li><a href="<?php echo u('member/yuyue/index');?>">我的预约</a></li>
                        <li><a href="<?php echo u('member/dianping/index');?>">我的评价</a></li>
                        <li><a href="<?php echo u('member/favorites/index');?>">我的收藏</a></li>                                    
                        <li><a href="<?php echo u('member/myactivity/index');?>">我的活动</a></li>
                        <li><a href="<?php echo u('member/life/index');?>">会员服务</a></li>
                        <li><a href="<?php echo u('member/set/nickname');?>">帐号设置</a></li>
                    </ul>
                </div>
            </li>
            <span>|</span>
            <li class="liOne liOne_visit"><a class="liOneA" href="javascript:void(0);">最近浏览<em>&nbsp;</em></a>
                <div class="list liOne_visit_pull">
                    <ul style="border:none !important;">
                        <?php
 $views = unserialize(cookie('views')); $views = array_reverse($views, TRUE); if($views){ foreach($views as $v){ ?>
                        <li class="liOne_visit_pull_li">
                            <a href="<?php echo U('tuan/detail',array('tuan_id'=>$v['tuan_id']));?>"><img src="__ROOT__/attachs/<?php echo ($v["photo"]); ?>" width="80" height="50" /></a>
                            <h5><a href="<?php echo U('tuan/detail',array('tuan_id'=>$v['tuan_id']));?>"><?php echo ($v["title"]); ?></a></h5>
                            <div class="price_box"><a href="<?php echo U('tuan/detail',array('tuan_id'=>$v['tuan_id']));?>"><em class="price">￥<?php echo ($v["tuan_price"]); ?></em><span class="old_price">￥<?php echo ($v["price"]); ?></span></a></div>
                        </li>
                        <?php }?>
                    </ul>
                    <p class="empty"><a href="javascript:;" id="emptyhistory">清空最近浏览记录</a></p>
                    <?php }else{?>
                    <p class="empty">您还没有浏览记录</p>
                    <?php } ?>
                </div>
            </li>
            <span>|</span>
            <li class="liOne"> <a class="liOneA" href="javascript:void(0);">我是商家<em>&nbsp;</em></a>
                <div class="list">
                    <ul>
                        <li><a href="<?php echo u('shangjia/login/index');?>">商家登陆</a></li>
                    </ul>
                </div>
            </li>
            <span>|</span>
            <li class="liOne"> <a class="liOneA" href="javascript:void(0);">网站导航<em>&nbsp;</em></a>
                <div class="list">
                    <ul>
                       <li><a href="<?php echo u('shangjia/login/index');?>">商家中心</a></li>

                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
</div>
<script>
    $(document).ready(function(){
        $("#emptyhistory").click(function(){
            $.get("<?php echo U('tuan/emptyviews');?>",function(data){
                if(data.status == 'success'){
                    $(".liOne_visit_pull ul li").remove();
                    $(".liOne_visit_pull p.empty").html("您还没有浏览记录");
                }else{
                    layer.msg(data.msg,{icon:2});
                }
            },'json')
        })
    });
</script>   
<style>
.liOne {z-index: 999;}
.common-banner--floor {width:1200px;}
.common-banner--newtop {width:1200px; height: 60px;margin:0px auto 0; border: none;padding: 0;overflow: hidden;}
.common-banner {position: relative;text-align: center;}
.common-banner--newtop .common-banner__sheet {width: 100%;}
.common-banner--floor .color--left { left: 0;}
.common-banner--floor .color {position: absolute; width: 50%;height: 60px;margin: 0;padding: 0;border: none;}
.common-banner--floor .color--right {right: 0;}
.common-banner--floor .common-banner__link { position: absolute;top: 0;left: 50%;width: 1170px; height: 60px; margin-left: -585px;}
.common-banner--newtop .common-banner__link { display: block;z-index: 9;}
.common-banner img { vertical-align: top;}
.cf:after {display: block;clear: both;height: 0;overflow: hidden;visibility: hidden;}
.common-banner--floor .close {z-index:10;}
.common-banner .close {position: absolute;top:8px;right:8px;background:url(/themes/default/Pchome/statics/images/tp_54.png) no-repeat center center;}
.common-close--iconfont-small { padding: 8px;}
</style>



<?php  $cache = cache(array('type'=>'File','expire'=> 21600)); $token = md5("Ad, closed=0 AND site_id=67 AND  city_id IN ({$city_ids}) and bg_date <= '{$today}' AND end_date >= '{$today}' ,0,1,21600,orderby asc,,"); if(!$items= $cache->get($token)){ $items = D("Ad")->where(" closed=0 AND site_id=67 AND  city_id IN ({$city_ids}) and bg_date <= '{$today}' AND end_date >= '{$today}' ")->order("orderby asc")->limit("0,1")->select(); $cache->set($token,$items); } ; $index=0; foreach($items as $item): $index++; ?><div class="J-hub J-banner-newtop ui-slider common-banner common-banner--newtop common-banner--floor log-mod-viewed J-banner-stamp-active" >
            <div class="common-banner__sheet cf">
                <div class="color color--left" style="background:#83d8f5"></div>
                <div class="color color--right" style="background:#83d8f5"></div>
                <a class="common-banner__link" target="_blank" href="<?php echo ($item["link_url"]); ?>" >
                     <img  src="<?php echo config_img($item['photo']);?>" width="1200" height="60" >
                </a>
            </div><a href="javascript:void(0)" class="F-glob F-glob-close common-close--iconfont-small close" title="关闭"></a>
</div> <?php endforeach; ?>
<script>
    $(document).ready(function () {
		$(".common-close--iconfont-small").click(function () {
            $(".common-banner").hide();
        });
    });
</script>
<div class="topTwo">
    <div class="left">
        <?php if(!empty($CONFIG['site']['logo'])): if(!empty($city['photo'])): ?><h1><a href="<?php echo u('pchome/index/index');?>"><img src="<?php echo config_img($city['photo']);?>" width="215" height="65" /></a></h1>
            <?php else: ?>
            <h1><a href="<?php echo u('pchome/index/index');?>"><img src="<?php echo config_img($CONFIG['site']['logo']);?>" /></a></h1><?php endif; endif; ?> 
        <div class="changeCity">
            <p class="changeCity_name"><?php echo ($city_name); ?></p>
            <a href="<?php echo u('pchome/city/index');?>" class="graycl changeCity_link">更换城市</a>
        </div>
    </div>
    <div class="right searchBox_r">
    <script>
		$(document).ready(function () {
			$(".selectList li a").click(function () {
				$("#search_form").attr('action', $(this).attr('rel'));
				$("#selectBoxInput").html($(this).html());
				$('.selectList').hide();
			});

			$(".selectList a").each(function(){
				if($(this).attr("cur")){
					$("#search_form").attr('action', $(this).attr('rel'));
					$("#selectBoxInput").html($(this).html());                                
				}
			})
		});
	</script>

        <div class="searchBox">
        	<form id="search_form"  method="post" action="<?php echo u('pchome/all/index');?>">
            <div class="selectBox"> <span class="select"  id="selectBoxInput">全部</span>
                <div  class="selectList">
                    <ul>
<li><a href="javascript:void(0);" <?php if($ctl == 'all'){?> cur='true'<?php }?> rel="<?php echo u('pchome/all/index');?>">全部</a></li>
<li><a href="javascript:void(0);" <?php if($ctl == 'shop'){?> cur='true'<?php }?> rel="<?php echo u('pchome/shop/index');?>">商家</a></li>
<li><a href="javascript:void(0);" <?php if($ctl == 'tuan'){?> cur='true'<?php }?>rel="<?php echo u('pchome/tuan/index');?>">抢购</a></li>
<li><a href="javascript:void(0);" <?php if($ctl == 'life'){?> cur='true'<?php }?>rel="<?php echo u('pchome/life/index');?>">生活</a></li>
<li><a href="javascript:void(0);" <?php if($ctl == 'mall'){?> cur='true'<?php }?>rel="<?php echo u('pchome/mall/index');?>">商品</a></li>
<li><a href="javascript:void(0);" <?php if($ctl == 'news'){?> cur='true'<?php }?>rel="<?php echo u('pchome/news/index');?>">新闻</a></li>

                    </ul>        

                </div>
            </div>

            <input type="text" class="text" <?php if($ctl != ding): ?>name="keyword" value="<?php echo (($keyword)?($keyword):'输入您要搜索的内容'); ?>"<?php endif; ?> onclick="if (value == defaultValue) {
                        value = '';
                        this.style.color = '#000'
                    }"  onBlur="if (!value) {
                                value = defaultValue;
                                this.style.color = '#999'
                            }" />

            <input type="submit" class="submit" value="搜索" />
            </form>
        </div>

        <div class="hotSearch">
            <?php $a =1; ?>
            <?php  $cache = cache(array('type'=>'File','expire'=> 43200)); $token = md5("Keyword,,0,8,43200,key_id desc,,"); if(!$items= $cache->get($token)){ $items = D("Keyword")->where("")->order("key_id desc")->limit("0,8")->select(); $cache->set($token,$items); } ; $index=0; foreach($items as $item): $index++; if($item['type'] == 0 or $item['type'] == 1): ?><a href="<?php echo u('pchome/shop/index',array('keyword'=>$item['keyword']));?>"><?php echo ($item["keyword"]); ?></a>
                <?php elseif($item['type'] == 2): ?>
                    <a href="<?php echo u('pchome/tuan/index',array('keyword'=>$item['keyword']));?>"><?php echo ($item["keyword"]); ?></a>
                <?php elseif($item['type'] == 3): ?>
                    <a href="<?php echo u('pchome/life/index',array('keyword'=>$item['keyword']));?>"><?php echo ($item["keyword"]); ?></a>
                <?php elseif($item['type'] == 4): ?>
                    <a href="<?php echo u('pchome/mall/index',array('keyword'=>$item['keyword']));?>"><?php echo ($item["keyword"]); ?></a><?php endif; ?> <?php endforeach; ?>
        </div>
    </div>

    <div class="menu">
			<div class="ment_left">
			  <div class="ment_left_img"><img src="/themes/default/Pchome/statics/images/o2o1_13.png"></div>
			  <div class="ment_left_txt">随时退</div>
			</div>
			<div class="ment_left">
			  <div class="ment_left_img"><img src="/themes/default/Pchome/statics/images/o2o1_15.png"></div>
			  <div class="ment_left_txt">不满意免单</div>
			</div>
			<div class="ment_left">
			  <div class="ment_left_img"><img src="/themes/default/Pchome/statics/images/o2o1_17.png"></div>
			  <div class="ment_left_txt">过期退</div>
			</div>
	</div>
    <div class="clear"></div>
</div>







 
		<div class="layout">
			<div class="navbar">
				<div class="container">			
					<div class="navbar-body">
						<div class="main-drop float-left">
							<span class="main-drop-title">全部商家分类 </span>
							<div class="main-drop-menu <?php if($ctl != 'index'): ?>out-index<?php endif; ?>">
								<?php $i=0; ?> <!--定义I函数-->
								<?php if(is_array($tuancates)): foreach($tuancates as $key=>$item): if(($item["parent_id"]) == "0"): $i++;if($i <= 10){ ?>
								<dl>
									<dt><a href="<?php echo U('tuan/index',array('cat'=>$item['cate_id']));?>"><?php echo msubstr($item['cate_name'],0,2,'utf-8',false);?></a></dt>
									<dd class="sub-nav">
										<?php $i2=0; ?>
										 <?php if(is_array($tuancates)): foreach($tuancates as $key=>$item2): if(($item2["parent_id"]) == $item["cate_id"]): $i2++;if($i2 <= 2){ ?>
										<a href="<?php echo U('tuan/index',array('cat'=>$item['cate_id'],'cate_id'=>$item2['cate_id']));?>"><?php echo msubstr($item2['cate_name'],0,4,'utf-8',false);?></a>
									 <?php } endif; endforeach; endif; ?>
									</dd>
									<dd class="pop-nav">
										<span><?php echo ($item["cate_name"]); ?></span>
										<ul>
											<?php if(is_array($tuancates)): foreach($tuancates as $key=>$item2): ?><!--二级分类foreach-->
												<?php if(($item2["parent_id"]) == $item["cate_id"]): ?><!--删选条件-->
											<li><a href="<?php echo U('tuan/index',array('cat'=>$item['cate_id'],'cate_id'=>$item2['cate_id']));?>"><?php echo ($item2['cate_name']); ?></a></li><?php endif; endforeach; endif; ?>
										</ul>
									</dd>
									<span class="icon icon-angle-right"></span>
								</dl>
								<?php } endif; endforeach; endif; ?>
							</div>
						</div>
						<ul class="nav nav-inline nav-menu">
<?php $map = array('status' => 4); $navigations = D('Navigation'); $nav = $navigations ->where($map)->order(array('orderby' => 'asc'))->select(); ?>

<?php if(is_array($nav)): $index = 0; $__LIST__ = $nav;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$var): $mod = ($index % 2 );++$index; if(($var["parent_id"] == 0)): ?><li class="navLi"><a <?php if($ctl == $var['title']): ?>class="navA  on"<?php else: ?>class="navA"<?php endif; ?> title="<?php echo ($var['nav_name']); ?>" href="<?php echo ($var['url']); ?>" ><?php echo ($var['nav_name']); ?> <?php if($var['is_new'] == 1): ?><em class="hot"></em><?php endif; ?> </a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
						</ul>
						<?php if($ctl == 'index'): ?><div class="navbar-text navbar-right"><a class="dialogs" href="javascript:;" data-toggle="click" data-target="#shop-cate" data-mask="1" data-width="60%"><i class="icon icon-bars"></i> 选商家</a></div><?php endif; ?>
					</div>
				</div>
			</div>
		</div>   <div class="blank-10"></div>
<div class="container">
	<div class="line">
		<div class="x3">
			<div class="bar-left fixed" data-style="fixed-top" data-offset-fixed="10">
				<dl class="user-panel">
					<dt><img src="<?php echo config_img($MEMBER['face']);?>" /></dt>
					<dd>
						<span><?php if(!empty($MEMBER)): echo ($MEMBER['nickname']); else: ?>游客<?php endif; ?></span>
						<span><?php if(!empty($MEMBER)): ?>发帖数：<?php echo ($MEMBER['post_num']); else: ?>点击这里[<a mini="load" href="/tieba/login.html">登录</a>]<?php endif; ?></span>
					</dd>
				</dl>
				<div class="blank-10"></div>
				<div class="collapse bar-cate">
					<div class="cate-index"><a href="<?php echo U('tieba/index');?>"><i class="icon-reorder"></i> 全部板块</a></div>
					<?php $i=0; ?>
					<?php if(is_array($sharecates)): foreach($sharecates as $key=>$item): if(($item["parent_id"]) == "0"): $i++; ?>
					<div class="panel <?php if(($i) == "1"): ?>active<?php endif; ?>">
						<div class="panel-head"><h4><?php echo ($item["cate_name"]); ?></h4></div>
						<div class="panel-body">
							<ul>
								<?php if(is_array($sharecates)): foreach($sharecates as $key=>$item2): if(($item2["parent_id"]) == $item["cate_id"]): ?><li><a href="<?php echo U('tieba/index',array('cat'=>$item2['cate_id']));?>"><?php echo ($item2["cate_name"]); ?></a></li><?php endif; endforeach; endif; ?>
							</ul>
						</div>
					</div><?php endif; endforeach; endif; ?>
				</div>
			</div>
		</div>
		<div class="x9">
			<div class="bar-status">
				<?php foreach($sharecates as $k){ if($k['cate_id']==$cat){ $cate = $k; $chid = $k['parent_id']; } } foreach($sharecates as $k){ if($k['cate_id']==$chid){ $channel = $k; } } ?>
				<h2><?php if($cat == 0): ?>全部板块<?php else: echo ($channel['cate_name']); ?> / <?php echo ($cate['cate_name']); endif; ?></h2>
				<span>帖子总数：<em><?php echo ($total["post"]); ?></em></span>
			</div>
			<div class="blank-10"></div>
			<div class="bar-sort">
				<ul>
					<li <?php if(($order) == "d"): ?>class="current"<?php endif; ?> >
						<a href="<?php echo LinkTo('tieba/index',$linkArr,array('order'=>'d'));?>">默认排序
							<?php if($order != 'd'): ?><i class="icon-sort-desc"></i><?php else: ?><i class="icon-sort-asc"></i><?php endif; ?>
						</a>
					</li>  
					<li <?php if(($order) == "x"): ?>class="current"<?php endif; ?>>
						<a href="<?php echo LinkTo('tieba/index',$linkArr,array('order'=>'x'));?>">点赞排序 
							<?php if($order != 'x'): ?><i class="icon-sort-desc"></i><?php else: ?><i class="icon-sort-asc"></i><?php endif; ?>
						</a>
					</li>
					<li <?php if(($order) == "t"): ?>class="current"<?php endif; ?>>
						<a href="<?php echo LinkTo('tieba/index',$linkArr,array('order'=>'t'));?>">热度排序 
							<?php if($order != 't'): ?><i class="icon-sort-desc"></i><?php else: ?><i class="icon-sort-asc"></i><?php endif; ?>
						</a>
					</li>
				</ul>
                <?php if(!empty($cat)): ?><a class="sort-post" href="#post"><i class="icon-pencil-square-o"></i> 我要发帖</a><?php endif; ?>
			</div>
			<div class="blank-10"></div>
			<div class="bar-list">
				<?php if(!empty($list)): ?><ul class="tie-list">
					<?php if(is_array($list)): foreach($list as $key=>$item): ?><li class="line">
						<div class="x1">
							<span class="rcount"><?php echo ($item["reply_num"]); ?></span>
						</div>
						<div class="x9">
							<div class="title">
								<a href="<?php echo U('tieba/detail',array('post_id'=>$item['post_id']));?>"><?php echo ($item['title']); ?></a>
								<?php if(($item["is_fine"]) == "1"): ?><span class="badge bg-dot">精</span><?php endif; ?>
							</div>
							<p><?php echo msubstr(strip_tags($item['details']),0,100);?></p>
							<?php if(!empty($item['pic'])): $gallery = explode(',',$item['pic']); ?>
							<ul class="gallery">
								<?php if(is_array($gallery)): foreach($gallery as $key=>$var): ?><li><a href="/attachs/<?php echo ($var); ?>"><img src="/attachs/<?php echo ($var); ?>" /></a></li><?php endforeach; endif; ?>
							</ul><?php endif; ?>
						</div>
						<div class="x2">
							<dl class="reply">
								<dt><?php echo ($users[$item['user_id']]['nickname']); ?></dt>
							</dl>
						</div>
					</li><?php endforeach; endif; ?>
				</ul>
				<?php else: ?>
				<div class="blank-20"></div>
				<div class="text-center">
					这里暂时没有人来开辟发帖记录，就等你来破了！
				</div><?php endif; ?>
				<div class="blank-20"></div>
				<div class="text-center">
					<div class="pagination">
						<?php echo ($page); ?>
					</div>
				</div>
				<div class="blank-20"></div>
			</div>
			<?php if(!empty($cat)): ?><div class="tieba-form">
				<form target="x-frame" action="<?php echo U('tieba/post');?>" method="post" id="post">
					<div class="line">
						<div class="x12">
							<div class="post-photo">
								<strong>上传图片</strong> <span>(只有登录成功才能发表帖子、上传图片哦！)</span>											
								<div class="left">
                        <script type="text/javascript" src="/Public/js/uploadify/jquery.uploadify.min.js"></script>
                        <link rel="stylesheet" href="/Public/js/uploadify/uploadify.css">
                    </div>
                   <div class="lef" style="float: left;">
                        <div>
                            <input id="niu_file" name="niu_file" type="file" multiple="true" value="<?php echo ($item["pic"]); ?>" />
							<input type="hidden" id="photo" name="data[photo]" />
                        </div>
                        <div class="jq_uploads_img">
                            <?php if(is_array($photos)): foreach($photos as $key=>$item): ?><span style="width: 200px; height: 120px; float: left; margin-left: 5px; margin-top: 10px;"> 
                            <img width="200" height="100" src="__ROOT__/attachs/<?php echo ($item["pic"]); ?>">  
                            <input type="hidden" name="photos" value="<?php echo ($item["pic"]); ?>" />  
                            <a class="myInfor_sx" href="#">取消</a>  
                        </span><?php endforeach; endif; ?>
                        </div>
                        <script>
                            $("#niu_file").uploadify({
                                'swf': '__PUBLIC__/js/uploadify/uploadify.swf?t=<?php echo ($nowtime); ?>',
                                'uploader': '<?php echo U("app/upload/uploadify",array("model"=>"tieba"));?>',
                                'cancelImg': '__PUBLIC__/js/uploadify/uploadify-cancel.png',
                                'buttonText': '上传图片',
                                'fileTypeExts': '*.gif;*.jpg;*.png',
                                'queueSizeLimit': 5,
                                'onUploadSuccess': function (file, data, response) {
                                    var str = '<span style="width: 200px; height: 120px; float: left; margin-left: 5px; margin-top: 10px;">  <img width="200" height="100" src="__ROOT__/attachs/' + data + '">  <input type="hidden" name="photos" value="' + data + '" />    <a class="myInfor_sx" href="#">取消</a>  </span>';
                                    //$(".jq_uploads_img").append(str);
									
									var photo = $("#photo").val();
									if( photo == ""){
										photo =  data;
									}else{
										photo = photo + "," + data;
									}
									$("#photo").val(photo);
									
									var strs = '<img width="200" height="100" src="__ROOT__/attachs/' + data + '">';
									$("#data_details").append(strs);
                                }
                            });
                            $(document).on("click", ".jq_uploads_img a", function () {
                                $(this).parent().remove();
                            });
                        </script>
 <script>
									$(document).ready(function () {
										<?php if(!empty($MEMBER)): ?>$("#niu_file").change(function () {
											 ajaxupload();
										});
										$(document).on("click", "#jq_photo_list  a", function () {
											$(this).parent().remove();
										});
										<?php else: ?>
										$("#niu_file").change(function () {
												alert("登录后刷新页面才可以上传图片！");
											});<?php endif; ?>
									});
									function showauthor(){
										var author = "<?php echo ($detail['user_id']); ?>";
										$("#show-list li").each(function(){
												var uid = $(this).attr("rel");
												if(uid != author){
													$(this).hide();
												}
										  });	
									}
								</script>
							</div>
						</div>
						<div class="x12">
								<input name="data[cate_id]" value="<?php echo ($cat); ?>" type="hidden">
								<p>
									<label>标题</label><input class="input" name="data[title]" value="" type="text">
								</p>
								<p>
									<label>内容</label>
									<script type="text/plain" id="data_details" name="data[details]" class="post-editor"><?php echo ($detail["details"]); ?></script>
									<link rel="stylesheet" href="__PUBLIC__/umeditor/themes/default/css/umeditor.min.css" type="text/css">
									<script type="text/javascript" charset="utf-8" src="__PUBLIC__/umeditor/umeditor.simple.js"></script>
									<script type="text/javascript" charset="utf-8" src="__PUBLIC__/umeditor/umeditor.min.js"></script>
									<script type="text/javascript" src="__PUBLIC__/umeditor/lang/zh-cn/zh-cn.js"></script>
									<script>
										um = UM.getEditor('data_details', {
											imageUrl: "<?php echo U('public/editor');?>",
											imagePath: '__ROOT__/attachs/editor/',
											lang: 'zh-cn',
											langPath: UMEDITOR_CONFIG.UMEDITOR_HOME_URL + "lang/",
											focus: false
										});
									</script>
								</p>
								<p>
									<button class="button" type="submit">发表帖子</button>
								</p>
						</div>
					</div>
				</form>
			</div><?php endif; ?>
		</div>
	</div>
</div>
<link rel="stylesheet" href="/static/default/pc/css/zoom.css" />
<script src="/static/default/pc/js/zoom.js"></script>
<div class="footerOut">
    <?php if($ctl == index): ?><div class="foot_yqlj">
            友情链接：
            <?php  $cache = cache(array('type'=>'File','expire'=> 21600)); $token = md5("Links,,0,10,21600,orderby asc,,"); if(!$items= $cache->get($token)){ $items = D("Links")->where("")->order("orderby asc")->limit("0,10")->select(); $cache->set($token,$items); } ; $index=0; foreach($items as $item): $index++; ?><a target="_blank" href="<?php echo ($item["link_url"]); ?>"><?php echo ($item["link_name"]); ?></a> <?php endforeach; ?>
        </div><?php endif; ?>

    <div class="footer">
        <div class="footNav">
            <div class="left">
                <div class="footNavLi">
                    <ul>

                    	<li class="footerLi foot_contact">
                            <h3><i class="ico_1"></i>联系我们</h3>
                			<div class="nr">
                            	<p>客服电话：<b class="fontcl3"><?php echo ($CONFIG["site"]["tel"]); ?></b></p>
                                <p class="graycl">免费长途</p>
                                <p>在线客服：<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo ($CONFIG["site"]["qq"]); ?>&site=<?php echo ($CONFIG["site"]["host"]); ?>&menu=yes"><img src="__TMPL__statics/images/foot_btn.png"/></a></p>
                                <p>工作时间：周一至周日9:00-22:00</p>
                                <p class="graycl">法定节假日除外</p>
                            </div>
                        </li>

                        <li class="footerLi">
                            <h3><i class="ico_2"></i>公司信息</h3>
                            <ul class="list">
                                <li><a target="_blank" title="关于我们" href="<?php echo U('pchome/article/system',array('content_id'=>1));?>">关于我们</a></li>
                                <li><a target="_blank" title="联系我们" href="<?php echo U('pchome/article/system',array('content_id'=>3));?>">联系我们</a></li>
                                <li><a target="_blank" title="人才招聘" href="<?php echo U('pchome/article/system',array('content_id'=>2));?>">人才招聘</a></li>
                                <li><a target="_blank" title="免责声明" href="<?php echo U('pchome/article/system',array('content_id'=>6));?>">免责声明</a></li>
                            </ul>
                        </li>

                        <li class="footerLi">
                            <h3><i class="ico_3"></i>商户合作</h3>
                            <ul class="list">
                                <li><a href="<?php echo U('pchome/shop/apply');?>">商家入驻</a></li>
                                <li><a target="_blank" title="广告合作" href="<?php echo U('pchome/article/system',array('content_id'=>5));?>">广告合作</a></li>
                                <li><a href="<?php echo U('pchome/shangjia/index/index');?>">商家后台</a></li>
                            </ul>
                        </li>
                        <li class="footerLi">
                            <h3><i class="ico_4"></i>用户帮助</h3>
                            <ul class="list">
                                <li><a target="_blank" title="服务协议" href="<?php echo U('pchome/article/system',array('content_id'=>7));?>">服务协议</a></li>
                                <li><a target="_blank" title="退款承诺" href="/">退款承诺</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="right"><p>扫一扫加关注</p><img src="__ROOT__/attachs/<?php echo ($CONFIG["site"]["wxcode"]); ?>" width="149" height="149" /></div>
        </div>
    </div>

	<div class="footerCopy">copyright 2013-2113 <?php echo ($_SERVER['HTTP_HOST']); ?> All Rights Reserved <?php echo ($CONFIG["site"]["sitename"]); ?>版权所有 - <?php echo ($CONFIG["site"]["icp"]); ?> <?php echo ($CONFIG["site"]["tongji"]); ?></div>
</div>  

<div class="topUp">
    <ul>
    	<li class="kefu"><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo ($CONFIG["site"]["qq"]); ?>&site=<?php echo ($CONFIG["site"]["host"]); ?>&menu=yes"><div class="kefu_open maincl">在线客服</div></a></li>
        <li class="topBack"><div class="topBackOn">回到<br />顶部</div></li>
        <li class="topUpWx"><div class="topUpWxk"><img src="__ROOT__/attachs/<?php echo ($CONFIG["site"]["wxcode"]); ?>" width="149" height="149" /><p class="maincl">扫描二维码关注微信</p></div></li>
    </ul>
</div>



<script>
    $(document).ready(function () {
        $(window).scroll(function () {
            if ($(window).scrollTop() > 100) {
                $(".topUp").show();
                $(".indexpop").show();
            } else {
                $(".topUp").hide();
                $(".indexpop").hide();

            }

            var ctl = "<?php echo ($ctl); ?>";
            if(ctl == 'coupon'){
                if ($(window).scrollTop() > 665) {
                    $(".spxq_xqT2").show();
                } else {
                    $(".spxq_xqT2").hide();
                }

            }else{
                if ($(window).scrollTop() > '<?php echo ($height_num); ?>') {
                    $(".spxq_xqT2").show();
                } else {
                    $(".spxq_xqT2").hide();
                }
            }
        });

        $(".topBack").click(function () {
            $("html,body").animate({scrollTop: 0}, 200);
        });

		$(window).scroll(function(){
			var top = $(document).scrollTop();          //定义变量，获取滚动条的高度
			var menu = $(".topUp");                      //定义变量，抓取topUp
			var items = $(".footerOut");    //定义变量，查找footerOut 
			items.each(function(){
				var m=$(this);
				var itemsTop = m.offset().top;      //定义变量，获取当前类的top偏移量
				if(itemsTop-360 <= top-360){
					menu.css('bottom','360px');
					menu.css('top','auto');
				}else{
					menu.css('bottom','0px');
					menu.css('top','auto');
				}
			});
		});
    });
</script>
</body>
</html>