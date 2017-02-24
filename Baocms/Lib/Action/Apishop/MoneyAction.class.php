<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/14
 * Time: 16:26
 */
class MoneyAction extends CommonAction{

    public function detail()
    {
        $shops = D('Shop')->where(array('shop_id' => $this->shop_id))->find();
        $map = array('user_id' => $shops['user_id']);
        if (($bg_date = $this->_param('bg_date', 'htmlspecialchars')) && ($end_date = $this->_param('end_date', 'htmlspecialchars'))) {
            $bg_time = strtotime($bg_date);
            $end_time = strtotime($end_date);
            $map['create_time'] = array(array('ELT', $end_time), array('EGT', $bg_time));
        } else {
            if ($bg_date = $this->_param('bg_date', 'htmlspecialchars')) {
                $bg_time = strtotime($bg_date);
                $map['create_time'] = array('EGT', $bg_time);
            }
            if ($end_date = $this->_param('end_date', 'htmlspecialchars')) {
                $end_time = strtotime($end_date);
                $map['create_time'] = array('ELT', $end_time);
            }
        }
        $Usermoneylogs = D('Usergoldlogs');

        $count = $Usermoneylogs->where($map)->count();
        $maxpage=ceil($count/16);
        $page = $this->_param('page', 'htmlspecialchars')?$this->_param('page', 'htmlspecialchars'):1;

        $list = $Usermoneylogs->where($map)->order(array('log_id' => 'desc'))->page($page.',16')->select();
        $rs=array(
            'success'=>true,
            'data'=>array('bg_date'=>$bg_date,'end_date'=>$end_date) ,
            'list'=>$list,
            'page'=>$page,
            'maxpage'=>(int)$maxpage,
            'error_msg'=>''
        );

        $this->ajaxReturn($rs,'JSON');
    }


    public function cashlogs()
    {
        $map = array('shop_id' => $this->shop_id, 'type' => shop);
        if (($bg_date = $this->_param('bg_date', 'htmlspecialchars')) && ($end_date = $this->_param('end_date', 'htmlspecialchars'))) {
            $bg_time = strtotime($bg_date);
            $end_time = strtotime($end_date);
            $map['create_time'] = array(array('ELT', $end_time), array('EGT', $bg_time));
            $this->assign('bg_date', $bg_date);
            $this->assign('end_date', $end_date);
        } else {
            if ($bg_date = $this->_param('bg_date', 'htmlspecialchars')) {
                $bg_time = strtotime($bg_date);
                $this->assign('bg_date', $bg_date);
                $map['create_time'] = array('EGT', $bg_time);
            }
            if ($end_date = $this->_param('end_date', 'htmlspecialchars')) {
                $end_time = strtotime($end_date);
                $this->assign('end_date', $end_date);
                $map['create_time'] = array('ELT', $end_time);
            }
        }
        $Userscash = D('Userscash');
        $count = $Userscash->where($map)->count(); // 查询满足要求的总记录数
        $maxpage=ceil($count/16);
        $page = $this->_param('page', 'htmlspecialchars')?$this->_param('page', 'htmlspecialchars'):1;

        $list = $Userscash->where($map)->order(array('cash_id' => 'desc'))->page($page.',16')->select();
        $rs=array(
            'success'=>true,
            'list'=>$list,
            'page'=>$page,
            'maxpage'=>(int)$maxpage,
            'error_msg'=>''
        );

        $this->ajaxReturn($rs,'JSON');


    }
    public function sendsms(){
        if(!trim($this->_param('mobile'))){
            $rs = array(
                'success'=>false,
                'error_msg'=>'登陆手机号码不能为空!',
            );
            $this->ajaxReturn($rs,'JSON');
        }
        $mobile = trim($this->_param('mobile'));
        if ($user = D('Users')->getUserByAccount($mobile)) {
            $yzm = rand(100000,999999);
            $text = "尊敬的用户：您再拉拉秀生态平台手机认证的验证码为:".$yzm." 千万别告诉别人!";
//            file_get_contents("http://sms-api.luosimao.com/v1/http_get/send/json?key=e3829a670f2c515ab8befa5096dd135c&mobile={$mobile}&message={$text}【拉拉秀】");
            file_get_contents("http://api.smsbao.com/sms?u=ml6666&p=c4ba944ae255386e8323a6b0a2a30dc5&m={$mobile}&c=【拉拉秀】{$text}");
            $rs = array(
                'success'=>true,
                'yzm'=>$yzm,
                'error_msg'=>''
            );
            echo json_encode($rs);
        }else{
            $rs = array(
                'success'=>false,
                'error_msg'=>'手机号码和收取验证码的手机号不一致!',
            );
            $this->ajaxReturn($rs,'JSON');
        }
    }

