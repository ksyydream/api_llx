<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/20
 * Time: 10:00
 */
class PayAction extends CommonAction
{
 //   private $create_fields = array('shop_id', 'photo', 'name', 'zhucehao', 'addr', 'end_date', 'zuzhidaima', 'user_name', 'pic', 'mobile', 'audit');
  //  private $edit_fields = array('shop_id', 'photo', 'name', 'zhucehao', 'addr', 'end_date', 'zuzhidaima', 'user_name', 'pic', 'mobile', 'audit');


    public function index()
    {
        $Pay = D('Pay');
        $Shop = D('Shop');
        $member = $this->member;
        $map = array('mobile' => $member['mobile']);
        $count = $Pay->where($map)->count();
        $maxpage=ceil($count/20);
        $page = $this->_param('page', 'htmlspecialchars')?$this->_param('page', 'htmlspecialchars'):1;
        //$list = $Pay->query("select a.*,shop_name from `bao_pay` AS a left join `bao_shop` AS b on a.shop_id = b.shop_id where a.mobile = ".$member['account']." order by a.id desc limit ".$page.",25");
        $list = $Pay->alias('a')->field('a.*,b.shop_name')
            ->join('bao_shop b on a.shop_id = b.shop_id','LEFT')
            ->where('a.mobile='.$member['account'])
            ->order('a.id desc')
            ->page($page . ',20')
            ->select();
       // echo $Pay->getlastsql();
        foreach ($list as $k => $v) {
            $list[$k]['zp'] = (array)json_decode($v['zp']);
        }
        $rs=array('success'=>true,
            'list'=>$list,
            'page'=>$page,
            'maxpage'=>(int)$maxpage,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }
    public function pay()
    {
        $id=$this->_param('id');
        $Pay = D('Pay');
        $Shop = D('Shop');
        $rss = $Pay->query("select a.*,shop_name from `bao_pay` AS a left join `bao_shop` AS b on a.shop_id = b.shop_id where a.id = ".$id);
        if(empty($rss)){
            $rs=array(
                'success'=>false,
                'error_msg'=>'不存在该笔付款'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        $detail = $rss[0];
        $detail['zp'] = (array)json_decode($rss[0]['zp']);
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
        $member = $this->member;
        $rs=array(
            'success'=>true,
            'detail'=>$detail,
            'integral'=>$member['integral'],
            'gold'=>$member['gold'],
            'zp_list'=>$zp_list,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }

    public function check_pay(){

        $id = $this->_post('id');
        $integral = $this->_post('integral');
        $gold = (int)($this->_post('gold')*100) ;
        $Pay = D('Pay');
        $Users = D('Users');
        $rs = $Pay->where(array('id'=>$id))->find();
        if(empty($rs)){
            $this->ajaxReturn(array('success'=>false,'error_msg'=>'不存在该笔付款!'));
        }
        if($rs['status'] != 1){
            $this->ajaxReturn(array('success'=>false,'error_msg'=>'请勿重复支付!'));
        }
        $member = $this->member;
        if($rs['mobile'] != $member['mobile']){
            $this->ajaxReturn(array('success'=>false,'error_msg'=>'权限不足!'));
        }

        if($integral < 0 || $member['integral'] < $integral || $integral > ($rs['total'] - $rs['yhk'])*100){
            $this->ajaxReturn(array('success'=>false,'error_msg'=>'秀币输入错误!'));
        }

        $Shop = D('Shop');
        $shop = $Shop->where(array('shop_id'=>$rs['shop_id']))->find();

        if($integral == ($rs['total'] - $rs['yhk'])*100){//全部用秀币抵扣,不涉及支付
            $zp = (array)json_decode($rs['zp']);
            $this->compute_yhk($member['mobile'],$rs['yhk'],$zp,$rs['shop_id']);
            $Pay->where(array('id'=>$id))->save(array('status'=>2,'integral'=>$integral,'pay_time'=>NOW_TIME));
            $Users->addIntegral($member['user_id'],-$integral,'优惠买单使用秀币');
            $Users->addIntegral($shop['user_id'],$integral,'客户优惠买单获得秀币');
            $this->ajaxReturn(array('success'=>true,'error_msg'=>'','flag'=>1));
            exit();
        }

        if($gold < 0 || $member['gold'] < $gold || $gold > ($rs['total'] - $rs['yhk'])*100 - $integral ){
            $this->ajaxReturn(array('success'=>false,'error_msg'=>'余额输入错误!'));
        }

        if($gold == ($rs['total'] - $rs['yhk'])*100 - $integral){//全部用秀币抵扣,不涉及支付
            $zp = (array)json_decode($rs['zp']);
            $this->compute_yhk($member['mobile'],$rs['yhk'],$zp,$rs['shop_id']);
            $Pay->where(array('id'=>$id))->save(array('status'=>2,'integral'=>$integral,'use_gold'=>$gold,'pay_time'=>NOW_TIME));
            if($integral > 0){
                $Users->addIntegral($member['user_id'],-$integral,'优惠买单使用秀币');
                $Users->addIntegral($shop['user_id'],$integral,'客户优惠买单获得秀币');
            }
            $Users->addGold($member['user_id'],-$gold,'优惠买单使用余额');
            $Users->addGold($shop['user_id'],$gold,'客户优惠买单获得余额');
            $this->ajaxReturn(array('success'=>true,'error_msg'=>'','flag'=>1));
            exit();
        }

        $pay_log = array(
            'user_id'=>$member['user_id'],
            'type'=>'breaks',
            'order_id'=>$id,
            'code'=>'weixin',
            'need_pay'=>($rs['total'] - $rs['yhk'])*100 - $integral - $gold,
            'create_time'=>NOW_TIME,
            'create_ip'=>get_client_ip(),
            'is_paid'=>0
        );
        $Pay->where(array('id'=>$id))->save(array('integral'=>$integral,'use_gold'=>$gold));
        if($integral > 0){
            $Users->addIntegral($member['user_id'],-$integral,'优惠买单使用秀币');
        }
        if($gold > 0){
            $Users->addGold($member['user_id'],-$gold,'优惠买单使用余额');
        }
        $Paymentlogs = D('Paymentlogs');
        $log_id = $Paymentlogs->add($pay_log);
        $pay_log['log_id']=$log_id;
        $this->ajaxReturn(array('success'=>true,'error_msg'=>'','flag'=>2,'logs'=>$pay_log));
    }
}