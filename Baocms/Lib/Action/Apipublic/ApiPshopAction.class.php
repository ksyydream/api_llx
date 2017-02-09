<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 16/11/3
 * Time: 上午11:15
 */
class ApiPshopAction extends CommonAction{
    public function shopdetail($sid=null){
        try{

            $shop_id = $sid ? $sid : $this->_post('shop_id');
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
            if($_GET['uid']){
                if(IS_WEIXIN){
                    if(!$_COOKIE['openid']){
                        $this->access_openid('',false,$_GET['uid']);
                    }

                    $openid = $_COOKIE['openid'];
                    $Userparent = D('Userparent');
                    $parent = array();
                    $appid = $this -> _CONFIG['weixin']["appid"];
                    $appsecret = $this -> _CONFIG['weixin']["appsecret"];

                    $rs = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}");
                    $rs = json_decode($rs,true);
                    $access_token = $rs['access_token'];
                    $rs = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN");
                    $rs = json_decode($rs,true);
                    if($rs['subscribe'] != 1){
                        redirect(U('/weixin/index/get_or_create_ticket', array('uid' => $_GET['uid'],'shop_id'=>$shop_id)));
                        exit();
                    }

                    $uid = D('Connect')->where(array('open_id'=>$openid))->find();

                    if($uid['uid'] != $_GET['uid']){//不是自己分享给自己的
                        $rs = $Userparent->where(array('openid'=>$openid))->find();
                        if($rs){
                            $parent_old = json_decode($rs['parent']);
                            foreach ($parent_old as $k=>$v){
                                $parent[$k] = $v;
                            }
                            if(!isset($parent[$shop_id])){
                                $parent[$shop_id] = $_GET['uid'];
                            }
                            $parent = json_encode($parent);
                            $Userparent->where(array('openid'=>$openid))->save(array('parent'=>$parent));
                        }else{
                            $parent[$shop_id] = $_GET['uid'];
                            $parent = json_encode($parent);
                            $data = array(
                                'openid'=>$openid,
                                'parent'=>$parent
                            );
                            $Userparent->add($data);
                        }
                    }
                }
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
            $orderby = (int)($this->_post('orderby'))?(int)($this->_post('orderby')):1;
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
            $map = array('a.closed' => 0, 'a.shop_id' => $shop_id, 'a.show_date' => array('ELT', TODAY));
            $count = $Shopdianping->alias('a')->field("*")->join('left join bao_users b on a.user_id = b.user_id')->where($map)->count();
            $count_pics = $Shopdianping->alias('a')->field('count(DISTINCT a.order_id) total')
                ->join('LEFT JOIN bao_users b on a.user_id = b.user_id')
                ->join('INNER JOIN bao_shop_dianping_pics c on a.order_id = c.order_id')
                ->where($map)
                ->find();
            //die(var_dump($Shopdianping->getLastSql()));
            switch($orderby){
                case 3:
                    $list = $Shopdianping->dianpingByshopid_haspic($shop_id,$page);
                    break;
                default:
                    $list = $Shopdianping->dianpingByshopid($shop_id,$page,$orderby);
                    break;
            }
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
                'totalnum'=> $count,
                'totalnum_haspic'=>$count_pics['total'],
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

    public function goodsdianping()
    {
        $orderby = (int)($this->_post('orderby'))?(int)($this->_post('orderby')):1;
        $goods_id = trim($this->_param('goods_id'))?trim($this->_param('goods_id')):0;
        $goods_id = (int)$goods_id;
        if (!($detail = D('Goods')->find($goods_id))) {
            $rs = array(
                'success' => false,
                'error_msg'=>'没有此商品'
            );
            die(json_encode($rs));
        }
        if ($detail['closed']) {
            $rs = array(
                'success' => false,
                'error_msg'=>'商品已关闭'
            );
            die(json_encode($rs));
        }
        $Goodsdianping = D('Goodsdianping');
        // 导入分页类
        $map = array('closed' => 0, 'goods_id' => $goods_id, 'show_date' => array('ELT', TODAY));
        $map_count = array('a.closed' => 0, 'a.goods_id' => $goods_id, 'a.show_date' => array('ELT', TODAY));
        $count = $Goodsdianping->where($map)->count();
        $count_pics = $Goodsdianping->field('count(DISTINCT a.order_id) total')->alias('a')
            ->join('INNER JOIN bao_goods_dianping_pics b on a.order_id = b.order_id')
            ->where($map_count)
            ->find();
        die(var_dump($Goodsdianping->getLastSql()));
        $maxpage =ceil($count/5);
        $page = $this->_param('page', 'htmlspecialchars')?$this->_param('page', 'htmlspecialchars'):1;
        switch($orderby){
            case 1:
                $list = $Goodsdianping->where($map)->order(array('score' => 'desc'))->page($page.',5')->select();
                break;
            case 2:
                $list = $Goodsdianping->where($map)->order(array('create_time' => 'desc'))->page($page.',5')->select();
                break;
            case 3:
                $list = $Goodsdianping->alias('a')->group('a.order_id')->field('a.*,b.pic_id yy_id')
                    ->join('bao_goods_dianping_pics b on a.order_id = b.order_id','INNER')
                    ->where($map_count)
                    ->page($page.',5')
                    ->select();
                break;
            default:
                $list = $Goodsdianping->where($map)->order(array('score' => 'desc'))->page($page.',5')->select();
                break;
        }
        $user_ids = $orders_ids = array();
        foreach ($list as $k => $val) {
            $user_ids[$val['user_id']] = $val['user_id'];
            $users= D('Users')->itemsByIds($user_ids);
            $list[$k]['username']=$users[$val['user_id']]['nickname'];
            $list[$k]['rank_id']=$users[$val['user_id']]['rank_id'];
            $list[$k]['face']=$users[$val['user_id']]['face'];
            $pic=D('Goodsdianpingpics')->where(array('order_id' => $val['order_id']))->select();
            $list[$k]['pic']=array();
            foreach ($pic as $a => $v){
            $list[$k]['pic'][]=$v['pic'];}
        }
        $rs = array(
            'success' => true,
            'totalnum'=> $count,
            'totalnum_haspic'=>$count_pics['total'],
            'list'=>$list,
            'maxpage'=> $maxpage,
            'page'=>$page,
            'error_msg'=>''
        );
        die(json_encode($rs));
    }



    public function hot_goods(){
        $shop_id = trim($this->_param('shop_id'))?trim($this->_param('shop_id')):0;
        $shop_id = (int)$shop_id;
        if (empty($shop_id)) {
            $rs = array(
                'success' => false,
                'error_msg'=>'商铺不存在!'
            );
            die(json_encode($rs));
        }
        $recom = D('Goods')->where(array('shop_id' => $shop_id,'audit'=>1,'closed'=>0,'end_date'=> array('egt', TODAY)))
            ->order('sold_num desc')
            ->limit(2)
            ->select();
        $rs = array(
            'success' => true,
            'error_msg'=>'',
            'goods_list'=> $recom
        );
        die(json_encode($rs));
    }
}