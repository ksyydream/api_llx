<?php



class OrdergoodsModel extends CommonModel {

    protected $pk = 'id';
    protected $tableName = 'order_goods';
    protected $types = array(
        0 => '等待发货',
        1 => '已经捡货',
        8 => '已完成',
    );

    public function getType() {
        return $this->types;
    }
    /*
     * 新增函数
     */
    public function getOrderGoodsinfo($order_id){
        $this->field("bao_goods.goods_id,
        bao_goods.photo,
        bao_goods.title,
        bao_order_goods.price,
        bao_order_goods.num,
        bao_order_goods.total_price")
            ->join('left join bao_goods on bao_goods.goods_id = bao_order_goods.goods_id')
            ->where(array('bao_order_goods.order_id'=>$order_id));
        $data=$this->select();
        return $data;
    }

}