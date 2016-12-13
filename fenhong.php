<?php

$mysql_server_name = "localhost"; //数据库服务器名称
$mysql_username = "root"; // 连接数据库用户名
$mysql_password = "p2ssw0rd"; // 连接数据库密码
$mysql_database = "baocms"; // 数据库的名字



$conn = mysql_connect($mysql_server_name, $mysql_username, $mysql_password);
mysql_query("set names 'utf8'");
mysql_select_db($mysql_database);

$sql_get_price = "SELECT shop_id,sum(total_price)*0.05 AS total_price FROM bao_fenhong WHERE STATUS = 1 GROUP BY shop_id";
$result = mysql_query($sql_get_price, $conn);
$shop_fenhong = array();//每个店铺可分配金额
$user_count = array();
$shops = array();
while ($row = mysql_fetch_array($result)) {
    $shops[] = $row['shop_id'];
    $shop_fenhong[$row['shop_id']] = $row['total_price'];
}

if(empty($shops)){
    die;
}
$shops_str = '(' . implode(',', $shops) . ')';
$sql_get_count = "SELECT shop_id,count(uid) as count_u FROM bao_user_shop WHERE shop_id in {$shops_str} GROUP BY shop_id";
$result = mysql_query($sql_get_count, $conn);
while ($row = mysql_fetch_array($result)) {
    $user_count[$row['shop_id']] = $row['count_u'];
}

foreach($shop_fenhong as $k=>$v){
    if(isset($user_count[$k])){
        $shop_fenhong[$k] = floor($v/$user_count[$k]);
    }
}

$user_fenhong = array();//用户对应该用户需要分红的总额
$sql_get_users = "SELECT uid,shop_id FROM bao_user_shop where shop_id in {$shops_str}";
$result = mysql_query($sql_get_users, $conn);
while ($row = mysql_fetch_array($result)) {
    if(isset($user_fenhong[$row['uid']])){
        $user_fenhong[$row['uid']] = $user_fenhong[$row['uid']] + $shop_fenhong[$row['shop_id']];
    }else{
        $user_fenhong[$row['uid']] = $shop_fenhong[$row['shop_id']];
    }
}







$uids = array();

foreach ($user_fenhong as $k => $v) {
    $ip = get_client_ip();

    $sql1 = "update `bao_users` set integral = (integral + {$v}) where user_id = {$k}";
    if ($v > 0) {
        $sql2 = "INSERT INTO `bao_user_integral_logs` (user_id,integral,intro,create_time,create_ip) VALUES({$k},{$v},'每日分红获得秀币','{$_SERVER['REQUEST_TIME']}','{$ip}')";
        mysql_query($sql2, $conn);
        $uids[] = $k;
    }
    mysql_query($sql1, $conn);

}
$uids = '(' . implode(',', $uids) . ')';

$sql_get_openid = "select open_id,uid from `bao_connect` where uid in {$uids}";
$rs = mysql_query($sql_get_openid, $conn);
while ($row = mysql_fetch_array($rs)) {
    $uid = $row['uid'];
    $integral = $user_fenhong[$uid];
    if($integral > 0){
        $openid = $row['open_id'];
        $description = "恭喜您,今日分红获得秀币:{$integral}秀币";
        $articles[0] = array(
            'title' => urlencode('秀币每日分红'),
            'url' => 'http://wap.51loveshow.com/mcenter/member',
            'picurl' => 'http://wap.51loveshow.com/xbfh.jpg',
            'description' => urlencode($description)
        );
        $content = array();
        $content['touser'] = $openid;
        $content['msgtype'] = 'news';
        $content['news'] = array('articles' => $articles);
        send_msg($content);
    }

}


$sql3 = "update `bao_fenhong` set status = 2 where id in {$ids}";
mysql_query($sql3, $conn);
//////////////////////die('dddd');


function send_msg($content){
    $access_token = get_access_token();
    $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $access_token;
    $rs = post($url, $content);
    echo $rs;
}

function get_access_token(){
    return '9mgfbktULVMTcfP6rCHk_-V2urnywXNYS8HFvuH1JV7UKY-uv4CVFg56u2KUzlP1WgiZZyU_0Ez8HPqn2UhII7AXaYHNMXM1jZ4ZycFaudQWGCeAEARBX';
    $str = file_get_contents('/alidata/www/llx/access_token.json');
    $obj = json_decode($str);
    if(NOW_TIME >= $obj->expire_time){
        $appid = 'wx3b4f8d5f9ee9df5d';
        $appsecret = '4274017b2b05c5294843be35723bb8b9';
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
        $res = json_decode($this->httpGet($url));
        $access_token = $res->access_token;

        $data = array(
            'expire_time'=>NOW_TIME+7000,
            'access_token'=>$access_token
        );
        $str = json_encode($data);
        $open=fopen('/alidata/www/llx/access_token.json',"w+");
        fwrite($open,$str);
        fclose($open);
    }else{
        $access_token = $obj->access_token;
    }

    return $access_token;
}


function get_client_ip($type = 0)
{
    $type = $type ? 1 : 0;
    static $ip = NULL;
    if ($ip !== NULL) return $ip[$type];
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos = array_search('unknown', $arr);
        if (false !== $pos) unset($arr[$pos]);
        $ip = trim($arr[0]);
    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u", ip2long($ip));
    $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

function post($url, $post_data, $timeout = 300)
{
    $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-type:application/json;encoding=utf-8',
            'content' => urldecode(json_encode($post_data)),
            'timeout' => $timeout
        )
    );
    $context = stream_context_create($options);
    return file_get_contents($url, false, $context);
}

function httpGet($url)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
}