    public function cash()
    {
        $user_ids = D('Shop')->where(array('shop_id' => $this->shop_id))->find();
        $user_id = $user_ids['user_id'];
        $userscash = D('Userscash')->where(array('user_id' => $user_ids['user_id']))->find();;
        $shop = D('Shop')->where(array('user_id' => $user_id))->find();
        $forzengold = 0;
            $rlgold=$this->member['gold'];
            $cash_money = $this->_CONFIG['cash']['user'];
            $cash_money_big = $this->_CONFIG['cash']['user_big'];


        //对比手机号码，验证码
        $shop = D('Shop')->where(array('shop_id' => $this->shop_id))->find();
        $users = D('Users')->where(array('user_id' => $shop['user_id']))->find();

        if ($_POST['gold']) {
            $gold = (int)($_POST['gold'] * 100);
            if ($gold <= 0) {
                $rs['error_msg']='提现金额不合法';
                $this->ajaxReturn($rs,'JSON');
            }
            if ($gold < $cash_money * 100) {
                $rs['error_msg']='提现金额小于最低提现额度';
                $this->ajaxReturn($rs,'JSON');
            }
            /*if ($gold > $cash_money_big * 100) {
                $this->fengmiMsg('您单笔最多能提现' . $cash_money_big . '元');
            }
            if ($this->member['gold']-$gold<3000000) {
                $rs['error_msg']='商户可提取资金不足，无法提现';
                $this->ajaxReturn($rs,'JSON');
            }*/
            if ($gold > $this->member['gold'] || $this->member['gold'] == 0) {
                $rs['error_msg']='资金不足，无法提现';
                $this->ajaxReturn($rs,'JSON');
            }
            if (!$data['bank_name'] = htmlspecialchars($_POST['bank_name'])) {
                $rs['error_msg']='开户行不能为空';
                $this->ajaxReturn($rs,'JSON');
            }
//            var_dump($_POST['bank_num']);die;
            if (!$data['bank_num'] = htmlspecialchars($_POST['bank_num'])) {
                $rs['error_msg']='银行账号不能为空';
                $this->ajaxReturn($rs,'JSON');
            }

            if (!$data['bank_realname'] = htmlspecialchars($_POST['bank_realname'])) {
                $rs['error_msg']='开户姓名不能为空';
                $this->ajaxReturn($rs,'JSON');
            }
            if (empty($yzm)) {
                $rs['error_msg']='请输入短信验证码';
                $this->ajaxReturn($rs,'JSON');
            }

            /*if ($users['mobile'] != $s_mobile) {
                $rs['error_msg']='手机号码和收取验证码的手机号不一致！';
                $this->ajaxReturn($rs,'JSON');
            }
            if ($yzm != $cash_code) {
                $rs['error_msg']='短信验证码不正确';
                $this->ajaxReturn($rs,'JSON');
            }*/

            $data['bank_branch'] = htmlspecialchars($_POST['bank_branch']);
            $data['user_id'] = $this->uid;

            $arr = array();
            $arr['user_id'] = $this->uid;
            $arr['shop_id'] = $this->shop_id;//提现商家
            $arr['city_id'] = $shop['city_id'];
            $arr['area_id'] = $shop['area_id'];
            $arr['money'] = $gold;
            $arr['type'] = shop;
            $arr['addtime'] = NOW_TIME;
            $arr['account'] = $this->member['account'];
            $arr['bank_name'] = $data['bank_name'];
            $arr['bank_num'] = $data['bank_num'];
            $arr['bank_realname'] = $data['bank_realname'];
            $arr['bank_branch'] = $data['bank_branch'];

            D("Userscash")->add($arr);

            D('Usersex')->save($data);
            D('Users')->Money($this->uid, -$gold, '商户申请提现，扣款');
            $rs['success']=true;
            $rs['error_msg']='申请提现成功';
            $this->ajaxReturn($rs,'JSON');
        } else {
            $rs = array(
                'success'=>true,
                'info'=>D('Usersex')->getUserex($user_id),//曾经用过的银行信息
                'nickname'=>$this->member['nickname'],
                'gold'=>$rlgold,//余额
                'forzengold'=>$forzengold,//冻结金
                'cash_money'=>$cash_money,//可提取金额最小值
                'cash_money_big'=>$cash_money_big,//最大值
                'error_msg'=>''
            );
            $this->ajaxReturn($rs,'JSON');
        }
    }

