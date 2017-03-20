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
    protected $url_path = 'http://be.51loveshow.com/attachs/';
    protected function _initialize(){
        define('__HOST__', 'http://' . $_SERVER['HTTP_HOST']);
        $this->_CONFIG = d( "Setting" )->fetchAll( );
        $token= $this->get_token();
        $this->token = $token;
        if($token == -1){
            $this->app_uid = 0;
        }else{
            $this->app_uid = get_token_uid($token);
        }
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


    //专门为 秀一秀 的模块准备
    function upload2xiu($input_name = 'img_input',$folder = 'face'){
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
    }

    protected function get_xiu_list($order=1,$user=null){
        $xiumodel = D('Xiuuser');
        $page = trim($this->_param('page')) ? trim($this->_param('page')) : 1;
        $map = array('a.flag'=>1,'a.closed'=>0);
        if($user){
            $map['a.uid']=$user;
        }
        switch($order){
            case 1:
                $order_arr = array('a.id' => 'desc');
                break;
            case 2:
                $order_arr = array('a.zan_count' => 'desc');
                break;
            case 3:
                $order_arr = array('a.hf_count' => 'desc');
                break;
            case 4:
                $order_arr = array('a.liwu_count' => 'desc');
                break;
            default:
                $order_arr = array('a.id' => 'desc');
                break;
        }
        $list = $xiumodel->alias('a')->field('a.*,b.nickname,b.face')->where($map)
            ->join('bao_users b on a.uid = b.user_id','LEFT')
            ->order($order_arr)
            ->page($page.",10")
            ->select();
        foreach ($list as $k => $val) {
            $xiuuserf = D('Xiuuserfile');
            $files=$xiuuserf->where(array('master_id' => $val['id']))
                ->order(array('id' => 'asc'))
                ->select();
            $list[$k]['files']=array();
            foreach ($files as $a => $v){
                if(file_exists(BASE_PATH.'/attachs/'.$v['path'])){
                    $list[$k]['files'][]=array('path'=>$this->url_path.$v['path'],'flag'=>$v['flag']);
                }
            }
            $xiulike = D('Xiuuserlike');
            $map2 = array('master_id'=>$val['id'],'uid'=>$this->app_uid);
            $row = $xiulike->where($map2)->find();
            if($row){
                $list[$k]['liked']=1;
            }else{
                $list[$k]['liked']=-1;
            }
        }

        $rs = array(
            'success'=>true,
            'list'=>$list,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }

    protected function get_xiushop_list($order=1,$shop_id=null){
        $xiumodel = D('Xiuuser');
        $page = trim($this->_param('page')) ? trim($this->_param('page')) : 1;
        $map = array('a.flag'=>2,'a.closed'=>0);
        if($shop_id){
            $map['a.shop_id']=$shop_id;
        }else{
            /*$shop_ids = array();
            $scfmodel = D('Scf');
            $reslut_arr = $scfmodel->alias('a')->field('a.*,b.shop_id')
                ->join('bao_shop_fd b on a.fd_id = b.fd_id','LEFT')
                ->where(array('a.uid'=>$this->app_uid))
                ->group('b.shop_id')
                ->select();
            //die(var_dump($scfmodel->getLastSql()));
            foreach($reslut_arr as $value){
                $shop_ids[]=$value['shop_id'];
            }
            $map['a.shop_id']=array('in',implode(',',$shop_ids));*/
        }
        switch($order){
            case 1:
                $order_arr = array('a.id' => 'desc');
                break;
            case 2:
                $order_arr = array('a.zan_count' => 'desc');
                break;
            case 3:
                $order_arr = array('a.hf_count' => 'desc');
                break;
            case 4:
                $order_arr = array('a.liwu_count' => 'desc');
                break;
            default:
                $order_arr = array('a.id' => 'desc');
                break;
        }
        $list = $xiumodel->alias('a')->field('a.*,b.shop_name,b.logo')->where($map)
            ->join('bao_shop b on a.shop_id = b.shop_id','LEFT')
            ->order($order_arr)
            ->page($page.",10")
            ->select();
        foreach ($list as $k => $val) {
            $xiuuserf = D('Xiuuserfile');
            $files=$xiuuserf->where(array('master_id' => $val['id']))
                ->order(array('id' => 'asc'))
                ->select();
            $list[$k]['files']=array();
            foreach ($files as $a => $v){
                if(file_exists(BASE_PATH.'/attachs/'.$v['path'])){
                    $list[$k]['files'][]=array('path'=>$this->url_path.$v['path'],'flag'=>$v['flag']);
                }
            }
            $xiulike = D('Xiuuserlike');
            $map2 = array('master_id'=>$val['id'],'uid'=>$this->app_uid);
            $row = $xiulike->where($map2)->find();
            if($row){
                $list[$k]['liked']=1;
            }else{
                $list[$k]['liked']=-1;
            }
        }

        $rs = array(
            'success'=>true,
            'list'=>$list,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }
}