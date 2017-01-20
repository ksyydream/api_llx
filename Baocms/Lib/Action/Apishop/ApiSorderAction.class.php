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
        }
        $rs = array(
            'success'=>true,
            'list'=>$list,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }
}