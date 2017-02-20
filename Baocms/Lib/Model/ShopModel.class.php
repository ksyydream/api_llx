<?php



class ShopModel extends CommonModel {

    protected $pk = 'shop_id';
    protected $tableName = 'shop';

    protected $cate_ids =array();
    public function get_tj($city_id, $keyword) {
        $map = array('is_ding' => 1, 'audit' => 1, 'closed' => 0, 'city_id' => $city_id, 'shop_name' => array('LIKE', '%' . $keyword . '%'));
        $shop = $this->where($map)->order(array('orderby' => 'asc', 'score' => 'desc', 'view' => 'desc'))->limit(0, 8)->select();
        $shop_ids = $cate_ids = $arr = array();
        foreach ($shop as $val) {
            $shop_ids[] = $val['shop_id'];
            $cate_ids[] = $val['cate_id'];
        }
        if ($shop_ids) {
            $obj = D('Shopdetails');
            $setting = D('Shopdingsetting');
            $arr['details'] = $obj->itemsByIds($shop_ids);
            $arr['set'] = $setting->itemsByIds($shop_ids);
        }
        if ($cate_ids) {
            $cate = D('Shopcate');
            $arr['cat'] = $cate->itemsByIds($cate_ids);
        }
        $arr['shop'] = $shop;
        return $arr;
    }

    public function countDingShop($where) {

        $sql = "select  s.*,d.price from  " . $this->tablePrefix . $this->tableName . " s join " . $this->tablePrefix . 'shop_details' . " d  ON (s.shop_id = d.shop_id)" . " where " . $where;
        $count = count($this->query($sql));
        return $count;
    }

    public function get_ding_shop($where, $order, $start, $limit) {
        $arr = $shop_ids = $cate_ids = $tem = array();
        $sql = "select  s.*,d.price from  " . $this->tablePrefix . $this->tableName . " s join " . $this->tablePrefix . 'shop_details' . " d  ON (s.shop_id = d.shop_id)" . " where " . $where . ' ORDER BY ' . $order . ' limit ' . $start . ',' . $limit;
        $shop = $this->query($sql);
        foreach ($shop as $val) {
            $shop_ids[] = $val['shop_id'];
            $cate_ids[] = $val['cate_id'];
        }
        if ($shop_ids) {
            $setting = D('Shopdingsetting');
            $tem['set'] = $setting->itemsByIds($shop_ids);
        }
        if ($cate_ids) {
            $cate = D('Shopcate');
            $tem['cat'] = $cate->itemsByIds($cate_ids);
        }
        $tem['shop'] = $shop;
        return $tem;
    }

    public function getshop($order, $city_id) {
        $shop = $this->where('is_ding = 1 and city_id=  ' . $city_id)->order(array($order => 'desc'))->limit(0, 6)->select();
        $shop_ids = $cate_ids = $get_shop = array();
        foreach ($shop as $val) {
            $shop_ids[] = $val['shop_id'];
            $cate_ids[] = $val['cate_id'];
        }
        if ($shop_ids) {
            $obj = D('Shopdetails');
            $setting = D('Shopdingsetting');
            $get_shop['details'] = $obj->itemsByIds($shop_ids);
            $get_shop['set'] = $setting->itemsByIds($shop_ids);
        }
        if ($cate_ids) {
            $cate = D('Shopcate');
            $get_shop['cat'] = $cate->itemsByIds($cate_ids);
        }
        $get_shop['shop'] = $shop;
        return $get_shop;
    }

    public function getbuyshopID($shop_id) {
        $shop = $this->where('is_ding = 1 and shop_id=' . $shop_id)->find();

        $obj = D('Shopdetails');
        $setting = D('Shopdingsetting');
        $get_shop['details'] = $obj->where('shop_id=' . $shop_id)->find();
        $get_shop['set'] = $setting->where('shop_id=' . $shop_id)->find();
        $cate = D('Shopcate');
        $get_shop['cat'] = $cate->where('cate_id=' . $shop['cate_id'])->find();
        $get_shop['shop'] = $shop;

        return $get_shop;
    }

    public function getphoto($shop_id, $photo) {
        $obj = D('Shoppic');
        $pic = $obj->field('photo')->where('shop_id=' . $shop_id)->limit(0, 2)->select();
        $photos = array();
        $photos[] = $photo;
        foreach ($pic as $k => $v) {
            $photos[] = $v["photo"];
        }
        return $photos;
    }

    public function gettuan($shop_id) {
        $obj = D('Tuan');
        $tuan = $obj->where('audit=1 and closed=0 and shop_id=' . $shop_id)->order(array('create_time' => 'desc'))->find();
        return $tuan;
    }

