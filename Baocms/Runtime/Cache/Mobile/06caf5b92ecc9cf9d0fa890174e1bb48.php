<?php if (!defined('THINK_PATH')) exit(); if(is_array($list)): $index = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($index % 2 );++$index;?><a class="item" href="<?php echo U('shop/detail',array('shop_id'=>$item['shop_id']));?>">	
    
		<img class="pic" src="<?php echo config_img($item['photo']);?>" />	
		<div class="des">	
			<h5><?php echo msubstr($item['shop_name'],0,6,'utf-8',false);?> &nbsp;<?php if($item['is_renzheng'] == 1): ?><span class="renzheng">认证</span><?php endif; ?>
				<span class="distance"><?php echo ($item["d"]); ?></span>	
			</h5>	
			<div class="info">	
				<span class="ui-starbar"><span style="width:<?php echo round($item['score']*2,2);?>%"></span></span>
                
                <?php if(!empty($item['price'])): ?><!--如果价格等于0-->
                <span>￥<?php echo ($item['price']); ?>/位</span>	
                <?php else: ?>
                <span></span>	<!--0元消费--><?php endif; ?>
			</div>	
			<span class="addr">	
				<?php echo msubstr($item['addr'],0,26,'utf-8',false);?>
			</span>
		</div>	
	</a><?php endforeach; endif; else: echo "" ;endif; ?>