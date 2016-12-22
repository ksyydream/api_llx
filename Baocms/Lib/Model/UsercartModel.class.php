<?php
class UsercartModel extends CommonModel {

    protected $pk = 'cart_id';
    protected $tableName = 'user_cart';

    
    public function checkCart($goods_id,$app_uid) {
        $goods_id = (int) $goods_id;
        $app_uid = (int) $app_uid;
        return $this->find(array('where' => array('goods_id' => $goods_id,'user_id' => $app_uid)));
    }

    public function get_cart_list($app_uid){
        $Model = new Model();
        $map = array('b.user_id' => $app_uid);
        $items = $Model->table('bao_goods a')
            ->field("a.*,b.num cart_num,b.create_time cart_cdate")
            ->join('left join bao_user_cart b on a.goods_id = b.goods_id')
            ->where($map)
            ->order(array('b.cart_id' => 'desc'))
            ->select();
        return $items;
    }

}
