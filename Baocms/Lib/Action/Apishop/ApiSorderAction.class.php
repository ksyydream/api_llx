<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 17/1/20
 * Time: 上午9:15
 */
class ApiSorderAction extends CommonAction{
    public function index(){
        $Pay = D('Pay');
        $page = $this->_post('page','trim')?$this->_post('page','trim'):1;
        $map = array('shop_id' => $this->shop_id);
        if ($keyword = $this->_post('keyword', 'htmlspecialchars')) {
            $map['mobile'] = array('LIKE', '%' . $keyword . '%');
            $this->assign('keyword', $keyword);
        }
        $list = $Pay->field('*,DATE_FORMAT(FROM_UNIXTIME(create_time),\'%Y-%m-%d %H:%i:%s\') cdate,DATE_FORMAT(FROM_UNIXTIME(pay_time),\'%Y-%m-%d %H:%i:%s\') pdate')
            ->where($map)->order(array('id' => 'desc'))->page($page . ',20')->select();
        foreach ($list as $k => $v) {
            $list[$k]['zp'] = (array)json_decode($v['zp']);
            $arr = (array)json_decode($v['zp']);
            $zp_list = array();
            if($arr){
                foreach ($arr as $k1 => $v1){
                    $zp_arr=array(
                        'zp_name'=>$k1,
                        'zp_num'=>$v1
                    );
                    $zp_list[]= $zp_arr;
                }
            }
            $list[$k]['zp_list']=$zp_list;

        }
        $rs = array(
            'success'=>true,
            'list'=>$list,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }

    //获取用户赠品
    public function get_zp()
    {
        if(!$mobile = $this->_post('mobile')){
            $rs=array(
                'success'=>false,
                'error_msg'=>'电话号码不能为空'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        if (!isMobile($mobile)) {
            $rs=array(
                'success'=>false,
                'error_msg'=>'此电话不符合要求!'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        $Users = D('Users');
        $user = $Users->where(array('account' => $mobile))->find();
        if(!$user){
            $rs=array(
                'success'=>false,
                'error_msg'=>'此用户不存在!'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        $arr = (array)json_decode($user['zp']);
        $zp_list = array();
        if($arr){
            foreach ($arr as $k1 => $v1){
                if($k1 == $this->shop_id){
                   // $shop_zp = (array)json_decode($v1);
                    $shop_zp = $v1;
                    if($shop_zp){
                        foreach($shop_zp as $k2 => $v2){
                            $zp_arr=array(
                                'zp_name'=>$k2,
                                'zp_num'=>$v2
                            );
                            $zp_list[]= $zp_arr;
                        }
                    }
                }
            }
        }
        $arr_yhk = (array)json_decode($user['yhk']);
        $yhk_list = array(
            'bd'=>0,
            'qt'=>0
        );
        if($arr_yhk){
            foreach ($arr_yhk as $yhk_k1 => $yhk_v1){
                if($yhk_k1 == $this->shop_id){
                    $yhk_list['bd']+=(int)$yhk_v1;
                }else{
                    $yhk_list['qt']+=(int)$yhk_v1;
                }
            }
        }
        $rs=array(
            'success'=>true,
            'error_msg'=>'',
            'zp_list'=>$zp_list,
            'yhk'=>$yhk_list,
            'shop_id'=>$this->shop_id
        );
        $this->ajaxReturn($rs,'JSON');
        //echo '{"zp":' . $user['zp'] . ',"yhk":' . $user['yhk'] . '}';
    }

    //创建订单
    public function create(){

        $Users = D('Users');
        $Pay = D('Pay');
        $data = array(
            'mobile'=>$this->_post('mobile'),
            'shop_id'=>$this->shop_id,
            'remark'=>htmlspecialchars($this->_post('remark')),
            'status'=>1,
            'yhk'=>0,
            'total'=>(int)$this->_post('total'),
            'create_time'=>NOW_TIME
        );
        $desc = $this->_post('desc');
        $qty = $this->_post('qty');
        if($desc){
            if(!is_array($desc) || !is_array($qty)){
                $rs=array(
                    'success'=>false,
                    'error_msg'=>'赠品参数 不符合要求'
                );
                $this->ajaxReturn($rs,'JSON');
            }
        }
        $zp = array();
        foreach ($desc as $k => $v) {
            if ($qty[$k] > 0) {
                $zp[$v] = $qty[$k];
            }
        }
        if ($zp) {
            $data['zp'] = json_encode($zp);
        }

        $user_count = $Users->where(array('account' => $data['mobile']))->count();
       // die($this->ajaxReturn($Users->getLastSql(),'JSON'));
        if ($user_count == 0) {
            $rs=array(
                'success'=>false,
                'error_msg'=>'会员不存在'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        $pay_count = $Pay->where(array('mobile' => $data['mobile'], 'status' => 1))->count();

        if ($pay_count > 0) {
            $rs=array(
                'success'=>false,
                'error_msg'=>'该会员存在未付款的订单,无法新建支付'
            );
            $this->ajaxReturn($rs,'JSON');
        }

        if ($data['total'] <= 0) {
            $rs=array(
                'success'=>false,
                'error_msg'=>'消费金额必须大于0'
            );
            $this->ajaxReturn($rs,'JSON');
        }


        $user = $Users->where(array('account' => $data['mobile']))->find();
        //这里验证赠品
        $zp_limit = json_decode($user['zp']);
        $key = (string)$this->shop_id;
        if($desc){
            if ($zp_limit->$key) {
                foreach ($zp as $k => $v) {
                    if ($zp_limit->$key->$k) {
                        if ($zp_limit->$key->$k < $v) {
                            $rs=array(
                                'success'=>false,
                                'error_msg'=>'赠品数量不足'
                            );
                            $this->ajaxReturn($rs,'JSON');
                        }
                    }else{
                        $rs=array(
                            'success'=>false,
                            'error_msg'=>'无相关赠品记录'
                        );
                        $this->ajaxReturn($rs,'JSON');
                    }
                }
            }else{
                $rs=array(
                    'success'=>false,
                    'error_msg'=>'赠品有误,请查看'
                );
                $this->ajaxReturn($rs,'JSON');
            }
        }


        //这里由后台自己计算优惠券抵扣情况
        $arr_yhk = (array)json_decode($user['yhk']);
        $yhk_list = array('bd'=>0, 'qt'=>0);
        if($arr_yhk){
            foreach ($arr_yhk as $yhk_k1 => $yhk_v1){
                if($yhk_k1 == $this->shop_id){
                    $yhk_list['bd']+=(int)$yhk_v1;
                }else{
                    $yhk_list['qt']+=(int)$yhk_v1;
                }
            }
        }
        if($yhk_list['bd'] > 0){
            $yhk1 = $this->shop['yhk1'];
            $yhk1 = $yhk1-100 < 0 ? $yhk1 : 100;
            $yhk1 = $yhk1 >= 0 ? $yhk1 : 0;
            $data['yhk'] = ((int)($data['total']/100)) * $yhk1;
            if($data['yhk'] >=$yhk_list['bd']){
                $data['yhk'] = $yhk_list['bd'];
            }
        }else{
            $yhk2 = $this->shop['yhk2'];
            $yhk2 = $yhk2-100 < 0 ? $yhk2 : 100;
            $yhk2 = $yhk2 >= 0 ? $yhk2 : 0;
            $data['yhk'] = ((int)($data['total']/100)) * $yhk2;
            if($data['yhk'] >=$yhk_list['qt']){
                $data['yhk'] = $yhk_list['qt'];
            }
        }
        //优惠卡抵扣 计算完成;


        if($data['yhk'] >= $data['total']){//满100抵扣100优惠券
            $data['status'] = 2;
            $data['pay_time'] = NOW_TIME;
        }
        if (false !== $Pay->add($data)) {
            $zp_array = array();
            foreach($desc as $k=>$v){
                $zp_array[$v] = $qty[$k];
            }
            if($data['yhk'] >= $data['total']){
                $this->compute_yhk($data['mobile'],$data['yhk'],$zp_array);
            }
            $rs=array(
                'success'=>true,
                'error_msg'=>''
            );
            $this->ajaxReturn($rs,'JSON');
        }
    }

    public function delete(){
        $id = (int)$this->_post('id');
        if (empty($id)) {
            $this->ajaxReturn(array('success'=>false,'error_msg'=>'优惠买单 订单编号不能为空!'));
        }
        $pay = D('Pay')->find($id);
        if (empty($pay) || $pay['status'] != 1) {
            $this->ajaxReturn(array('success'=>false,'error_msg'=>'操作非法!'));
        }
        if ($pay['shop_id'] != $this->shop_id ) {
            $this->ajaxReturn(array('success'=>false,'error_msg'=>'您没有权限访问！'));
        }
        $member = D('Users')->where(array('account'=>$pay['mobile']))->find();
        if($pay['integral'] > 0){
            D('Users')->addIntegral($member['user_id'],$pay['integral'],'优惠买单订单取消,退回秀币');
        }
        if($pay['use_gold'] > 0){
            D('Users')->addGold($member['user_id'],$pay['use_gold'],'优惠买单订单取消,退回余额');
        }
        $obj = D('Pay');
        $obj->where(array('id' => $id))->delete();
        $this->ajaxReturn(array('success'=>true,'error_msg'=>''));
    }

    //线下支付 接口 需要检查
    public function pay()
    {
        $id = (int)$this->_post('id');
        if (empty($id)) {
            $this->ajaxReturn(array('success'=>false,'error_msg'=>'优惠买单 订单编号不能为空!'));
        }
        $Pay = D('Pay');
        $Shop = D('Shop');
        $rs = $Pay->query("select a.*,shop_name from ".$Pay->getTableName()." a left join ".$Shop->getTableName()." b on a.shop_id = b.shop_id where a.id = ".$id);
        if(empty($rs)){
            $this->ajaxReturn(array('success'=>false,'error_msg'=>'订单不存在!'));
        }
        $detail = $rs[0];
        $detail['zp'] = (array)json_decode($rs[0]['zp']);
        $zp_list = array();
        if($detail['zp']){
            foreach($detail['zp'] as $k2 => $v2){
                $zp_arr=array(
                    'zp_name'=>$k2,
                    'zp_num'=>$v2
                );
                $zp_list[]= $zp_arr;
            }
        }
        $member = D('Users')->where(array('account'=>$detail['mobile']))->find();
        $rs=array(
            'success'=>true,
            'detail'=>$detail,
            'zp_list'=>$zp_list,
            'integral'=>$member['integral'],
            //'gold'=>$member['gold'],
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }

    public function check_pay(){

        $id = $this->_post('id');
        $integral = $this->_post('integral');
        //$gold = (int)($this->_post('gold')*100) ;
        $Pay = D('Pay');
        $Users = D('Users');
        $rs = $Pay->where(array('id'=>$id))->find();
        if(empty($rs)){
            $this->ajaxReturn(array('success'=>false,'error_msg'=>'不存在该笔付款!'));
        }
        if($rs['status'] != 1){
            $this->ajaxReturn(array('success'=>false,'error_msg'=>'请勿重复支付!'));
        }
        $member = D('Users')->where(array('account'=>$rs['mobile']))->find();
//        if($rs['mobile'] != $member['mobile']){
//            $this->fengmiMsg('权限不足');
//        }
        if ($rs['shop_id'] != $this->shop_id ) {
            $this->ajaxReturn(array('success'=>false,'error_msg'=>'权限不足!'));
        }

        if($integral < 0 || $member['integral'] < $integral || $integral > ($rs['total'] - $rs['yhk'])*100){
            $this->ajaxReturn(array('success'=>false,'error_msg'=>'秀币输入错误!'));
        }

        $Shop = D('Shop');
        $shop = $Shop->where(array('shop_id'=>$this->shop_id))->find();

//        if($integral == ($rs['total'] - $rs['yhk'])*100){//全部用秀币抵扣,不涉及支付
        $zp = (array)json_decode($rs['zp']);
        $this->compute_yhk($member['account'],$rs['yhk'],$zp,$rs['shop_id']);
        $Pay->where(array('id'=>$id))->save(array('status'=>2,'integral'=>$integral,'pay_time'=>NOW_TIME,'is_offline'=>2));
        if($integral>0){
            $Users->addIntegral($member['user_id'],-$integral,'优惠买单使用秀币');
            $Users->addIntegral($shop['user_id'],$integral,'客户优惠买单获得秀币');
        }


        $this->ajaxReturn(array('success'=>true,'error_msg'=>''));
    }

    private function compute_yhk($mobile, $yhk = '', $zp = '')
    {
        $Users = D('Users');
        $Pay = D('Pay');
        $Yhk_log = D('Yhklog');
        $Zengpin_log = D('Zengpinlog');
        $user = $Users->where(array('account' => $mobile))->find();


        if ($yhk) {//优惠卡规则
            $yhk_limit_old = (array)json_decode($user['yhk']);
            $yhk_limit = array();
            foreach ($yhk_limit_old as $key => $val) {
                $yhk_limit[$key] = $val;
            }

            if (isset($yhk_limit[$this->shop_id]) && $yhk_limit[$this->shop_id] > 0) {
                if ($yhk_limit[$this->shop_id] < $yhk) {
                    $rs=array(
                        'success'=>false,
                        'error_msg'=>'优惠券余额不足'
                    );
                    $this->ajaxReturn($rs,'JSON');
                } else {
                    $yhk_limit[$this->shop_id] = $yhk_limit[$this->shop_id] - $yhk;
                }
            }else{
                $yhk_surplus = $yhk;
                foreach($yhk_limit as $k=>$v){
                    if($yhk_surplus > 0){
                        if($v < $yhk_surplus){
                            $yhk_surplus = $yhk_surplus - $v;
                            $yhk_limit[$k] = 0;
                        }else{
                            $yhk_limit[$k] = $v - $yhk_surplus;
                            $yhk_surplus = 0;
                        }
                    }
                }
                if($yhk_surplus > 0){
                    $rs=array(
                        'success'=>false,
                        'error_msg'=>'优惠券余额不足'
                    );
                    $this->ajaxReturn($rs,'JSON');
                }
            }

            $data = array(
                'mobile' => $mobile,
                'qty' => $yhk,
                'create_time' => NOW_TIME,
                'shop_id' => $this->shop_id,
                'type' => -1
            );
            $Yhk_log->add($data);
            $Users->where(array('account' => $mobile))->save(array('yhk' => json_encode($yhk_limit)));
        }

        if ($zp) {
            $zp_limit = json_decode($user['zp']);
            $key = (string)$this->shop_id;
            $data = array();
            if ($zp_limit->$key) {
                foreach ($zp as $k => $v) {
                    if ($zp_limit->$key->$k) {
                        if ($zp_limit->$key->$k < $v) {
                            $rs=array(
                                'success'=>false,
                                'error_msg'=>'赠品数量不足'
                            );
                            $this->ajaxReturn($rs,'JSON');
                        } else {
                            $zp_limit->$key->$k = $zp_limit->$key->$k - $v;
                            $data[] = array(
                                'mobile' => $mobile,
                                'qty' => $v,
                                'create_time' => NOW_TIME,
                                'shop_id' => $this->shop_id,
                                'type' => -1,
                                'desc' => $k
                            );
                        }
                    }
                }

                foreach($data as $k=>$v){
                    $Zengpin_log->add($v);
                }
                $Users->where(array('account' => $mobile))->save(array('zp' => json_encode($zp_limit)));
            } else {
                $rs=array(
                    'success'=>false,
                    'error_msg'=>'赠品有误,请查看'
                );
                $this->ajaxReturn($rs,'JSON');
            }
        }

    }
}