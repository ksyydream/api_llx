<?php if (!defined('THINK_PATH')) exit();?>    <?php if(is_array($list)): foreach($list as $key=>$item): ?><li class="line" onclick="location='<?php echo U($item['t_url'],array($item['t_param']=>$item['t_id']));?>'">
          <dd class="zhong">
            <div class="x3">
                   <?php if(!empty($item['t_photo'])): ?><img style="width:80%;" src="__ROOT__/attachs/<?php echo ($item["t_photo"]); ?>">
                   <?php else: ?>
                   <img style="width:80%;" src="__ROOT__/attachs/no.png"><?php endif; ?>
                   </div>
             <div class="x9">
                <p class="text-small">名称：<?php echo bao_msubstr($item['t_title'],0,26,false);?></p>
                <p class="text-gray">类型：<span class="sou"><?php echo ($item["t_name"]); ?></p>  
                <?php if(!empty($item['t_note'])): ?><p class="text-small">
                   <span class="text-dot1 margin-right">说明：<span class="text-dot"><?php echo ($item["t_note"]); ?></span></span>
                </p><?php endif; ?>
             </div>
          </dd>
        </li><?php endforeach; endif; ?>