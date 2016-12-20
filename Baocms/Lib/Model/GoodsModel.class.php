<?php



class GoodsModel extends CommonModel{
    protected $pk   = 'goods_id';
    protected $tableName =  'goods';
	 protected $_validate = array(
        array( ),
        array( ),
        array( )
    );

    
    
    public function _format($data){
        $data['save'] =  round(($data['price'] - $data['mall_price'])/100,2);
        $data['price'] = round($data['price']/100,2);
		//多属性开始
		$data['mobile_fan'] = round($data['mobile_fan']/100,2);
		//多属性结束
		 
        $data['mall_price'] = round($data['mall_price']/100,2); 
        $data['settlement_price'] = round($data['settlement_price']/100,2); 
        $data['commission'] = round($data['commission']/100,2); 
        $data['discount'] = round($data['mall_price'] * 10 / $data['price'],1);
        return $data;
    }

    /*
    * 新增函数
    */

    public function goods_list($shop_id,$page){
        $Model = new Model();
        $map =array('shop_id' => $shop_id,'audit'=>1,'closed'=>0,'end_date'=> array('egt', TODAY));
        $items = $Model->table('bao_goods')
            ->field("*")
            ->where($map)
            ->order(array('goods_id' => 'desc'))
            ->page("{$page},10")
            ->select();
        return $items;
    }
}