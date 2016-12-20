<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 16/11/3
 * Time: 上午11:15
 */
class ApiPshopAction extends CommonAction{
    public function shopdetail(){
        try{
            $shop_id = trim($this->_param('shop_id'))?trim($this->_param('shop_id')):0;
            if (!$detail = D('Shop')->find($shop_id)) {
                $rs = array(
                    'success' => false,
                    'error_msg'=>'没有该商家!'
                );
                die(json_encode($rs));
            }
            if ($detail['closed']) {
                $rs = array(
                    'success' => false,
                    'error_msg'=>'该商家已经被删除!'
                );
                die(json_encode($rs));
            }
            $Shopdianping = D('Shopdianping');
            $map = array('closed' => 0, 'shop_id' => $shop_id, 'show_date' => array('ELT', TODAY));
            $count = $Shopdianping->where($map)->count(); // 查询满足要求的总记录数
            $ex = D('Shopdetails')->find($shop_id);
            $favnum = D('Shopfavorites')->where(array('shop_id'=>$shop_id))->count();
            D('Shop')->updateCount($shop_id, 'view');
            if ($this->token != -1) {
                D('Userslook')->look($this->app_uid, $shop_id);
            }
           /*
            //招聘
            $work = D('work')->order('work_id desc ')->where(array('shop_id' => $shop_id, 'audit' => 1,'city_id'=>$this->city_id, 'closed' => 0, 'expire_date' => array('EGT', TODAY)))->select();
            //微店
            $weidian = D('WeidianDetails')->where(array('audit' => 1,'city_id'=>$this->city_id, 'closed' => 0, ))->order('id desc')->limit(0, 1)->select();
            //商品
            $goods = D('Goods')->where(array('shop_id' => $shop_id, 'audit' => 1,'city_id'=>$this->city_id, 'closed' => 0, 'end_date' => array('EGT', TODAY)))->order('goods_id desc')->select();
            //优惠
            $coupon = D('Coupon')->order('coupon_id desc ')->where(array('shop_id' => $shop_id, 'audit' => 1,'city_id'=>$this->city_id, 'closed' => 0, 'expire_date' => array('EGT', TODAY)))->select();
            //活动
            $huodong = D('Activity')->order('activity_id desc ')->where(array('shop_id' => $shop_id,'city_id'=>$this->city_id, 'audit' => 1, 'closed' => 0, 'end_date' => array('EGT', TODAY), 'bg_date' => array('ELT', TODAY)))->select();
            //外卖
            $ele_menu = D('ele_product')->order('product_id desc ')->where(array('shop_id' => $shop_id,'city_id'=>$this->city_id))->select();
            //菜单
            $ding_menu = D('shop_ding_menu')->order('menu_id desc ')->where(array('shop_id' => $shop_id,'city_id'=>$this->city_id))->select();



            $Weidian = D('Weidian_details');
            $weidianid=$Weidian->where('shop_id='.$shop_id.' ')->find();
            $weidian_id = $weidianid['id'];

            $this->assign('pic',$pic = D('Shoppic')->where(array('shop_id' => $shop_id))->order(array('pic_id' => 'desc'))->count());
            $shopyouhui = D('Shopyouhui')->where(array('shop_id'=>$shop_id,'is_open'=>1))->find();*/

            $rs = array(
                'success' => true,
                'totalnum'=>$count,
                'detail'=>$detail,
                'ex' => $ex,
                'favnum'=>$favnum,
                'error_msg'=>''
            );
            die(json_encode($rs));
        }catch(Exception $e) {
            $rs = array(
                'success' => false,
                'error_msg'=>'获取数据失败!'
            );
            die(json_encode($rs));
        }

    }

