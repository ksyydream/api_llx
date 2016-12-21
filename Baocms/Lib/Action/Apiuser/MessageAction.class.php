<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/20
 * Time: 11:03
 */
class MessageAction extends CommonAction {

    public function index() {
        $Msg = D('Msg');
        $map = array('is_fenzhan'=>0,'user_id'=> 0);
        $count = $Msg->where($map)->count();
        $maxpage=ceil($count/6);
        if($Page = $this->_param('page', 'htmlspecialchars')){
            $page=$Page-1;
        }else{
            $page=0;
        }
        $msgs = $Msg->where($map)->order(array('msg_id' => 'desc'))->limit($page.',6')->select();
        $rs=array(
            'success'=>true,
            'msg'=>$msgs,
            'type'=>$Msg->getType(),
            'page'=>$page+1,
            'maxpage'=>(int)$maxpage,
            'error_msg'=>''
        );

        $this->ajaxReturn($rs,'JSON');
    }
    public function psmsg() {
        $Msg = D('Msg');
        $map = array('is_fenzhan'=>0,'user_id'=> $this->app_uid);

        $count = $Msg->where($map)->count();
        $maxpage=ceil($count/6);
        if($Page = $this->_param('page', 'htmlspecialchars')){
            $page=$Page-1;
        }else{
            $page=0;
        }
        $msgs = $Msg->where($map)->order(array('msg_id' => 'desc'))->limit($page.',6')->select();
        $rs=array(
            'success'=>true,
            'msg'=>$msgs,
            'type'=>$Msg->getType(),
            'page'=>$page+1,
            'maxpage'=>(int)$maxpage,
            'error_msg'=>''
        );

        $this->ajaxReturn($rs,'JSON');
    }

    public function msgshow() {
        if (!$msg_id = $this->_param('msg_id')){
            $rs=array(
                'success'=>false,
                'error_msg'=>'没有消息'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        D('Msg')->updateCount($msg_id, 'views');
        if (!$detail = D('Msg')->find($msg_id)) {
            $rs=array(
                'success'=>false,
                'error_msg'=>'消息不存在'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        if ($detail['user_id'] != $this->app_uid && $detail['user_id'] != 0  ) {
            $rs=array(
                'success'=>false,
                'error_msg'=>'您没有权限查看该消息'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        if (!empty($detail['city_id'])) {
            $rs=array(
                'success'=>false,
                'error_msg'=>'消息属于代理商的，您无权查看！'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        if (!D('Msgread')->find(array('user_id' => $this->app_uid, 'msg_id' => $msg_id))) {
            D('Msgread')->add(array('user_id' => $this->app_uid,'msg_id' => $msg_id,'create_time' => NOW_TIME,'create_ip' => get_client_ip()));
        }
        $rs['detail']=$detail;
        $this->ajaxReturn($rs,'JSON');
    }
}