<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php echo ($CONFIG['site']['headinfo']); ?>
        <title><?php if($config['title'])echo $config['title'];else echo $seo_title; ?></title>
        <meta name="keywords" content="<?php echo ($seo_keywords); ?>" />
        <meta name="description" content="<?php echo ($seo_description); ?>" />
        <link href="__TMPL__statics/css/style.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="/themes/default/Pchome/statics/css/<?php echo ($ctl); ?>.css" />
        <script> var BAO_PUBLIC = '__PUBLIC__'; var BAO_ROOT = '__ROOT__';</script>
        <script src="__TMPL__statics/js/jquery.js"></script>
        <script src="__PUBLIC__/js/layer/layer.js"></script>
        <script src="__TMPL__statics/js/jquery.flexslider-min.js"></script>
        <script src="__TMPL__statics/js/js.js"></script>
        <script src="__PUBLIC__/js/web.js"></script>
        <script src="__TMPL__statics/js/baocms.js"></script>
    </head>
<style>
/*背景*/
.nav, .searchBox .submit, .sy_hottjJd, .cityInfor_nr .cityInfor_list .nr:hover .link .img, .topBackOn, .goods_flListA.on, .nearbuy_hotNum, .sy_sjcpBq1, .spxq_qgjjKk, .spxq_xqT li.on code, .hdxq_ljct, .qg-sp-tab span.on, .dcsy_topLi:hover .dcsy_topLiTu, .sjsy_ljzx, .dui-huan, .locaNr_serAn, .seat-check.on, .spxq_xqMapList li.on, .hdsy_Licj_l em, .hdsy_LicjA, .tBarFabu .sub_btn .btn, .dcsy_topLi.on .dcsy_topLiTu, .liveBtn, .cloudBuy_list .btn, .jfsy_spA, .jfsy_flexslider .flex-control-nav .flex-active, .spxq_xqT li.on a, .subBtn, .cloudBuy_cont_tab ul li.on, .zy_doorSer_detail .nrForm .btn, .basic-info .action .write,  .sy_coupon_tab a.on, .sales-promotion .tag-tuan, .comment_input p .pn, .goods .tm-fcs-panel span.y a, .login_btndz{ background-color: <?php echo ($color); ?>!important; }
/*文字颜色*/
.sy_FloorBtz .bt, .fontcl3, .topOne .nr .left a.on, .liOne:hover .liOneA, .spxq_qgsnum, .nearbuy_zjClear, .zixunList .wz .bt a, .spxq_pjAn, .sjsy_newsList h3, .locaTopDl a, .liOne .list ul li a:hover, .spxq_xqMapT, .spxq_table td a, .hdsy_Licj_l, .hdsy_Libms, .zixunDetail h1, .zixun_hot h3, .liveTab li,.shfw_xq_new li, .jfsy_jffzT, .jfsy_wellcome .blue, .maincl, .m-detail-main-winner-content .user, .pointcl, .liOne_visit_pull .empty a, .liOne_visit_pull .empty a, .goods .tm-price, .intro a, .comment .price{color: <?php echo ($color); ?>!important; }/*边框top上*/
.sy_FloorBt, .qg-sp-tab span.on, .zixun_hot h3, .liveTab {border-bottom: 1px solid <?php echo ($color); ?>!important;}/*边框*/
.spxq_qgjjKk, .hdxq_tgList, .liOne .list ul, .liOne_visit .liOne_visit_pull, .seat-check.on, .liveSearchLeft{border: 1px solid <?php echo ($color); ?>!important;}

