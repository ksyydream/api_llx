<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/30
 * Time: 15:52
 */
class AdrAction extends CommonAction {

    public function index() {
        $page = $this->_param('page', 'htmlspecialchars')?$this->_param('page', 'htmlspecialchars'):1;

        $u = D('Users');
        $ud = D('UserAddr');
        $addr = $ud->alias('a')->field('a.*,b.name province_name,c.name city_name,d.name area_name')
            ->join('bao_nprovince b on a.province_code = b.code')
            ->join('bao_ncity c on a.city_code = c.code')
            ->join('bao_narea d on a.area_code = d.code')
            ->where('a.user_id='.$this->app_uid)
            ->page($page . ',20')
            ->select();
        $rs = array(
            'success'=>true,
            'addr'=>$addr,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }

    public function update_addr(){

        $addr_id = I('addr_id','','trim,intval');
        if(!$addr_id){
            $rs = array(
                'success'=>false,
                'error_msg'=>'没有此地址'
            );
            $this->ajaxReturn($rs,'JSON');
        }else{

            $ud = D('UserAddr');
            $up1 = $ud -> where('user_id ='.$this->app_uid)->setField('is_default',0);
            $up2 = $ud -> where('addr_id ='.$addr_id)->setField('is_default',1);
                $rs = array(
                    'success'=>true,
                    'error_msg'=>''
                );
                $this->ajaxReturn($rs,'JSON');
        }
    }

        public function delete(){
            $addr_id = (int)$this->_param('addr_id');
            if(empty($addr_id)){
                $this->ajaxReturn(array('status'=>'error','error_msg'=>'地址不存在'));
            }
            if(!$detail = D('Useraddr')->find($addr_id)){
                $this->ajaxReturn(array('status'=>'error','error_msg'=>'地址不存在'));
            }
            if($detail['user_id'] != $this->app_uid){
                $this->ajaxReturn(array('status'=>'error','error_msg'=>'不要操作别人的地址'));
            }
            if(D('Useraddr')->delete($addr_id)){
                $this->ajaxReturn(array('status'=>'success','error_msg'=>'恭喜您删除成功'));
            }
        }


        public function add_addr(){


                $name = I('name','','trim,htmlspecialchars');
                $area_code = I('area_code','','intval,trim');
                $city_code = I('city_code','','intval,trim');
                $province_code = I('province_code','','intval,trim');
                $mobile = I('mobile','','trim');
                $addr = I('addr','','trim,htmlspecialchars');
                $default_add = $this->_post('default');
                if(!$name){
                    $this->ajaxReturn(array('status' => 'error', 'error_msg' => '联系人没有填写！'));
                }

                if(!$city_code || !$area_code || !$province_code){
                    $this->ajaxReturn(array('status' => 'error', 'error_msg' => '省区、城市、地区必须都选择！'));
                }

                if(!isMobile($mobile)){
                    $this->ajaxReturn(array('status' => 'error', 'error_msg' => '手机号码不正确！'));
                }

                if(!$addr){
                    $this->ajaxReturn(array('status' => 'error', 'error_msg' => '收货地址没有填写！'));
                }
                $ud = D('UserAddr');
                $data = array();
                $data['name'] = $name;
                $data['city_code'] = $city_code;
                $data['area_code'] = $area_code;
                $data['province_code'] = $province_code;
                $data['mobile'] = $mobile;
                $data['addr'] = $addr;
                $data['user_id'] = $this->app_uid;
                if($default_add){
                    $data['is_default'] = 1;
                    $up1 = $ud -> where('user_id ='.$this->app_uid)->setField('is_default',0);
                }else{
                    $data['is_default'] = 0;
                }

                $data['closed'] = 0;


                $add = $ud -> add($data);
                if($add){
                    $this->ajaxReturn(array('status' => 'success', 'error_msg' => '添加成功！'));
                }else{
                    $this->ajaxReturn(array('status' => 'error', 'error_msg' => '添加失败！'));
                }

            }



            public function edit_addr(){


                    $addr_id = I('addr_id','','trim,intval');
                    $name = I('name','','trim,htmlspecialchars');
                    $area_code = I('area_code','','intval,trim');
                    $city_code = I('city_code','','intval,trim');
                    $province_code = I('province_code','','intval,trim');
                    $mobile = I('mobile','','trim');
                    $addr = I('addr','','trim,htmlspecialchars');
                    $ud = D('UserAddr');
                    $default_add = $this->_post('default');
                    if(!$addr_id){
                        $this->ajaxReturn(array('status' => 'error', 'error_msg' => '错误！'));
                    }else{
                        $f = $ud -> where('addr_id ='.$addr_id)-> find();
                        if(!$f){
                            $this->ajaxReturn(array('status' => 'error', 'error_msg' => '错误！'));
                        }else{
                            if($f['user_id'] != $this->app_uid){
                                $this->ajaxReturn(array('status' => 'error', 'error_msg' => '非法操作！'));
                            }
                        }
                    }

                    if(!$name){
                        $this->ajaxReturn(array('status' => 'error', 'error_msg' => '联系人没有填写！'));
                    }

                    if(!$city_code || !$area_code || !$province_code){
                        $this->ajaxReturn(array('status' => 'error', 'error_msg' => '省区、城市、地区必须都选择！'));
                    }

                    if(!isMobile($mobile)){
                        $this->ajaxReturn(array('status' => 'error', 'error_msg' => '手机号码不正确！'));
                    }

                    if(!$addr){
                        $this->ajaxReturn(array('status' => 'error', 'error_msg' => '收货地址没有填写！'));
                    }

                    $data = array();
                    $data['name'] = $name;
                    $data['city_code'] = $city_code;
                    $data['area_code'] = $area_code;
                    $data['province_code'] = $province_code;
                    $data['mobile'] = $mobile;
                    $data['addr'] = $addr;
                    $data['user_id'] = $this->app_uid;
                    if($default_add){
                        $data['is_default'] = 1;
                        $up1 = $ud -> where('user_id ='.$this->app_uid)->setField('is_default',0);
                    }else {
                        $data['is_default'] = 0;
                    }
                    $data['closed'] = 0;


                    $add = $ud -> where('addr_id ='.$addr_id) -> setField($data);
                    if($add){
                        $this->ajaxReturn(array('status' => 'success', 'error_msg' => '修改成功！'));
                    }else{
                        $this->ajaxReturn(array('status' => 'error', 'error_msg' => '修改失败！'));
                    }

                }

}