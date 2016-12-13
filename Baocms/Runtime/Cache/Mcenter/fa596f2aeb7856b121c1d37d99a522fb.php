<?php if (!defined('THINK_PATH')) exit();?>    <?php if(is_array($list)): foreach($list as $key=>$item): ?><li class="line tuan-card">
			<div class="x8">
				<div class="card-l">
					
					<p>名称：<?php echo bao_Msubstr($tuans[$item['tuan_id']]['title'],0,10);?></p>
                    <!--<p>商家：<?php echo ($shops[$item['tuan_id']['shop_id']]['shop_name']); ?></p>
                    <p>地址：<?php echo ($shops[$item['tuan_id']['shop_id']]['addr']); ?></p>-->
                    <p>订单ID：<?php echo ($item["order_id"]); ?>&nbsp;</p>
					<p>密码：<em class="text-yellow margin-right"><?php echo ($item["code"]); ?></i></em>
                         <?php if(($item["is_used"]) == "1"): ?>已使用
                            <a href="javascript:void(0);" rel="<?php echo ($item["code_id"]); ?>"  class="jquery-delete">删除</a> 
                            <?php else: ?>
                            <?php if(($item["status"]) == "0"): if(($item["price"]) != "0"): ?><a target="x-frame"  href="<?php echo U('tuancode/refund',array('code_id'=>$item['code_id']));?>">申请退款</a>
                            <?php else: ?>
                            到店付款<?php endif; ?>
                            <?php else: ?>
                            <?php if(($item["status"]) == "1"): ?>正在退款&nbsp;&nbsp;&nbsp;&nbsp;<a target="x-frame"  href="<?php echo U('tuancode/quxiao',array('code_id'=>$item['code_id']));?>"><font color="#990000">取消退款</font></a>
                            <?php else: ?>
                            已退款<?php endif; endif; endif; ?>
					</p>
				</div>

			</div>
			<div class="x4">
				<div class="card-r">
					<a href="<?php echo U('tuancode/weixin',array('code_id'=>$item['code_id']));?>">
						<img src="/static/default/pc/image/wx.png" />
						<p>点击查看二维码</p>
					</a>
				</div>
			</div>
		</li>
		<div class="blank-10 bg"></div><?php endforeach; endif; ?>
 <script>
	$(document).ready(function () {
		$(document).on('click', ".jquery-delete", function (e) {
			var code_id = $(this).attr('rel');
			layer.confirm('您确定要删除该抢购劵？', {
				skin: 'layer-ext-demo', 
				area: ['50%', 'auto'], //宽高
				btn: ['是的', '不'], //按钮
				shade: false //不显示遮罩
			}, function () {
				$.post("<?php echo U('tuancode/delete');?>", {code_id: code_id}, function (result) {
					if (result.status == "success") {
						layer.msg(result.msg);
						setTimeout(function () {
							location.reload();
						}, 1000);
					} else {
						layer.msg(result.msg);
					}
				}, 'json');
			});
		});
	});
</script>