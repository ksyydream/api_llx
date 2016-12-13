<?php if (!defined('THINK_PATH')) exit(); if(is_array($list)): $index = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($index % 2 );++$index;?><li class="line">		
    <a href="<?php echo U('mall/detail',array('goods_id'=>$item['goods_id']));?>">		
    <div class="x3"><img src="<?php echo config_img($item['photo']);?>" />		
    </div>		
    <div class="x9" style="margin-top:0.3rem; padding: 0 5px;"><h5><?php echo bao_msubstr($item['title'],0,18);?></h5>	
    
    	<?php if(!empty($item['mobile_fan'])): ?><p class="desc">手机下单立减 <span style="color:#F00; font-size:12px;"><?php echo round($item['mobile_fan']/100,2);?></span> 元</p>	
		<?php else: ?>
        <p class="desc"><?php echo bao_msubstr($item['intro'],0,26);?></p><?php endif; ?>  
             
        <p class="info"><span>&yen;<?php echo round($item['mall_price']/100,2);?></span><del>&yen;<?php echo round($item['price']/100,2);?></del>				
        <em>已售<?php echo ($item["sold_num"]); ?></em>
        <?php $shopids = D('Shop')->where('shop_id ='.$item['shop_id'])->find(); $is_renzheng = $shopids['is_renzheng']; ?>
        <?php if($is_renzheng == 1): ?><em class="is_renzheng">认证</em><?php endif; ?>
        	</p>	
        	</div>		
            </a>	
       </li><?php endforeach; endif; else: echo "" ;endif; ?>