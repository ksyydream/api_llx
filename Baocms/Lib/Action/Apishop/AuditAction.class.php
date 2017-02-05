<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/3
 * Time: 16:57
 */
class AuditAction extends CommonAction {

    private $create_fields = array('shop_id', 'photo', 'name', 'zhucehao', 'addr', 'end_date', 'zuzhidaima', 'user_name', 'pic', 'mobile', 'audit');
    private $edit_fields = array('shop_id','photo', 'name', 'zhucehao', 'addr', 'end_date', 'zuzhidaima', 'user_name', 'pic', 'mobile', 'audit');



    public function index() {


        if ($this->_post('name')) {

            $photo =  $this->_post('photo', false);
            echo $photo;
            if(!$photo){
                $rs['success']=false;
                $rs['error_msg']='请上传营业执照，可以用手机拍照上传！';
                $this->ajaxReturn($rs,'JSON');
            }
            if(!isImage($photo)){
                $rs['success']=false;
                $rs['error_msg']='所上传的营业执照格式不正确！';
                $this->ajaxReturn($rs,'JSON');
            }
            $pic =  $this->_post('pic', false);
            if(!$pic){
                $rs['success']=false;
                $rs['error_msg']='请上食品经营许可证，可以用手机拍照上传！';
                $this->ajaxReturn($rs,'JSON');
            }
            if(!isImage($pic)){

                $rs['success']=false;
                $rs['error_msg']='所上传食品经营许可证格式不正确！';
                $this->ajaxReturn($rs,'JSON');
            }


            $data = $this->createCheck();
            $data['photo'] = $photo;
            $data['pic'] = $pic;
            $obj = D('Audit');
            $shop_audit = $obj->where('shop_id =' . ($this->shop_id))->find();
            if ($shop_audit){
                if ($obj->save($data)){
                    $rs['success']=true;
                    $rs['error_msg']='修改成功';
                    $this->ajaxReturn($rs,'JSON');
                }
            }else{
            if ($obj->add($data)) {
                $rs['success']=true;
                $rs['error_msg']='添加成功';
                $this->ajaxReturn($rs,'JSON');
            }
            }
            $rs['success']=false;
            $rs['error_msg']='操作失败！';
            $this->ajaxReturn($rs,'JSON');
        } else {
            $shop_audit = D('Audit')->where('shop_id =' . ($this->shop_id))->find();
            $rs=array(
                'success'=>true,
                'shop_audit'=>$shop_audit,
                'error_msg'=>'');
            $this->ajaxReturn($rs,'JSON');
        }
    }
    private function createCheck() {

        //$data =checkFields($this->_post('data', false), $this->create_fields);
        $data['shop_id'] = $this->shop_id;



        $data['name'] = htmlspecialchars($_POST['name']);
        if (empty($data['name'])) {
            $rs['success']=false;
            $rs['error_msg']='企业名称不能为空';
            $this->ajaxReturn($rs,'JSON');
        }


        $data['zhucehao'] = htmlspecialchars($_POST['zhucehao']);
        if (empty($data['zhucehao'])) {
            $rs['success']=false;
            $rs['error_msg']='营业执照注册号不能为空';
            $this->ajaxReturn($rs,'JSON');
        }

        $data['addr'] = htmlspecialchars($_POST['addr']);
        if (empty($data['addr'])) {
            $rs['success']=false;
            $rs['error_msg']='营业地址不能为空';
            $this->ajaxReturn($rs,'JSON');
        }

        $data['end_date'] =htmlspecialchars($_POST['end_date']);
        if (empty($data['end_date'])) {
            $rs['success']=false;
            $rs['error_msg']='到期时间不能为空';
            $this->ajaxReturn($rs,'JSON');
        }
        if (!isDate($data['end_date'])) {
            $rs['success']=false;
            $rs['test']=$data['end_date'];
            $rs['error_msg']='到期时间格式不正确';
            $this->ajaxReturn($rs,'JSON');
        }

        $data['zuzhidaima'] = htmlspecialchars($_POST['zuzhidaima']);
        if (empty($data['zuzhidaima'])) {
            $rs['success']=false;
            $rs['error_msg']='组织机构代码证为空';
            $this->ajaxReturn($rs,'JSON');
        }

        /*$data['user_name'] = htmlspecialchars($_POST['user_name']);
        if (empty($data['user_name'])) {
            $rs['success']=false;
            $rs['error_msg']='员工姓名为空';
            $this->ajaxReturn($rs,'JSON');
        }

        $data['mobile'] = htmlspecialchars($_POST['mobile']);
        if (empty($data['mobile'])) {
            $rs['success']=false;
            $rs['error_msg']='员工手机不能为空';
            $this->ajaxReturn($rs,'JSON');

        }
        if (!isMobile($data['mobile'])) {
            $rs['success']=false;
            $rs['error_msg']='员工手机格式不正确';
            $this->ajaxReturn($rs,'JSON');

        }*/
        $data['audit'] = 0;//默认不通过
        $data['create_time'] = NOW_TIME;
        $data['create_ip'] = get_client_ip();
        return $data;
    }

