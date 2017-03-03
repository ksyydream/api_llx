<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 16/11/3
 * Time: 上午11:15
 */
class ApiajaxAction extends CommonAction{

    public function get_gg(){
        $gg_list = D('Ggpic')->order('gg_id asc')->select();
        $rs=array(
            'gg_list'=>$gg_list,
            'success' => true,
            'error_msg'=>''
        );
        die(json_encode($rs));
    }

    public function get_is_subscribe(){
        $code = $this->_post('code');
        $appid=C('zs_wx_appid');
        $secret= C('zs_wx_appsecret');
        $j_access_token=file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$secret}&code={$code}&grant_type=authorization_code");
        $a_access_token=json_decode($j_access_token,true);
        if($openid = $a_access_token['openid']){
            import("@/Net.Jssdk");
            $jssdk = new JSSDK("$appid", "$secret");
            $access_token = $jssdk->getAccessToken();
            $rs = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN");
            $rs = json_decode($rs,true);
            if(isset($rs['errcode']) and $rs['errcode'] == 40001) {
                $access_token = $jssdk->new_AccessToken();
                $rs = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN");
                $rs = json_decode($rs,true);
            }
            if($rs['subscribe'] != 1){
                $rs = array(
                    'success' => false,
                    'error_msg'=>'需要关注公众号!'
                );
                die(json_encode($rs));
            }else{
                $rs = array(
                    'success' => true,
                    'error_msg'=>''
                );
                die(json_encode($rs));
            }
        }else{
            $rs = array(
                'success' => false,
                'error_msg'=>'获取失败!'
            );
        }

        die(json_encode($rs));
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
        echo $openid;
    }

    public function down_Android(){
        $info = D('Appinfo')->where("type=1")->order('version_num desc')->find();
        if(file_exists(BASE_PATH.'/attachs/'.$info['path'])){
            import('ORG.Net.Http');
            Http::download(BASE_PATH.'/attachs/'.$info['path'],$info['path']);
        }
    }

    public function get_url(){
        $app_type = (int)$this->_post('app_type')?(int)$this->_post('app_type'):1;
        $info = D('Appinfo')->where("type={$app_type}")->order('version_num desc')->find();
        $rs=array(
            'url'=>$info['app_url'],
            'success' => true,
            'error_msg'=>''
        );
        die(json_encode($rs));
    }

    public function test()
    {
        $fans = D('Scf');
        //实例化fans模型
        $map = array(
            'b.shop_id' => $this->_post('shop_id', 'htmlspecialchars')
        );
        //查询条件
        if ($keyword = $this->_post('keyword', 'htmlspecialchars')) {
            $map['c.nickname|c.mobile'] = array('like','%'.trim($keyword).'%');
        }

        $count = $fans->alias('a')->group('a.uid')->field('a.*')
            ->join('bao_shop_fd b on a.fd_id = b.fd_id','LEFT')
            ->join('bao_users c on c.user_id = a.uid','LEFT')
            ->where($map)->count();
        // 查询满足要求的总记录数
        $maxpage=ceil($count/6);
        $page = $this->_param('page', 'htmlspecialchars')?$this->_param('page', 'htmlspecialchars'):1;
        $list = $fans->alias('a')->group('a.uid')->field('a.*,c.nickname,c.mobile,c.face')
            ->join('bao_shop_fd b on a.fd_id = b.fd_id','LEFT')
            ->join('bao_users c on c.user_id = a.uid','LEFT')
            ->where($map)
            ->order(array('a.id' => 'desc'))
            ->page($page.',6')
            ->select();
ddie(var_dump($fans->getLastSql()));
        $rs = array(
            'success' =>true,
            'keyword'=> $keyword,
            'list'=> $list,
            'page'=> $page,
            'maxpage'=>$maxpage,
            'error_msg'=>''
        );
        die(json_encode($rs));
    }
}