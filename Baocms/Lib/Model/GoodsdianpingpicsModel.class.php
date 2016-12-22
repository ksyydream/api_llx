<?php



class GoodsdianpingpicsModel extends CommonModel{
    protected $pk   = 'pic_id';
    protected $tableName =  'goods_dianping_pics';
	
	public function upload($order_id,$photos,$goods_id){
        $order_id = (int)$order_id;
        $this->delete(array("where"=>array('order_id'=>$order_id)));
        foreach($photos as $val){
            $this->add(array('pic'=>$val,'order_id'=>$order_id,'goods_id'=>$goods_id));
        }
        return true;
    }



    public function getPics($order_id){
        $order_id = (int)$order_id;
        return $this->where(array('order_id'=>$order_id))->select();
    }
}