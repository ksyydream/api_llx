<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 17/2/6
 * Time: 下午5:26
 */
class ApijfAction extends CommonAction {
    
    public function save_order(){
        $goods_id = (int) $this->_post('goods_id');
        $pty = (int) $this->_post('pty'); //购买数量
        $addr = (int)$this->_post('addr_id');

        $gold = (int)$this->_post('gold')?(int)$this->_post('gold'):0; //用户使用的余额;
        //进行验证信息
        if (empty($goods_id)) {
            $rs = array('success' => false, 'error_msg'=>'请选择商品!');
            die(json_encode($rs));
        }
        if (empty($pty)) {
            $rs = array('success' => false, 'error_msg'=>'请选择购买数量!');
            die(json_encode($rs));
        }
        if (empty($addr)) {
            $rs = array('success' => false, 'error_msg'=>'请选择收货地址!');
            die(json_encode($rs));
        }
        if (!($detail = D('Llxgoods')->find($goods_id))) {
            $rs = array('success' => false, 'error_msg'=>'该商品不存在');
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
        if ($detail['num'] <= 0 || $detail['num'] < $pty) {
            $rs = array('success' => false, 'error_msg'=>'亲！没有库存了！');
            die(json_encode($rs));
        }
        if (!($addr_detail = D('Useraddr')->find($addr))) {
            $rs = array('success' => false, 'error_msg'=>'该地址不存在');
            die(json_encode($rs));
        }else{
            if($addr_detail['user_id'] != $this->app_uid || $addr_detail['closed'] != 0){
                $rs = array('success' => false, 'error_msg'=>'该地址不可使用!');
                die(json_encode($rs));
            }
        }

        //开始保存信息
        /*1,先保存订单
         *2,再保存地址信息
         * */

        //计算使用秀币 余额 剩余支付
        if($gold > $this->member['gold']){
            $gold = $this->member['gold'];
        }

        $total = $detail['price'] * $pty;
        $need_pay = $total;
        $integral = $this->member['integral'];
        if($total <= $integral){
            $integral = $total;
            $gold = 0;
            $need_pay = 0;
        }else{
            $money_ = $total - $integral;
            if($money_ <= $gold){
                $gold = $money_;
                $need_pay = 0;
            }else{
                $need_pay = $money_ - $gold;
            }
        }

        $jforder = D('Jforder');
        $add_detail = array(
            'integral'=>$integral,
            'gold'=>$gold,
            'need_pay'=>$need_pay,
            'num'=>$pty,
            'total'=>$total,
            'cdate'=>date('Y-m-d H:i:s')
        );
        if($add_detail['need_pay']==0){
            $add_detail['status'] = 2;
        }else{
            $add_detail['status'] = 1;
        }
        $order_id = $jforder->add($add_detail);
        D('Jfordergoods')->add(array(
            'title'=>$detail['title'],
            'jforder_id'=>$order_id,
            'price'=>$detail['price'],
            'goods_id'=>$detail['goods_id'],
            'photo'=>$detail['photo'],
            'pty'=>$pty,
            'cdate'=>date('Y-m-d H:i:s')
        ));
        D('Jforderaddr')->add(array(
            'name'=>$addr_detail['name'],
            'jforder_id'=>$order_id,
            'mobile'=>$addr_detail['mobile'],
            'addr'=>$addr_detail['addr'],
            'province_code'=>$addr_detail['province_code'],
            'city_code'=>$addr_detail['city_code'],
            'area_code'=>$addr_detail['area_code']
        ));
        if($gold != 0){
            D('Users')->addGold($this->app_uid,0 - $gold,'积分商城'.$order_id.'订单使用');
        }

        if($integral != 0){
            D('Users')->addIntegral($this->app_uid,0 - $integral,'积分商城'.$order_id.'订单使用');
        }

        if($add_detail['status']==2){
            $this->ajaxReturn(array('success'=>true,'error_msg'=>'','flag'=>1));
            exit();
        }else{
            $pay_log = array(
                'user_id'=>$this->app_uid,
                'type'=>'jf',
                'order_id'=>$order_id,
                'code'=>'weixin',
                'need_pay'=>$add_detail['need_pay'],
                'create_time'=>NOW_TIME,
                'create_ip'=>get_client_ip(),
                'is_paid'=>0
            );
            $Paymentlogs = D('Paymentlogs');
            $log_id = $Paymentlogs->add($pay_log);
            $pay_log['log_id']=$log_id;
            $this->ajaxReturn(array('success'=>true,'error_msg'=>'','flag'=>2,'logs'=>$pay_log));
            exit();
        }
    }
}