<?php if (!defined('THINK_PATH')) exit();?><table>
  
    <?php if(!empty($cate['select1'])): ?><tr>
            <td align="right"><?php echo ($cate["select1"]); ?>：</td>
            <td>
                <select name="data[select1]" class="manageSelect">
                    <?php if(is_array($attrs)): foreach($attrs as $key=>$item): if(($item["type"]) == "select1"): ?><option value="<?php echo ($item["attr_id"]); ?>"  <?php if(($detail["select1"]) == $item["attr_id"]): ?>selected="selected"<?php endif; ?>  ><?php echo ($item["attr_name"]); ?></option><?php endif; endforeach; endif; ?>                    

                </select>

            </td>
        </tr><?php endif; ?>
    <?php if(!empty($cate['select2'])): ?><tr>
            <td align="right"><?php echo ($cate["select2"]); ?>：</td>
            <td>
                <select name="data[select2]" class="manageSelect">
                    <?php if(is_array($attrs)): foreach($attrs as $key=>$item): if(($item["type"]) == "select2"): ?><option value="<?php echo ($item["attr_id"]); ?>"  <?php if(($detail["select2"]) == $item["attr_id"]): ?>selected="selected"<?php endif; ?>  ><?php echo ($item["attr_name"]); ?></option><?php endif; endforeach; endif; ?>                    

                </select>

            </td>
        </tr><?php endif; ?>
    <?php if(!empty($cate['select3'])): ?><tr>
            <td align="right"><?php echo ($cate["select3"]); ?>：</td>
            <td>
                <select name="data[select3]" class="manageSelect">
                    <?php if(is_array($attrs)): foreach($attrs as $key=>$item): if(($item["type"]) == "select3"): ?><option value="<?php echo ($item["attr_id"]); ?>"  <?php if(($detail["select3"]) == $item["attr_id"]): ?>selected="selected"<?php endif; ?>  ><?php echo ($item["attr_name"]); ?></option><?php endif; endforeach; endif; ?>                    

                </select>

            </td>
        </tr><?php endif; ?>


    <?php if(!empty($cate['select4'])): ?><tr>
            <td align="right"><?php echo ($cate["select4"]); ?>：</td>
            <td>
                <select name="data[select4]" class="manageSelect">
                    <?php if(is_array($attrs)): foreach($attrs as $key=>$item): if(($item["type"]) == "select4"): ?><option value="<?php echo ($item["attr_id"]); ?>"  <?php if(($detail["select4"]) == $item["attr_id"]): ?>selected="selected"<?php endif; ?>  ><?php echo ($item["attr_name"]); ?></option><?php endif; endforeach; endif; ?>                    

                </select>

            </td>
        </tr><?php endif; ?>
    
        <?php if(!empty($cate['select5'])): ?><tr>
            <td align="right"><?php echo ($cate["select5"]); ?>：</td>
            <td>
                <select name="data[select5]" class="manageSelect">
                    <?php if(is_array($attrs)): foreach($attrs as $key=>$item): if(($item["type"]) == "select5"): ?><option value="<?php echo ($item["attr_id"]); ?>"  <?php if(($detail["select5"]) == $item["attr_id"]): ?>selected="selected"<?php endif; ?>  ><?php echo ($item["attr_name"]); ?></option><?php endif; endforeach; endif; ?>                    

                </select>

            </td>
        </tr><?php endif; ?>

</table>