<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/16
 * Time: 9:17
 */
class TeamAction extends CommonAction{

    public function index() {
        $shop_id = $this->_param('shop_id');
        $shop_ids = array();
        $member = $this->member;
        $yhk = (array)json_decode($member['yhk']);

        foreach($yhk as $k=>$v){
            $shop_ids[] = $k;
        }

        $map_shop['shop_id'] = array('in',$shop_ids);
        $shops = D('Shop')->field('shop_id,shop_name')->where($map_shop)->select();

        if(!$shop_id){
        $rs = array(
            'success'=>true,
            'shop'=>$shops?$shops:array(),
            'team1_info'=>array(),
            'team2_info'=>array(),
            'team3_info'=>array(),
            'shop_id'=>$shop_id,
            'error_msg'=>''
        );
            $this->ajaxReturn($rs,'JSON');
        }

        $uid = $this->app_uid;

        $team1 = $this->get_low_users(array($uid),$shop_id);
        if(!empty($team1)){
            $team1_info = $this->get_user_info($team1);
            $team2 = $this->get_low_users($team1,$shop_id);
        }else{
            $team2 = array();
            $team1_info = array();
        }
        if(!empty($team2)){
            $team2_info = $this->get_user_info($team2);
            $team3 = $this->get_low_users($team2,$shop_id);
        }else{
            $team2_info = array();
        }

        if(!empty($team3)){
            $team3_info = $this->get_user_info($team3);
        }else{
            $team3_info = array();
        }
        $fx1=0;
        $fx2=0;
        $fx3=0;
        if($shop_id){
            $fx=D('shop')->where(array('shop_id'=>$shop_id))->find();
            if($fx){
                $fx1=$fx['fx_1'];
                $fx2=$fx['fx_2'];
                $fx3=$fx['fx_3'];
            }
        }
        $rs = array(
            'success'=>true,
            'shop'=>$shops,
            'team1_info'=>$team1_info,
            'team2_info'=>$team2_info,
            'team3_info'=>$team3_info,
            'shop_id'=>$shop_id,
            'fx1'=>$fx1,
            'fx2'=>$fx2,
            'fx3'=>$fx3,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }



    public function get_low_users($users,$shop_id){
        $Userparent = D('Userparent');
        //$sql = "SELECT a.*,b.uid FROM `bao_user_parent` a left join `bao_connect` b on a.openid = b.open_id";
        $sql = "SELECT a.*,b.user_id FROM `bao_user_parent` a left join `bao_users` b on a.mobile = b.account";
        $data = $Userparent->query($sql);
        $data_n = array();
        foreach($data as $k=>$v){
            $parent_old= (array)json_decode($v['parent']);
            $parent = array();
            foreach($parent_old as $key=>$val){
                $parent[$key] = $val;
            }
            if(isset($parent[$shop_id])){
                foreach($users as $vv){
                    if($parent[$shop_id] == $vv){
                        if($data[$k]['user_id']!=$this->app_uid){ //新增加 不显示自己
                            $data_n[] = $data[$k]['user_id'];
                        }
                    }
                }
            }
        }
        return $data_n;
    }

    public function get_user_info($users){
        $map['user_id']  = array('in',$users);
        $data = D('Users')->field('face,account AS mobile,nickname')->where($map)->select();

        return $data;
    }

}