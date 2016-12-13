<?php if (!defined('THINK_PATH')) exit(); if(is_array($shops)): foreach($shops as $key=>$var): ?><li>
	<a class="line" title="<?php echo ($var["shop_name"]); ?>" href="<?php echo U('favorites/detail',array('shop_id'=>$var['shop_id']));?>">
		<div class="x2"><img src="__ROOT__/attachs/<?php echo ($var["logo"]); ?>" /></div>
		<div class="x10 padding-left">
			<h5>
				<?php echo msubstr($var['shop_name'],0,6,'utf-8',false);?>
			</h5>
			<?php if(!empty($news[$var['shop_id']])){?>
			<p <?php if(isset($read_ids[$news[$var['shop_id']]['news_id']])){?> style="color:#cccccc;" <?php }?>>
			  <?php echo msubstr($news[$var['shop_id']]['title'],0,15);?>
			</p>
			 <?php }else{?>
			 <p>
			 该商家比较懒什么都没写....
			 </p>
			<?php }?>
		</div>
	</a>
</li>
<div class="blank-10 bg"></div><?php endforeach; endif; ?>