<?php if (!defined('THINK_PATH')) exit(); if(is_array($list)): foreach($list as $key=>$order): ?><li class="line ">
        <dt>
        <a class="x4">订单ID：<?php echo ($order["order_id"]); ?></a>
        <a class="x8 text-right">下单时间：<?php echo (date('Y-m-d H:i:s',$order["create_time"])); ?></span> </a>
        </dt>
        
      <?php if(is_array($goods)): foreach($goods as $key=>$good): if($good['order_id'] == $order['order_id']): ?><dd class="zhong">
            <div class="x4">
               <img src="__ROOT__/attachs/<?php echo ($products[$good['goods_id']]['photo']); ?>" width="70" height="70">
            </div>
            <div class="x8">
                <p><a href="<?php echo U('goods/detail',array('order_id'=>$order['order_id']));?>"><?php echo ($products[$good['goods_id']]['title']); ?> </a></p>
                <p class="text-small">
                    <span class="text-dot1 margin-right">小计：<span class="text-dot">￥<?php echo round($good['price']/100,2);?> x <?php echo ($good["num"]); ?> = <?php echo round($good['total_price']/100,2);?> 元</span></span>
                </p>
                
            <p class="text-small">
            <?php if($good['mobile_fan'] > 0): ?><span class="text-dot1 margin-right">手机下单立减：<span class="text-dot"><?php echo round($good['mobile_fan']/100,2);?>元</span><?php endif; ?>
			</p>
                
                <?php $pcl_totle = $good[num]*$products[$good['goods_id']]['use_integral']; ?>
                <?php if($order['status'] > 0): if($order['use_integral'] > 0): ?><p class="text-small">
	                    <span class="text-dot1 margin-right">使用秀币：<span class="text-dot"><?php echo ($order['use_integral']); ?> 抵现：<?php echo round($order['use_integral']/100,2);?>元</span></span>
	                </p><?php endif; endif; ?>
                <?php if($order['status'] == 0): if($order['can_use_integral'] > 0): ?><p class="text-small">
	                    <span class="text-dot1 margin-right">使用秀币：<span class="text-dot"><?php echo ($order['use_integral']); ?> 抵现：<?php echo round($order['use_integral']/100,2);?>元</span></span>
	                </p><?php endif; endif; ?>
         
          </div>
         </dd><?php endif; endforeach; endif; ?>

       <?php $need_pay = $order['total_price'] - $order['use_integral'] - $order['mobile_fan']; ?>
       
       
         <dt>
             <div class="x12">
             <span class="margin-right"><?php if(($order["is_daofu"]) == "1"): ?>金额：<?php echo round($need_pay/100,2);?>（到付）<?php else: ?>
             实际支付：
             <?php if(($order["status"]) == "0"): ?>未支付
             <?php else: ?>
             <a class="text-dot">￥<?php echo round($order['need_pay']/100,2);?></a> 元<?php endif; endif; ?></span>
          
             <!--<span>运费：-->
             <!--<?php if($order['total_express'] == 0): ?>-->
             <!--免邮-->
             <!--<?php else: ?>-->
             <!--￥<?php echo round($order['total_express']/100,2);?>元-->
             <!--<?php endif; ?>-->
             <!---->
             <!---->
             <!--</span>-->
             </div>
         </dt>   
			
        
      
      <dl>
      
      <p class="text-right padding-top x12">
      
      
<?php if(($order["is_daofu"]) == "0"): ?><!--如果不是到付-->   
 
<?php switch($order["status"]): case "0": ?><a  class="button button-small bg-dot"  href="<?php echo U('mobile/mall/pay',array('order_id'=>$order['order_id']));?>" target="_blank">去付款</a>
<a  target="x-frame" class="button button-small bg-gray" href="<?php echo U('goods/orderdel',array('order_id'=>$order['order_id']));?>">取消订单</a><?php break;?>
<?php case "1": ?><span class="button button-small bg-dot">已付款</span><?php break;?>
<?php case "2": ?><a target="x-frame"  class="button button-small bg-blue" href="<?php echo U('goods/queren',array('order_id'=>$order['order_id']));?>">确认收货</a><?php break;?>
    <?php case "8": if(($order["is_dianping"]) == "0"): ?><a class="button button-small bg-blue" href="<?php echo U('goods/dianping',array('order_id'=>$order['order_id']));?>">我要评价</a><?php endif; ?> 
     <?php if(($order["is_dianping"]) == "1"): ?><a class="button button-small bg-gray">已评价</a><?php endif; break; endswitch;?>

<?php else: ?> <!--下面是到付的-->                         
<?php if(($order["is_daofu"]) == "0"): ?><a class="button button-small bg-dot" href="<?php echo U('mobile/mall/pay',array('order_id'=>$order['order_id']));?>">去付款</a>
<a  target="x-frame"  class="button button-small bg-dot" href="<?php echo U('mcenter/goods/orderdel',array('order_id'=>$order['order_id']));?>">删除订单</a>
<?php else: ?>
<span  class="button button-small bg-gray">货到付款</span>
<?php if(($order["status"]) == "2"): ?><a target="x-frame" class="button button-small bg-blue" href="<?php echo U('goods/daofu_queren',array('order_id'=>$order['order_id']));?>">确认收货</a><?php endif; ?>  

<?php if(($order["status"]) == "3"): if(($order["is_dianping"]) == "0"): ?><a class="button button-small bg-blue" href="<?php echo U('goods/dianping',array('order_id'=>$order['order_id']));?>">我要评价</a><?php endif; ?> 
     <?php if(($order["is_dianping"]) == "1"): ?><a class="button button-small bg-gray">已评价</a><?php endif; endif; endif; endif; ?>      		
 <a  class="button button-small bg-blue"  href="<?php echo U('goods/detail',array('order_id'=>$order['order_id']));?>">详情</a>           
      </p>
      
      </dl>
    </li>
    <div class="blank-10 bg"></div><?php endforeach; endif; ?>