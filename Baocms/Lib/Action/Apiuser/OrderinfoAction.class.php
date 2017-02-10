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
                    use_gold,
                    status,
                    is_daofu,
                    is_dianping,
                    can_use_integral,
                    use_integral,
                    mobile_fan,
                    total_price,
                    need_pay')
                    ->where($map)->order("order_id desc")->page("{$page},10")->select();
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
                    $shop = D('Shop')->field('shop_id,shop_name')->itemsByIds_select($shop_ids);
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
            $order_title = '';
            $order_num = 0;
            $order_flag=1;
            foreach($order_goods_info as $k=>$val){
                $order_num +=(int)$val['num'];
                if($order_title == ""){
                    $order_title = $val['title'];
                }else{
                    $order_flag=2;
                }
            }
            if($order_flag==2){
                $order_title.=" 等{$order_num}个商品";
            }
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
            $shop_info = D('Shop')->find($detail['shop_id']);
            $json_types = D('Order')->getType();
            $rs = array(
                'success' => true,
                'order_title'=>$order_title,
                'shop_name'=>$shop_info['shop_name'],
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

    public function save_dp_pic(){
        $img = $this->uploadimg('dp_pic');
        if($img){
            $rs = array(
                'success' => true,
                'error_msg' =>'',
                'pic_path'=>$img//头像上传失败
            );
        }else{
            $rs = array(
                'success' => false,
                'error_msg' =>''
            );
        }
        $this->ajaxReturn($rs,'JSON');
    }

    public function dianping(){

        $order_id = (int) $this->_param('order_id');
        if ( empty( $order_id )|| !( $detail = D("Order")->field('order_id,shop_id,user_id,is_dianping,total_price,use_integral')->where( 'order_id='.$order_id )->find())){
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

        $photos = $this->_post('photos_path');
        if($photos){
            if (!is_array($photos)){
                $rs = array(
                    'success' => false,
                    'error_msg'=>'图片地址必须是数组!'
                );
                die(json_encode($rs));
            }
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
                //$photos = $this->uploadimg2($_FILES['photos']);
                $photos = $this->_post('photos_path')?$this->_post('photos_path'):array();
                D( "Goodsdianpingpics" )->upload( $order_id, $photos,$goods_id );
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

    public function order_cart() {
        //查询这个用户所有的可用积分数
        $user_integral = D("users")->field('integral')->find($this->app_uid);
        $cart_ids = $this->_post('cart_ids');
        if(!$cart_ids){
            $rs = array('success' => false, 'error_msg' => '购物车编号不能未空!');
            die(json_encode($rs));
        }
        //这里的写法参照 原有代码,会比较累赘
        $goods_ids = array();
        $num = array();
        $cart = D('Usercart');
        if(is_array($cart_ids)){
            foreach ($cart_ids as $cart_id){
                $cart_good = $cart->find($cart_id);
                if($cart_good && $cart_good['user_id'] == $this->app_uid){
                    $num[$cart_good['goods_id']]=(int)$cart_good['num'];
                    $goods_ids[$cart_good['goods_id']] = (int) $cart_good['goods_id'];
                }
            }
        }else{
            $cart_good = $cart->find($cart_ids);
            if($cart_good && $cart_good['user_id'] == $this->app_uid){
                $num[$cart_good['goods_id']]=(int)$cart_good['num'];
                $goods_ids[$cart_good['goods_id']] = (int) $cart_good['goods_id'];
            }
        }
        if (empty($goods_ids)) {
            $rs = array('success' => false, 'error_msg' => '没有可购买商品!');
            die(json_encode($rs));
        }
        $goods = D('Goods')->itemsByIds($goods_ids);

        foreach ($goods as $key => $val) {
            if ($val['closed'] != 0 || $val['audit'] != 1 || $val['end_date'] < TODAY) {
                unset($goods[$key]);
            }
        }
        if (empty($goods)) {
            $rs = array('success' => false, 'error_msg' => '您提交的产品暂时不能购买!');
            //$rs = array('success' => false, 'error_msg' => $goods);
            die(json_encode($rs));
        }
        $tprice = 0;
        $all_integral = $total_mobile = 0;
        $ip = get_client_ip();
        $total_canuserintegral = $ordergoods = $total_price = $mm_price = array();
        foreach ($goods as $val) {
            $price = $val['mall_price'] * $num[$val['goods_id']];
            $js_price = $val['settlement_price'] * $num[$val['goods_id']];
            $mobile_fan = $val['mobile_fan'] * $num[$val['goods_id']];
            //每个商品的手机减少的钱
            $canuserintegral = $val['use_integral'] * $num[$val['goods_id']];
            //可使用积分=单个可使用*商品数量 每个产品的
            $m_price = $price - $mobile_fan;
            $tprice += $m_price;
            $total_mobile += $mobile_fan;
            $all_integral += $canuserintegral;
            //所有的订单的积分总数 用于后面判断 如果用户的积分超过这个数目 才减少
            $ordergoods[$val['shop_id']][] = array(
                'goods_id' => $val['goods_id'],
                'shop_id' => $val['shop_id'],
                'num' => $num[$val['goods_id']],
                'price' => $val['mall_price'],
                'total_price' => $price,
                'mobile_fan' => $mobile_fan,
                'is_mobile' => 1,
                'js_price' => $js_price,
                'create_time' => NOW_TIME,
                'create_ip' => $ip
            );
            $total_canuserintegral[$val['shop_id']] += $canuserintegral; //不同商家的每个订单的 总共 可以使用的积分
            $total_price[$val['shop_id']] += $price; //不同商家的总价格
            $mm_price[$val['shop_id']] += $mobile_fan;  //不同商家的  总的 手机下单减少 的价格

        }
        //总订单
        $order = array('user_id' => $this->app_uid, 'create_time' => NOW_TIME, 'create_ip' => $ip, 'is_mobile' => 1);

        $order_ids = array();
        foreach ($ordergoods as $k => $val) {
            $order['shop_id'] = $k;
            $order['total_price'] = $total_price[$k];
            $order['need_pay'] = $total_price[$k];
            $order['mobile_fan'] = $mm_price[$k];
            //手机下单减少的价钱 不同商家是不同的订单的
            $order['can_use_integral'] = $total_canuserintegral[$k];
            //每个订单可以使用的积分的数量
            $shop = D('Shop')->find($k);
            $order['is_shop'] = (int) $shop['is_pei'];
            //是否由商家自己配送
            if ($order_id = D('Order')->add($order)) {
                //推广ID 赋值了
                $order_ids[] = $order_id;
                foreach ($val as $k1 => $val1) {
                    $val1['order_id'] = $order_id;
                    D('Ordergoods')->add($val1);
                }
            }
        }
        $cart->where(array('cart_id'=>array('IN',$cart_ids)))->delete();
        if (count($order_ids) > 1) {
            /*$need_pay = D('Order')->useGold($this->app_uid, $order_ids);
            $logs = array(
                'type' => 'goods',
                'user_id' => $this->app_uid,
                'order_id' => 0,
                'order_ids' => join(',', $order_ids),
                'code' => '',
                'need_pay' => $need_pay,
                'create_time' => NOW_TIME,
                'create_ip' => get_client_ip(),
                'is_paid' => 0
            );
            $logs['log_id'] = D('Paymentlogs')->add($logs);*/
            $rs = array(
                'success' => true,
                'error_msg' => '',
                'order_id'=>-1
            );
            die(json_encode($rs));
        } else {
            $rs = array(
                'success' => true,
                'error_msg' => '',
                'order_id'=>$order_id
            );
            die(json_encode($rs));
        }
        die;
    }

    public function check_order(){
        $order_id = (int) $this->_post('order_id');
        $order = D('Order')->find($order_id);
        if (empty($order) || $order['status'] != 0 || $order['user_id'] != $this->app_uid) {
            $rs = array(
                'success' => false,
                'error_msg'=>'订单不存在!'
            );
            die(json_encode($rs));
        }
        $this->goods_mum($order_id);//检测库存
        $logs = D('Paymentlogs')->getLogsByOrderId('goods', $order_id);
        //写入支付记录
        //$need_pay = D('Order')->useIntegral($this->app_uid, array($order_id));
        $need_pay = D('Order')->useGold($this->app_uid, array($order_id));
        //die(var_dump($need_pay));
        //更新支付结果
        if (empty($logs)) {
            $logs = array(
                'type' => 'goods',
                'user_id' => $this->app_uid,
                'order_id' => $order_id,
                'code' => '',
                'need_pay' => $need_pay,
                'create_time' => NOW_TIME,
                'create_ip' => get_client_ip(),
                'is_paid' => 0
            );
            //单个付款走的这里，为什么没写入数据库$need_pay
            $logs['log_id'] = D('Paymentlogs')->add($logs);
        } else {
            $logs['need_pay'] = $need_pay;
            $logs['code'] = '';
            D('Paymentlogs')->save($logs);
        }
        D('Order')->where("order_id={$order_id}")->save(array('need_pay' => $need_pay));
        $order_new = D('Order')->find($order_id);
        if($order_new['need_pay'] == 0){
            if(D('Payment')->logsPaid($logs['log_id'])){
                // 这里返回支付成功 全秀币支付
                $rs = array(
                    'success' => true,
                    'error_msg' => '',
                    'flag'=>1,//代表支付成功
                    'logs'=>$logs

                );
                die(json_encode($rs));
            }
        }

        $rs = array(
            'success' => true,
            'error_msg' => '',
            'flag'=>2,//代表还需要第三方支付
            'logs'=>$logs
        );
        die(json_encode($rs));
    }

    public function goods_mum($order_id){
        $order_id = (int) $order_id;
        $ordergoods_ids = D('Ordergoods')->where(array('order_id' => $order_id))->select();
        foreach ($ordergoods_ids as $k => $v) {
            $goods_num = D('Goods')->where(array('goods_id' => $v['goods_id']))->find();
            if ($goods_num['num'] < $v['num']) {
                $rs = array(
                    'success' => false,
                    'error_msg'=>'商品ID' . $v['goods_id'] . '库存不足无法付款'
                );
                die(json_encode($rs));
            }
        }
        return 1;
    }

    public function order_del() {
        $order_id = (int) $this->_post('order_id');
        if (is_numeric($order_id) && ($order_id = (int) $order_id)) {
            $obj = D('Order');
            $detail = $obj->find($order_id);
            if (!$detail) {
                $rs = array(
                    'success' => false,
                    'error_msg'=>'该订单不存在!'
                );
                die(json_encode($rs));
            }
            if ($detail['user_id'] != $this->app_uid) {
                $rs = array(
                    'success' => false,
                    'error_msg'=>'请不要操作他人的订单!'
                );
                die(json_encode($rs));
                //$this->fengmiMsg('请不要操作他人的订单');
            }
            if ($detail['status'] != 0) {
                $rs = array(
                    'success' => false,
                    'error_msg'=>'该订单暂时不能取消!'
                );
                die(json_encode($rs));
            }
            if($obj->save(array('order_id' => $order_id, 'closed' => 1))){
                if($detail['use_gold']){
                    D('Users')->addGold($detail['user_id'],$detail['use_gold'],'取消订单'.$detail['order_id'].'余额退还');
                }

            }
            $rs = array(
                'success' => true,
                'error_msg' => ''
            );
            die(json_encode($rs));
        } else {
            $rs = array(
                'success' => false,
                'error_msg'=>'请选择要取消的订单!'
            );
            die(json_encode($rs));
        }
    }

}