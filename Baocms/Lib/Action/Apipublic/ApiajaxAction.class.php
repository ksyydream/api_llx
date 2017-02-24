<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 16/11/3
 * Time: 上午11:15
 */
class ApiajaxAction extends CommonAction{

    public function get_gg(){
        $gg_list = D('Ggpic')->order('gg_id asc')->select();
        $rs=array(
            'gg_list'=>$gg_list,
            'success' => true,
            'error_msg'=>''
        );
        die(json_encode($rs));
    }

    public function change_yy(){
        $shop_list =D('Shop')->select();
        foreach($shop_list as $item){
            D('Shopfd')->where("shop_id={$item['shop_id']}")->save(array(
                'logo'=>$item['logo'],
                'photo'=>$item['photo']
            ));
        }
    }
}