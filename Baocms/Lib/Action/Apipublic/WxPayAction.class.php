<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 17/1/12
 * Time: 下午1:40
 */
class WxPayAction extends CommonAction{
    protected $wx_appid;
    protected $wx_appsecret;
    public function app_pay(){

        $pay_sys=$this->_post('pay_sys');
        if($pay_sys!='Android' && $pay_sys!='IOS'){
            $rs = array(
                'success' => false,
                'error_msg'=>'移动端选择错误!'
            );
            die(json_encode($rs));
        }
        if($pay_sys=='Android'){
            $this->wx_appid=C('wx_Android_appid');
            $this->wx_appsecret=C('wx_Android_appsecret');
        }
        if($pay_sys=='IOS'){
            $this->wx_appid=C('wx_IOS_appid');
            $this->wx_appsecret=C('wx_IOS_appsecret');
        }
        $log_id = (int)$this->_post('log_id');

        $logs = D('Paymentlogs') -> find($log_id);

        if (empty($logs) || $logs['user_id'] != $this -> app_uid || $logs['is_paid'] == 1) {
            $rs = array(
                'success' => false,
                'error_msg'=>'没有有效的支付记录!'
              /*  'log'=>$logs,
                'app_uid'=>$this->app_uid*/
            );
            die(json_encode($rs));
        }
        require_cache( APP_PATH . 'Lib/Payment/weixin/Wechatpay.php' );//
        $wxconfig=array(
            'appid'=> $this->wx_appid,
            //'appid'=> C('wx_appid'),
            'mch_id'=> C('mch_id'),
            'apikey'=> C('apikey'),
            'appsecret'=> $this->wx_appsecret,
            'sslcertPath'=> C('sslcertPath'),
            'sslkeyPath'=> C('sslkeyPath'),
        );
        $weixin_pay = new Wechatpay($wxconfig);
        $param['body'] = '拉拉秀';
        $param['attach'] = 'attach';
        $param['detail'] = "拉拉秀线上商城——微信支付";
        $param['out_trade_no'] = $logs['log_id'];
        $param['total_fee'] = $logs['need_pay'];
        $param["spbill_create_ip"] = $_SERVER['REMOTE_ADDR'];
        $param["time_start"] = date("YmdHis");
        $param["time_expire"] = date("YmdHis", time() + 600);
        $param["goods_tag"] = "拉拉秀线上商城";
        $param["notify_url"] = 'http://'.$this->_server('HTTP_HOST').'/Apipublic/WxPay/appnotify';
        $param["trade_type"] = "APP";
        //统一下单，获取结果，结果是为了构造jsapi调用微信支付组件所需参数
        $result = $weixin_pay->unifiedOrder($param);
        if (isset($result["prepay_id"]) && !empty($result["prepay_id"])) {
            $rs = array(
                'success' => true,
                'error_msg'=>'',
                'result'=>$result,
                'app_need'=>$this->getOrder($result["prepay_id"])
            );
            die(json_encode($rs));
        }else{
            $rs = array(
                'success' => false,
                'error_msg'=>'微信预支付ID 获取失败!',
                'result'=>$result
            );
            die(json_encode($rs));
        }


        //先测试能不能使用APP 支付申请到预支付编号
        //然后 设计回调函数,
    }

