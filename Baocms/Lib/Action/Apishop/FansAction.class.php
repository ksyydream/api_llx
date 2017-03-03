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
        $fans = D('Scf');
        //实例化fans模型
        $map = array(
            'b.shop_id' => $this->shop_id
        );
        //查询条件
        if ($keyword = $this->_post('keyword', 'htmlspecialchars')) {
            $map['c.nickname|c.mobile'] = array('like','%'.trim($keyword).'%');
        }

        $count = $fans->alias('a')->group('a.uid')->field('a.*')
            ->join('bao_shop_fd b on a.fd_id = b.fd_id','LEFT')
            ->join('bao_users c on c.user_id = a.uid','LEFT')
            ->where($map)->count();
        // 查询满足要求的总记录数
        $maxpage=ceil($count/6);
        $page = $this->_param('page', 'htmlspecialchars')?$this->_param('page', 'htmlspecialchars'):1;
        $list = $fans->alias('a')->group('a.uid')->field('a.*,b.shop_id,c.user_id,c.nickname,c.mobile,c.face')
            ->join('bao_shop_fd b on a.fd_id = b.fd_id','LEFT')
            ->join('bao_users c on c.user_id = a.uid','LEFT')
            ->where($map)
            ->order(array('a.scf_id' => 'desc'))
            ->page($page.',6')
            ->select();
        //die(var_dump($fans->getLastSql()));
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