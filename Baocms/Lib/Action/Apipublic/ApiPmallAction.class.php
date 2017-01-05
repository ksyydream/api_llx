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
        if(!$this->_param('provincecode')){
            $rs = array(
                'success' => false,
                'error_msg'=>'省份编号不能为空!'
            );
            die(json_encode($rs));
        }
        try{
            $City = D('Ncity');
            $provincecode = $this->_param('provincecode')?$this->_param('provincecode'):12;//如果没有city_id 默认使用上海
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
        if(!$this->_param('citycode')){
            $rs = array(
                'success' => false,
                'error_msg'=>'城市编号不能为空!'
            );
            die(json_encode($rs));
        }
        try{
            $City = D('Narea');
            $citycode = $this->_param('citycode')?$this->_param('citycode'):12;//如果没有city_id 默认使用上海
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
            $lng = $this->_param('lng');
            $lat = $this->_param('lat');
            //$city_id = $this->_param('city_id')?$this->_param('city_id'):12;//如果没有city_id 默认使用上海
            //$cate_id = $this->_param('cate_id')?$this->_param('cate_id'):0;
            //$area_id = $this->_param('area_id')?$this->_param('area_id'):0;
            $area_code = $this->_param('area_code')?$this->_param('area_code'):310101;
            $page = $this->_param('page')?$this->_param('page'):1;
            $order = $this->_param('order')?$this->_param('order'):1;
            $map = array('closed'=>0,'audit'=>1);
            /*$map['city_id'] = $city_id;
            if($area_id != 0){
                $map['area_id'] = $area_id;
            }
            if($cate_id != 0){
                $map['cate_id'] = $cate_id;
            }*/
            //$list = $Shop->getshopsAPP($city_id,$cate_id,$area_id,$page,$lng,$lat,$order);
            $list = $Shop->getshopsAPP2($area_code,$page,$lng,$lat,$order);
            //$list = $Shop->getshopsJL();(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*({$lat}-lat)/360),2)+COS(PI()*{$lng}/180)* COS(lat * PI()/180)*POW(SIN(PI()*({$lng}-lng)/360),2)))) as juli
            $rs = array(
                'success' => true,
                'shop_list'=>$list,
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
}