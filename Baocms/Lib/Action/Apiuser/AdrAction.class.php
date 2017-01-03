<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/30
 * Time: 15:52
 */
class AdrAction extends CommonAction {

    public function index() {
        $type = (int) $this->_param('type');
        $order_id = (int) $this->_param('order_id');
        $u = D('Users');
        $ud = D('UserAddr');
        $addr = $ud -> where('user_id='.$this->app_uid) -> select();
        $rs = array(
            'success'=>true,
            'type'=>$type,
            'order_id'=>$order_id,
            'addr'=>$addr,
            'business'=>D('Business')->fetchAll(),
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }

    public function update_addr(){
        $type = (int) $this->_param('type');
        $this->assign('type', $type);
        $order_id = (int) $this->_param('order_id');
        $this->assign('order_id', $order_id);


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

            if($type == 1){
                $rs = array(
                    'success'=>true,
                    'order_id'=>$order_id,
                    'tp'=>'ele',
                    'error_msg'=>''
                );
                $this->ajaxReturn($rs,'JSON');
            }elseif($type == 2){
                $rs = array(
                    'success'=>true,
                    'order_id'=>$order_id,
                    'tp'=>'mall',
                    'error_msg'=>''
                );
                $this->ajaxReturn($rs,'JSON');
            }elseif($type == 3){
                $rs = array(
                    'success'=>true,
                    'order_id'=>$order_id,
                    'tp'=>'mart',
                    'error_msg'=>''
                );
                $this->ajaxReturn($rs,'JSON');
            }else{
                $rs = array(
                    'success'=>true,
                    'order_id'=>$order_id,
                    'tp'=>'addrs',
                    'error_msg'=>''
                );
                $this->ajaxReturn($rs,'JSON');
            }
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
                $area_id = I('area_id','','intval,trim');
                $city_id = I('city_id','','intval,trim');
                $business_id = I('business_id','','intval,trim');
                $mobile = I('mobile','','trim');
                $addr = I('addr','','trim,htmlspecialchars');

                if(!$name){
                    $this->ajaxReturn(array('status' => 'error', 'error_msg' => '联系人没有填写！'));
                }

                if(!$city_id || !$area_id || !$business_id){
                    $this->ajaxReturn(array('status' => 'error', 'error_msg' => '城市、地区、商圈必须都选择！'));
                }

                if(!isMobile($mobile)){
                    $this->ajaxReturn(array('status' => 'error', 'error_msg' => '手机号码不正确！'));
                }

                if(!$addr){
                    $this->ajaxReturn(array('status' => 'error', 'error_msg' => '收货地址没有填写！'));
                }

                $data = array();
                $data['name'] = $name;
                $data['city_id'] = $city_id;
                $data['area_id'] = $area_id;
                $data['business_id'] = $business_id;
                $data['mobile'] = $mobile;
                $data['addr'] = $addr;
                $data['user_id'] = $this->app_uid;
                $data['is_default'] = 0;
                $data['closed'] = 0;

                $ud = D('UserAddr');
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
                    $area_id = I('area_id','','intval,trim');
                    $city_id = I('city_id','','intval,trim');
                    $business_id = I('business_id','','intval,trim');
                    $mobile = I('mobile','','trim');
                    $addr = I('addr','','trim,htmlspecialchars');
                    $ud = D('UserAddr');
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

                    if(!$city_id || !$area_id || !$business_id){
                        $this->ajaxReturn(array('status' => 'error', 'error_msg' => '城市、地区、商圈必须都选择！'));
                    }

                    if(!isMobile($mobile)){
                        $this->ajaxReturn(array('status' => 'error', 'error_msg' => '手机号码不正确！'));
                    }

                    if(!$addr){
                        $this->ajaxReturn(array('status' => 'error', 'error_msg' => '收货地址没有填写！'));
                    }

                    $data = array();
                    $data['name'] = $name;
                    $data['city_id'] = $city_id;
                    $data['area_id'] = $area_id;
                    $data['business_id'] = $business_id;
                    $data['mobile'] = $mobile;
                    $data['addr'] = $addr;
                    $data['user_id'] = $this->app_uid;
                    $data['is_default'] = $f['is_default'];
                    $data['closed'] = 0;


                    $add = $ud -> where('addr_id ='.$addr_id) -> setField($data);
                    if($add){
                        $this->ajaxReturn(array('status' => 'success', 'error_msg' => '修改成功！'));
                    }else{
                        $this->ajaxReturn(array('status' => 'error', 'error_msg' => '修改失败！'));
                    }

                }

}