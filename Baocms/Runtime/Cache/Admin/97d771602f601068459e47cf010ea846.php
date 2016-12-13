<?php if (!defined('THINK_PATH')) exit();?><div class="listBox clfx">
    <div class="menuManage">
        <form  target="baocms_frm" action="<?php echo U('area/create');?>" method="post">
            <div class="mainScAdd">
                <div class="tableBox">
                    <table bordercolor="#e1e6eb" cellspacing="0" width="100%" border="1px"  style=" border-collapse: collapse; margin:0px; vertical-align:middle; background-color:#FFF;" >
                        <tr>
                            <td class="lfTdBt">区域名称：</td>
                            <td class="rgTdBt"><input type="text" name="data[area_name]" value="<?php echo (($detail["area_name"])?($detail["area_name"]):''); ?>" class="scAddTextName" />
                            </td>
                        </tr>
                         <tr>
                            <td class="lfTdBt">所在城市：</td>
                            <td class="rgTdBt">
                            <select id="data[city_id]" name="data[city_id]" class="selectInput">
                            <option value="0">请选择...</option>
                            <?php if(is_array($citys)): foreach($citys as $key=>$var): ?><option value="<?php echo ($var["city_id"]); ?>"  <?php if(($var["city_id"]) == $detail["city_id"]): ?>selected="selected"<?php endif; ?> ><?php echo ($var["name"]); ?></option><?php endforeach; endif; ?>
                        </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="lfTdBt">排序：</td>
                            <td class="rgTdBt"><input type="text" name="data[orderby]" value="<?php echo (($detail["orderby"])?($detail["orderby"]):''); ?>" class="scAddTextName" />
                                <code>数字越小排序越高</code>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="smtQr"><input type="submit" value="确认保存" class="smtQrIpt" /></div>
            </div>
        </form>
    </div>
</div>