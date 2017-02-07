<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 17/2/6
 * Time: 下午1:29
 */

class LlxgoodsphotoModel extends CommonModel{
    protected $pk   = 'pic_id';
    protected $tableName =  'llxgoods_photos';

    protected $id = 0;


    public function getPics($goods_id){
        $goods_id = (int) $goods_id;
        return $this->where(array('goods_id'=>$goods_id))->select();
    }
}