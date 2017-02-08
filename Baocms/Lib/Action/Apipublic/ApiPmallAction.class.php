<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 16/11/2
 * Time: 上午11:38
 */
class ApiPmallAction extends CommonAction{
    public function getshopscate(){
        try{
            $Shopcate = D('Shopcate');
            $parent_id = $this->_param('parent_id')?$this->_param('parent_id'):0;
            $list = $Shopcate
                ->field('cate_id,cate_name,parent_id,orderby,is_hot')
                ->where(array('parent_id'=>$parent_id))->select();
            $rs = array(
                'success' => true,
                'cate_list'=>$list,
                'error_msg'=>''
            );
            die(json_encode($rs));
        }catch(Exception $e) {
            $rs = array(
                'success' => false,
                'cate_list'=>'',
                'error_msg'=>'获取数据失败!'
            );
            die(json_encode($rs));
        }

    }

    public function getcity(){
        try{
            $City = D('City');
            $list = $City
                ->field('city_id,name,pinyin,orderby,first_letter,photo')
                ->where(array('is_open'=>1))
                ->order('first_letter asc')
                ->select();
            $rs = array(
                'success' => true,
                'city_list'=>$list,
                'error_msg'=>''
            );
            die(json_encode($rs));
        }catch(Exception $e) {
            $rs = array(
                'success' => false,
                'city_list'=>'',
                'error_msg'=>'获取数据失败!'
            );
            die(json_encode($rs));
        }

    }

    public function getarea(){
        try{
            $Area = D('Area');
            $city_id = $this->_param('city_id')?$this->_param('city_id'):12;//如果没有city_id 默认使用上海
            $list = $Area
                ->where(array('city_id'=>$city_id))->select();
            $rs = array(
                'success' => true,
                'area_list'=>$list,
                'error_msg'=>''
            );
            die(json_encode($rs));
        }catch(Exception $e) {
            $rs = array(
                'success' => false,
                'area_list'=>'',
                'error_msg'=>'获取数据失败!'
            );
            die(json_encode($rs));
        }

    }

    public function get_nprovince(){
        try{
            $City = D('Nprovince');
            $list = $City
                ->field('*')
                ->order('id asc')
                ->select();
            $rs = array(
                'success' => true,
                'province_list'=>$list,
                'error_msg'=>''
            );
            die(json_encode($rs));
        }catch(Exception $e) {
            $rs = array(
                'success' => false,
                'province_list'=>'',
                'error_msg'=>'获取数据失败!'
            );
            die(json_encode($rs));
        }
    }

    public function get_ncity(){
        if(!$this->_param('province_code')){
            $rs = array(
                'success' => false,
                'error_msg'=>'省份编号不能为空!'
            );
            die(json_encode($rs));
        }
        try{
            $City = D('Ncity');
            $provincecode = $this->_param('province_code')?$this->_param('province_code'):12;//如果没有city_id 默认使用上海
            $list = $City
                ->field('*')
                ->where(array('provincecode'=>$provincecode))
                ->order('id asc')
                ->select();
            $rs = array(
                'success' => true,
                'city_list'=>$list,
                'error_msg'=>''
            );
            die(json_encode($rs));
        }catch(Exception $e) {
            $rs = array(
                'success' => false,
                'city_list'=>'',
                'error_msg'=>'获取数据失败!'
            );
            die(json_encode($rs));
        }
    }

    public function get_narea(){
        if(!$this->_param('city_code')){
            $rs = array(
                'success' => false,
                'error_msg'=>'城市编号不能为空!'
            );
            die(json_encode($rs));
        }
        try{
            $City = D('Narea');
            $citycode = $this->_param('city_code')?$this->_param('city_code'):12;//如果没有city_id 默认使用上海
            $list = $City
                ->field('*')
                ->where(array('citycode'=>$citycode))
                ->order('id asc')
                ->select();
            $rs = array(
                'success' => true,
                'area_list'=>$list,
                'error_msg'=>''
            );
            die(json_encode($rs));
        }catch(Exception $e) {
            $rs = array(
                'success' => false,
                'area_list'=>'',
                'error_msg'=>'获取数据失败!'
            );
            die(json_encode($rs));
        }
    }

    public function getshops(){

        try{
            $Shop = D('Shop');
            $lng = (float)$this->_param('lng');
            $lat = (float)$this->_param('lat');
            if(!$lng || !$lat){
                $lat = 31.2383718228;
                $lng = 121.3301816158;
            }
            $area_code = $this->_post('area_code');
            $area_name = '';
            if(!$area_code){
                $map_res = $this->use_QQmap($lat,$lng);
                if($map_res != -1){
                    $area_code = $map_res['code'];
                    $area_name = $map_res['name'];
                }else{
                    $area_code = 310101;
                    $area_name = '黄浦区';
                }
            }else{
                if (!($detail = D('Narea')->where('code='.$area_code)->find())) {
                    $area_code = 310101;
                    $area_name = '黄浦区';
                }else{
                    $area_name = $detail['name'];
                }
            }
            $page = $this->_param('page')?$this->_param('page'):1;
            $order = $this->_param('order')?$this->_param('order'):1;
            $shop_name = $this->_post('shop_name','trim')?$this->_post('shop_name','trim'):'';
            //$list = $Shop->getshopsAPP($city_id,$cate_id,$area_id,$page,$lng,$lat,$order);
            $list = $Shop->getshopsAPP2($area_code,$page,$lng,$lat,$order,$shop_name);
            //$list = $Shop->getshopsJL();(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*({$lat}-lat)/360),2)+COS(PI()*{$lng}/180)* COS(lat * PI()/180)*POW(SIN(PI()*({$lng}-lng)/360),2)))) as juli
            $rs = array(
                'success' => true,
                'shop_list'=>$list,
                'area_code'=>$area_code,
                'area_name'=>$area_name,
                'error_msg'=>''
            );
            die(json_encode($rs));
        }
        catch(Exception $e) {
            $rs = array(
                'success' => false,
                'shop_list'=>'',
                'error_msg'=>'获取数据失败!'
            );
            die(json_encode($rs));
        }
    }

    private function use_QQmap($lat,$lng){
        $res = file_get_contents("http://apis.map.qq.com/ws/geocoder/v1/?location={$lat},{$lng}&get_poi=1&key=JFOBZ-HYWWW-T3XR3-OA5ZK-BYBP3-2JF2F");//百度API
        $obj=json_decode($res);

        if($obj->status=='0'){
            $data = $obj->result->ad_info->adcode;
            $area = D('Narea');
            $info = $area->where('code = '.$data)->find();
            if($info){
                return $info;
            }else{
                return -1;
            }
        }else{
            return -1;
        }
    }
}