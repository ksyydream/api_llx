<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/11
 * Time: 15:11
 */
class FavouriteAction extends CommonAction
{
    public function shop_favourites()
    {
        $shop_id = (int)$this->_param('shop_id');
        if (!$detail = D('Shop')->find($shop_id)) {
            $rs=array(
                'success'=>false,
                'error_msg'=>'没有该商家'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        if ($detail['closed']) {
            $rs=array(
                'success'=>false,
                'error_msg'=>'该商家已经被删除'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        if (D('Shopfavorites')->check($shop_id, $this->app_uid)) {
            $rs=array(
                'success'=>false,
                'error_msg'=>'您已经收藏过了！'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        $data = array(
            'shop_id' => $shop_id,
            'user_id' => $this->app_uid,
            'create_time' => NOW_TIME,
            'create_ip' => get_client_ip()
        );
        if (D('Shopfavorites')->add($data)) {
            $rs=array(
                'success'=>true,
                'error_msg'=>'恭喜您收藏成功！'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        $rs=array(
            'success'=>false,
            'error_msg'=>'收藏失败！'
        );
        $this->ajaxReturn($rs,'JSON');
    }
    public function goods_favourites()
    {
        $goods_id = (int)$this->_param('goods_id');
        if (!$detail = D('Goods')->find($goods_id)) {
            $rs=array(
                'success'=>false,
                'error_msg'=>'没有该商品'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        /*if ($detail['closed']) {
            $rs=array(
                'success'=>false,
                'error_msg'=>'该商品已经被下架'
            );
            $this->ajaxReturn($rs,'JSON');
        }*/
        if (D('Usergood')->check($goods_id, $this->app_uid)) {
            $rs=array(
                'success'=>false,
                'error_msg'=>'您已经收藏过了！'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        $data = array(
            'good_id' => $goods_id,
            'uid' => $this->app_uid,
            'create_time' => NOW_TIME
        );
        if (D('Usergood')->add($data)) {
            $rs=array(
                'success'=>true,
                'error_msg'=>'恭喜您收藏成功！'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        $rs=array(
            'success'=>false,
            'error_msg'=>'收藏失败！'
        );
        $this->ajaxReturn($rs,'JSON');
    }
}