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
}