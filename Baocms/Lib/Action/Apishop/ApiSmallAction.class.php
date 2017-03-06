<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 17/1/17
 * Time: 上午10:58
 */
class ApiSmallAction extends CommonAction{
    public function index() {
        /*$this->assign('homepage','商户中心首页');

        $this->assign('shop_branch',D('Shopbranch')->where(array('shop_id'=>$this->shop_id,'closed'=>0))->count());
        $this->assign('shop_branch_audit',D('Shopbranch')->where(array('shop_id'=>$this->shop_id,'closed'=>0,'audit'=>0))->count());*/

        $counts = array();
        $bg_time = strtotime(TODAY);
        //抢购
        $counts['tuan'] = (int) D('Tuan')->where(array('shop_id' => $this->shop_id,'closed' => 0))->count();//总抢购数量
        $counts['tuan_audit'] = (int) D('Tuan')->where(array('shop_id' => $this->shop_id,'closed' => 0,'status' => array('EGT', 0),'audit' => 0))->count();//待审核抢购
        $counts['tuan_order'] = (int) D('Tuanorder')->where(array('shop_id' => $this->shop_id))->count();//总抢购清单
        $counts['totay_tuan_order'] = (int) D('Tuanorder')->where(array('shop_id' => $this->shop_id,'create_time' => array(array('ELT', NOW_TIME),array('EGT', $bg_time),), 'status' => array('EGT', 0),))->count();//今日抢购订单
        $counts['tuan_order_code_is_used'] = (int) D('Tuancode')->where(array('shop_id' => $this->shop_id,'is_used' => 0))->count();//未验证
        $counts['tuan_order_code_is_used_ture'] = (int) D('Tuancode')->where(array('shop_id' => $this->shop_id,'is_used' => 1))->count();//已验证
        $counts['tuan_order_code_status'] = (int) D('Tuancode')->where(array('shop_id' => $this->shop_id,'status' => 1))->count();//抢购退款中

        //商城
        $counts['goods'] = (int) D('Goods')->where(array('shop_id' => $this->shop_id,'closed' => 0,))->count();//总商品
        $counts['goods_audit'] = (int) D('Goods')->where(array('shop_id' => $this->shop_id,'closed' => 0,'audit' => 0))->count();//待审核商品
        $counts['goods_order'] = (int) D('Order')->where(array('shop_id' => $this->shop_id,'closed' => 0))->count();//总商品清单
        $counts['totay_goods_order'] = (int) D('Order')->where(array('shop_id' => $this->shop_id,'closed' => 0,'create_time' => array(array('ELT', NOW_TIME),array('EGT', $bg_time),), 'status' => array('EGT', 0),))->count();//今日商品订单
        $counts['goods_order_one'] = (int) D('Order')->where(array('shop_id' => $this->shop_id,'closed' => 0,'status' => 1))->count();//1代表已经付
        $counts['goods_order_two'] = (int) D('Order')->where(array('shop_id' => $this->shop_id,'closed' => 0,'status' => 2))->count();//2代表正在配送
        $counts['goods_order_three'] = (int) D('Order')->where(array('shop_id' => $this->shop_id,'closed' => 0,'status' => 8))->count();//8代表已经完成

        //优惠劵
        $counts['coupon'] = (int) D('Coupon')->where(array('shop_id' => $this->shop_id,'closed' => 0,))->count();//总优惠劵
        $counts['coupon_audit'] = (int) D('Coupon')->where(array('shop_id' => $this->shop_id,'closed' => 0,'audit' => 0))->count();//待审核优惠劵
        $counts['coupon_download'] = (int) D('Coupondownload')->where(array('shop_id' => $this->shop_id))->count();//总下载优惠劵
        $counts['coupon_download_is_used'] = (int) D('Coupondownload')->where(array('shop_id' => $this->shop_id,'is_used' => 0))->count();//未验证优惠劵

        //外卖
        $counts['ele'] = (int) D('Ele')->where(array('shop_id' => $this->shop_id))->count();//总外卖个数
        $counts['ele_audit'] = (int) D('Ele')->where(array('shop_id' => $this->shop_id,'audit' => 0))->count();//待审核外卖
        $counts['ele_order'] = (int) D('Eleorder')->where(array('shop_id' => $this->shop_id,'closed' => 0))->count();//总外卖订单
        $counts['totay_ele_order'] = (int) D('Eleorder')->where(array('shop_id' => $this->shop_id,'closed' => 0,'create_time' => array(array('ELT', NOW_TIME),array('EGT', $bg_time),), 'status' => array('EGT', 0),))->count();//今日外卖订单
        $counts['ele_order_one'] = (int) D('Eleorder')->where(array('shop_id' => $this->shop_id,'closed' => 0,'status' => 1))->count();//1等待处理
        $counts['ele_order_two'] = (int) D('Eleorder')->where(array('shop_id' => $this->shop_id,'closed' => 0,'status' => 2))->count();// 2代表已经确认
        $counts['ele_order_eight'] = (int) D('Eleorder')->where(array('shop_id' => $this->shop_id,'closed' => 0,'status' => 8))->count();// 8代表配送完成


        //订座
        $counts['ding_room'] = (int) D('Shopdingroom')->where(array('shop_id' => $this->shop_id))->count();//订座包厢数量
        $counts['ding_order'] = (int) D('Shopdingorder')->where(array('shop_id' => $this->shop_id))->count();//总订座订单
        $counts['totay_ding_order'] = (int) D('Shopdingorder')->where(array('shop_id' => $this->shop_id,'create_time' => array(array('ELT', NOW_TIME),array('EGT', $bg_time),), 'status' => array('EGT', 0),))->count();//今日订座订单
        $counts['ding_order_one'] = (int) D('Shopdingyuyue')->where(array('shop_id' => $this->shop_id,'is_pay' => 1))->count();// 订座1代表已经付款购买
        $counts['ding_order_zero'] = (int) D('Shopdingyuyue')->where(array('shop_id' => $this->shop_id,'is_pay' => 0))->count();// 订座0未付款

        //黄页
        $counts['biz'] = (int) D('Biz')->where(array('shop_id' => $this->shop_id))->count();//总黄页数量
        $counts['biz_audit'] = (int) D('Biz')->where(array('shop_id' => $this->shop_id,'status' => -1))->count();// 等待审核黄页

        //粉丝
        $counts['favorites'] = (int) D('Shopfavorites')->where(array('shop_id' => $this->shop_id))->count();//总粉丝数量
        $counts['totay_favorites'] = (int) D('Shopfavorites')->where(array('shop_id' => $this->shop_id,'create_time' => array(array('ELT', NOW_TIME),array('EGT', $bg_time),), 'status' => array('EGT', 0),))->count();//今日新增粉丝数量

        //评价
        $counts['shop_dianping'] = (int) D('Shopdianping')->where(array('shop_id' => $this->shop_id,'closed' => 0))->count();//总商家点评
        $counts['totay_shop_dianping'] = (int) D('Shopdianping')->where(array('shop_id' => $this->shop_id,'closed' => 0,'create_time' => array(array('ELT', NOW_TIME),array('EGT', $bg_time),), 'status' => array('EGT', 0),))->count();//今日商家点评
        $counts['goods_dianping'] = (int) D('Goodsdianping')->where(array('shop_id' => $this->shop_id,'closed' => 0))->count();//总商城点评
        $counts['totay_goods_dianping'] = (int) D('Goodsdianping')->where(array('shop_id' => $this->shop_id,'closed' => 0,'create_time' => array(array('ELT', NOW_TIME),array('EGT', $bg_time),), 'status' => array('EGT', 0),))->count();//今日商城点评
        $counts['ele_dianping'] = (int) D('Eledianping')->where(array('shop_id' => $this->shop_id,'closed' => 0))->count();//总外卖点评
        $counts['totay_ele_dianping'] = (int) D('Eledianping')->where(array('shop_id' => $this->shop_id,'closed' => 0,'create_time' => array(array('ELT', NOW_TIME),array('EGT', $bg_time),), 'status' => array('EGT', 0),))->count();//今日外卖点评
        $counts['ding_dianping'] = (int) D('Shopdingdianping')->where(array('shop_id' => $this->shop_id,'closed' => 0))->count();//总订座点评
        $counts['totay_ding_dianping'] = (int) D('Shopdingdianping')->where(array('shop_id' => $this->shop_id,'closed' => 0,'create_time' => array(array('ELT', NOW_TIME),array('EGT', $bg_time),), 'status' => array('EGT', 0),))->count();//今日订座点评
        $counts['tuan_dianping'] = (int) D('Tuandianping')->where(array('shop_id' => $this->shop_id,'closed' => 0))->count();//总抢购点评
        $counts['totay_tuan_dianping'] = (int) D('Tuandianping')->where(array('shop_id' => $this->shop_id,'closed' => 0,'create_time' => array(array('ELT', NOW_TIME),array('EGT', $bg_time),), 'status' => array('EGT', 0),))->count();//今日抢购点评

        //分类信息
        $counts['life'] = (int) D('Life')->where(array('shop_id' => $this->shop_id,'closed' => 0))->count();//总分类信息
        $counts['life_audit'] = (int) D('Life')->where(array('shop_id' => $this->shop_id,'audit' => 0,'closed' => 0))->count();//待审核分类信息

        //商家招聘
        $counts['work'] = (int) D('Work')->where(array('shop_id' => $this->shop_id))->count();//总招聘
        $counts['work_audit'] = (int) D('Work')->where(array('shop_id' => $this->shop_id,'audit' => 0))->count();//待审核招聘

        //商家预约
        $counts['shopyuyue'] = (int) D('Shopyuyue')->where(array('shop_id' => $this->shop_id,))->count();//总商家预约数量
        $counts['shopyuyue_one'] = (int) D('Shopyuyue')->where(array('shop_id' => $this->shop_id,'used' => 1))->count();//已确认预约
        $counts['shopyuyue_eight'] = (int) D('Shopyuyue')->where(array('shop_id' => $this->shop_id,'used' => 0))->count();//未确认预约

        //文章
        $counts['news'] = (int) D('Article')->where(array('shop_id' => $this->shop_id,'closed' => 0))->count();//全部文章
        $counts['news_autit'] = (int) D('Article')->where(array('shop_id' => $this->shop_id,'closed' => 0,'audit' => 0))->count();//未审核文章

        //商家员工数量
        $counts['shopworker'] = (int) D('Shopworker')->where(array('shop_id' => $this->shop_id,'closed' => 0))->count();//总商家预约数量
        $shop_audit = D('Audit')->where('shop_id =' . ($this->shop_id))->find();
        if(!$shop_audit){
            $shop_audit=array(
                'name'=>'',
                'photo'=>'',
                'pic'=>'',
                'shop_id'=>$this->shop_id,
                'zhucehao'=>'',
                'addr'=>'',
                'end_date'=>'',
                'zuzhidaima'=>''
            );
        }
        $rs = array(
            'success'=>true,
            'shop_info'=>$this->shop,
            'user_info'=>$this->member,
            'shop_detail'=>D('Shopdetails')->find($this->shop_id),
            'shop_audit'=> $shop_audit,
            'shop_cate_name'=>'',
            'error_msg'=>''
        );
        if($this->shopcates){
            $rs['shop_cate_name'] = $this->shopcates['cate_name'];
        }
        $this->ajaxReturn($rs,'JSON');

    }

