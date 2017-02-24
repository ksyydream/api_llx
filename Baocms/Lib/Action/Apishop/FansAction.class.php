<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/20
 * Time: 13:39
 */

class FansAction extends CommonAction
{
    public function index()
    {
        $fans = D('Shopfavorites');
        //实例化fans模型
        $map = array('shop_id' => $this->shop_id);
        //查询条件
        if ($keyword = $this->_post('keyword', 'htmlspecialchars')) {
            $maps['nickname|mobile'] = array('like','%'.trim($keyword).'%');
            $Users = D('Users');
            $user = $Users->where($maps)->select();
            foreach ($user as $k => $val) {
                if ($val['user_id']) {
                    $user_ids[$val['user_id']] = $val['user_id'];
                }
            }
            if (!empty($user)) {
                $map['user_id'] = array('in',$user_ids);
            }else{
                $rs = array(
                    'success' =>true,
                    'keyword'=> $keyword,
                    'list'=>'',
                    'error_msg'=>''
                );
                die(json_encode($rs));
            }

        }
        $count = $fans->where($map)->count();
        // 查询满足要求的总记录数
        $maxpage=ceil($count/6);
        $page = $this->_param('page', 'htmlspecialchars')?$this->_param('page', 'htmlspecialchars'):1;
        $list = $fans->where($map)->order(array('favorites_id' => 'desc'))->page($page.',6')->select();
        $user_ids = array();
        foreach ($list as $k => $val) {
            if ($val['user_id']) {
                $users=D('Users')->where(array('user_id'=>$val['user_id']))->find();
                //print_r($users);
                $list[$k]['username']=$users['nickname'];
                $list[$k]['mobile']=$users['mobile'];
                $list[$k]['face']=$users['face'];
            }
        }

        $rs = array(
            'success' =>true,
            'keyword'=> $keyword,
            'list'=> $list,
            'page'=> $page,
            'maxpage'=>$maxpage,
            'error_msg'=>''
        );
        die(json_encode($rs));
    }
    /*public function add($user_id = 0)
    {
        $fans = D('Shopfavorites');
        $uid = (int) $user_id;
        $user = D('Users')->find($user_id);
        $shop = D('shop')->find($this->shop_id);
        if ($this->isPost()) {
            $integral = (int) $_POST['integral'];
            if ($integral <= 0) {
                $this->fengmiMsg('请输入正确的积分');
            }
            if ($this->member['integral'] < $integral) {
                $this->fengmiMsg('您的账户积分不足');
            }
            D('Users')->addIntegral($this->uid, -$integral, '赠送会员积分');
            D('Users')->addIntegral($user_id, $integral, '获得商家赠送积分');
            $this->fengmiMsg('赠送积分成功!', U('store/fans/index'));
        } else {
            $this->assign('shop', $shop);
            $this->assign('jifen', $this->member['integral']);
            $this->assign('user', $user);
            $this->display();
        }
    }*/
}