<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/16
 * Time: 16:32
 */
class YhkAction extends CommonAction {

    public function index() {
        $user = D('Users')->find($this->app_uid);
        $yhk = (array)json_decode($user['yhk']);
        $yhk_n = array();
        $zp = (array)json_decode($user['zp']);
        $zp_n = array();
        foreach($zp as $k=>$v){
            $zp_n[$k] = (array)$v;
        }
        foreach($yhk as $k=>$v){
            $shop = D('Shop')->find($k);
            if($shop){
                if(isset($zp_n[$k])){
                    $yhk_n[] = array(
                        'shop_id'=>$shop['shop_id'],
                        'yhk'=>$v,
                        'shop_name'=>$shop['shop_name'],
                        'logo'=>$shop['logo'],
                        'zp'=>$zp_n[$k]
                    );
                }else{
                    $yhk_n[] = array(
                        'shop_id'=>$shop['shop_id'],
                        'yhk'=>$v,
                        'shop_name'=>$shop['shop_name'],
                        'logo'=>$shop['logo']
                    );
                }

            }
        }
        $rs = array(
            'success'=>true,
            'yhk'=>$yhk_n,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }

    public function share(){
        //include '../phpqrcode.php';
        //http://$Think.SERVER.HTTP_HOST}>__ROOT__<{:U('/mobile/shop/detail',array('shop_id'=>$shop_id))}>?uid=<{$uid}>
        $shop_id=$this->_param('shop_id');
        $url=getSiteUrl().U('/Apipublic/ApiPshop/shopdetail',array('shop_id'=>$shop_id))."?uid=".$this->app_uid;
        //$url=getSiteUrl().U('/Apipublic/ApiPshop/shopdetail',array('shop_id'=>$shop_id,'uid'=>$this->app_uid));
       /* $rs = array(
            'success'=>true,
            'url'=>$url,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');*/
        $this->ctqrcode($url);
        echo $url;
    }

}