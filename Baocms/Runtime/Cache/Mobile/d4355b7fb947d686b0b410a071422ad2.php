<?php if (!defined('THINK_PATH')) exit();?>
    <?php if(is_array($tuans)): foreach($tuans as $key=>$item): ?><li class="x12">
		<a class="line" href="<?php echo U('tuan/detail',array('tuan_id'=>$item['tuan_id']));?>" >
			<div class="container">
				<img class="x3" src="__ROOT__/attachs/<?php echo ($item["photo"]); ?>" />	
				<div class="des x9">
					<h5><?php echo ($item["title"]); ?></h5>
					<p class="intro">
						<?php echo msubstr($item['intro'],0,20);?>
					</p>
					<p class="info">
						<span>￥ <em><?php echo round($item['tuan_price']/100,2);?></em></span> <del>¥ <?php echo round($item['price']/100,2);?></del>
                        
                    <?php $business = D('Business') -> where('business_id ='.$item['business_id']) -> find(); $business_name = $business['business_name']; ?>
            
						<span class="text-little float-right badge bg-gray margin-small-top"><?php echo ($business_name); echo ($item["d"]); ?></span>
					</p>
				</div>
			</div>
		</a>
	</li><?php endforeach; endif; ?>