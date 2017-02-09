<?php



class ShopdianpingModel extends CommonModel {

    protected $pk = 'dianping_id';
    protected $tableName = 'shop_dianping';

    public function check($shop_id, $user_id) {
        $data = $this->find(array('where' => array('shop_id' => (int) $shop_id, 'user_id' => (int) $user_id)));
        return $this->_format($data);
    }
    
    public function updateScore($shop_id){
        $shop_id = (int)$shop_id;
        $rows = $this->query("select  sum(score) /count(1) as s,sum(d1)/count(1) as d1,
            sum(d2)/count(1) as d2 ,sum(d3)/count(1) as d3 from ".$this->getTableName()." where shop_id = {$shop_id} group by  shop_id");
        if(!empty($rows[0])){
            D('Shop')->save(array(
                'shop_id'=>$shop_id,
                'score' => (int)($rows[0]['s'] *10),
                 'd1' => (int)($rows[0]['d1'] *10),
                'd2' => (int)($rows[0]['d2'] *10),
                'd3' => (int)($rows[0]['d3'] *10),
            ));
        } 
        return true;
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

    /*
     * 新增函数
     */

    public function dianpingByshopid($shop_id,$page,$orderby = 1){
        $Model = new Model();
        $map = array('a.closed' => 0, 'a.shop_id' => $shop_id, 'a.show_date' => array('ELT', TODAY));
        $Model->table('bao_shop_dianping a')
            ->field("a.contents,
            a.score,
            a.dianping_id,
            a.reply,
            FROM_UNIXTIME(a.create_time) AS create_time,
            b.face user_face,
            b.nickname user_nickname
            ")
            ->join('left join bao_users b on a.user_id = b.user_id')
            ->where($map);
        if($orderby == 2){
            $Model->order(array('a.dianping_id' => 'desc'));
        }else{
            $Model->order(array('a.score' => 'desc'));
        }
        $items = $Model->page("{$page},5")->select();
        return $items;
    }

    public function dianpingByshopid_haspic($shop_id,$page){
        $Model = new Model();
        $map = array('a.closed' => 0, 'a.shop_id' => $shop_id, 'a.show_date' => array('ELT', TODAY));
        $items = $Model->table('bao_shop_dianping a')
            ->group('a.dianping_id')
            ->field("a.contents,
            a.score,
            a.dianping_id,
            a.reply,
            FROM_UNIXTIME(a.create_time) AS create_time,
            b.face user_face,
            b.nickname user_nickname
            ")
            ->join('left join bao_users b on a.user_id = b.user_id')
            ->join('inner join bao_shop_dianping_pics c on a.dianping_id = b.dianping_id')
            ->where($map)
            ->order(array('a.dianping_id' => 'asc'))
            ->page("{$page},5")
            ->select();
        return $items;
    }

}