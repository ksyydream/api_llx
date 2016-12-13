<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 16/11/5
 * Time: 下午3:31
 */
class OrderinfoAction extends CommonAction{
    public function orderlist(){
        try{
            $user_id = $this->app_uid;
            if ($user = D('Users')->find($user_id)) {
                $Order = D('Order');
                $map = array('closed' => 0, 'user_id' => $user_id);
                $aready = (int) $this->_param('aready');
                $page = trim($this->_param('page'))?trim($this->_param('page')):1;
                if ($aready == 1) {
                    $map['status'] = 0;
                } elseif ($aready == 3) {
                    $map['status'] = array('IN',array(1,2));
                }  elseif($aready == 4) {
                    $map['status'] = array('IN',array(3,8));
                }
                $order_list = $Order
                    ->field('FROM_UNIXTIME(create_time) AS create_time,
                    order_id,
                    use_integral,
                    status,
                    is_daofu,
                    is_dianping,
                    can_use_integral,
                    use_integral,
                    mobile_fan,
                    total_price,
                    need_pay')
                    ->where($map)->page("{$page},10")->select();
                $order_ids =array();
                foreach ($order_list as $key => $val) {
                    $order_ids[$val['order_id']] = $val['order_id'];
                }
                if (!empty($order_ids)) {
                    $order_list_goods = D('Ordergoods')->field('shop_id,goods_id,order_id,num,price,mobile_fan,total_price')->where(array('order_id' => array('IN', $order_ids)))->select();
                    foreach ($order_list_goods as $val) {
                        $goods_ids[$val['goods_id']] = $val['goods_id'];
                        $shop_ids[$val['shop_id']] = $val['shop_id'];
                    }
                    $products = D('Goods')->itemsByIds($goods_ids);
                    $shop = D('Shop')->field('shop_id,shop_name')->itemsByIds($shop_ids);
                    foreach ($order_list_goods as $key => $val) {
                        foreach($products as $key1 => $val1){
                            if($val['goods_id']==(int)$key1){
                                $order_list_goods[$key]['g_title']=$products[$key1]['title'];
                                $order_list_goods[$key]['g_photo']=$products[$key1]['photo'];
                                $order_list_goods[$key]['g_use_integral']=$products[$key1]['use_integral'];
                                break;
                            }
                        }
                    }
                }

                $rs = array(
                    'success' => true,
                    'order_list'=>$order_list,
                    'goods'=>$order_list_goods,
                    //'products'=>$products,
                    'shop'=>$shop,
                    'error_msg'=>''
                );
                die(json_encode($rs));
            }else{
                $rs = array(
                    'success' => false,
                    'error_msg'=>'用户已注销!'
                );
                die(json_encode($rs));
            }

        }catch(Exception $e) {
            $rs = array(
                'success' => false,
                'error_msg'=>'获取数据失败!'
            );
            die(json_encode($rs));
        }

    }

    public function orderdetail(){
        try{
            $order_id = (int) $this->_param('order_id');
            if(empty($order_id) || !$detail = D('Order')
                    ->field('*,FROM_UNIXTIME(create_time) AS c_time')
                    ->find($order_id)){
                $rs = array(
                    'success' => false,
                    'error_msg'=>'订单不存在!'
                );
                die(json_encode($rs));
            }
            if($detail['user_id'] != $this->app_uid){
                $rs = array(
                    'success' => false,
                    'error_msg'=>'非本人订单!'
                );
                die(json_encode($rs));
            }
            $order_goods_info = D('Ordergoods')->getOrderGoodsinfo($order_id);
            //$err =    D('Ordergoods')->getLastSql();
            $order_goods = D('Ordergoods')->where(array('order_id'=>$order_id))->select();
            $goods_ids = array();
            foreach($order_goods as $k=>$val){
                $goods_ids[$val['goods_id']] = $val['goods_id'];
            }
            if(!empty($goods_ids)){
                $json_goods = D('Goods')->itemsByIds($goods_ids);
            }
            $json_addr = D('Useraddr')->find($detail['addr_id']);
            $json_types = D('Order')->getType();
            $rs = array(
                'success' => true,
                //'ordergoods'=>$order_goods,
                'addr'=>$json_addr,
                'types'=>$json_types,
                'detail'=>$detail,
                'order_goods_info'=>$order_goods_info,
                //'goods'=>$json_goods,
                'error_msg'=>''
            );
            die(json_encode($rs));
        }catch(Exception $e) {
            $rs = array(
                'success' => false,
                'error_msg'=>'获取数据失败!'
            );
            die(json_encode($rs));
        }

    }
}