    public function shopDianPing(){
        try{
            $shop_id = (int)$this->_param('shop_id');
            $page = trim($this->_param('page')) ? trim($this->_param('page')) : 1;
            if (!$detail = D('Shop')->find($shop_id)) {
                $rs = array(
                    'success' => false,
                    'error_msg'=>'商铺不存在!'
                );
                die(json_encode($rs));
            }
            if ($detail['closed']) {
                $rs = array(
                    'success' => false,
                    'error_msg'=>'商铺不存在!'
                );
                die(json_encode($rs));
            }
            $Shopdianping = D('Shopdianping');
            $list = $Shopdianping->dianpingByshopid($shop_id,$page);
            $dianping_ids = array();
            foreach ($list as $k => $val) {
                $dianping_ids[$val['dianping_id']] = $val['dianping_id'];
            }
            if (!empty($dianping_ids)) {
                $pics = D('Shopdianpingpics')->where(array('dianping_id' => array('IN', $dianping_ids)))->select();
            }
            $rs = array(
                'success' => true,
                'error_msg'=>'',
                'list'=>$list,
                'pics'=>$pics
            );
            die(json_encode($rs));
        }catch(Exception $e) {
            $rs = array(
                'success' => false,
                'error_msg'=>'获取数据失败!'
            );
            die(json_encode($rs));
        }

    }

    public function goodsdetail(){
        try{
            $goods_id = trim($this->_param('goods_id'))?trim($this->_param('goods_id')):0;
            $goods_id = (int)$goods_id;
            if (empty($goods_id)) {
                $rs = array(
                    'success' => false,
                    'error_msg'=>'商品不存在!'
                );
                die(json_encode($rs));
            }
            if (!($detail = D('Goods')->find($goods_id))) {
                $rs = array(
                    'success' => false,
                    'error_msg'=>'商品不存在!'
                );
                die(json_encode($rs));
            }
            if ($detail['closed'] != 0 || $detail['audit'] != 1) {
                $rs = array(
                    'success' => false,
                    'error_msg'=>'商品不存在!'
                );
                die(json_encode($rs));
            }
            $shop_id = $detail['shop_id'];

            $recom = D('Goods')->where(array('shop_id' => $shop_id,'audit'=>1,'closed'=>0,'goods_id' => array('neq', $goods_id),'end_date'=> array('egt', TODAY)))->select();
            $record = D('Usersgoods');
            if ($this->token != -1) {
                $insert = $record->getRecord($this->app_uid, $goods_id);
            }
            $json_shop = D('Shop')->find($shop_id);

            $json_pingnum = D('Goodsdianping')->where(array('goods_id' => $goods_id, 'show_date' => array('ELT', TODAY)))->count();

            $score = (int) D('Goodsdianping')->where(array('goods_id' => $goods_id))->avg('score');
            if ($score == 0) {
                $score = 5;
            }
            if(($detail['is_vs1'] || $detail['is_vs2'] || $detail['is_vs3'] || $detail['is_vs4'] || $detail['is_vs5'] || $detail['is_vs6']) ==1 ){
                $this->assign('is_vs', $is_vs = 1);
            }else{
                $this->assign('is_vs', $is_vs = 0);
            }
            $json_pics = D('Goodsphoto')->getPics($detail['goods_id']);
            $rs = array(
                'success' => true,
                'error_msg'=>'',
                'recom'=> $recom,
                'detail'=>$detail,
                //'shop'=>$json_shop,
                'pingnum'=>$json_pingnum,
                'score'=>$score,
                'is_vs'=>$is_vs,
                'pics'=>$json_pics,
                'instructions'=>strip_tags($detail['instructions'])
            );
            die(json_encode($rs));
        }catch(Exception $e) {
            $rs = array(
                'success' => false,
                'error_msg'=>'获取数据失败!'
            );
            die(json_encode($rs));
        }

    }

    public function goods_list(){
        $shop_id = trim($this->_param('shop_id'))?trim($this->_param('shop_id')):0;
        $shop_id = (int)$shop_id;
        if (empty($shop_id)) {
            $rs = array(
                'success' => false,
                'error_msg'=>'商铺不存在!'
            );
            die(json_encode($rs));
        }
        $page = trim($this->_param('page')) ? trim($this->_param('page')) : 1;
        $recom = D('Goods')->goods_list($shop_id,$page);
        $rs = array(
            'success' => true,
            'error_msg'=>'',
            'goods_list'=> $recom
        );
        die(json_encode($rs));
    }
}