    public function uploadpic(){
        $img = $this->uploadimg('photo','yyzz');
        if($img){
            $rs = array(
                'success' => true,
                'error_msg' =>'',
                'pic_path'=>$img//头像上传失败
            );
        }else{
            $rs = array(
                'success' => false,
                'error_msg' =>''
            );
        }
        $this->ajaxReturn($rs,'JSON');
    }

    /*public function edit($audit_id = 0) {
        if ($audit_id = (int) $audit_id) {
            $obj = D('Audit');
            if (!$detail = $obj->find($audit_id)) {
                $this->error('请选择要编辑的商家认证';             $this->ajaxReturn($rs,'JSON');
            }
            if ($detail['shop_id'] != $this->shop_id) {
                $this->error('请不要操作别人的认证';             $this->ajaxReturn($rs,'JSON');
            }
            if ($detail['closed'] != 0) {
                $this->error('该认证已被删除';             $this->ajaxReturn($rs,'JSON');
            }
            if ($this->isPost()) {
                $photo =  $this->_post('photo', false);
                if(count($photo) ==0){
                    $rs['success']=false;             $rs['error_msg']='请上传营业执照，可以用手机拍照上传！';             $this->ajaxReturn($rs,'JSON');
                }
                if(!isImage($photo['0'])){
                    $rs['success']=false;             $rs['error_msg']='所上传的营业执照格式不正确！';             $this->ajaxReturn($rs,'JSON');
                }
                $pic =  $this->_post('pic', false);
                if(count($pic) ==0){
                    $rs['success']=false;             $rs['error_msg']='请上传员工身份证，可以用手机拍照上传！';             $this->ajaxReturn($rs,'JSON');
                }
                if(!isImage($pic['0'])){
                    $rs['success']=false;             $rs['error_msg']='所上传员工身份证格式不正确！';             $this->ajaxReturn($rs,'JSON');
                }

                $data = $this->editCheck();
                $data['audit_id'] = $audit_id;
                $data['photo'] = $photo['0'];
                $data['pic'] = $pic['0'];
                if (false !== $obj->save($data)) {
                    $rs['success']=false;             $rs['error_msg']='编辑操作成功', U('audit/index'));
                }
                $rs['success']=false;             $rs['error_msg']='操作失败';             $this->ajaxReturn($rs,'JSON');
            } else {
                $this->assign('detail', $detail);
                $this->assign('shop',D('Shop')->find($detail['shop_id']));
                $this->display();
            }
        } else {
            $this->error('请选择要编辑的商家认证1';             $this->ajaxReturn($rs,'JSON');
        }
    }

    private function editCheck() {
        $data = $this->checkFields($this->_post('data', false), $this->edit_fields);
        $data['audit_id'] = (int) $data['audit_id'];
        $data['shop_id'] = $this->shop_id;

        $data['name'] = htmlspecialchars($data['name']);
        if (empty($data['name'])) {
            $rs['success']=false;             $rs['error_msg']='企业名称不能为空';             $this->ajaxReturn($rs,'JSON');
        }


        $data['zhucehao'] = htmlspecialchars($data['zhucehao']);
        if (empty($data['zhucehao'])) {
            $rs['success']=false;             $rs['error_msg']='营业执照注册号不能为空';             $this->ajaxReturn($rs,'JSON');
        }

        $data['addr'] = htmlspecialchars($data['addr']);
        if (empty($data['addr'])) {
            $rs['success']=false;             $rs['error_msg']='营业地址不能为空';             $this->ajaxReturn($rs,'JSON');
        }

        $data['end_date'] = htmlspecialchars($data['end_date']);
        if (empty($data['end_date'])) {
            $rs['success']=false;             $rs['error_msg']='到期时间不能为空';             $this->ajaxReturn($rs,'JSON');
        }
        if (!isDate($data['end_date'])) {
            $rs['success']=false;             $rs['error_msg']='到期时间格式不正确';             $this->ajaxReturn($rs,'JSON');
        }

        $data['zuzhidaima'] = htmlspecialchars($data['zuzhidaima']);
        if (empty($data['zuzhidaima'])) {
            $rs['success']=false;             $rs['error_msg']='组织机构代码证为空';             $this->ajaxReturn($rs,'JSON');
        }

        $data['user_name'] = htmlspecialchars($data['user_name']);
        if (empty($data['user_name'])) {
            $rs['success']=false;             $rs['error_msg']='员工姓名为空';             $this->ajaxReturn($rs,'JSON');
        }




        $data['mobile'] = htmlspecialchars($data['mobile']);
        if (empty($data['mobile'])) {
            $rs['success']=false;             $rs['error_msg']='员工手机不能为空';             $this->ajaxReturn($rs,'JSON');

        }
        if (!isMobile($data['mobile'])) {
            $rs['success']=false;             $rs['error_msg']='员工手机格式不正确';             $this->ajaxReturn($rs,'JSON');

        }
        return $data;
    }*/

}
