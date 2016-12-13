<?php if (!defined('THINK_PATH')) exit();?><div class="listBox clfx" style="width: 500px;">
    <div class="menuManage">
        <form target="baocms_frm" action="<?php echo U('admin/edit',array('admin_id'=>$detail['admin_id']));?>" method="post">
            <div class="mainScAdd">
                <div class="tableBox">
                    <table  bordercolor="#dbdbdb" cellspacing="0" width="100%" border="1px"  style=" border-collapse: collapse; margin:0px; vertical-align:middle; background-color:#FFF;" >

                        <tr>
                            <td class="lfTdBt">用户名：</td>
                            <td class="rgTdBt"><?php echo (($detail["username"])?($detail["username"]):''); ?>

                            </td>
                        </tr><tr>
                            <td class="lfTdBt">密码：</td>
                            <td class="rgTdBt"><input type="password" name="data[password]" value="******" class="scAddTextName w150" />

                            </td>
                        </tr>
                        <?php if(($admin["role_id"]) == "1"): ?><tr>
                            <td class="lfTdBt">角色：</td>
                            <td class="rgTdBt">
                                <select name="data[role_id]" class="seleFl w150" style="display: inline-block;" onchange="check(this.value)">
                                    <?php if(is_array($roles)): foreach($roles as $key=>$var): ?><option value="<?php echo ($var["role_id"]); ?>" <?php if(($var["role_id"]) == $detail["role_id"]): ?>selected="selected"<?php endif; ?> ><?php echo ($var["role_name"]); ?></option><?php endforeach; endif; ?>
                                </select>
                                <code>必须选择正确的角色</code>
                            </td>
                        </tr><?php endif; ?>
                        
                         </table>
                          <table class="city"   <?php if($detail["city_id"] > 0): ?>style="display:block;"<?php endif; ?>  bordercolor="#dbdbdb" cellspacing="0" width="100%" style=" border-collapse: collapse; margin:0px; vertical-align:middle; background-color:#FFF;" >
                        <tr>
                            <td class="lfTdBt">城市：</td>
                            <td class="rgTdBt"><select name="data[city_id]" style="float: left;"  id="city_id" class="seleFl w210"></select>

                            </td>
                        </tr>
                        </table>
                          <table  bordercolor="#dbdbdb" cellspacing="0" width="100%" border="1px"  style=" border-collapse: collapse; margin:0px; vertical-align:middle; background-color:#FFF;" >
                        
                    
                        <tr>
                            <td class="lfTdBt">手机：</td>
                            <td class="rgTdBt"><input type="text" name="data[mobile]" value="<?php echo (($detail["mobile"])?($detail["mobile"]):''); ?>" class="scAddTextName w150" />
                                <code>手机不能为空</code>
                            </td>
                        </tr>




                    </table>
                </div>
                <div class="smtQr"><input type="submit" value="确定编辑" class="smtQrIpt" /></div>
            </div>
        </form>
    </div>
</div>

<script src="<?php echo U('app/datas/cityarea');?>"></script>
<script>
	function check(val){
		if(val == '3'){
			$('.city').css('display','block'); 
		}else{
			$('.city').css('display','none'); 
		}	
	}
	var city_id = "<?php echo ($detail["city_id"]); ?>";
	$(document).ready(function(){
		var city_str = '<option value="0">请选择.....</option>';
		for(a in cityareas.city){
		   if(city_id == cityareas.city[a].city_id){
			   city_str += '<option selected="selected" value="'+cityareas.city[a].city_id+'">'+cityareas.city[a].name+'</option>';
		   }else{
				city_str += '<option value="'+cityareas.city[a].city_id+'">'+cityareas.city[a].name+'</option>';
		   }  
		}
		$("#city_id").html(city_str);

	});
</script>