    public function save_about(){
        if(!$this->_post('addr','trim')){
            $rs=array(
                'success'=>false,
                'error_msg'=>'商铺地址不能为空'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        if(!$this->_post('contact','trim')){
            $rs=array(
                'success'=>false,
                'error_msg'=>'商铺联系人不能为空'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        if(!$this->_post('business_time','trim')){
            $rs=array(
                'success'=>false,
                'error_msg'=>'商铺营业时间不能为空'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        if(!$this->_post('tel','trim')){
            $rs=array(
                'success'=>false,
                'error_msg'=>'联系电话不能为空'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        $data = array(
            'addr'=>$this->_post('addr','trim,htmlspecialchars',''),
            'contact'=>$this->_post('contact','trim,htmlspecialchars',''),
            'business_time'=>$this->_post('business_time','trim,htmlspecialchars',''),
            'tel'=>$this->_post('tel','trim,htmlspecialchars',''),
            'shop_id'=>$this->shop_id,
        );
        $ex = array(
            'business_time'  => $data['business_time'],
        );
        unset($data['business_time']);
        if(D('Shop')->save($data)){
            D('Shopdetails')->upDetails($this->shop_id,$ex);
            $rs = array(
                'success'=>true,
                'error_msg'=>''
            );
            $this->ajaxReturn($rs,'JSON');
        }else{
            $rs=array(
                'success'=>false,
                'error_msg'=>'保存失败!'
            );
            $this->ajaxReturn($rs,'JSON');
        }

    }

    //图片列表
    public function photo(){
        $Shoppic = D('Shoppic');
        $map = array('shop_id' =>  $this->shop_id);
        $list = $Shoppic->field('*,DATE_FORMAT(FROM_UNIXTIME(create_time),\'%Y-%m-%d %H:%i:%s\') cdate')->where($map)->order(array('orderby'=>'desc'))->select();
        //die(var_dump($Shoppic->getLastSql()));
        $rs = array(
            'success'=>true,
            'shop_pics'=>$list,
            'error_msg'=>''
        );

        $this->ajaxReturn($rs,'JSON');
    }

    public function add_shop_pic(){
        if(!$this->_post('title','trim')){
            $rs=array(
                'success'=>false,
                'error_msg'=>'标题不能为空'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        if(!$this->_post('photo','trim')){
            $rs=array(
                'success'=>false,
                'error_msg'=>'图片地址不能为空'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        if(!(int)$this->_post('orderby')){
            $rs=array(
                'success'=>false,
                'error_msg'=>'顺序不能为空,且需要正整数!'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        $obj = D('Shoppic');
        $data = array(
            'shop_id'=>$this->shop_id,
            'title'=>htmlspecialchars($this->_post('title','trim'))
        );
        $data['photo'] = $this->_post('photo');
        $data['orderby'] = (int)$this->_post('orderby');
        $data['create_time'] = NOW_TIME;
        $data['create_ip']  = get_client_ip();
        if ($obj->add($data)) {
            $rs = array(
                'success'=>true,
                'error_msg'=>''
            );
        }else{
            $rs = array(
                'success'=>false,
                'error_msg'=>'保存失败!'
            );
        }
        $this->ajaxReturn($rs,'JSON');
    }

    public function upload(){
        $img = $this->uploadimg('shop_pic');
        if($img){
            $rs = array(
                'success' => true,
                'error_msg' =>'',
                'path'=>$img
            );
        }else{
            $rs = array(
                'success' => false,
                'error_msg' =>'上传失败'
            );
        }
        $this->ajaxReturn($rs,'JSON');
    }

    public function photo_delete(){
        $pic_id = (int)$this->_post('pic_id');
        $obj = D('Shoppic');
        $detail = $obj->find($pic_id);
        if($detail['shop_id'] == $this->shop_id){
            $obj->delete($pic_id);
            $rs = array(
                'success' => true,
                'error_msg' =>''
            );
            $this->ajaxReturn($rs,'JSON');
        }
        $this->ajaxReturn(array('success'=>false,'error_msg'=>'删除失败！'));
    }

//新增分店后的 修改
    public function fd_list(){
        $page = $this->_post('page','trim')?$this->_post('page','trim'):1;
        $map = array('shop_id' => $this->shop_id,'closed'=>1);
        $list = D('Shopjd')->field('*')->where($map)->order(array('fd_id' => 'asc'))->page($page . ',20')->select();
        $rs = array(
            'success'=>true,
            'list'=>$list,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }

    public function fd_info(){
        if(!$this->_post('fd_id','trim')){
            $rs=array(
                'success'=>false,
                'error_msg'=>'分店编号不能为空'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        if (!$fd_info = D('Shopfd')->find($this->_post('fd_id','trim'))) {
            $rs = array(
                'success' => false,
                'error_msg'=>'没有该商家!'
            );
            die(json_encode($rs));
        }
        if (!$fd_info['shop_id'] !=$this->shop_id) {
            $rs = array(
                'success' => false,
                'error_msg'=>'改分店不属于此用户!'
            );
            die(json_encode($rs));
        }
        $area = D('Narea');
        $area_info = $area->where('code = '.$fd_info['area_code'])->find();
        if($area_info){
            $area_name = $area_info['name'];
        }else{
            $area_name = '';
        }
        $city = D('Ncity');
        $city_info = $city->where('code = '.$fd_info['city_code'])->find();
        if($city_info){
            $city_name = $city_info['name'];
        }else{
            $city_name = '';
        }
        $province = D('Nprovince');
        $province_info = $province->where('code = '.$fd_info['province_code'])->find();
        if($province_info){
            $province_name = $province_info['name'];
        }else{
            $province_name = '';
        }
        $rs = array(
            'success'=>true,
            'fd_info'=>$fd_info,
            'province_name'=>$province_name,
            'city_name'=>$city_name,
            'area_name'=>$area_name,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }
    /*

    //图片列表
    public function photo(){
        if(!$this->_post('fd_id','trim')){
            $rs=array(
                'success'=>false,
                'error_msg'=>'标题不能为空'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        $Shopfdpic = D('Shopfdpic');
        $map = array('fd_id' =>  $this->_post('fd_id','trim'));
        $list = $Shopfdpic->field('*')->where($map)->order(array('pic_id'=>'asc'))->select();
        //die(var_dump($Shoppic->getLastSql()));
        $rs = array(
            'success'=>true,
            'fd_pics'=>$list,
            'error_msg'=>''
        );

        $this->ajaxReturn($rs,'JSON');
    }

    public function photo_delete(){
        $pic_id = (int)$this->_post('pic_id');
        $obj = D('Shopfdpic');
        $detail = $obj->find($pic_id);
        if($detail){
            $fd_info = D('Shopjd')->find($detail['fd_id']);
            if($fd_info==$this->shop_id){
                $obj->delete($pic_id);
                $rs = array(
                    'success' => true,
                    'error_msg' =>''
                );
                $this->ajaxReturn($rs,'JSON');
            }
        }
        $this->ajaxReturn(array('success'=>false,'error_msg'=>'删除失败！'));
    }

    public function add_shop_pic(){
        if(!$this->_post('title','trim')){
            $rs=array(
                'success'=>false,
                'error_msg'=>'标题不能为空'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        if(!$this->_post('photo','trim')){
            $rs=array(
                'success'=>false,
                'error_msg'=>'图片地址不能为空'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        if(!(int)$this->_post('orderby')){
            $rs=array(
                'success'=>false,
                'error_msg'=>'顺序不能为空,且需要正整数!'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        //$obj = D('Shoppic');
        $obj = D('Shopfdpic');
        $data = array(
            'shop_id'=>$this->shop_id,
            'title'=>htmlspecialchars($this->_post('title','trim'))
        );
        $data['photo'] = $this->_post('photo');
        $data['orderby'] = (int)$this->_post('orderby');
        $data['create_time'] = NOW_TIME;
        $data['create_ip']  = get_client_ip();
        if ($obj->add($data)) {
            $rs = array(
                'success'=>true,
                'error_msg'=>''
            );
        }else{
            $rs = array(
                'success'=>false,
                'error_msg'=>'保存失败!'
            );
        }
        $this->ajaxReturn($rs,'JSON');
    }

    public function save_about(){
        if(!$this->_post('fd_id','trim')){
            $rs=array(
                'success'=>false,
                'error_msg'=>'分店编号不能为空'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        if (!$fd_info = D('Shopfd')->find($this->_post('fd_id','trim'))) {
            $rs = array(
                'success' => false,
                'error_msg'=>'没有该商家!'
            );
            die(json_encode($rs));
        }
        if (!$fd_info['shop_id'] !=$this->shop_id) {
            $rs = array(
                'success' => false,
                'error_msg'=>'改分店不属于此用户!'
            );
            die(json_encode($rs));
        }
        if(!$this->_post('addr','trim')){
            $rs=array(
                'success'=>false,
                'error_msg'=>'商铺地址不能为空'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        if(!$this->_post('contact','trim')){
            $rs=array(
                'success'=>false,
                'error_msg'=>'商铺联系人不能为空'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        if(!$this->_post('business_time','trim')){
            $rs=array(
                'success'=>false,
                'error_msg'=>'商铺营业时间不能为空'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        if(!$this->_post('tel','trim')){
            $rs=array(
                'success'=>false,
                'error_msg'=>'联系电话不能为空'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        $data = array(
            'addr'=>$this->_post('addr','trim,htmlspecialchars',''),
            'contact'=>$this->_post('contact','trim,htmlspecialchars',''),
            'business_time'=>$this->_post('business_time','trim,htmlspecialchars',''),
            'tel'=>$this->_post('tel','trim,htmlspecialchars',''),
            'fd_id'=>$this->_post('fd_id','trim'),
        );
        if(D('Shopfd')->save($data)){
            $rs = array(
                'success'=>true,
                'error_msg'=>''
            );
            $this->ajaxReturn($rs,'JSON');
        }else{
            $rs=array(
                'success'=>false,
                'error_msg'=>'保存失败!'
            );
            $this->ajaxReturn($rs,'JSON');
        }

    }

    */

}