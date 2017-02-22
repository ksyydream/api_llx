<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 17/2/6
 * Time: 下午1:29
 */

class ScgModel extends CommonModel{
    protected $pk   = 'scg_id';
    protected $tableName =  'user_scg';

    protected $id = 0;
    public function get_list($app_uid,$page=1){
        //$Model = new Model();
        $map = array(
            'a.uid' => $app_uid,
            'b.closed'=>0,
            'c.closed'=>0
        );
        $items = $this->alias('a')->field("a.scg_id,b.*")
            ->join('bao_goods b on b.goods_id = a.goods_id','LEFT')
            ->join('bao_shop c on c.shop_id = b.shop_id','LEFT')
            ->where($map)
            ->order(array('a.scg_id' => 'desc'))
            ->page($page.",10")
            ->select();
        return $items;
    }
}