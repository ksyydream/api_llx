<?php if (!defined('THINK_PATH')) exit();?>
<?php if(is_array($list)): foreach($list as $key=>$var): ?><div class="item">	
	<div class="line">
		<div class="x2">
        
         <img class="pic"  src="<?php echo config_img($users[$var['user_id']]['face']);?>" />
            
        </div>
        
		<div class="x10">
        
			<h5><?php echo config_user_name($users[$var['user_id']]['nickname']);?></h5> 
            <p class="intro"><?php echo ($var["contents"]); ?></p>
            <?php $stars= intval(($var['score'])*20); ?>
			<p class="intro ui-starbar" ><span style="width:<?php echo ($stars); ?>%"></span></p><span class="intro intro1 float-right "><?php echo (date('Y-m-d H:i',$var["create_time"])); ?></span>
			<p class="info7 x12" >
				<?php if(is_array($pics)): $index = 0; $__LIST__ = $pics;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pic): $mod = ($index % 2 );++$index; if(($pic["dianping_id"]) == $var['dianping_id']): ?><div class="pics" class="ac" onclick="liclick(this);" href="javascript:;">
                        <img style="width:60px; height:50px;float:left;padding-right:5px"  url="<?php echo config_img($pic['pic']);?>" src="<?php echo config_img($pic['pic']);?>" >
                    </div>
                    
                    <div id="menuDetail" class="menu_detail">
                    <img style="display: none;">
               		</div><?php endif; endforeach; endif; else: echo "" ;endif; ?> 
			</p><br/>
            <?php if(!empty($var['reply'])): ?><p class="intro x12">商家回复：<a style="color:#FF6430"><?php echo ($var["reply"]); ?></a></p>
            <?php else: endif; ?>
		</div>
	</div>
</div>
<div class="blank-10 bg"></div><?php endforeach; endif; ?>

<script>
                    var _wraper = $('#menuDetail');
                    var dialogTarget;
                    function liclick(l){
                            var _this = $(l),
                                F = function(str){return _this.parent().find(str);},
                                title = F('h5').text(),
                                imgUrl = F('img').attr('url'),
                                val = _this.parent().find('.jq_jian').attr('val'),
                                did = _this.parent().find('.jq_jian').attr('did'),
                                price = F('.unit_price').text(),
                                sales = F('.sales strong').attr('class'),
                                saleNum = F('.sale_num').text(),
                                info = F('.intro1').text(),
                                saleDesc = F('.salenum').html(),
                                unit=F('.theunit').text(),
                                _detailImg = _wraper.find('img');
                                _wraper.find('.price').text(price).end()
                                .find('.sales strong').attr('class', sales).end()
                                .find('.info').text(info);
                                _wraper.parents('.dialog').find('.dialog_tt').text(title);
                                $('#detailBtn').removeClass('disabled').text('来一份');
                                $('#detailBtn').attr('val',val);
                                $('#detailBtn').attr('did',did);
                            if(imgUrl){
                                _detailImg.attr('src', imgUrl).show().next().hide();
                            }else{
                                _detailImg.hide().next().show();
                            }
                            dialogTarget = _this;
                            _wraper.dialog({title: title, closeBtn: true});
                    }
                    </script>