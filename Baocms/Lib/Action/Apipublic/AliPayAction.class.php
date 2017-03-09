<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 17/1/12
 * Time: 下午1:40
 */
class AliPayAction extends CommonAction{

    private $alipay_config=array();

    protected function _initialize(){
        parent::_initialize();
        $this->alipay_config=array(
            'partner'=>C('private_key'),
            'transport'=>C('transport'),
            'private_key'=>C('private_key'),
            'alipay_public_key'=>C('alipay_public_key'),
            'service'=>C('service'),
            'sign_type'=>C('sign_type'),
            'input_charset'=>C('input_charset'),
            'cacert'=>C('cacert')
        );
    }
    public function app_pay(){
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
        require_once(APP_PATH . "Lib/Payment/alipay_app/alipay_notify.class.php");
        require_once(APP_PATH . "Lib/Payment/alipay_app/alipay_rsa.function.php");
        require_once(APP_PATH . "Lib/Payment/alipay_app/alipay_core.function.php");
        $pay_data = array(
            'partner'=>C('private_key'),
            'seller_id'=>C('private_key'),
            'out_trade_no'=> $logs['log_id'],
            'subject'=>'拉拉秀',
            'body'=>"拉拉秀线上商城——支付宝支付",
            'total_fee'=>round((float)$logs['need_pay']/100,2),
            'notify_url'=>'http://'.$this->_server('HTTP_HOST').'/Apipublic/AliPay/appnotify',
            'service'=>$this->alipay_config['service'],
            'payment_type'=>1,
            '_input_charset'=>$this->alipay_config['_input_charset'],
            'it_b_pay'=>'30m',
        );
        $data=createLinkstring($pay_data);

        //打印待签名字符串。工程目录下的log文件夹中的log.txt。
        logResult($data);

        //将待签名字符串使用私钥签名,且做urlencode. 注意：请求到支付宝只需要做一次urlencode.
        $rsa_sign=urlencode(rsaSign($data, C('private_key')));

        //把签名得到的sign和签名类型sign_type拼接在待签名字符串后面。
        $data = $data.'&sign='.'"'.$rsa_sign.'"'.'&sign_type='.'"'.C('sign_type').'"';

        //返回给客户端,建议在客户端使用私钥对应的公钥做一次验签，保证不是他人传输。
        echo $data;


        //先测试能不能使用APP 支付申请到预支付编号
        //然后 设计回调函数,
    }

    public function appnotify(){
        require_once(APP_PATH . "Lib/Payment/alipay_app/alipay_notify.class.php");
        require_once(APP_PATH . "Lib/Payment/alipay_app/alipay_rsa.function.php");
        require_once(APP_PATH . "Lib/Payment/alipay_app/alipay_core.function.php");
        $alipayNotify = new AlipayNotify($this->alipay_config);
        if($alipayNotify->getResponse($_POST['notify_id']))//判断成功之后使用getResponse方法判断是否是支付宝发来的异步通知。
        {
            if($alipayNotify->getSignVeryfy($_POST, $_POST['sign'])) {//使用支付宝公钥验签

                //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
                //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
                //商户订单号
                $out_trade_no = $_POST['out_trade_no'];

                //支付宝交易号
                $trade_no = $_POST['trade_no'];

                //交易状态
                $trade_status = $_POST['trade_status'];

                if($_POST['trade_status'] == 'TRADE_FINISHED') {
                    //判断该笔订单是否在商户网站中已经做过处理
                    //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                    //如果有做过处理，不执行商户的业务程序
                    //注意：
                    //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
                    //请务必判断请求时的out_trade_no、total_fee、seller_id与通知时获取的out_trade_no、total_fee、seller_id为一致的
                    if(D('Payment')->logsPaid($out_trade_no)){

                    }else{

                    }
                }
                else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
                    //判断该笔订单是否在商户网站中已经做过处理
                    //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                    //如果有做过处理，不执行商户的业务程序
                    //注意：
                    //付款完成后，支付宝系统发送该交易状态通知
                    //请务必判断请求时的out_trade_no、total_fee、seller_id与通知时获取的out_trade_no、total_fee、seller_id为一致的
                    if(D('Payment')->logsPaid($out_trade_no)){

                    }else{

                    }
                }
                //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
                echo "success";		//请不要修改或删除
            }
            else //验证签名失败
            {
                echo "sign fail";
            }
        }
        else //验证是否来自支付宝的通知失败
        {
            echo "response fail";
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

}