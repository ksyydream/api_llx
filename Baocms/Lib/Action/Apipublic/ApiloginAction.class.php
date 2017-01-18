<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 16/10/27
 * Time: 上午9:55
 */
class ApiloginAction extends CommonAction{
    public function test_token(){
        $dataall = $this->_param();
        $open=fopen('/Users/yangyang/ajk/try/yy.txt',"wb" );
        fwrite($open,var_export($dataall,true));
        fclose($open);
        $token= $this->get_token();

        $rs = array(
            'success' => $token==-1?false:true,
            'user_id' => get_token_uid($token),
            'token'=>$token
        );
        die(json_encode($rs));
    }
    public function login(){
      /*  $token = $this->_param('token');

        $rs = array(
            'success' => false,
            'error_msg' => get_token_uid($token),
            'asd'=>'asd'
        );
        $this->ajaxReturn($rs,'JSON');*/

        $hear = getallheaders();
        $this->ajaxReturn($hear,'JSON');


    }
    public function get_yzm(){
        //$request = Request::instance();
        if(!trim($this->_param('mobile'))){
            $rs = array(
                'success'=>false,
                'yzm'=>-1,
                'error_msg'=>'请输入电话号码!'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        $mobile = trim($this->_param('mobile'))?trim($this->_param('mobile')):'18914970292';
        if ($user = D('Users')->getUserByAccount($mobile)) {
            $rs = array(
                'success'=>false,
                'yzm'=>-1,
                'error_msg'=>'手机已注册!'
            );
            $this->ajaxReturn($rs,'JSON');
        }

        $yzm = rand(100000,999999);
        $text = "欢迎注册拉拉秀生态平台,您的短信验证码为:".$yzm;
        file_get_contents("http://sms-api.luosimao.com/v1/http_get/send/json?key=e3829a670f2c515ab8befa5096dd135c&mobile={$mobile}&message={$text}【拉拉秀】");
        $rs = array(
            'success'=>true,
            'yzm'=>$yzm,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }
    public function save_user(){
        if ($user = D('Users')->getUserByAccount(trim($this->_param('mobile')))) {
            $rs = array(
                'success'=>false,
                'error_msg'=>'手机已注册!'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        if(!trim($this->_param('mobile')) || !trim($this->_param('password'))){
            $rs = array(
                'success'=>false,
                'error_msg'=>'手机号码或密码不能为空!'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        $data = array(
            'password'=>md5(trim($this->_param('password'))),
            'account' => trim($this->_param('mobile')),
            'nickname' => $this->_param('nickname')?$this->_param('nickname'):$this->_param('mobile'),
            'sex' => $this->_param('sex')?$this->_param('sex'):null,
        );
        $data['face'] = $this->uploadimg('face');
        if($user_id = D('Users')->add($data)){
            $token = set_token_uid($user_id);
            $rs = array(
                'success' => true,
                'token' => $token,
                'error_msg' => '' //头像上传失败
            );
            $this->ajaxReturn($rs,'JSON');
        }else{
            $rs = array(
                'success' => false,
                'error_msg' => '信息保存失败'
            );
            $this->ajaxReturn($rs,'JSON');
        }
    }
    public function login_name_pw(){


        /*$dataall = $this->_post();
        $open=fopen('/var/yy.txt',"a" );
        fwrite($open,var_export($dataall,true));
        fclose($open);*/

       if(!trim($this->_post('mobile')) || !trim($this->_post('password'))){
            $rs = array(
                'success'=>false,
                'error_msg'=>'登陆手机号码或密码不能为空! mobile:'.$this->_post('mobile').",password:".$this->_post('password')
            );
           echo json_encode($rs);
           die();
        }
        $mobile = $this->_post('mobile');
        if ($user = D('Users')->getUserByAccount($mobile)) {
            if($user['password']==md5($this->_post('password'))){
                $token = set_token_uid($user['user_id']);
                $rs = array(
                    'success'=>true,
                    'token' => $token,
                    'error_msg'=>''
                );
                echo json_encode($rs);
                die();
            }
        }
        $rs = array(
            'success' => false,
            'error_msg' => '手机号码或密码错误!'
        );
        echo json_encode($rs);
        die();
    }
    public function login_only_name(){
        /*$dataall = $this->_param();
        $open=fopen('/var/www/html/baocms/Baocms/Lib/Payment/logs/'.date( 'Y-m-d' ) . '.yy.log',"a" );
        fwrite($open,var_export($dataall,true));
        fclose($open);*/
        if(!trim($this->_param('mobile'))){
            $rs = array(
                'success'=>false,
                'error_msg'=>'登陆手机号码不能为空!',
            );
            $this->ajaxReturn($rs,'JSON');
        }
        $mobile = trim($this->_param('mobile'));
        if ($user = D('Users')->getUserByAccount($mobile)) {
                $yzm = rand(100000,999999);
                $text = "欢迎登陆拉拉秀生态平台,您的短信验证码为:".$yzm;
                file_get_contents("http://sms-api.luosimao.com/v1/http_get/send/json?key=e3829a670f2c515ab8befa5096dd135c&mobile={$mobile}&message={$text}【拉拉秀】");
                $token = set_token_uid($user['user_id']);
                $rs = array(
                    'success'=>true,
                    'yzm'=>$yzm,
                    'token' => $token,
                    'error_msg'=>''
                );
                echo json_encode($rs);
        }else{
            $rs = array(
                'success'=>false,
                'error_msg'=>'登陆手机号码未注册!',
            );
            $this->ajaxReturn($rs,'JSON');
        }
    }
    public function resetpw_yzm(){
        if(!trim($this->_param('mobile'))){
            $rs = array(
                'success'=>false,
                'yzm'=>-1,
                'error_msg'=>'请输入电话号码!'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        $mobile = trim($this->_param('mobile'))?trim($this->_param('mobile')):'18914970292';
        if ($user = D('Users')->getUserByAccount($mobile)) {
            $yzm = rand(100000,999999);
            $text = "拉拉秀生态平台密码修改,您的短信验证码为:".$yzm;
            file_get_contents("http://sms-api.luosimao.com/v1/http_get/send/json?key=e3829a670f2c515ab8befa5096dd135c&mobile={$mobile}&message={$text}【拉拉秀】");
            $rs = array(
                'success'=>true,
                'yzm'=>$yzm,
                'error_msg'=>''
            );
            $this->ajaxReturn($rs,'JSON');
        }
        $rs = array(
            'success'=>false,
            'yzm'=>-1,
            'error_msg'=>'手机未注册!'
        );
        $this->ajaxReturn($rs,'JSON');
    }
    public function resetpw(){
        if(!trim($this->_param('Npassword')) || !trim($this->_param('mobile'))){
            $rs = array(
                'success'=>false,
                'error_msg'=>'手机号或新密码不能为空!'
            );
            $this->ajaxReturn($rs,'JSON');
        }
        D('Users')->updatePwByAccount($this->_param('mobile'),trim($this->_param('Npassword')));
        $rs = array(
            'success'=>true,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }
    public function login_only_name_2(){
        if(!$this->_param('token')){
            $rs = array(
                'success'=>false,
                'error_msg'=>'认证失败!',
            );
            $this->ajaxReturn($rs,'JSON');
        }
        $token = $this->_param('token');
        $uid= get_token_uid($token);
        if (D('Users')->find($uid)) {
            D('Users')->where('id='.$uid)->save(array('token'=>$token));
            $rs = array(
                'success'=>true,
                'token' => $token,
                'error_msg'=>'',
            );
            $this->ajaxReturn($rs,'JSON');
        }
        $rs = array(
            'success' => false,
            'error_msg' => '认证失败!'
        );
        $this->ajaxReturn($rs,'JSON');
    }
    public function uploadimage(){
        import('ORG.Net.UploadFile');
        $upload = new UploadFile(); //
        $upload->maxSize = 102400; // 设置附件上传大小
        $upload->allowExts = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型
        $name = date('Y/m/d', NOW_TIME);
        $dir =  './attachs/' . $name . '/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $upload->savePath = $dir; // 设置附件上传目录
        $base64 = $this->_post('face');
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64, $result)){
            $name = date('Y/m/d', NOW_TIME);
            $dir ='./attachs/' . $name . '/';
            $img_name = $this->getRandChar(24).'jpg';
            $img = base64_decode(str_replace($result[1], '', $base64));
            file_put_contents($dir.$img_name, $img);//返回的是字节数
            $data['face'] = $name.'/'.$img_name;
        }else{
            if(!$upload->upload()) {// 上传错误提示错误信息
                $rs = array(
                    'success' => false,
                    'error_msg' => '1' //头像上传失败
                );
                $this->ajaxReturn($rs,'JSON');
            }else{// 上传成功 获取上传文件信息
                $info =  $upload->getUploadFileInfo();
                $data['face'] = $name . '/' . $info[0]['savename'];
            }
        }
        $rs = array(
            'success' => true,
            'error_msg' => $data['face'] //头像上传失败
        );
        $this->ajaxReturn($rs,'JSON');
    }
    public function testload(){
        $img = $this->uploadimg('face');
        $rs = array(
            'success' => true,
            'error_msg' =>$img //头像上传失败
        );
        $this->ajaxReturn($rs,'JSON');
    }
    public function get_wxconfig(){
        require_cache( APP_PATH . 'Lib/Net/Wxjssdk.php' );//
        $Wxjssdk = new Wxjssdk();
        $signPackage = @$Wxjssdk->wxgetSignPackage(C('wx_appid'),C('wx_appsecret'),C('sys_path'));
        $rs = array(
            'success' => true,
            'error_msg' => '',
            'wxappId' => $signPackage["appId"],
            'wxtimestamp' => $signPackage["timestamp"],
            'wxnonceStr' => $signPackage["nonceStr"],
            'wxsignature' => $signPackage["signature"]
        );
        $this->ajaxReturn($rs,'JSON');
    }
    public function use_QQmap(){
        $lat = $this->_post('lat');
        $lng = $this->_post('lng');
        $res = file_get_contents("http://apis.map.qq.com/ws/geocoder/v1/?location={$lat},{$lng}&get_poi=1&key=JFOBZ-HYWWW-T3XR3-OA5ZK-BYBP3-2JF2F");//百度API
        $obj=json_decode($res);

        if($obj->status=='0'){
            //$data = (int)$obj->result->ad_info->adcode;
            $data = $obj->result->ad_info;
            if($data){
                $rs = array(
                    'success' => true,
                    'error_msg' =>json_encode($data) //头像上传失败
                );
                $this->ajaxReturn($rs,'JSON');
            }else{
                $rs = array(
                    'success' => false,
                    'error_msg' =>'获取失败!'
                );
                $this->ajaxReturn($rs,'JSON');
            }
        }else{
            $rs = array(
                'success' => false,
                'error_msg' =>'获取失败!'
            );
            $this->ajaxReturn($rs,'JSON');
        }
    }

}