<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 16/11/3
 * Time: 上午11:15
 */
class ApiPshopAction extends CommonAction{
    public function shopdetail($sid=null,$puid=0,$fid=null){
        try{


            $fd_id = $fid ? $fid : $this->_post('fd_id');
            if (!$fd_info = D('Shopfd')->find($fd_id)) {
                $rs = array(
                    'success' => false,
                    'error_msg'=>'没有该商家!'
                );
                die(json_encode($rs));
            }
            if ($fd_info['closed']) {
                $rs = array(
                    'success' => false,
                    'error_msg'=>'该分店已经被删除!'
                );
                die(json_encode($rs));
            }
            $shop_id = $fd_info['shop_id'];
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

            $area = D('Narea');
            $info = $area->where('code = '.$fd_info['area_code'])->find();
            if($info){
                $area_name = $info['name'];
            }else{
                $area_name = '';
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
            if($puid > 0){
                if($openid=$this->_post('openid')){
                    $Userparent = D('Userparent');
                    $parent = array();
                    //$appid = $this -> _CONFIG['weixin']["appid"];
                    //$appsecret = $this -> _CONFIG['weixin']["appsecret"];
                    $appid = C('zs_wx_appid');
                    $appsecret = C('zs_wx_appsecret');
                    $rs = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}");
                    $rs = json_decode($rs,true);
                    $access_token = $rs['access_token'];
                    $rs = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN");
                    $rs = json_decode($rs,true);
                    if($rs['subscribe'] != 1){
                        $img_url = $this->get_or_create_ticket($puid,$shop_id);
                        //die($img_url);
                        $rs = array(
                            'success' => false,
                            'error_msg'=>'需要关注公众号!',
                            'img_url'=>$img_url
                        );
                        die(json_encode($rs));

                    }
                    $user_info = D('Users')->find($this->app_uid);
                    if($user_info){//在登陆的状态
                        //$uid = D('Connect')->where(array('mobile'=>$user_info['mobile']))->find();
                        if($user_info['user_id'] != $puid) {//不是自己分享给自己的
                            $rs = $Userparent->where(array('mobile' => $user_info['account']))->find();
                            if ($rs) {
                                $parent_old = json_decode($rs['parent']);
                                foreach ($parent_old as $k => $v) {
                                    $parent[$k] = $v;
                                }
                                if (!isset($parent[$shop_id])) {
                                    $parent[$shop_id] = $puid;
                                }else{
                                    if($parent[$shop_id]==$user_info['user_id']){
                                        $parent[$shop_id] = $puid;
                                    }
                                }
                                $parent = json_encode($parent);
                                $Userparent->where(array('mobile' => $user_info['account']))->save(array('parent' => $parent));
                            } else {
                                $rs1 = $Userparent->where(array('openid'=>$openid))->find();
                                if($rs1){
                                    if($rs1['mobile']){
                                        $parent[$shop_id] = $puid;
                                        $parent = json_encode($parent);
                                        $data = array(
                                            'mobile' => $user_info['account'],
                                            'parent'=>$parent
                                        );
                                        $Userparent->add($data);
                                    }else{
                                        $parent_old = json_decode($rs1['parent']);
                                        foreach ($parent_old as $k=>$v){
                                            $parent[$k] = $v;
                                        }
                                        if(!isset($parent[$shop_id])){
                                            $parent[$shop_id] = $puid;
                                        }else{
                                            if($parent[$shop_id]==$user_info['user_id']){
                                                $parent[$shop_id] = $puid;
                                            }
                                        }
                                        $parent = json_encode($parent);
                                        $Userparent->where(array('openid'=>$openid))->save(array('parent'=>$parent,'mobile'=>$user_info['account']));
                                    }

                                }else{
                                    $parent[$shop_id] = $puid;
                                    $parent = json_encode($parent);
                                    $data = array(
                                        'mobile' => $user_info['account'],
                                        'openid'=>$openid,
                                        'parent'=>$parent
                                    );
                                    $Userparent->add($data);
                                }
                                /*$dataall['mobile'] = $user_info['mobile'];
                                $dataall['parent'] = $parent;*/
                            }
                            /*$open = fopen('/var/wx.txt', "a");
                            fwrite($open, var_export($dataall, true));
                            fclose($open);*/
                        }
                    }else{//在非登陆的状态
                        $uids = D('Connect')->where(array('open_id'=>$openid))->select();
                        foreach($uids as $uid){
                            if($uid['uid'] != $puid){//不是自己分享给自己的
                                //$rs = $Userparent->where(array('openid'=>$openid))->find();
                                $con_user_info = D('Users')->find($uid['uid']);
                                $rs = $Userparent->where(array('mobile'=>$con_user_info?$con_user_info['account']:'-1'))->find();
                                if($rs){
                                    $parent_old = json_decode($rs['parent']);
                                    foreach ($parent_old as $k=>$v){
                                        $parent[$k] = $v;
                                    }
                                    if(!isset($parent[$shop_id])){
                                        $parent[$shop_id] = $puid;
                                    }else{
                                        if($parent[$shop_id]==$user_info['user_id']){
                                            $parent[$shop_id] = $puid;
                                        }
                                    }
                                    $parent = json_encode($parent);
                                    $Userparent->where(array('mobile'=>$rs['mobile']))->save(array('parent'=>$parent));
                                }else{
                                    $parent[$shop_id] = $puid;
                                    $parent = json_encode($parent);
                                    $data = array(
                                        'openid'=>$openid,
                                        'parent'=>$parent,
                                        'mobile'=>$con_user_info?$con_user_info['account']:null
                                    );
                                    $Userparent->add($data);
                                }
                               /* $open=fopen('/var/wx.txt',"a" );
                                fwrite($open,var_export($dataall,true));
                                fclose($open);*/
                            }
                        }
                    }


                }else{

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
            $detail['fd_name']=$fd_info['fd_name'];
            $detail['fd_id']=$fd_info['fd_id'];
            $detail['tel']=$fd_info['tel'];
            $detail['addr']=$fd_info['addr'];
            $detail['logo']=$fd_info['logo'];
            $detail['photo']=$fd_info['photo'];
            $detail['contact']=$fd_info['contact'];
            $ex=array();
            $ex['details']=$fd_info['detail'];
            $ex['business_time']=$fd_info['business_time'];
            $rs = array(
                'success' => true,
                'totalnum'=>$count,
                'detail'=>$detail,
                'shop_audit'=> D('Audit')->where('shop_id =' . ($shop_id))->find(),
                'ex' => $ex,
                'area_name'=>$area_name,
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

    private function get_or_create_ticket($uid = '',$shop_id = '', $action_name = 'QR_LIMIT_STR_SCENE') {
//        $access_token = $this->get_access_token();

        //$appid = $this -> _CONFIG['weixin']["appid"];
        //$appsecret = $this -> _CONFIG['weixin']["appsecret"];
        $appid = C('zs_wx_appid');
        $appsecret = C('zs_wx_appsecret');
        import("@/Net.Jssdk");
        $jssdk = new JSSDK("$appid", "$appsecret");
        $access_token = $jssdk->getAccessToken();


        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $access_token;
        @$post_data->expire_seconds = 2592000;
        @$post_data->action_name = $action_name;
        @$post_data->action_info->scene->scene_str = $uid.'/'.$shop_id;
        $ticket_data = json_decode($this->post($url, $post_data));
        $ticket = $ticket_data->ticket;
        $img_url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".urlencode($ticket);
        return $img_url;
    }

    private function post($url, $post_data, $timeout = 300){
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type:application/json;encoding=utf-8',
                'content' => urldecode(json_encode($post_data)),
                'timeout' => $timeout
            )
        );
        $context = stream_context_create($options);
        return file_get_contents($url, false, $context);
    }

    public function shopDianPing(){
        try{
           // $orderby = (int)($this->_post('orderby'))?(int)($this->_post('orderby')):1;
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
            /*$Shopdianping = D('Shopdianping');
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
            die(json_encode($rs));*/
            $Goodsdianping = D('Goodsdianping');
            // 导入分页类
            $map = array('closed' => 0, 'a.shop_id' => $shop_id, 'show_date' => array('ELT', TODAY),'a.score'=> 5);
            $map_count = array('a.closed' => 0, 'a.shop_id' => $shop_id, 'a.show_date' => array('ELT', TODAY),'a.score'=> 5);
            $count = $Goodsdianping->where($map)->count();
            $count_pics = $Goodsdianping->field('count(DISTINCT a.order_id) total')->alias('a')
                ->join('INNER JOIN bao_goods_dianping_pics b on a.order_id = b.order_id')
                ->where($map_count)
                ->find();
            $maxpage =ceil($count/5);
            $page = $this->_param('page', 'htmlspecialchars')?$this->_param('page', 'htmlspecialchars'):1;
            $list = $Goodsdianping->alias('a')->group('a.order_id')->field('a.*,FROM_UNIXTIME(a.create_time) AS cdate')
                ->join('INNER JOIN bao_goods_dianping_pics b on a.order_id = b.order_id')
                ->where($map_count)
                ->page($page.',5')
                ->select();
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
                    if(file_exists(BASE_PATH.'/attachs/'.$v['pic'])){
                        //$img_list[]=array('path'=>'statics/images/carousel1.jpg');
                        $list[$k]['pic'][]=$v['pic'];
                    }
                }
            }
            $rs = array(
                'success' => true,
                //'totalnum'=> $count,
                'totalnum_haspic'=>$count_pics['total'],
                'list'=>$list,
                'maxpage'=> $maxpage,
                'page'=>$page,
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
        //die(var_dump($Goodsdianping->getLastSql()));
        $maxpage =ceil($count/5);
        $page = $this->_param('page', 'htmlspecialchars')?$this->_param('page', 'htmlspecialchars'):1;
        switch($orderby){
            case 1:
                $list = $Goodsdianping->field('*,FROM_UNIXTIME(create_time) AS cdate')->where($map)->order(array('score' => 'desc'))->page($page.',5')->select();
                break;
            case 2:
                $list = $Goodsdianping->field('*,FROM_UNIXTIME(create_time) AS cdate')->where($map)->order(array('create_time' => 'desc'))->page($page.',5')->select();
                break;
            case 3:
                $list = $Goodsdianping->alias('a')->group('a.order_id')->field('a.*,FROM_UNIXTIME(a.create_time) AS cdate')
                    ->join('INNER JOIN bao_goods_dianping_pics b on a.order_id = b.order_id')
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
                if(file_exists(BASE_PATH.'/attachs/'.$v['pic'])){
                    //$img_list[]=array('path'=>'statics/images/carousel1.jpg');
                    $list[$k]['pic'][]=$v['pic'];
                }
            }
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