    public function getcoupon($shop_id) {
        $obj = D('Coupon');
        $coupon = $obj->where('audit=1 and closed=0 and shop_id=' . $shop_id)->order(array('create_time' => 'desc'))->find();
        return $coupon;
    }

    public function getShopIdsByTuiId($tui_uid) {
        $tui_uid = (int) $tui_uid;
        $datas = $this->where(array('tui_uid' => $tui_uid))->select();

        $return = array();
        foreach ($datas as $v) {
            $return[$v['shop_id']] = $v['shop_id'];
        }
        return $return;
    }

    public function CallDataForMat($items) { //专门针对CALLDATA 标签处理的
        if (empty($items))
            return array();
        $obj = D('Shopdetails');
        $sd_ids = array();
        foreach ($items as $k => $val) {
            $sd_ids[$val['shop_id']] = $val['shop_id'];
        }
        $shopdetail = $obj->itemsByIds($sd_ids);
        foreach ($items as $k => $val) {
            $val['shopdetail'] = $shopdetail[$val['shop_id']];
            $items[$k] = $val;
        }
        return $items;
    }

    /** 新增加函数 */
    public function getshopsAPP($city_id,$cate_id,$area_id,$page,$lng,$lat,$order){
        $map = array('bao_shop.closed'=>0,'bao_shop.audit'=>1);
        $map['bao_shop.city_id'] = $city_id;
        if($area_id != 0){
            //$map['bao_shop.area_id'] = $area_id;
        }
        if($cate_id != 0){
            //$map['bao_shop.cate_id'] = $cate_id;
        }


        $this->field("bao_shop.shop_id,
        bao_shop.shop_name,
        bao_shop.logo,
        bao_shop.photo,
        bao_shop.tel,
        bao_shop.addr,
        bao_shop.yhk1,
        ROUND(lat_lng_distance({$lat}, {$lng}, bao_shop.lat, bao_shop.lng), 2) AS juli,
        IFNULL(sum(bao_goods.sold_num),0) AS allsold_num")
            ->where($map)
            ->where('lat is not null and lng is not null')
            ->join('left join bao_goods on bao_goods.shop_id = bao_shop.shop_id')
            ->group('bao_shop.shop_id')
            ->page("{$page},10");
        if($order == 2){
            $this->order('allsold_num desc');
        }else{
            $this->order('juli asc');
        }
        $data=$this->select();
        return $data;
        //return $this->getLastSql();
    }

    public function getshopsAPP2($area_code,$page,$lng=0,$lat=0,$order,$shop_name = ''){
        $cate_id = $_POST['cate_id']?$_POST['cate_id']:0;
        $map = array('bao_shop.closed'=>0,'bao_shop.audit'=>1);
        if($cate_id!=0){
            $this->cate_ids[] = $cate_id;
            $this->get_all_cateid($cate_id);
            $map['bao_shop.cate_id']=array('in',implode(',',$this->cate_ids));
        }
       // die(var_dump($map['bao_shop.cate_id']));
       // $map['bao_shop.area_code'] = $area_code;
        $map['bao_shop.shop_name'] = array('like',"%{$shop_name}%");
        $this->field("bao_shop.shop_id,
        bao_shop.shop_name,
        bao_shop.logo,
        bao_shop.photo,
        bao_shop.tel,
        bao_shop.addr,
        bao_shop.yhk1,
        bao_shop.yhk2,
        bao_shop.score,
        bao_shop.shop_class,
        ROUND(lat_lng_distance('{$lat}', '{$lng}', bao_shop.lat, bao_shop.lng), 2) AS juli,
        IFNULL(sum(bao_goods.sold_num),0) AS allsold_num")
            ->where($map)
            ->where('lat is not null and lng is not null')
            ->join('bao_goods on bao_goods.shop_id = bao_shop.shop_id','LEFT')
            ->group('bao_shop.shop_id')
            ->page("{$page},10");
        switch($order){
            case 1:
                $this->order('juli asc');
                break;
            case 2:
                $this->order('allsold_num desc');
                break;
            case 3:
                $this->order('score desc');
                break;
            default:
                $this->order('juli asc');
                break;
        }
        $data=$this->select();
        /*var_dump($this->getLastSql());*/
        return $data;
        //return $this->getLastSql();
    }

    private function get_all_cateid($cate_id){
        //$this->cate_ids[]=$cate_id;
        $Shopcate = D('Shopcate');
        $list = $Shopcate
            ->field('cate_id,cate_name,parent_id,orderby,is_hot')
            ->where(array('parent_id'=>$cate_id))->select();
        foreach($list as $val){
            $this->cate_ids[] = $val['cate_id'];
            $this->get_all_cateid($val['cate_id']);
        }
        return true;
    }
}
