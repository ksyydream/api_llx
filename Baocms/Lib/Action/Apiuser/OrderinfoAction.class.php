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

    public function dianping(){

        $order_id = (int) $this->_param('order_id');
        if ( empty( $order_id )|| !( $detail = D("Order")->field('order_id,shop_id,user_id,is_dianping,total_price,use_integral')->where( 'order_id='.$order_id )->find())){
            echo D("Order")->getLastSql();
            $rs = array(
                'success' => false,
                'error_msg'=>'该订单不存在!'
            );
            die(json_encode($rs));
        }
        if ($detail['user_id'] != $this->app_uid){
            $rs = array(
                'success' => false,
                'error_msg'=>'请不要操作他人的订单!'
            );
            die(json_encode($rs));
        }
        if ( $detail['is_dianping'] != 0 ){
            $rs = array(
                'success' => false,
                'error_msg'=>'您已经点评过了!'
            );
            die(json_encode($rs));
        }

        $goodss = D('Ordergoods')->where('order_id ='.$detail['order_id']) -> find();
        $goods_id = $goodss['goods_id'];
        $score=$this->_param('score');
        if ( isset($score) ){
            $data['user_id'] = $this->app_uid;
            $data['order_id'] = $detail['order_id'];
            $data['shop_id'] = $detail['shop_id'];
            $data['goods_id'] = $goods_id;
            $data['score'] = $score;
            if ( $data['score'] <= 0 || 5 < $data['score'] ){
                $rs = array(
                    'success' => false,
                    'error_msg'=>'请选择评分!'
                );
                die(json_encode($rs));
            }
            $data['contents'] = htmlspecialchars( $this->_param('contents') );
            if ( empty( $data['contents'] ) ){
                $rs = array(
                    'success' => false,
                    'error_msg'=>'不说点什么么'
                );
                die(json_encode($rs));
            }
            $data['create_time'] = NOW_TIME;
            $data_mall_dianping = $this->_CONFIG['mobile']['data_mall_dianping'];
            $data['show_date'] = date('Y-m-d', NOW_TIME + $data_mall_dianping * 86400); //15天生效
            $data['create_ip'] = get_client_ip( );
            $obj = D( "Goodsdianping" );
            if ($dianping_id = $obj->add( $data ) ){
                $photos = $this->uploadimg('photos');
                $local = array();
                foreach ( $photos as $val ){
                        $local[] = $val;
                }
                if (!empty( $photos ) ){
                    D( "Goodsdianpingpics" )->upload( $order_id, $photos,$goods_id );
                }
                D( "Order" )->save( array( "order_id" => $order_id,"is_dianping" => 1));
                D( "Shop" )->updateCount( $detail['shop_id'], "score_num" );
                D( "Users" )->updateCount( $this->app_uid, "ping_num" );
                D( "Users" )->prestige( $this->app_uid, "dianping" );
                $rs = array(
                    'success' => true,
                    'error_msg'=>'评价成功'
                );
                die(json_encode($rs));

            }
            $rs = array(
                'success' => false,
                'error_msg'=>'操作失败'
            );
            die(json_encode($rs));
        }
        else{
            $goods = D('Goods')->field('title,photo')->where('goods_id ='.$goods_id) -> find();
            $rs = array(
                'success' => true,
                'detail'=> $detail,
                'goods'=> $goods,
                'error_msg'=>''
            );
            die(json_encode($rs));
        }
    }
}