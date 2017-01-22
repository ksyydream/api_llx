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
        $user = $Users->where(array('mobile' => $mobile))->find();
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
}