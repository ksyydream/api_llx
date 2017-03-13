<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/16
 * Time: 16:32
 */
class WxtxAction extends CommonAction {

    public function Wxtx_list()
    {

        $page = $this->_param('page', 'htmlspecialchars')?$this->_param('page', 'htmlspecialchars'):1;
        //$list = $Pay->query("select a.*,shop_name from `bao_pay` AS a left join `bao_shop` AS b on a.shop_id = b.shop_id where a.mobile = ".$member['account']." order by a.id desc limit ".$page.",25");
        $list = D('Wxtx')->field('*')
            ->where('uid='.$this->app_uid)
            ->order('id desc')
            ->page($page . ',20')
            ->select();
        $rs=array('success'=>true,
            'list'=>$list,
            'page'=>$page,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }
}