<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/16
 * Time: 16:32
 */
class XlkAction extends CommonAction {

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

    public function use_xlk(){
        $xlh = $this->_post('xlh');
        if(!$xlh){
            $rs = array('success'=>false, 'error_msg'=>'序列号不能为空!');
            $this->ajaxReturn($rs,'JSON');
        }
        $check = D('Xlktimes')->check_times($this->app_uid);
        if($check != 1){
            $rs = array('success'=>false, 'error_msg'=>'因输入错误次数过多,今日无法进行兑换序列号');
            $this->ajaxReturn($rs,'JSON');
        }
        $xlk_detail =  D('Xlkdetail')->where(array('xlh'=>$xlh))->find();
        if(!$xlk_detail){
            D('Xlktimes')->add_times($this->app_uid);
            $rs = array('success'=>false, 'error_msg'=>'序列号不存在,请重新输入!');
            $this->ajaxReturn($rs,'JSON');
        }
        if($xlk_detail['flag']!=1){
            $rs = array('success'=>false, 'error_msg'=>'序列号已被使用!');
            $this->ajaxReturn($rs,'JSON');
        }
        $xlk_matser = D('Xlkmaster')->where(array(
            'id'=>$xlk_detail['master_id'],
            'flag'=>1,
            'valid_time'=>array('EGT',date('Y-m-d'))
        ))->find();
        if(!$xlk_matser){
            $rs = array('success'=>false, 'error_msg'=>'序列号已无效!');
            $this->ajaxReturn($rs,'JSON');
        }
        //这里进行优惠券和赠品的增加
        //1 首先 优惠卡标记已使用,
        //2 增加优惠券
        //3 增加赠品
        D('Xlkdetail')->where(array('xlh'=>$xlh))->save(array(
            'flag'=>2,
            'used_time'=>date('Y-m-d H:i:s'),
            'uid'=>$this->app_uid,
            ));
        $user = D('Users')->where(array('user_id'=>$this->app_uid))->find();
        $yhq_ = $xlk_matser['yhq']?$xlk_matser['yhq']:0;
        if($yhq_ < 0 ){
            $yhq_ = 0;
        }
        if($user['yhk']){//这里处理 优惠卡
            $yhk_old = (Array)json_decode($user['yhk']);
            $yhk = array();
            foreach ($yhk_old as $key=>$val){
                $yhk[$key] = $val;
            }
            if(isset($yhk[$xlk_matser['shop_id']])){
                $yhk[$xlk_matser['shop_id']] = $yhk[$xlk_matser['shop_id']] + $yhq_;
            }else{
                $yhk[$xlk_matser['shop_id']] = $yhq_;
            }
        }else{
            $yhk = array($xlk_matser['shop_id'] => $yhq_);
        }
        D('Users')->where(array('user_id'=>$this->app_uid))->save(array('yhk'=>json_encode($yhk)));

        $zengpins = D('Xlkzp')->where(array('master_id'=>$xlk_matser['id']))->select();
        if($user['zp']){//赠品
            $zp_old = (Array)json_decode($user['zp']);
            $zp_old2 = array();
            $zp = array();
            if($zengpins){
                foreach($zp_old as $kk=>$vv){
                    $zp_old2[$kk] = $vv;
                }
                if(isset($zp_old2[$xlk_matser['shop_id']])){
                    foreach($zengpins as $vvv){
                        if(isset($zp_old2[$xlk_matser['shop_id']]->$vvv['desc'])){
                            $zp_old2[$xlk_matser['shop_id']]->$vvv['desc'] = $zp_old2[$xlk_matser['shop_id']]->$vvv['desc'] + ($vvv['qty']);
                        }else{
                            $zp_old2[$xlk_matser['shop_id']]->$vvv['desc'] = ($vvv['qty']);
                        }
                    }
                }else{
                    foreach($zengpins as $vvv){
                        $zp_old2[$xlk_matser['shop_id']]->$vvv['desc'] = ($vvv['qty']);
                    }
                }
                $zp = $zp_old2;
            }
        }else{
            if($zengpins){
                $zp = array();
                foreach($zengpins as $k=>$vv){
                    $zps[$vv['desc']] = ($vv['qty']);
                }
                $zp[$xlk_matser['shop_id']] = (object)$zps;
            }
        }
        D('Users')->where(array('user_id'=>$this->app_uid))->save(array('zp'=>json_encode($zp)));

        //D('Xlktimes')->delete_times($this->app_uid);
        $rs = array('success'=>true, 'error_msg'=>'');
        $this->ajaxReturn($rs,'JSON');
    }
}