    /*public function integral()
    {
        $user_ids = D('Shop')->where(array('shop_id' => $this->shop_id))->find();
        $user_id = $user_ids['user_id'];
        $userscash = D('Userscash')->where(array('user_id' => $user_ids['user_id']))->find();;
        $shop = D('Shop')->where(array('user_id' => $user_id))->find();
        if ($shop == '') {
            $rlgold=$this->member['gold'];
            $cash_money = $this->_CONFIG['cash']['user'];
            $cash_money_big = $this->_CONFIG['cash']['user_big'];
        } elseif ($shop['is_renzheng'] == 0) {
            $rlgold=$this->member['gold']-3000000 >= 0?$this->member['gold']-3000000:0;
            $forzengold=$rlgold > 0 ? 3000000 : $this->member['gold'];
            $cash_money = $this->_CONFIG['cash']['shop'];
            $cash_money_big = $this->_CONFIG['cash']['shop_big'];
        } elseif ($shop['is_renzheng'] == 1) {
            $rlgold=$this->member['gold']-3000000 >= 0?$this->member['gold']-3000000:0;
            $forzengold=$rlgold > 0 ? 3000000 : $this->member['gold'];
            $cash_money = $this->_CONFIG['cash']['renzheng_shop'];
            $cash_money_big = $this->_CONFIG['cash']['renzheng_shop_big'];
        } else {
            $rlgold=$this->member['gold'];
            $cash_money = $this->_CONFIG['cash']['user'];
            $cash_money_big = $this->_CONFIG['cash']['user_big'];
        }

        //对比手机号码，验证码
        $shop = D('Shop')->where(array('shop_id' => $this->shop_id))->find();
        $users = D('Users')->where(array('user_id' => $shop['user_id']))->find();

        if ($_POST['gold']) {
            $gold = (int)($_POST['gold'] * 100);
            if ($gold <= 0) {
                $rs['error_msg']='提现金额不合法';
                $this->ajaxReturn($rs,'JSON');
            }
            if ($gold < $cash_money * 100) {
                $rs['error_msg']='提现金额小于最低提现额度';
                $this->ajaxReturn($rs,'JSON');
            }
            /*if ($gold > $cash_money_big * 100) {
                $this->fengmiMsg('您单笔最多能提现' . $cash_money_big . '元');
            }*/
            /*if ($this->member['gold']-$gold<3000000) {
                $rs['error_msg']='商户可提取资金不足，无法提现';
                $this->ajaxReturn($rs,'JSON');
            }
            if ($gold > $this->member['gold'] || $this->member['gold'] <= 3000000) {
                $rs['error_msg']='商户可资金不足，无法提现';
                $this->ajaxReturn($rs,'JSON');
            }
            if (!$data['bank_name'] = htmlspecialchars($_POST['bank_name'])) {
                $rs['error_msg']='开户行不能为空';
                $this->ajaxReturn($rs,'JSON');
            }
//            var_dump($_POST['bank_num']);die;
            if (!$data['bank_num'] = htmlspecialchars($_POST['bank_num'])) {
                $rs['error_msg']='银行账号不能为空';
                $this->ajaxReturn($rs,'JSON');
            }

            if (!$data['bank_realname'] = htmlspecialchars($_POST['bank_realname'])) {
                $rs['error_msg']='开户姓名不能为空';
                $this->ajaxReturn($rs,'JSON');
            }
            if (empty($yzm)) {
                $rs['error_msg']='请输入短信验证码';
                $this->ajaxReturn($rs,'JSON');
            }

            /*if ($users['mobile'] != $s_mobile) {
                $rs['error_msg']='手机号码和收取验证码的手机号不一致！';
                $this->ajaxReturn($rs,'JSON');
            }
            if ($yzm != $cash_code) {
                $rs['error_msg']='短信验证码不正确';
                $this->ajaxReturn($rs,'JSON');
            }*/

