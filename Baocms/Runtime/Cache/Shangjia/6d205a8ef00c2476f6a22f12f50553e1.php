<?php if (!defined('THINK_PATH')) exit();?><div class="tuan_content">
    <div class="tabnr_change show">
    <form method="post"  action="<?php echo U('dianping/mallreply',array('order_id'=>$detail['order_id']));?>"  target="baocms_frm">
        <table cellpadding="0" cellspacing="0" width="100%">
            
            <tr >
                    <td style="padding-top: 10px;" align="right">回复</td>
                    <td class="tl" style="padding-top: 10px;">
                        <textarea name="reply" cols="50" rows="10"></textarea>

                    </td>
                </tr>
            <tr>
                        <td></td>
                        <td class="tl">
                            <input type="submit" class="radius3 sjgl_an tuan_topbt" value="确认回复"  />
                        </td>
                    </tr>
            
        </table>
    </form>
    
    
</div>
</div>