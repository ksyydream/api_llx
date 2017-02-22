<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/16
 * Time: 16:32
 */
class ScAction extends CommonAction {
    //商铺收藏
    public function add_sc_fd(){
        $fd_id = $this->_post('fd_id');
        if (empty($fd_id)) {
            $rs = array('success' => false, 'error_msg'=>'请选择分店!');
            die(json_encode($rs));
        }
        if (!$fd_info = D('Shopfd')->find($fd_id)) {
            $rs = array('success' => false, 'error_msg'=>'没有该分店!');
            die(json_encode($rs));
        }
        if ($fd_info['closed']) {
            $rs = array('success' => false, 'error_msg'=>'该分店已经被删除!');
            die(json_encode($rs));
        }
        if (!$detail = D('Shop')->find($fd_info['shop_id'])) {
            $rs = array('success' => false, 'error_msg'=>'没有该商家!');
            die(json_encode($rs));
        }
        if ($detail['closed']) {
            $rs = array('success' => false, 'error_msg'=>'该商家已经被删除!');
            die(json_encode($rs));
        }
        $data=array(
            'fd_id'=>$fd_id,
            'uid'=>$this->app_uid
        );
        $row =  D('Scf')->where($data)->find();
        if($row){
            $rs = array('success' => false, 'error_msg'=>'该分店已收藏!');
            die(json_encode($rs));
        }else{
            D('Scf')->add($data);
            $rs = array('success' => true, 'error_msg'=>'');
            die(json_encode($rs));
        }
    }

    public function del_sc_fd(){
        $scf_id = $this->_post('scf_id');
        if (empty($scf_id)) {
            $rs = array('success' => false, 'error_msg'=>'请选择收藏编号!');
            die(json_encode($rs));
        }
        $row =  D('Scf')->find($scf_id);
        if($row['uid']==$this->app_uid){
            D('Scf')->where("uid = {$this->app_uid} and scf_id = {$scf_id}")->delete();
            $rs = array('success' => true, 'error_msg'=>'');
            die(json_encode($rs));
        }else{
            $rs = array('success' => false, 'error_msg'=>'该收藏不是本人的,不可操作!');
            die(json_encode($rs));
        }
    }

    public function sc_fd_list(){
        $scfmodel = D('Scf');
        $page = trim($this->_param('page')) ? trim($this->_param('page')) : 1;
        $list = $scfmodel->get_list($this->app_uid,$page);
        $rs = array(
            'success'=>true,
            'list'=>$list,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }

    //商品收藏
    public function add_sc_good(){
        $goods_id = (int) $this->_post('goods_id');
        if (empty($goods_id)) {
            $rs = array('success' => false, 'error_msg'=>'请选择商品!');
            die(json_encode($rs));
        }
        if (!($detail = D('Goods')->find($goods_id))) {
            $rs = array('success' => false, 'error_msg'=>'该商品不存在!');
            die(json_encode($rs));
        }
        if ($detail['closed'] != 0 || $detail['audit'] != 1) {
            $rs = array('success' => false, 'error_msg'=>'该商品不存在!');
            die(json_encode($rs));
        }
        if ($detail['end_date'] < TODAY) {
            $rs = array('success' => false, 'error_msg'=>'该商品已经过期，暂时不能购买!');
            die(json_encode($rs));
        }
        if ($detail['num'] <= 0) {
            $rs = array('success' => false, 'error_msg'=>'亲！没有库存了！');
            die(json_encode($rs));
        }
        $data=array(
            'goods_id'=>$goods_id,
            'uid'=>$this->app_uid
        );
        $row =  D('Scg')->where($data)->find();
        if($row){
            $rs = array('success' => false, 'error_msg'=>'该商品已收藏!');
            die(json_encode($rs));
        }else{
            D('Scg')->add($data);
            $rs = array('success' => true, 'error_msg'=>'');
            die(json_encode($rs));
        }
    }

    public function del_sc_good(){
        $scg_id = $this->_post('scg_id');
        if (empty($scg_id)) {
            $rs = array('success' => false, 'error_msg'=>'请选择收藏编号!');
            die(json_encode($rs));
        }
        $row =  D('Scg')->find($scg_id);
        if($row['uid']==$this->app_uid){
            D('Scg')->where("uid = {$this->app_uid} and scg_id = {$scg_id}")->delete();
            $rs = array('success' => true, 'error_msg'=>'');
            die(json_encode($rs));
        }else{
            $rs = array('success' => false, 'error_msg'=>'该收藏不是本人的,不可操作!');
            die(json_encode($rs));
        }
    }

    public function sc_good_list(){
        $scgmodel = D('Scg');
        $page = trim($this->_param('page')) ? trim($this->_param('page')) : 1;
        $list = $scgmodel->get_list($this->app_uid,$page);
        $rs = array(
            'success'=>true,
            'list'=>$list,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }
}