    public function aj_pay(){
        if(!is_weixin()){
            $rs = array(
                'success' => false,
                'error_msg'=>'必须微信端登陆!'
            );
            die(json_encode($rs));
        }
        $log_id = (int)$this->_post('log_id');

        $logs = D('Paymentlogs') -> find($log_id);
        $openid = $this->_post('openid');
        if($openid==''){
            $rs = array(
                'success' => false,
                'error_msg'=>'openid 获取失败!'
            );
            die(json_encode($rs));
        }
        if (empty($logs) || $logs['user_id'] != $this -> app_uid || $logs['is_paid'] == 1) {
            $rs = array(
                'success' => false,
                'error_msg'=>'没有有效的支付记录!'
            );
            die(json_encode($rs));
        }
        require_cache( APP_PATH . 'Lib/Payment/weixin/Wechatpay.php' );//
        $wxconfig=array(
            //'appid'=> $this->wx_appid,
            'appid'=> C('zs_wx_appid'),
            'mch_id'=> C('zs_wx_mch_id'),
            'apikey'=> C('zs_wx_apikey'),
            'appsecret'=> C('zs_wx_appsecret'),
            'sslcertPath'=> C('sslcertPath'),
            'sslkeyPath'=> C('sslkeyPath'),
        );
        $weixin_pay = new Wechatpay($wxconfig);
        $param['body'] = '拉拉秀';
        $param['attach'] = 'attach';
        $param['detail'] = "拉拉秀线上商城——微信支付";
        $param['out_trade_no'] = $logs['log_id'];
        $param['total_fee'] = $logs['need_pay'];
        $param["spbill_create_ip"] = $_SERVER['REMOTE_ADDR'];
        $param["time_start"] = date("YmdHis");
        $param["time_expire"] = date("YmdHis", time() + 600);
        $param["goods_tag"] = "拉拉秀线上商城";
        $param["notify_url"] = 'http://'.$this->_server('HTTP_HOST').'/Apipublic/WxPay/jsnotify';
        $param["trade_type"] = "JSAPI";
        $param["openid"] = $openid;
        $result = $weixin_pay->unifiedOrder($param);
        if (isset($result["prepay_id"]) && !empty($result["prepay_id"])) {
            //调用支付类里的get_package方法，得到构造的参数
            $result = $weixin_pay->get_package($result['prepay_id']);
            $data['parameters'] = json_encode($result);
            $data['data'] = $result;
            $data['fee'] = $logs['need_pay'];
            $data['pubid'] = $logs['log_id'];
            $rs = array(
                'success' => true,
                'error_msg'=>'',
                'result'=>$data
            );
            die(json_encode($rs));
        }else{
            $rs = array(
                'success' => false,
                'error_msg'=>'微信预支付ID 获取失败!',
                'result'=>$result
            );
            die(json_encode($rs));
        }
    }

    public function getOrder($prepayId){
        $data["appid"] = $this->wx_appid;
        $data["noncestr"] = $this->getRandChar(32);;
        $data["package"] = "Sign=WXPay";
        $data["partnerid"] = C('mch_id');
        $data["prepayid"] = $prepayId;
        $data["timestamp"] = time();
        $s = $this->getSign($data, false);
        $data["sign"] = $s;

        return $data;
    }

    function getSign($data)
    {
        ksort($data);
        $string1 = "";
        foreach ($data as $k => $v) {
            if ($v && trim($v)!='') {
                $string1 .= "$k=$v&";
            }
        }
        $stringSignTemp = $string1 . "key=" . C('apikey');
        $sign = strtoupper(md5($stringSignTemp));
        return $sign;
    }

    public function notify(){
        require_cache( APP_PATH . 'Lib/Payment/weixin/Wechatpay.php' );//
        $this->wx_appid=C('wx_Android_appid');
        $this->wx_appsecret=C('wx_Android_appsecret');
        $wxconfig=array(
            'appid'=> $this->wx_appid?$this->wx_appid:'',
            'mch_id'=> C('mch_id'),
            'apikey'=> C('apikey'),
            'appsecret'=> $this->wx_appsecret?$this->wx_appsecret:'',
            'sslcertPath'=> C('sslcertPath'),
            'sslkeyPath'=> C('sslkeyPath'),
        );
        $weixin_pay = new Wechatpay($wxconfig);
        $data_array = $weixin_pay->get_back_data();
        if($data_array['result_code']=='SUCCESS' && $data_array['return_code']=='SUCCESS'){
            //$data_array['out_trade_no'] 就是传送的 商家订单
            if(D('Payment')->logsPaid($data_array['out_trade_no'])){
                return 'SUCCESS';
            }else{
                return 'FAIL';
            }
        }
    }

    public function appnotify(){
        require_cache( APP_PATH . 'Lib/Payment/weixin/Wechatpay.php' );//
        $this->wx_appid=C('wx_Android_appid');
        $this->wx_appsecret=C('wx_Android_appsecret');
        $wxconfig=array(
            'appid'=> C('wx_Android_appid'),
            'mch_id'=> C('mch_id'),
            'apikey'=> C('apikey'),
            'appsecret'=> C('wx_Android_appsecret'),
            'sslcertPath'=> C('sslcertPath'),
            'sslkeyPath'=> C('sslkeyPath'),
        );
        $weixin_pay = new Wechatpay($wxconfig);
        $data_array = $weixin_pay->get_back_data();
       /* $open=fopen('/var/wx.txt',"a" );
        fwrite($open,var_export($data_array,true));
        fclose($open);*/
        if($data_array['result_code']=='SUCCESS' && $data_array['return_code']=='SUCCESS'){
            //$data_array['out_trade_no'] 就是传送的 商家订单
            if(D('Payment')->logsPaid($data_array['out_trade_no'])){
                return 'SUCCESS';
            }else{
                return 'FAIL';
            }
        }
    }

