<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 16/10/27
 * Time: 下午5:25
 */
class CommonAction extends Action{
    protected $app_uid;
    protected $token;
    protected $_CONFIG = array();
    protected $member = array();

    protected function _initialize(){
        define('__HOST__', 'http://' . $_SERVER['HTTP_HOST']);
        $this->_CONFIG = d( "Setting" )->fetchAll( );
        $token= $this->get_token();
        $this->token = $token;
        if($token == -1){
            if($_SERVER['REQUEST_METHOD'] != 'OPTIONS')
                header('HTTP/1.1 401 Unauthorized');
            $rs = array(
                'success' => false,
                'error_msg'=>'用户未登陆!'
            );
            header('status: 401');
            die(json_encode($rs));
        }
        $this->app_uid = get_token_uid($token);
        if($this->app_uid == 0){
            if($_SERVER['REQUEST_METHOD'] != 'OPTIONS')
                header('HTTP/1.1 401 Unauthorized');
            $rs = array(
                'success' => false,
                'error_msg'=>'token错误!'
            );
            header('status: 401');
            die(json_encode($rs));
        }
        $this->member = D('Users')->find($this->app_uid);
    }
    protected function get_token(){
        foreach (getallheaders() as $name => $value) {
            if($name == 'Token'){
                return $value;
            }
        }
        return -1;
    }
    function getRandChar($length){
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol)-1;

        for($i=0;$i<$length;$i++){
            $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }

        return $str;
    }
    public function ctqrcode($data){
        //include '../phpqrcode.php';
        //http://$Think.SERVER.HTTP_HOST}>__ROOT__<{:U('/mobile/shop/detail',array('shop_id'=>$shop_id))}>?uid=<{$uid}>
        QRcode::png($data);
    }
    function uploadimg($input_name = 'img_input',$folder = 'face'){
        import('ORG.Net.UploadFile');
        $data['face']='';
        $upload = new UploadFile(); //
        $upload->maxSize = 1048000 * 5; // 设置附件上传大小
        $upload->allowExts = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型
        $name = date('Y/m/d', NOW_TIME);
        $dir = BASE_PATH . '/attachs/' . $name . '/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $upload->savePath = $dir; // 设置附件上传目录
        $base64 = $this->_post($input_name);
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64, $result)){
            $img_name = $this->getRandChar(24).'.jpg';
            $img = base64_decode(str_replace($result[1], '', $base64));
            file_put_contents($dir.$img_name, $img);//返回的是字节数
            $data['face'] = $name.'/'.$img_name;
        }else{
            if(!$upload->upload()) {// 上传错误提示错误信息

            }else{// 上传成功 获取上传文件信息
                $info =  $upload->getUploadFileInfo();
                foreach ($info as $k){
                $data['face'][] = $name . '/' . $k['savename'];
                }
            }
        }
        return $data['face'];
    }

    function uploadimg2($input_name = 'img_input',$folder = 'face'){
        import('ORG.Net.UploadFile');
        $data['face']='';
        $upload = new UploadFile(); //
        $upload->maxSize = 1048000 * 5; // 设置附件上传大小
        $upload->allowExts = array('jpg', 'gif', 'png', 'jpeg'); // 设置附件上传类型
        $name = date('Y/m/d', NOW_TIME);
        $dir = BASE_PATH . '/attachs/' . $name . '/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $upload->savePath = $dir; // 设置附件上传目录
        if($this->_post($input_name)){
            $base64 = $this->_post($input_name);
            if(is_array($base64)){
                foreach ($base64 as $img_file){
                    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $img_file, $result)){
                        $img_name = $this->getRandChar(24).'.jpg';
                        $img = base64_decode(str_replace($result[1], '', $img_file));
                        file_put_contents($dir.$img_name, $img);//返回的是字节数
                        $data['face'][] = $name.'/'.$img_name;
                    }
                }
            }else{
                if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64, $result)){
                    $img_name = $this->getRandChar(24).'jpg';
                    $img = base64_decode(str_replace($result[1], '', $base64));
                    file_put_contents($dir.$img_name, $img);//返回的是字节数
                    $data['face'] = $name.'/'.$img_name;
                }
            }

        }else{
                $info =  $upload->uploadOne($input_name);
                foreach ($info as $k){
                    $data['face'][] = $name . '/' . $k['savename'];
                }
            }

        return $data['face'];
    }

    protected function checkFields($data = array(), $fields = array()) {
        foreach ($data as $k => $val) {
            if (!in_array($k, $fields)) {
                unset($data[$k]);
            }
        }
        return $data;
    }

    //专门为 秀一秀 的模块准备
    /*function upload2xiu($input_name = 'img_input',$folder = 'face'){
        import('ORG.Net.UploadFile');
        $data['face']='';
        $upload = new UploadFile(); //
        $upload->maxSize = 1048000 * 5; // 设置附件上传大小
        $upload->allowExts = array('jpg', 'gif', 'png', 'jpeg','mp4','avi','3gp','wmv'); // 设置附件上传类型
        $name = date('Y/m/d', NOW_TIME);
        $dir = BASE_PATH . '/attachs/xiu/' . $name . '/';
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $upload->savePath = $dir; // 设置附件上传目录
        $base64 = $this->_post($input_name);
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64, $result)){
            $img_name = $this->getRandChar(24).'.jpg';
            $img = base64_decode(str_replace($result[1], '', $base64));
            file_put_contents($dir.$img_name, $img);//返回的是字节数
            $data['face'] = 'xiu/'.$name.'/'.$img_name;
        }else{
            if(!$upload->upload()) {// 上传错误提示错误信息

            }else{// 上传成功 获取上传文件信息
                $info =  $upload->getUploadFileInfo();
                foreach ($info as $k){
                    $data['face'][] = 'xiu/'.$name . '/' . $k['savename'];
                }
            }
        }
        return $data['face'];
    }*/
}