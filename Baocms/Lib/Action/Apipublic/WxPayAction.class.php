<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 17/1/12
 * Time: 下午1:40
 */
class WxpayAction extends CommonAction{
    protected $wx_appid;
    protected $wx_appsecret;
    public function app_pay(){

        $pay_sys=$this->_post('pay_sys');
        if($pay_sys!='Android' && $pay_sys!='IOS'){
            $rs = array(
                'success' => false,
                'error_msg'=>'1移动端选择错误!'
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

        /*if (empty($logs) || $logs['user_id'] != $this -> app_uid || $logs['is_paid'] == 1) {
            $rs = array(
                'success' => false,
                'error_msg'=>'2没有有效的支付记录!'
            );
            die(json_encode($rs));
        }*/
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
        $param['total_fee'] = 1;
        $param["spbill_create_ip"] = $_SERVER['REMOTE_ADDR'];
        $param["time_start"] = date("YmdHis");
        $param["time_expire"] = date("YmdHis", time() + 600);
        $param["goods_tag"] = "拉拉秀线上商城";
        $param["notify_url"] = U('notify');
        $param["trade_type"] = "APP";
        //统一下单，获取结果，结果是为了构造jsapi调用微信支付组件所需参数
        $result = $weixin_pay->unifiedOrder($param);
        var_dump($result);
        die;


        //先测试能不能使用APP 支付申请到预支付编号
        //然后 设计回调函数,
    }
}