<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/20
 * Time: 11:03
 */
class CartAction extends CommonAction {

    public function cartadd()
    {
            $goods_id = (int) $this->_post('goods_id');
            if (empty($goods_id)) {
                $rs = array('success' => false, 'error_msg'=>'请选择商品!');
                die(json_encode($rs));
            }
            if (!($detail = D('Goods')->find($goods_id))) {
                $rs = array('success' => false, 'error_msg'=>'该商品不存在!');
                die(json_encode($rs));
            }
            if ($detail['closed'] != 0 || $detail['audit'] != 1) {
                $rs = array('success' => false, 'error_msg'=>'该商品不存在!');
                die(json_encode($rs));
            }
            if ($detail['end_date'] < TODAY) {
                $rs = array('success' => false, 'error_msg'=>'该商品已经过期，暂时不能购买!');
                die(json_encode($rs));
            }
            if ($detail['num'] <= 0) {
                $rs = array('success' => false, 'error_msg'=>'亲！没有库存了！');
                die(json_encode($rs));
            }
            $cart = D('Usercart');
            if($cart->checkCart($goods_id,$this->app_uid)){
                $rs = array('success' => false, 'error_msg'=>'商品已添加');
                die(json_encode($rs));
            }else {
                $data = array(
                    'goods_id' => $goods_id,
                    'user_id' => $this->app_uid,
                    'create_time' => date('Y-m-d H:i:s', time())
                );
                $cart->add($data);
                $rs = array('success' => true, 'error_msg' => '');
                die(json_encode($rs));
            }
    }

    public function cart_list(){
        $cart = D('Usercart');
        $cart_list = $cart->get_cart_list($this->app_uid);
        $rs = array(
            'success' => true,
            'cart_list'=>$cart_list,
            'error_msg' => ''
        );
        die(json_encode($rs));
    }

    public function cartdel(){
        $cart = D('Usercart');
        $cart_id = $this->_post('cart_id');
        $row = $cart->find($cart_id);
        if($row){
            if($row['user_id'] != $this->app_uid){
                $rs = array('success' => false, 'error_msg' => '只可操作自己的购物车!');
                die(json_encode($rs));
            }
        }else{
            $rs = array('success' => false, 'error_msg' => '未找到购物车信息!');
            die(json_encode($rs));
        }
        $res = $cart->where("user_id = {$this->app_uid} and cart_id = {$cart_id}")->delete();
        if($res){
            $rs = array('success' => true, 'error_msg' => '');
            die(json_encode($rs));
        }else{
            $rs = array('success' => false, 'error_msg' => '操作失败');
            die(json_encode($rs));
        }
    }

    public function cartedit(){
        $cart = D('Usercart');
        $cart_id = $this->_post('cart_id');
        $row = $cart->find($cart_id);
        if($row){
            if($row['user_id'] != $this->app_uid){
                $rs = array('success' => false, 'error_msg' => '只可操作自己的购物车!');
                die(json_encode($rs));
            }
        }else{
            $rs = array('success' => false, 'error_msg' => '未找到购物车信息!');
            die(json_encode($rs));
        }
        $num = (int)$this->_post('num');
        if (empty($num)) {
            $rs = array('success' => false, 'error_msg'=>'保存数量不能为空!');
            die(json_encode($rs));
        }
        if ($num <=0 || $num >99) {
            $rs = array('success' => false, 'error_msg'=>'数量不能小于1 或者 大于99!');
            die(json_encode($rs));
        }
        if($num == $row['num']){
            $rs = array('success' => false, 'error_msg'=>'修改数量与原数量相同!');
            die(json_encode($rs));
        }
        $res = $cart->where("cart_id = {$cart_id}")->save(array('num'=>$num));
        //die(var_dump($cart->getLastSql()));
        if($res){
            $rs = array('success' => true, 'error_msg' => '');
            die(json_encode($rs));
        }else{
            $rs = array('success' => false, 'error_msg' => '操作失败');
            die(json_encode($rs));
        }
    }

}