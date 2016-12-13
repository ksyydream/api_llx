<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 16/10/31
 * Time: 下午4:11
 */
class UserinfoAction extends CommonAction{
    public function mainpage(){
        $user_id = $this->app_uid;
        if ($user = D('Users')->find($user_id)) {
            $yhk = (array)json_decode($user['yhk']);
            $yhk_s = 0;
            foreach($yhk as $v){
                $yhk_s+=$v;
            }
            $shop = D('Shop');
            $shop_user = $shop->where("user_id={$user_id}")->select();
            $shop_count = count($shop_user);
            $rs = array(
                'success'=>true,
                'token'=>$this->token,
                'nickname'=> $user['nickname'],//昵称
                'money'=> $user['gold']/100,//账户余额
                'integral'=> $user['integral'],
                'rank_id'=>$user['rank_id'],
                'mobile'=>$user['mobile'],
                'face'=>$user['face'],
                'yhk'=>$yhk_s,
                'shopflag'=>$shop_count==0 ? 1 : 2,
                'error_msg'=>''
            );
            die(json_encode($rs));
        }else{
            $rs = array(
                'success' => false,
                'error_msg'=>'用户已注销!'
            );
            die(json_encode($rs));
        }
    }

    public function nickcheck() {
        $nickname = $this->_param('nickname');
        $user = D('Users')->where(array('nickname'=>$nickname))->find();
        if(empty($user)){
            $rs = array(
                'success' => true,
                'error_msg'=>''
            );
            die(json_encode($rs));
        }else{
            $rs = array(
                'success' => false,
                'error_msg'=>'昵称存在!'
            );
            die(json_encode($rs));
        }
    }

    public function nickname() {
        try{
            $nickname = trim($this->_param('nickname'));
            if(!$nickname){
                $rs = array(
                    'success' => false,
                    'error_msg'=>'昵称不能为空!'
                );
                die(json_encode($rs));
            }
            $user = D('Users')->where(array('nickname'=>$nickname))->find();
            if(!empty($user)){
                $rs = array(
                    'success' => false,
                    'error_msg'=>'昵称存在!'
                );
                die(json_encode($rs));
            }
            D('Users')->save(array('nickname'=>$nickname,'user_id'=>$this->app_uid));
            $rs = array(
                'success' => true,
                'error_msg'=>''
            );
            die(json_encode($rs));
        }catch(Exception $e) {
            $rs = array(
                'success' => false,
                'error_msg'=>'操作失败!'
            );
            die(json_encode($rs));
        }
    }

    public function upload1(){
        try{
            import('ORG.Net.UploadFile');
            $upload = new UploadFile(); //
            $upload->maxSize = 102400; // 设置附件上传大小
            $upload->allowExts = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型
            $name = date('Y/m/d', NOW_TIME);
            $dir = BASE_PATH . '/attachs/' . $name . '/';
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $upload->savePath = $dir; // 设置附件上传目录
            $data = array();
            $base64 = $this->_param('face');
            if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64, $result)){
                $name = date('Y/m/d', NOW_TIME);
                $dir = BASE_PATH . '/attachs/' . $name . '/';
                $img_name = $this->getRandChar(24).'.jpg';
                $img = base64_decode(str_replace($result[1], '', $base64));
                file_put_contents($dir.$img_name, $img);//返回的是字节数
                $data['face'] = $name.'/'.$img_name;

            }else{
                if(!$upload->upload()) {// 上传错误提示错误信息
                    $rs = array(
                        'success' => false,
                        'error_msg' => '' //头像上传失败
                    );
                    $this->ajaxReturn($rs,'JSON');
                }else{// 上传成功 获取上传文件信息
                    $info =  $upload->getUploadFileInfo();
                    $data['face'] = $name . '/' . $info[0]['savename'];
                }
            }
            $rs = array(
                'success' => true,
                'face'=>$data['face'],
                'error_msg'=>''
            );
            die(json_encode($rs));
        }catch(Exception $e) {
            $rs = array(
                'success' => false,
                'error_msg'=>'操作失败!'
            );
            die(json_encode($rs));
        }

    }

    public function changeface() {
        try{
            $face = trim($this->_param('face'));
            if(!$face){
                $rs = array(
                    'success' => false,
                    'error_msg'=>'不能为空!'
                );
                die(json_encode($rs));
            }
            D('Users')->save(array('face'=>$face,'user_id'=>$this->app_uid));
            $rs = array(
                'success' => true,
                'error_msg'=>''
            );
            die(json_encode($rs));
        }catch(Exception $e) {
            $rs = array(
                'success' => false,
                'error_msg'=>'操作失败!'
            );
            die(json_encode($rs));
        }
    }
}