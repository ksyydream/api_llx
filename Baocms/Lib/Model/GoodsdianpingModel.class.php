<?php



class GoodsdianpingModel extends CommonModel{
    protected $pk   = 'order_id';
    protected $tableName =  'goods_dianping';
	
	 public function check($order_id, $user_id) {
        $data = $this->find(array('where' => array('order_id' => (int) $order_id, 'user_id' => (int) $user_id)));
        return $this->_format($data);
    }

    public function CallDataForMat($items) { //专门针对CALLDATA 标签处理的
        if (empty($items))
            return array();
        $obj = D('Users');
        $user_ids = array();
        foreach ($items as $k => $val) {
            $user_ids[$val['user_id']] = $val['user_id'];
        }
        $users = $obj->itemsByIds($user_ids);
        foreach ($items as $k => $val) {
            $val['user'] = $users[$val['user_id']];
            $items[$k] = $val;
        }
        return $items;
    }

    //新增函数,获取附近的消费点评,需要好评
    public function get_xf_list($page,$lat,$lng){
        $map = array(
            'a.cdate'=>array('GT',date('Y-m-d', strtotime('-15 days')))
        );
        $list = $this->field("
a.create_time,
a.contents,
a.user_id,
a.shop_id,
c.fd_name,
c.fd_id,
FROM_UNIXTIME(a.create_time) AS cdate,
ROUND(lat_lng_distance('{$lat}', '{$lng}', c.lat, c.lng), 2) AS juli
")
            ->alias('a')
            ->join('bao_shop_fd c on c.shop_id = a.shop_id','INNER')
            ->where("a.closed=0 and c.lat is not null and c.lng is not null AND c.lat <>'' and c.lng <>''")
            ->where($map)
            ->group('a.order_id')
            ->order('juli asc')
            ->page("{$page},10")
            ->select();
        return $this->getLastSql();
        return $list;
    }
}