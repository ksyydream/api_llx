<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/20
 * Time: 10:00
 */
class PayAction extends CommonAction
{
 //   private $create_fields = array('shop_id', 'photo', 'name', 'zhucehao', 'addr', 'end_date', 'zuzhidaima', 'user_name', 'pic', 'mobile', 'audit');
  //  private $edit_fields = array('shop_id', 'photo', 'name', 'zhucehao', 'addr', 'end_date', 'zuzhidaima', 'user_name', 'pic', 'mobile', 'audit');


    public function index()
    {
        $Pay = D('Pay');
        $Shop = D('Shop');
        $member = $this->member;
        $map = array('mobile' => $member['mobile']);
        $count = $Pay->where($map)->count();
        $maxpage=ceil($count/25);
        $page = $this->_param('page', 'htmlspecialchars')?$this->_param('page', 'htmlspecialchars'):1;
        //$list = $Pay->query("select a.*,shop_name from `bao_pay` AS a left join `bao_shop` AS b on a.shop_id = b.shop_id where a.mobile = ".$member['account']." order by a.id desc limit ".$page.",25");
        $list = $Pay->alias('a')->field('a.*,b.shop_name')
            ->join('bao_shop b on a.shop_id = b.shop_id','LEFT')
            ->where('a.mobile='.$member['account'])
            ->order('a.id desc')
            ->page($page . ',20')
            ->select();
       // echo $Pay->getlastsql();
        foreach ($list as $k => $v) {
            $list[$k]['zp'] = (array)json_decode($v['zp']);
        }
        $rs=array('success'=>true,
            'list'=>$list,
            'page'=>$page,
            'maxpage'=>(int)$maxpage,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }
    public function pay()
    {
        $id=$this->_param('id');
        $Pay = D('Pay');
        $Shop = D('Shop');
        $rss = $Pay->query("select a.*,shop_name from `bao_pay` AS a left join `bao_shop` AS b on a.shop_id = b.shop_id where a.id = ".$id);
        if(empty($rss)){
            $rs=array(
                'success'=>false,
                'error_msg'=>'不存在该笔付款'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        $detail = $rss[0];
        $detail['zp'] = (array)json_decode($rss[0]['zp']);
        $member = $this->member;
        $rs=array(
            'success'=>true,
            'detail'=>$detail,
            'integral'=>$member['integral'],
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }
}