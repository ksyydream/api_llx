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
        $map = array();
        $map['is_fenzhan']=0;
        $map['user_id']=array($this->app_uid,0,'OR');
        $count = $Msg->where($map)->count();
        $maxpage=ceil($count/6);
        $page = $this->_param('page', 'htmlspecialchars')?$this->_param('page', 'htmlspecialchars'):1;
        $msgs = $Msg->where($map)->order(array('msg_id' => 'desc'))->page($page.',6')->select();
        $test=$Msg->getLastSql();
        $rs=array(
            'success'=>true,
            'msg'=>$msgs,
            'test'=>$test,
            'type'=>$Msg->getType(),
            'page'=>$page,
            'maxpage'=>(int)$maxpage,
            'error_msg'=>''
        );

        $this->ajaxReturn($rs,'JSON');
    }
    /*public function psmsg() {
        $Msg = D('Msg');
        $map = array('is_fenzhan'=>0,'user_id'=> $this->app_uid);

        $count = $Msg->where($map)->count();
        $maxpage=ceil($count/6);
        $page = $this->_param('page', 'htmlspecialchars')?$this->_param('page', 'htmlspecialchars'):1;
        $msgs = $Msg->where($map)->order(array('msg_id' => 'desc'))->page($page.',6')->select();
        $rs=array(
            'success'=>true,
            'msg'=>$msgs,
            'type'=>$Msg->getType(),
            'page'=>$page+1,
            'maxpage'=>(int)$maxpage,
            'error_msg'=>''
        );

        $this->ajaxReturn($rs,'JSON');
    }*/

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
        if (!D('Msgread')->where(array('user_id' => $this->app_uid,'type'=>'msg','msg_id'=>$msg_id))->find()) {
            echo D('Msgread')->getLastSql();
            D('Msgread')->add(array('user_id' => $this->app_uid,'msg_id' => $msg_id,'type'=>'msg','create_time' => NOW_TIME,'create_ip' => get_client_ip()));
        }
        $rs=array(
            'success'=>true,
            'detail'=>$detail,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }

    public function vipmsg() {
        $shop_id=D('Order')->where(array('user_id'=> $this->app_uid,'status'=>1))->field('shop_id')->group('shop_id')->select();
        foreach ($shop_id as $v=>$k){
            $shop_ids[]=$k['shop_id'];
        }
        $msg=array();
        $Shopmsg = D('Shopmsg');
        $page = $this->_param('page', 'htmlspecialchars')?$this->_param('page', 'htmlspecialchars'):1;
        $map['shop_id']=array('in',$shop_ids);
        $msgs = $Shopmsg->where($map)->order(array('msg_id' => 'desc'))->page($page.',6')->select();
        foreach ($msgs as $a){
            $msg[]=$a;
        }
        $rs=array(
            'success'=>true,
            'msg'=>$msg,
            'type'=>$Shopmsg->getType(),
            'page'=>$page,
            'error_msg'=>''
        );

        $this->ajaxReturn($rs,'JSON');
    }

    public function vipmsgshow() {
        if (!$msg_id = $this->_param('msg_id')){
            $rs=array(
                'success'=>false,
                'error_msg'=>'没有消息'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        D('Shopmsg')->where(array('msg_id'=>$msg_id))->setInc('views',1);;
        if (!$detail = D('Shopmsg')->find($msg_id)) {
            $rs=array(
                'success'=>false,
                'error_msg'=>'消息不存在'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        $shop_id=D('Order')->where(array('user_id'=> $this->app_uid,'status'=>1))->field('shop_id')->group('shop_id')->select();
        foreach ($shop_id as $v=>$k){
            $shop_ids[]=$k['shop_id'];
        }
        if (!in_array($detail['shop_id'],$shop_ids)) {
            $rs=array(
                'success'=>false,
                'error_msg'=>'您不是该商店会员'
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
        if (!D('Msgread')->where(array('type'=>'vipmsg','msg_id'=>$msg_id))->find()) {
            D('Msgread')->add(array('user_id' => $this->app_uid,'msg_id' => $msg_id,'type'=>'vipmsg','create_time' => NOW_TIME,'create_ip' => get_client_ip()));
        }
        $rs=array(
            'success'=>true,
            'detail'=>$detail,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }
}