            /*$data['bank_branch'] = htmlspecialchars($_POST['bank_branch']);
            $data['user_id'] = $this->uid;

            $arr = array();
            $arr['user_id'] = $this->uid;
            $arr['shop_id'] = $this->shop_id;//提现商家
            $arr['city_id'] = $shop['city_id'];
            $arr['area_id'] = $shop['area_id'];
            $arr['money'] = $gold;
            $arr['type'] = shop;
            $arr['addtime'] = NOW_TIME;
            $arr['account'] = $this->member['account'];
            $arr['bank_name'] = $data['bank_name'];
            $arr['bank_num'] = $data['bank_num'];
            $arr['bank_realname'] = $data['bank_realname'];
            $arr['bank_branch'] = $data['bank_branch'];

            D("Userscash1")->add($arr);

            D('Usersex')->save($data);
            D('Users')->addIntegral($this->uid, -$gold, '商户申请提现，扣秀币');
            $rs['success']=true;
            $rs['error_msg']='申请提现成功';
            $this->ajaxReturn($rs,'JSON');
        } else {
            $rs = array(
                'success'=>true,
                'info'=>D('Usersex')->getUserex($user_id),//曾经用过的银行信息
                'nickname'=>$this->member['nickname'],
                'gold'=>$rlgold,//余额
                'forzengold'=>$forzengold,//冻结金
                'cash_money'=>$cash_money,//可提取金额最小值
                'cash_money_big'=>$cash_money_big,//最大值
                'error_msg'=>''
            );
            $this->ajaxReturn($rs,'JSON');
            $this->assign('info', D('Usersex')->getUserex($this->uid));
            $this->assign('gold', $this->member['integral']);
            $this->assign('cash_money', $cash_money);
            $this->assign('cash_money_big', $cash_money_big);
            $this->assign('userscash', $userscash);
            $this->display();
        }
    }

    public function integral_detail(){
        $shops = D('Shop')->where(array('shop_id' => $this->shop_id))->find();
        $map = array('user_id' => $shops['user_id']);
        if (($bg_date = $this->_param('bg_date', 'htmlspecialchars')) && ($end_date = $this->_param('end_date', 'htmlspecialchars'))) {
            $bg_time = strtotime($bg_date);
            $end_time = strtotime($end_date);
            $map['create_time'] = array(array('ELT', $end_time), array('EGT', $bg_time));
            $this->assign('bg_date', $bg_date);
            $this->assign('end_date', $end_date);
        } else {
            if ($bg_date = $this->_param('bg_date', 'htmlspecialchars')) {
                $bg_time = strtotime($bg_date);
                $this->assign('bg_date', $bg_date);
                $map['create_time'] = array('EGT', $bg_time);
            }
            if ($end_date = $this->_param('end_date', 'htmlspecialchars')) {
                $end_time = strtotime($end_date);
                $this->assign('end_date', $end_date);
                $map['create_time'] = array('ELT', $end_time);
            }
        }
        $Userintegrallogs = D('Userintegrallogs');
        $count = $Userintegrallogs->where($map)->count();
        $maxpage=ceil($count/16);
        $page = $this->_param('page', 'htmlspecialchars')?$this->_param('page', 'htmlspecialchars'):1;



        $list = $Userintegrallogs->where($map)->order(array('log_id' => 'desc'))->page($page . ',16')->select();
        $rs = array(
            'success'=>true,
            'data'=>array('bg_data'=>$bg_date,'end_data'=>$end_date) ,
            'list'=>$list,
            'page'=>$page,
            'maxpage'=>(int)$maxpage,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }

    public function integral_cashlogs(){
        $map = array('shop_id' => $this->shop_id, 'type' => shop);
        if (($bg_date = $this->_param('bg_date', 'htmlspecialchars')) && ($end_date = $this->_param('end_date', 'htmlspecialchars'))) {
            $bg_time = strtotime($bg_date);
            $end_time = strtotime($end_date);
            $map['create_time'] = array(array('ELT', $end_time), array('EGT', $bg_time));
            $this->assign('bg_date', $bg_date);
            $this->assign('end_date', $end_date);
        } else {
            if ($bg_date = $this->_param('bg_date', 'htmlspecialchars')) {
                $bg_time = strtotime($bg_date);
                $this->assign('bg_date', $bg_date);
                $map['create_time'] = array('EGT', $bg_time);
            }
            if ($end_date = $this->_param('end_date', 'htmlspecialchars')) {
                $end_time = strtotime($end_date);
                $this->assign('end_date', $end_date);
                $map['create_time'] = array('ELT', $end_time);
            }
        }
        $Userscash = D('Userscash1');
        $count = $Userscash->where($map)->count();
        $maxpage=ceil($count/16);
        $page = $this->_param('page', 'htmlspecialchars')?$this->_param('page', 'htmlspecialchars'):1;
        $list = $Userscash->where($map)->order(array('cash_id' => 'desc'))->page($page . ',16')->select();
        $rs = array(
            'success'=>true,
            'list'=>$list,
            'page'=>$page,
            'maxpage'=>(int)$maxpage,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');

    }*/
}