    public function jsnotify(){
        require_cache( APP_PATH . 'Lib/Payment/weixin/Wechatpay.php' );//
        $wxconfig=array(
            'appid'=> C('zs_wx_appid'),
            'mch_id'=> C('zs_wx_mch_id'),
            'apikey'=> C('zs_wx_apikey'),
            'appsecret'=> C('zs_wx_appsecret'),
            'sslcertPath'=> C('sslcertPath'),
            'sslkeyPath'=> C('sslkeyPath'),
        );
        $weixin_pay = new Wechatpay($wxconfig);
        $data_array = $weixin_pay->get_back_data();
        if($data_array['result_code']=='SUCCESS' && $data_array['return_code']=='SUCCESS'){
            //$data_array['out_trade_no'] 就是传送的 商家订单
            if(D('Payment')->logsPaid($data_array['out_trade_no'])){
                return 'SUCCESS';
            }else{
                return 'FAIL';
            }
        }
    }

    public function notify_tb(){
        $log_id = (int)$this->_post('log_id');
        $logs = D('Paymentlogs') -> find($log_id);

        if (empty($logs) || $logs['user_id'] != $this -> app_uid) {
            $rs = array(
                'success' => false,
                'error_msg'=>'没有有效的支付记录!'
            );
            die(json_encode($rs));
        }
        if(D('Payment')->logsPaid($log_id)){
            $rs = array(
                'success' => true,
                'error_msg'=>''
            );
            die(json_encode($rs));
        }else{
            $rs = array(
                'success' => false,
                'error_msg'=>'支付失败!'
            );
            die(json_encode($rs));
        }
    }

    public function get_openid(){
        $appid=C('zs_wx_appid');
        $secret= C('zs_wx_appsecret');
        $openid='';
        if(empty($_GET['code'])){
            $url = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
            $url = urlencode($url);
            redirect("https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$url}&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect");
        }else{
            $j_access_token=file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$secret}&code={$_GET['code']}&grant_type=authorization_code");
            $a_access_token=json_decode($j_access_token,true);
            $access_token=$a_access_token["access_token"];
            $openid=$a_access_token["openid"];
        }
        return $openid;
    }

    public function get_openidbycode(){
        $code = $this->_post('code');
        $appid=C('zs_wx_appid');
        $secret= C('zs_wx_appsecret');
        $j_access_token=file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$secret}&code={$code}&grant_type=authorization_code");
        $a_access_token=json_decode($j_access_token,true);
        if($openid = $a_access_token['openid']){
            if($this->app_uid > 0 ){
                $user_info = D('Users')->find($this->app_uid);
                if($user_info){
                    $uid = D('Connect')->where(array('open_id'=>$openid))->find();
                    $data=array(
                        'type'=>'weixin',
                        'open_id'=>$openid,
                        'uid'=>$user_info['user_id'],
                        'mobile'=>$user_info['mobile']
                    );
                    if(!$uid){
                        D('Connect')->add($data);
                    }else{
                        if(!$uid['uid']){
                            D('Connect')->where(array('open_id'=>$openid))->save(array('uid'=>$user_info['user_id'],'mobile'=>$user_info['mobile']));
                        }else{
                            if($uid['uid']!=$user_info['user_id']){
                                D('Connect')->add($data);
                            }
                        }
                    }
                }else{
                    $uid = D('Connect')->where(array('open_id'=>$openid))->find();
                    $data=array(
                        'type'=>'weixin',
                        'open_id'=>$openid
                    );
                    if(!$uid){
                        D('Connect')->add($data);
                    }
                }
            }
            $rs = array(
                'success' => true,
                'error_msg'=>'',
                'openid'=>$openid
            );
        }else{
            $rs = array(
                'success' => false,
                'error_msg'=>'获取失败!'
            );
        }

        die(json_encode($rs));
    }
}