/*特殊的*/
.liOne:hover .liOneA {color: <?php echo ($color); ?>; border-left: 1px solid <?php echo ($color); ?>;border-right: 1px solid <?php echo ($color); ?>!important;}
.changeCity_link:after {border-bottom: 2px solid <?php echo ($color); ?>!important;border-right: 2px solid <?php echo ($color); ?>!important;}
.spxq_xqT {border-bottom: 1px solid <?php echo ($color); ?>!important;}
.hdsy_tabLi.on a {border-top: 2px solid <?php echo ($color); ?>!important;}
.spxq_slider .flex-control-thumbs li .flex-active {border-color: <?php echo ($color); ?> !important;}
.zixunRelet { border-top: 2px solid <?php echo ($color); ?>!important;}
.sy_sjcpLi:hover {border-color: <?php echo ($color); ?>!important;}
.navListAll{background-color: #17A994;}
.topTwo .menu {width: 18%; margin-top: 10px;float: right;color: #929292;font-size: 12px;text-align: center;}
.topTwo .ment_left {float: left;width: 33%;}
.topTwo .ment_left .ment_left_img img { width: 36px;height: 36px;}
.navA {position: relative;}
.navA .hot {display: block;width: 27px;height: 18px;background: url(/themes/default/Pchome/statics/images/header-hot.gif) no-repeat center top;position: absolute;right: -5px;top: 2px;}
.mod .mod-title .current {border-bottom: 2px solid <?php echo ($color); ?>;}
.topTwo .searchBox_r .searchBox {border: 2px solid <?php echo ($color); ?>;}
.superior {border-top: <?php echo ($color); ?> 2px solid;}
.navListAll {background-color: #BF1550;}
.navA.on, .navA:hover { background-color: #9C1F4B;}
</style>
<style>
.anchorBL{   display:none !important;  }  
</style>



    <body>

        <iframe id="baocms_frm" name="baocms_frm" style="display:none;"></iframe> 
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








 <div class="nav">
    <div class="navList">
        <ul>
        <?php if($ctl == life): ?><li class="navListAll"><span class="navListAllt">分类信息分类</span><div class="shadowy navAll"><div class="menu_fllist2">
    <?php $k = 0; ?>            
    <?php if(is_array($channelmeans)): foreach($channelmeans as $key=>$item): $k++; ?>
        <div <?php if($i == 1): ?>class="item2 bo"<?php else: ?>class="item2"<?php endif; ?> >
            <h3>
                <div class="left ico ico_<?php echo ($k); ?>"></div>
                <div class="wz">
                	<a class="bt1" title="<?php echo ($item); ?>" target="_blank" href="<?php echo U('life/index',array('channel'=>$key));?>"><?php echo msubstr($item,0,4,'utf-8',false);?></a>
                    <div class="bt2">
                        <?php $i2=0; ?>
                        <?php if(is_array($cates)): foreach($cates as $key=>$var): if($var['channel_id'] == $k): $i2++;if($i2 <= 2){ ?>
                            <a title="<?php echo ($var['cate_name']); ?>" target="_blank" href="<?php echo U('life/index',array('channel'=> $k,'cat'=>$var['cate_id']));?>"><?php echo msubstr($var['cate_name'],0,4,'utf-8',false);?></a>
                            <?php } endif; endforeach; endif; ?>
                    </div>
                </div>
                <div class="clear"></div>
            </h3>
            <div class="menu_flklist2">
                <div class="menu_fl2t"><a title="<?php echo ($item["cate_name"]); ?>" target="_blank" href="<?php echo U('life/index',array('channel'=>$key));?>"><?php echo ($item); ?></a></div>
                <div class="menu_fl2nr">
                    <?php if(is_array($cates)): foreach($cates as $key=>$var): if($var['channel_id'] == $k): ?><a title="<?php echo ($var['cate_name']); ?>" target="_blank" href="<?php echo U('life/index',array('channel'=> $k,'cat'=>$var['cate_id']));?>"><?php echo ($var['cate_name']); ?></a><?php endif; endforeach; endif; ?>
                </div>
            </div>
        </div><?php endforeach; endif; ?>
</div>
</div></li>
        <?php elseif($ctl == shop): ?>
        	<li class="navListAll"><span class="navListAllt">全部商家分类</span><div class="shadowy navAll"><div class="menu_fllist2">
    <?php $k = 0; ?>            
   <?php if(is_array($shopcates)): foreach($shopcates as $key=>$item): if(($item["parent_id"]) == "0"): $k++; ?>
        <div <?php if($i == 1): ?>class="item2 bo"<?php else: ?>class="item2"<?php endif; ?> >
            <h3>
                <div class="left ico ico_<?php echo ($k); ?>"></div>
                <div class="wz">
                	<a class="bt1" title="<?php echo ($item); ?>" target="_blank" href="<?php echo U('shop/index',array('cat'=>$item['cate_id']));?>"> <?php echo msubstr($var['cate_name'],0,4,'utf-8',false);?></a>
                    <div class="bt2">
                		 <?php $i=0; ?>
							<?php if(is_array($shopcates)): foreach($shopcates as $key=>$var): if($var['parent_id'] == $item['cate_id'] AND $i < 5): $i++; ?>
									<?php if($i < 4): ?><a title="<?php echo ($var['cate_name']); ?>" target="_blank" href="<?php echo U('shop/index',array('cat'=>$var['cate_id']));?>"><?php echo msubstr($var['cate_name'],0,4,'utf-8',false);?></a><?php endif; endif; endforeach; endif; ?>
                    </div>
                </div>
                <div class="clear"></div>
            </h3>
            <div class="menu_flklist2">
                <div class="menu_fl2t"><a title="<?php echo ($item["cate_name"]); ?>" target="_blank" href="<?php echo U('shop/index',array('cat'=>$item['cate_id']));?>"><?php echo msubstr($var['cate_name'],0,4,'utf-8',false);?></a></div>
                <div class="menu_fl2nr">
                    <?php if(is_array($shopcates)): foreach($shopcates as $key=>$var): if($var['parent_id'] == $item['cate_id']): ?><a href="<?php echo U('shop/index',array('cat'=>$var['cate_id']));?>"><?php echo msubstr($var['cate_name'],0,4,'utf-8',false);?></a><?php endif; endforeach; endif; ?>
                </div>
            </div>
        </div><?php endif; endforeach; endif; ?>
</div>
</div></li>
        <?php else: ?>
       		<li class="navListAll"><span class="navListAllt">全部抢购分类</span><div class="shadowy navAll"><div class="menu_fllist2">
    <?php $i=0; ?>             
    <?php if(is_array($tuancates)): foreach($tuancates as $key=>$item): if(($item["parent_id"]) == "0"): $i++;if($i <= 8){ ?>
        <div <?php if($i == 1): ?>class="item2 bo"<?php else: ?>class="item2"<?php endif; ?> >
            <h3>
                <div class="left ico ico_<?php echo ($i); ?>"></div>
                <div class="wz">
                	<a class="bt1" title="<?php echo ($item["cate_name"]); ?>" target="_blank" href="<?php echo U('tuan/index',array('cat'=>$item['cate_id']));?>"><?php echo msubstr($item['cate_name'],0,2,'utf-8',false);?></a>
                    <div class="bt2">
                        <?php $i2=0; ?>
                        <?php if(is_array($tuancates)): foreach($tuancates as $key=>$item2): if(($item2["parent_id"]) == $item["cate_id"]): $i2++;if($i2 <= 2){ ?>
                            <a title="<?php echo ($item2["cate_name"]); ?>" target="_blank" href="<?php echo U('tuan/index',array('cat'=>$item['cate_id'],'cate_id'=>$item2['cate_id']));?>"><?php echo msubstr($item2['cate_name'],0,4,'utf-8',false);?></a>
                            <?php } endif; endforeach; endif; ?>
                    </div>
                </div>
                <div class="clear"></div>
            </h3>
            <div class="menu_flklist2">
                <div class="menu_fl2t"><a title="<?php echo ($item["cate_name"]); ?>" target="_blank" href="<?php echo U('tuan/index',array('cat'=>$item['cate_id']));?>"><?php echo ($item["cate_name"]); ?></a></div>
                <div class="menu_fl2nr">
                    <?php $k=0; ?>
                    <?php if(is_array($tuancates)): foreach($tuancates as $key=>$item2): if(($item2["parent_id"]) == $item["cate_id"]): ?><a title="<?php echo ($item2["cate_name"]); ?>" target="_blank" href="<?php echo U('tuan/index',array('cat'=>$item['cate_id'],'cate_id'=>$item2['cate_id']));?>"><?php echo ($item2['cate_name']); ?></a><?php endif; endforeach; endif; ?>
                </div>
            </div>
        </div>
        <?php } endif; endforeach; endif; ?>
</div>
</div></li><?php endif; ?>
        	
<?php if(is_array($navigations)): $index = 0; $__LIST__ = $navigations;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$var): $mod = ($index % 2 );++$index; if(($var["parent_id"] == 0)): ?><li class="navLi"><a <?php if($var["target"] == 1): ?>target="_blank"<?php endif; ?> <?php if($ctl == $var['title']): ?>class="navA  on"<?php else: ?>class="navA"<?php endif; ?> title="<?php echo ($var['nav_name']); ?>" href="<?php echo ($var['url']); ?>" ><?php echo ($var['nav_name']); ?> <?php if($var['is_new'] == 1): ?><em class="hot"></em><?php endif; ?> </a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>

        </ul>
    </div>
</div>
<div class="clear"></div>
<script src="/static/default/pc/js/mod/shop.js"></script>
<style>
.zy_content { padding-top: 5px;}
.mn {overflow: hidden;}
.layui-layer-page .layui-layer-content{ padding:20px;}
.layui-layer-page .layui-layer-content input[type='text']{ width:100%; height:36px; border:1px solid #ccc; background:#fff; margin-bottom:10px; text-indent:10px; font-size:14px;}
.layui-layer-page .layui-layer-content input[type='button']{ width:100%; height:40px; border:none; background:#33b095; color:#fff; font-size:16px;}
.layui-layer-page .layui-layer-content p{ line-height:28px; color:#999;}
.layui-layer-page .layui-layer-content .check_box{ overflow:hidden; margin-bottom:5px;}
.layui-layer-page .layui-layer-content .check_box label{ display:block; float:left; margin-right:20px; margin-bottom:10px;}
</style>

<div class="content zy_content">

	<div class="spxq_loca">
     <a href="<?php echo U('shop/index');?>">商家 ></a>
     <a><?php echo ($detail["shop_name"]); ?></a>
    </div>
    

        <div class="body-content c2016">
        <div class="shop-type c2016">
            <ul>
                <li class="a"><a href="<?php echo U('shop/detail',array('shop_id'=>$detail['shop_id']));?>">首页</a></li>
                <li><a href="<?php echo U('shop/about',array('shop_id'=>$detail['shop_id']));?>">商家介绍</a></li>
                <li><a href="<?php echo U('shop/photo',array('shop_id'=>$detail['shop_id']));?>">相册</a></li>
                <li><a href="<?php echo U('shop/goods',array('shop_id'=>$detail['shop_id']));?>">商品</a></li>
                <li><a href="<?php echo U('shop/tuan',array('shop_id'=>$detail['shop_id']));?>">抢购</a></li>
                <li><a href="<?php echo U('shop/coupon',array('shop_id'=>$detail['shop_id']));?>">优惠劵</a></li>
                <li><a href="<?php echo U('shop/news',array('shop_id'=>$detail['shop_id']));?>">新闻</a></li>
                <li><a href="<?php echo U('shop/ping',array('shop_id'=>$detail['shop_id']));?>">点评</a></li>
            </ul>
        </div>
        
        <!--4-->
        <div class="banner2016 c2016">
            <div class="main">
                <div id="basic-info" class="basic-info default nug_shop_ab_pv-a default">
                    <s class="cover J_cover"></s>
                    <h1 class="shop-name"><?php echo ($detail["shop_name"]); ?>
                    
                        <?php if($detail['recognition'] == 0): ?><a href="javascript:void(0);" class="branch das"  >认领商家
                            <i class="icon i-arrow"></i></a><?php endif; ?>
                    </h1>
      <!--商家认领-->              
      <script>
        $(document).ready(function(){
            $(".das").click(function(){
                layer.open({
                    type: 1,
                    title:'请选择认领理由',
                    skin: 'layui-layer-rim', //加上边框
                    area: ['360px', 'auto'], //宽高
                    content: '<input type="text" class="donate2" name="name" placeholder="姓名" value=""><input type="text" class="donate3" name="mobil]" placeholder="手机号" value=""><input type="text" class="donate4" name="conten" placeholder="申请理由" value=""><input type="button" class="sure_das" value="确认举报"><p>认领不可取消，请慎重操作</p>',
                  });
            })
            
            $(document).on('click','.sure_das',function(){
               var url = "<?php echo U('shop/recognition');?>";
                var shop_id = "<?php echo ($detail["shop_id"]); ?>";
                var name = $(".donate2").val();
				var name = $(".donate3").val();
				var name = $(".donate4").val();
                layer.confirm('您确认要认领吗？', {
                    btn: ['是的','不了'] //按钮
                  }, function(){
                    $.post(url,{shop_id:shop_id,name:name,mobile:mobile,content:content},function(data){
                        if(data.status == 'login'){
                            ajaxLogin();
                        }else if(data.status == 'error'){
                            layer.msg(data.msg);
                        }else{
                            layer.msg(data.msg);
                            setTimeout(function(){
                                window.location.reload(true);
                            },1000)
                        }
                    },'json')
                  });
            })
            
        })
    </script>
    
    
                    <div class="brief-info">
                        <span class="mid-rank-stars mid-str<?php echo round($detail['score']*1,2);?>"></span>
                        <span class="item">人均 : &yen;<?php echo ($ex["price"]); ?></span>
                    </div>
                    
                    
                    <div class="expand-info address2" itemprop="street-address">
                        <span class="info-name">地址 :</span><span class="item" itemprop="street-address" title="<?php echo ($detail["addr"]); ?>"> <?php echo ($detail["addr"]); ?></span>
                    </div>
                    <p class="expand-info tel">
                        <span class="info-name">电话 :</span><span class="item mr10" itemprop="tel"><?php echo ($detail["tel"]); ?></span>
                        <span class="item">营业时间 : <?php echo ($ex["business_time"]); ?></span>
                    </p>
                    <p class="expand-info J-service info-indent">
                        <span class="info-name">商家详情 :</span><span class="item" itemprop="intro"><?php echo bao_msubstr(cleanhtml($ex['details']),0,108,false);?>...</span>
                        <a href="<?php echo U('shop/about',array('shop_id'=>$detail['shop_id']));?>"><i class="icon shop_view"></i>商家详情 >></a>
                    </p>
                    <div class="action">
                        <?php if(!empty($detail['qq'])): ?><a class="write left-action" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo ($detail["qq"]); ?>&menu=yes" target="_blank" rel="nofollow">
                            <i class="qq"></i>商家QQ客服</a><?php endif; ?>
                        
                        <a class="write left-action" href="<?php echo U('shop/ping',array('shop_id'=>$detail['shop_id']));?>" target="_blank" rel="nofollow">
                        <i class="icon"></i>我要点评</a>
                        
                        <a class="write left-action sjsy_ljzx2" rel="<?php echo U('shop/yuyue2',array('shop_id'=>$detail['shop_id']));?>" >
                        <i class="icon"></i>我要预约</a>
                        
                        <a id="reservation" class="act-mod reservation nug_shop_ab_booking-a" href="<?php echo U('shop/ping',array('shop_id'=>$detail['shop_id']));?>"><i class="icon book"></i><span class="hd">已有 <?php echo ($detail["score_num"]); ?> 条评论</span><i class="icon hot"></i></a>
                        <div class="act-mod reservation nug_shop_ab_booking-a">
                            <i class="icon_eye"></i><span class="hd"><?php echo ($detail["view"]); ?> </span>
                        </div>
                        <span class="right-action">
                        <a id="favoritemod"  target="baocms_frm"  href="<?php echo U('shop/favorites',array('shop_id'=>$detail['shop_id']));?>" class="favorite J-favorite" title="加入收藏"><i class="icon"></i></a>
                        </span>
                    </div>
                </div>
            </div>
            <div id="aside" class="aside">
                <div class="photos-container">
                    <div class="photos">
                        <a href="<?php echo U('shop/photo',array('shop_id'=>$detail['shop_id']));?>" target="_blank">
                        <div style="background: #ddd url(<?php echo config_img($detail['photo']);?>) no-repeat 0 0; height: 180px; left: -1px; position: absolute; top: -1px; width: 180px; background-size: 100% auto;">
                        </div>
                        </a>
                        <p>
                            <a class="upload-photo" href="<?php echo U('shop/photo',array('shop_id'=>$detail['shop_id']));?>" target="_blank">更多商家图片</a><a class="icon"></a><a id="pic-count"> <?php echo ($pic); ?> </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!--4-->
        
        
        <div class="wp ct2 c2016">
        <div class="mn">
        
        <!--3-->
        <div class="mod sales-promotion c2016">
            <h2 class="mod-title c2016">
            <a class="item current">优惠促销</a>
            </h2>
            <div class="group c2016">
            <!--商品开始-->
            <?php  $cache = cache(array('type'=>'File','expire'=> 21600)); $token = md5("Goods,shop_id = {$detail['shop_id']} AND audit=1 AND closed=0,0,4,21600,goods_id desc,,"); if(!$items= $cache->get($token)){ $items = D("Goods")->where("shop_id = {$detail['shop_id']} AND audit=1 AND closed=0")->order("goods_id desc")->limit("0,4")->select(); $cache->set($token,$items); } ; $index=0; foreach($items as $item): $index++; ?><div class="item big">
                   <p class="title">
                     <a class="block-link" href="<?php echo U('mall/detail',array('goods_id'=>$item['goods_id']));?>" target="_blank"><?php echo ($item["title"]); ?></a>
                   </p>
                    <a class="block-link" href="<?php echo U('mall/detail',array('goods_id'=>$item['goods_id']));?>" target="_blank">
                    <img class="pic" src="<?php echo config_img($item['photo']);?>" title="<?php echo ($item["title"]); ?>"></a>
                    <span class="price"><em>&yen;</em><?php echo round($item['mall_price']/100,2);?></span>
                    <del class="del-price">&yen;<?php echo round($item['price']/100,2);?></del><i class="tag tag-tuan">商品</i>
                    <p class="title">结束时间 : <?php echo ($item['end_date']); ?></p>
                    <span class="sold-count">已售 <?php echo ($item['sold_num']); ?></span>
                </div> <?php endforeach; ?> 
              <!--商品结束--> 
              <!--抢购开始-->
              <?php  $cache = cache(array('type'=>'File','expire'=> 21600)); $token = md5("Tuan,shop_id = {$detail['shop_id']},0,30,21600,tuan_id desc,,"); if(!$items= $cache->get($token)){ $items = D("Tuan")->where("shop_id = {$detail['shop_id']}")->order("tuan_id desc")->limit("0,30")->select(); $cache->set($token,$items); } ; $index=0; foreach($items as $item): $index++; ?><div class="item big">
                   <p class="title">
                     <a class="block-link" href="<?php echo U('tuan/detail',array('tuan_id'=>$item['tuan_id']));?>" target="_blank"><?php echo ($item["title"]); ?></a>
                   </p>
                    <a class="block-link" href="<?php echo U('tuan/detail',array('tuan_id'=>$item['tuan_id']));?>" target="_blank">
                    <img class="pic" src="<?php echo config_img($item['photo']);?>" title="<?php echo ($item["title"]); ?>"></a>
                    <span class="price"><em>&yen;</em><?php echo round($item['tuan_price']/100,2);?></span>
                    <del class="del-price">&yen;<?php echo round($item['price']/100,2);?></del><i class="tag tag-tuan">抢购</i>
                    <p class="title">结束时间 : <?php echo ($item['end_date']); ?></p>
                    <span class="sold-count">已售 <?php echo ($item['sold_num']); ?></span>
                </div> <?php endforeach; ?> 
              <!--抢购结束--> 
              
              <!--优惠劵开始-->
              <?php  $cache = cache(array('type'=>'File','expire'=> 21600)); $token = md5("Coupon,shop_id = {$detail['shop_id']},0,30,21600,coupon_id desc,,"); if(!$items= $cache->get($token)){ $items = D("Coupon")->where("shop_id = {$detail['shop_id']}")->order("coupon_id desc")->limit("0,30")->select(); $cache->set($token,$items); } ; $index=0; foreach($items as $item): $index++; ?><div class="item big">
                   <p class="title">
                     <a class="block-link" href="<?php echo U('coupon/detail',array('coupon_id'=>$item['coupon_id']));?>" target="_blank"><?php echo ($item["title"]); ?></a>
                   </p>
                    <a class="block-link" href="<?php echo U('coupon/detail',array('coupon_id'=>$item['coupon_id']));?>" target="_blank">
                    <img class="pic" src="<?php echo config_img($item['photo']);?>" title="<?php echo ($item["title"]); ?>"></a>
                    <span class="price"><em>关注人数：</em><?php echo ($item['views']); ?></span>
                    <i class="tag tag-tuan">优惠劵</i>
                    <p class="title">结束时间 : <?php echo ($item["expire_date"]); ?></p>
                    <span class="sold-count">领取人数： <?php echo ($item["downloads"]); ?></span>
                </div> <?php endforeach; ?> 
              <!--优惠劵结束--> 
                
            </div>
        </div>
<!--结束-->
        
        
        <div class="mod comment">
            <h2 class="mod-title c2016">
                <a class="item current"><span>商家</span>图片</a>
                <span class="y">
                <a href="<?php echo U('shop/photo',array('shop_id'=>$detail['shop_id']));?>" class="star-current">更多»</a>
                </span>
            </h2>
            <div class="group c2016 photo_list">
                <ul>
                <?php  $cache = cache(array('type'=>'File','expire'=> 21600)); $token = md5("Shoppic,shop_id = {$detail['shop_id']},0,30,21600,pic_id desc,,"); if(!$items= $cache->get($token)){ $items = D("Shoppic")->where("shop_id = {$detail['shop_id']}")->order("pic_id desc")->limit("0,30")->select(); $cache->set($token,$items); } ; $index=0; foreach($items as $item): $index++; ?><li><a href="javascript:;" title="<?php echo ($item['title']); ?>"  aid="85" ><img src="<?php echo config_img($item['photo']);?>"></a></li> <?php endforeach; ?>
            
                </ul>
            </div>
        </div>
        <div id="comment" class="mod comment">
            <h2 class="mod-title c2016 J-tab">
                <a class="item current" data-type="default"><span>商家</span>点评(共有<?php echo ($detail["score_num"]); ?>人参与点评)<span class="sub-title"></span></a>
                <span class="y">
                <a href="<?php echo U('shop/ping',array('shop_id'=>$detail['shop_id']));?>" class="star-current">更多»</a>
                </span>
            </h2>
        
        <ul class="comment-list J-list">
        <!--点评开始-->
        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$var): $mod = ($i % 2 );++$i;?><li class="comment-item">
                <a class="avatar J-avatar" target="_blank" rel="nofollow"><img src="<?php echo config_img($users[$var['user_id']]['face']);?>"></a>
                    <p class="user-info">
                        <span class="y f_12 666">发表时间：<?php echo formatTime($var['create_time']);?><br><br></span>
                        <a class="name"><?php echo config_user_name($users[$var['user_id']]['nickname']);?></a>
                    </p>
                <div class="content2">
                    <p class="shop-info">
                        <span class="sml-rank-stars sml-str<?php echo round($var['score']*10,2);?>"></span>
                        <span class="item">人均<em><?php echo ($var["cost"]); ?></em>元</span>
                    </p>
                <p class="desc"><?php echo ($var["contents"]); ?></p>
                <ul class="ml cm c2016">
               				 <?php if(is_array($pics)): foreach($pics as $key=>$pic): if(($pic["dianping_id"]) == $var["dianping_id"]): ?><li><img src="<?php echo config_img($pic['pic']);?>" /></li><?php endif; endforeach; endif; ?>
                </ul>
                </div>
            </li><?php endforeach; endif; else: echo "" ;endif; ?>
       <!--点评结束-->
        </ul>
        
        <p class="comment-all">
            <a href="<?php echo U('shop/ping',array('shop_id'=>$detail['shop_id']));?>" title="" target="_blank" rel="nofollow">更多点评 &gt;&gt;</a>
            </p>
        </div>
        
        <div class="mod sales-promotion c2016">
                <h2 class="mod-title c2016">
                    <a class="item current"><span>我要</span>点评</a>
                </h2>
                   <div class="bm">
                        <div class="bm_c">
                        <form id="ping-form" class="form-auto"  target="baocms_frm" method="post" action="<?php echo U('shop/dianping',array('shop_id'=>$detail['shop_id']));?>">
                        <script src="/static/default/pc/js/upload.js"></script>
                        
                        <table cellspacing="0" cellpadding="0" class="tfm up_row mbm">
                        <tbody id="attachbody"></tbody>
                        </table>
                        
                        
                        <?php if(!empty($MEMBER)): ?><div class="frm-pic">
								<script src="/static/default/pc/js/upload.js"></script>
								<a class="button input-file" href="javascript:void(0);"> + 添加图片 <input name="niu_file" id="niu_file" type="file" /> </a>
								<span class="pic-input"></span>
								<span class="pic-tip"><i class="icon-bell"></i> 最多可添加5张照片，文件大小2M以内 </span>
							</div>
							<div class="blank-10"></div>
							<ul class="pic-list" id="jq_photo_list">
								<li class="loading" style="display:none;"><span class="icon-spinner rotate"></span></li>
							</ul>
							<div class="blank-10"></div>
							<script>
								function ajaxupload(){
									$(".loading").show();
									$.ajaxFileUpload({
										url: '<?php echo U("app/upload/uploadify",array("model"=>"dianping"));?>',
										type: 'post',
										fileElementId: 'niu_file',
										dataType: 'text',
										secureuri: false, //一般设置为false
										success: function (data, status) {
											$(".loading").hide();
											var str = '<li><img src="__ROOT__' + data + '">  <input type="hidden" name="data[photo]" value="' + data + '" /><a href="javascript:void(0);">[删除]</a></li>';
											$("#jq_photo_list").append(str);
											$("#niu_file").unbind('change');
											$("#niu_file").change(function () {
											ajaxupload();
											});
										}
									});
								}
								$(document).ready(function () {
									$("#niu_file").change(function () {
										 ajaxupload();
									});
									$(document).on("click", "#jq_photo_list  a", function () {
										$(this).parent().remove();
									});
								});
							</script><?php endif; ?>
                            
                            
                        <div class="comment_selcet">
                        	<div class="form-star m1-10">
								<ul>
									<li>
										总体评分：
										<input id="datascore" name="data[score]" type="hidden" value="1" />
										<span class="star-select" id="star-datascore">
											<a onMouseOver="javascript:setProfix('datascore_');showStars(1,'datascore');" onMouseOut="javascript:setProfix('datascore_');clearStars('datascore');" href="javascript:setProfix('datascore_');setStars(1,'datascore');"><img id="datascore_1" src="/static/default/pc/image/icon_star_1.gif"></a>
											<a onMouseOver="javascript:setProfix('datascore_');showStars(2,'datascore');" onMouseOut="javascript:setProfix('datascore_');clearStars('datascore');" href="javascript:setProfix('datascore_');setStars(2,'datascore');"><img id="datascore_2" src="/static/default/pc/image/icon_star_1.gif"></a>
											<a onMouseOver="javascript:setProfix('datascore_');showStars(3,'datascore');" onMouseOut="javascript:setProfix('datascore_');clearStars('datascore');" href="javascript:setProfix('datascore_');setStars(3,'datascore');"><img id="datascore_3" src="/static/default/pc/image/icon_star_1.gif"></a>
											<a onMouseOver="javascript:setProfix('datascore_');showStars(4,'datascore');" onMouseOut="javascript:setProfix('datascore_');clearStars('datascore');" href="javascript:setProfix('datascore_');setStars(4,'datascore');"><img id="datascore_4" src="/static/default/pc/image/icon_star_1.gif"></a>
											<a onMouseOver="javascript:setProfix('datascore_');showStars(5,'datascore');" onMouseOut="javascript:setProfix('datascore_');clearStars('datascore');" href="javascript:setProfix('datascore_');setStars(5,'datascore');"><img id="datascore_5" src="/static/default/pc/image/icon_star_1.gif"></a>
									   </span>
									</li>
									<li>
										<?php echo ($cate["d1"]); ?>评分：
										<input id="datascore1" name="data[d1]" type="hidden" value="1" />
										<span class="star-select" id="star-datascore1">
											<a onMouseOver="javascript:setProfix('datascore_');showStars(1,'datascore1');" onMouseOut="javascript:setProfix('datascore1_');clearStars('datascore1');" href="javascript:setProfix('datascore1_');setStars(1,'datascore1');"><img id="datascore1_1" src="/static/default/pc/image/icon_star_1.gif"></a>
											<a onMouseOver="javascript:setProfix('datascore1_');showStars(2,'datascore1');" onMouseOut="javascript:setProfix('datascore1_');clearStars('datascore1');" href="javascript:setProfix('datascore1_');setStars(2,'datascore1');"><img id="datascore1_2" src="/static/default/pc/image/icon_star_1.gif"></a>
											<a onMouseOver="javascript:setProfix('datascore1_');showStars(3,'datascore1');" onMouseOut="javascript:setProfix('datascore1_');clearStars('datascore1');" href="javascript:setProfix('datascore1_');setStars(3,'datascore1');"><img id="datascore1_3" src="/static/default/pc/image/icon_star_1.gif"></a>
											<a onMouseOver="javascript:setProfix('datascore1_');showStars(4,'datascore1');" onMouseOut="javascript:setProfix('datascore1_');clearStars('datascore1');" href="javascript:setProfix('datascore1_');setStars(4,'datascore1');"><img id="datascore1_4" src="/static/default/pc/image/icon_star_1.gif"></a>
											<a onMouseOver="javascript:setProfix('datascore1_');showStars(5,'datascore1');" onMouseOut="javascript:setProfix('datascore1_');clearStars('datascore1');" href="javascript:setProfix('datascore_');setStars(5,'datascore1');"><img id="datascore1_5" src="/static/default/pc/image/icon_star_1.gif"></a>
									   </span>
									</li>
									<li>
										<?php echo ($cate["d2"]); ?>评分：
										<input id="datascore2" name="data[d2]" type="hidden" value="1" />
										
										<span class="star-select" id="star-datascore2">
											<a onMouseOver="javascript:setProfix('datascore2_');showStars(1,'datascore2');" onMouseOut="javascript:setProfix('datascore2_');clearStars('datascore2');" href="javascript:setProfix('datascore2_');setStars(1,'datascore2');"><img id="datascore2_1" src="/static/default/pc/image/icon_star_1.gif"></a>
											<a onMouseOver="javascript:setProfix('datascore2_');showStars(2,'datascore2');" onMouseOut="javascript:setProfix('datascore2_');clearStars('datascore2');" href="javascript:setProfix('datascore2_');setStars(2,'datascore2');"><img id="datascore2_2" src="/static/default/pc/image/icon_star_1.gif"></a>
											<a onMouseOver="javascript:setProfix('datascore2_');showStars(3,'datascore2');" onMouseOut="javascript:setProfix('datascore2_');clearStars('datascore2');" href="javascript:setProfix('datascore2_');setStars(3,'datascore2');"><img id="datascore2_3" src="/static/default/pc/image/icon_star_1.gif"></a>
											<a onMouseOver="javascript:setProfix('datascore2_');showStars(4,'datascore2');" onMouseOut="javascript:setProfix('datascore2_');clearStars('datascore2');" href="javascript:setProfix('datascore2_');setStars(4,'datascore2');"><img id="datascore2_4" src="/static/default/pc/image/icon_star_1.gif"></a>
											<a onMouseOver="javascript:setProfix('datascore2_');showStars(5,'datascore2');" onMouseOut="javascript:setProfix('datascore2_');clearStars('datascore2');" href="javascript:setProfix('datascore_');setStars(5,'datascore2');"><img id="datascore2_5" src="/static/default/pc/image/icon_star_1.gif"></a>
									   </span>
									</li>
									<li>
										<?php echo ($cate["d3"]); ?>评分：
										<input id="datascore3" name="data[d3]" type="hidden" value="1" />
										<span class="star-select" id="star-datascore3">
											<a onMouseOver="javascript:setProfix('datascore3_');showStars(1,'datascore3');" onMouseOut="javascript:setProfix('datascore3_');clearStars('datascore3');" href="javascript:setProfix('datascore3_');setStars(1,'datascore3');"><img id="datascore3_1" src="/static/default/pc/image/icon_star_1.gif"></a>
											<a onMouseOver="javascript:setProfix('datascore3_');showStars(2,'datascore3');" onMouseOut="javascript:setProfix('datascore3_');clearStars('datascore3');" href="javascript:setProfix('datascore3_');setStars(2,'datascore3');"><img id="datascore3_2" src="/static/default/pc/image/icon_star_1.gif"></a>
											<a onMouseOver="javascript:setProfix('datascore3_');showStars(3,'datascore3');" onMouseOut="javascript:setProfix('datascore3_');clearStars('datascore3');" href="javascript:setProfix('datascore3_');setStars(3,'datascore3');"><img id="datascore3_3" src="/static/default/pc/image/icon_star_1.gif"></a>
											<a onMouseOver="javascript:setProfix('datascore3_');showStars(4,'datascore3');" onMouseOut="javascript:setProfix('datascore3_');clearStars('datascore3');" href="javascript:setProfix('datascore3_');setStars(4,'datascore3');"><img id="datascore3_4" src="/static/default/pc/image/icon_star_1.gif"></a>
											<a onMouseOver="javascript:setProfix('datascore3_');showStars(5,'datascore3');" onMouseOut="javascript:setProfix('datascore3_');clearStars('datascore3');" href="javascript:setProfix('datascore_');setStars(5,'datascore3');"><img id="datascore3_5" src="/static/default/pc/image/icon_star_1.gif"></a>
									   </span>
									</li>
								</ul>
							</div>
                        </div>
                            <div class="comment_message">
                                <textarea name="data[contents]" id="contents" class="pt" rows="5"></textarea>
                            </div>
                            <div class="comment_input">
                            人均消费 : <input type="text" name="data[cost]" id="cost" class="px">
                            <p><button type="submit" class="pn pnp"><strong>提交</strong></button></p>
                            </div>
                        </form>
                        
                        </div>
                        </div>
                    </div>
                </div>


        
        
        
        <div class="sd"><div class="bm">
            <div class="bm_h">
           	 	<h2><span>商家</span>地图</h2>
            </div>
            <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=7b92b3afff29988b6d4dbf9a00698ed8"></script>
                                <div id="allmap" style="width:250px; height:250px;"></div>
                                <script type="text/javascript">
                                    // 百度地图API功能
                                    var map = new BMap.Map("allmap");
                                    map.centerAndZoom(new BMap.Point("<?php echo ($detail["lng"]); ?>", "<?php echo ($detail["lat"]); ?>"), 15);
                                    var point = new BMap.Point("<?php echo ($detail["lng"]); ?>", "<?php echo ($detail["lat"]); ?>");
                                    map.centerAndZoom(point, 15);
                                    var marker = new BMap.Marker(point); // 创建标注
                                    map.clearOverlays();
                                    map.addOverlay(marker); // 将标注添加到地图中
                                    marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
                                    map.addControl(new BMap.NavigationControl()); //添加默认缩放平移控件
                                </script>
                                
            </div>
            <div class="bm" style="margin-top:10px;">
                <div class="bm_h">
                	<h2><span>商家</span>二维码</h2>
                </div>
                <script src="/static/default/pc/js/qrcode.js"></script><!--引入二维码js-->
                 <script type="text/javascript">
                            $(function () {
                                var str = "<?php echo ($host); echo u('wap/shop/detail',array('shop_id'=>$detail['shop_id']));?>";
                                $("#code_<?php echo ($detail["shop_id"]); ?>").empty();
                                $('#code_<?php echo ($detail["shop_id"]); ?>').qrcode(str);
                            })
                          </script>
                        <style>
                        .sy_sjcpwx canvas{width: 180px;height: 180px; margin: 0px auto; padding: 10px;background: #fff; }
                        </style>
                <div class="bm_c">
                
               		 <?php if(!empty($ex['wei_pic'])): ?><img src="<?php echo ($ex['wei_pic']); ?>" width="240" />
                    <?php else: ?>
                         <div class="sy_sjcpwx"  id="code_<?php echo ($detail["shop_id"]); ?>"></div><?php endif; ?>  
                <p class="hm">扫描商家二维码进入商家手机版</p>
                </div>
            </div>
      
        </div>
        </div>
     </div>
   </div>  
   
   
   <div class="mask_box dhPop_mask">
<div class="dhPop">
    <h2><span class="bao_closed"></span><em id="yuyue_title"></em></h2>
    <form method="post" id="yuyue_form">
        <table cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td align="right">联系人：</td>
                <td><input type="text" name="data[name]" class="dhInput" value="<?php if($MEMBER["nickname"] != null): echo ($MEMBER["nickname"]); endif; ?>" /></td>
            </tr>
            <tr>
                <td align="right">手机号：</td>
                <td><input type="text" class="dhInput" name="data[mobile]" value="<?php if($MEMBER["mobile"] != null): echo ($MEMBER["mobile"]); endif; ?>" /></td>
            </tr>
            <tr>
                <td align="right">预约日期：</td>
                <td>
                    <input type="text" class="dhInput" name="data[yuyue_date]" value="<?php echo ($yuyue_date); ?>" onfocus="WdatePicker({minDate: '<?php echo ($today); ?>'});" />
                    <select id="yuyue_time" name="data[yuyue_time]" class="dhInput" >
                        <?php $__FOR_START_29251__=0;$__FOR_END_29251__=24;for($i=$__FOR_START_29251__;$i < $__FOR_END_29251__;$i+=1){ ?><option value="<?php echo ($i); ?>:00"><?php echo ($i); ?>:00</option>
                            <option value="<?php echo ($i); ?>:30"><?php echo ($i); ?>:30</option><?php } ?>
                    </select>
                    <script>
                        $("#yuyue_time").val('<?php echo ($yuyue_time); ?>');
                    </script>
                </td>
            </tr>
            <tr>
                <td align="right">人数：</td>
                <td>
                    <select id="number" name="data[number]" class="dhInput">
                        <?php $__FOR_START_16576__=1;$__FOR_END_16576__=10;for($i=$__FOR_START_16576__;$i < $__FOR_END_16576__;$i+=1){ ?><option <?php if(($number) == $i): ?>selected="selected"<?php endif; ?> value="<?php echo ($i); ?>"><?php echo ($i); ?>人</option><?php } ?>
                        <option value="10"  <?php if(($number) == "10"): ?>selected="selected"<?php endif; ?>>10人及以上</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td  align="right">留言：</td>
                <td><textarea rows="6" cols="50" name="data[content]"></textarea></td>
            </tr> 
            <tr>
                <td align="right"></td>
                <td><input style="cursor: pointer; margin-bottom: 20px;" class="subBtn" type="button" value="立即预约" /></td>
            </tr>
        </table>
    </form>
</div>
</div>

<script src="__PUBLIC__/js/my97/WdatePicker.js"></script>  
<script>
    $(document).ready(function () {
        $(".sjsy_ljzx2").click(function () {
            var url = $(this).attr('rel');
            $("#yuyue_title").html($(this).attr('data'));
            $(".mask_box").show();
            $(".subBtn").click(function(){
                var yuyue_form = $("#yuyue_form").serialize();
                $.post(url,yuyue_form,function(data){
                    if(data.status == 'success'){
                        $(".mask_box").hide();
                        layer.msg(data.msg,{icon:1});
                            setTimeout(function () {
                                    window.location.href = data.url;
                            }, 1000)
                    }else{
                        layer.msg(data.msg,{icon:2});
                    }
                },'json')
            })
        });
        $(".bao_closed").click(function () {
            $(".mask_box").hide();
        });
    })

</script>
  

   
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