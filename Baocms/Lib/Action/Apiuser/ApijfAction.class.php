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

        $gold = $this->_post('gold')?$this->_post('gold'):0; //用户使用的余额;
        $gold = (int)($gold * 100);
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
            'user_id'=>$this->app_uid,
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

    public function order_detail(){
        $order_id = (int) $this->_post('order_id');
        //进行验证信息
        if (empty($order_id)) {
            $rs = array('success' => false, 'error_msg'=>'请选择订单!');
            die(json_encode($rs));
        }
        if (!($detail = D('Jforder')->find($order_id))) {
            $rs = array('success' => false, 'error_msg'=>'该订单不存在');
            die(json_encode($rs));
        }
        if ($detail['user_id'] != $this->app_uid || $detail['status'] != -1) {
            $rs = array('success' => false, 'error_msg'=>'该订单不可操作!');
            die(json_encode($rs));
        }
        $order_addr = D('Jforderaddr')->alias('a')->field('a.*,b.name province_name,c.name city_name,d.name area_name')
            ->join('bao_nprovince b on a.province_code = b.code','LEFT')
            ->join('bao_ncity c on a.city_code = c.code','LEFT')
            ->join('bao_narea d on a.area_code = d.code','LEFT')
            ->where('a.jforder='.$order_id)
            ->find();
        $order_goods = D('Jfordergoods')->where(array('jforder'=>$order_id))->select();
        $rs = array(
            'success'=>true,
            'error_msg'=>'',
            'order_detail'=>$detail,
            'order_addr'=>$order_addr,
            'goods_list'=>$order_goods
        );
        die(json_encode($rs));
    }

    public function order_list(){
        $page = (int)$this->_post('page', 'htmlspecialchars')?(int)$this->_post('page', 'htmlspecialchars'):1;
        if (empty($page)) {
            $rs = array('success' => false, 'error_msg'=>'请选择页数!');
            die(json_encode($rs));
        }
        $ud = D('Jforder');
        $order_list = $ud->alias('a')->field('a.*,b.title,b.photo')
            ->join('bao_jf_order_goods b on a.jforder_id = b.jforder_id','LEFT')
            ->where('a.user_id='.$this->app_uid)
            ->where('a.status > 0')
            ->page($page . ',20')
            ->select();
        $rs = array(
            'success'=>true,
            'order_list'=>$order_list,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }

    public function order_delete(){
        $order_id = (int) $this->_post('order_id');
        //进行验证信息
        if (empty($order_id)) {
            $rs = array('success' => false, 'error_msg'=>'请选择订单!');
            die(json_encode($rs));
        }
        if (!($detail = D('Jforder')->find($order_id))) {
            $rs = array('success' => false, 'error_msg'=>'该订单不存在');
            die(json_encode($rs));
        }
        if ($detail['user_id'] != $this->app_uid || $detail['status'] != 1) {
            $rs = array('success' => false, 'error_msg'=>'该订单不可操作!');
            die(json_encode($rs));
        }
        $data = array(
            'jforder_id' => $order_id,
            'status' => -1,
        );
        if (D('Jforder')->save($data)){
            if($detail['gold'] != 0){
                D('Users')->addGold($this->app_uid,$detail['gold'],'积分商城'.$order_id.'订单取消订单 退回金额');
            }

            if($detail['integral'] != 0){
                D('Users')->addIntegral($this->app_uid,$detail['integral'],'积分商城'.$order_id.'订单取消订单 退回秀币');
            }
            $rs = array(
                'success'=>true,
                'error_msg'=>''
            );
            $this->ajaxReturn($rs,'JSON');
        }else{
            $rs = array(
                'success'=>false,
                'error_msg'=>'订单取消失败!'
            );
            $this->ajaxReturn($rs,'JSON');
        }
    }

    public function order_pay(){
        $order_id = (int) $this->_post('order_id');
        //进行验证信息
        if (empty($order_id)) {
            $rs = array('success' => false, 'error_msg'=>'请选择订单!');
            die(json_encode($rs));
        }
        if (!($order_det = D('Jforder')->find($order_id))) {
            $rs = array('success' => false, 'error_msg'=>'该订单不存在');
            die(json_encode($rs));
        }
        if ($order_det['user_id'] != $this->app_uid || $order_det['status'] != 1) {
            $rs = array('success' => false, 'error_msg'=>'该订单不可操作!');
            die(json_encode($rs));
        }
        $order_goods = D('Jfordergoods')->where(array('jforder'=>$order_id))->select();
        foreach($order_goods as $item){
            if (!($detail = D('Llxgoods')->find($item['goods_id']))) {
                $rs = array('success' => false, 'error_msg'=>'该商品不存在,不可再购买');
                die(json_encode($rs));
            }
            if ($detail['closed'] != 0 || $detail['audit'] != 1) {
                $rs = array('success' => false, 'error_msg'=>'该商品不存在,不可再购买!');
                die(json_encode($rs));
            }
            if ($detail['end_date'] < TODAY) {
                $rs = array('success' => false, 'error_msg'=>'该商品已经过期，暂时不能购买!');
                die(json_encode($rs));
            }
            if ($detail['num'] <= 0 || $detail['num'] < $item['pty']) {
                $rs = array('success' => false, 'error_msg'=>'亲！没有库存了！不可再购买');
                die(json_encode($rs));
            }
        }
        if($order_det['need_pay'] < 0){
            $rs = array('success' => false, 'error_msg'=>'订单异常,不可再购买');
            die(json_encode($rs));
        }

        if($order_det['need_pay']==0){
            D('Jforder')->save(array('jforder_id' => $order_id, 'status' => 2));
            $this->ajaxReturn(array('success'=>true,'error_msg'=>'','flag'=>1));
            exit();
        }
        $pay_log = array(
            'user_id'=>$this->app_uid,
            'type'=>'jf',
            'order_id'=>$order_id,
            'code'=>'weixin',
            'need_pay'=>$order_det['need_pay'],
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