<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/20
 * Time: 11:03
 */
class XiuuserAction extends CommonAction {

    protected function _initialize(){
        parent::_initialize();
        if($this->token == -1){
            if($_SERVER['REQUEST_METHOD'] != 'OPTIONS')
                header('HTTP/1.1 401 Unauthorized');
            $rs = array(
                'success' => false,
                'error_msg'=>'用户未登陆!'
            );
            header('status: 401');
            die(json_encode($rs));
        }
        $this->app_uid = get_token_uid($this->token);
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
        if(!$this->member){
            if($_SERVER['REQUEST_METHOD'] != 'OPTIONS')
                header('HTTP/1.1 401 Unauthorized');
            $rs = array(
                'success' => false,
                'error_msg'=>'用户不存在!'
            );
            header('status: 401');
            die(json_encode($rs));
        }
        if($this->member['closed']!=0){
            if($_SERVER['REQUEST_METHOD'] != 'OPTIONS')
                header('HTTP/1.1 401 Unauthorized');
            $rs = array(
                'success' => false,
                'error_msg'=>'用户已被关闭!'
            );
            header('status: 401');
            die(json_encode($rs));
        }
    }

    public function upload(){
        $img = $this->upload2xiu('file');
        if($img){
            $rs = array(
                'success' => true,
                'error_msg' =>'',
                'path'=>$img
            );
        }else{
            $rs = array(
                'success' => false,
                'error_msg' =>'上传失败'
            );
        }
        $this->ajaxReturn($rs,'JSON');
    }

    public function add_xiu(){
        $remark = $this->_post('remark','trim,htmlspecialchars','');
        if(!$remark){
            $rs = array('success' => false, 'error_msg' =>'秀内容,不能为空!');
            $this->ajaxReturn($rs,'JSON');
        }

        $photos = $this->_post('xiu_files');
        if($photos){
            if (!is_array($photos)){
                $rs = array(
                    'success' => false,
                    'error_msg'=>'文件地址必须是数组!'
                );
                die(json_encode($rs));
            }
        }

        $data = array(
            'uid'=>$this->app_uid,
            'remark'=>$remark,
            'create_time'=>date('Y-m-d H:i:s'),
            'hf_count'=>0,
            'zan_count'=>0,
            'liwu_count'=>0,
            'flag'=>1
        );

        $master_id = D('Xiuuser')->add($data);

        if($photos){
            foreach($photos as $file){
                if(file_exists(BASE_PATH.'/attachs/'.$file)){
                    $path_data = array(
                        'master_id'=>$master_id,
                        'path'=>$file
                    );
                    $file_path = pathinfo(BASE_PATH.'/attachs/'.$file);
                    $f_extension = isset($file_path['extension'])?$file_path['extension']:'';
                    $f_extension = strtolower($f_extension);
                    if($f_extension=='mp4' or $f_extension=='avi' or $f_extension=='3gp' or $f_extension=='wmv'){
                        $path_data['flag']=2;
                    }else{
                        $path_data['flag']=1;
                    }
                   D('Xiuuserfile')->add($path_data);
                }
            }
        }

        $rs = array('success' => true, 'error_msg' =>'','xiuuser_id'=>$master_id);
        $this->ajaxReturn($rs,'JSON');

    }

    public function xiu_list_self(){
        /*$xiumodel = D('Xiuuser');
        $page = trim($this->_param('page')) ? trim($this->_param('page')) : 1;
        $list = $xiumodel->alias('a')->field('a.*,b.nickname,b.face')->where(array('a.uid'=>$this->app_uid,'a.flag'=>1,'a.closed'=>0))
            ->join('bao_users b on a.uid = b.user_id','LEFT')
            ->order(array('a.id' => 'desc'))
            ->page($page.",10")
            ->select();
        foreach ($list as $k => $val) {
            $files=D('Xiuuserfile')->where(array('master_id' => $val['id']))->select();
            $list[$k]['files']=array();
            foreach ($files as $a => $v){
                if(file_exists(BASE_PATH.'/attachs/'.$v['path'])){
                    $list[$k]['files'][]=array('path'=>$v['path'],'flag'=>$v['flag']);
                }
            }
        }*/
        $order = trim($this->_post('order')) ? trim($this->_post('order')) : 1;
        $list = $this->get_xiu_list($order,$this->app_uid);
        $rs = array(
            'success'=>true,
            'list'=>$list,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }

    public function xiu_like(){
        $id = (int)$this->_post('id');
        if(!$id){
            $rs = array('success' => false, 'error_msg'=>'秀一秀编号不能为空!');
            die(json_encode($rs));
        }
        $xiulike = D('Xiuuserlike');
        $map = array('master_id'=>$id,'uid'=>$this->app_uid);
        $row = $xiulike->where($map)->find();
        if($row){
            $rs = array('success' => false, 'error_msg'=>'已点赞!');
            die(json_encode($rs));
        }
        $map['create_time']=date('Y-m-d H:i:s');
        $xiulike->add($map);
        D('Xiuuser')->where(array('id'=>$id))->setInc('zan_count',1);
        $rs = array('success' => true, 'error_msg' =>'');
        $this->ajaxReturn($rs,'JSON');
    }

    public function xiu_hf(){
        $id = (int)$this->_post('id');
        if(!$id){
            $rs = array('success' => false, 'error_msg'=>'秀一秀编号不能为空!');
            die(json_encode($rs));
        }
        $remark = $this->_post('remark','trim,htmlspecialchars','');
        if(!$remark){
            $rs = array('success' => false, 'error_msg' =>'评论内容,不能为空!');
            $this->ajaxReturn($rs,'JSON');
        }
        $xiuhf = D('Xiuuserhf');
        $data = array(
            'master_id'=>$id,
            'remark'=>$remark,
            'uid'=>$this->app_uid,
            'create_time'=>date('Y-m-d H:i:s')
        );
        $xiuhf->add($data);
        D('Xiuuser')->where(array('id'=>$id))->setInc('hf_count',1);
        $rs = array('success' => true, 'error_msg' =>'');
        $this->ajaxReturn($rs,'JSON');
    }

    public function buy2user_liwu(){
        $xiu_id = (int)$this->_post('xiu_id');
        if(!$xiu_id){
            $rs = array('success' => false, 'error_msg'=>'秀一秀编号不能为空!');
            die(json_encode($rs));
        }
        $xiu = D('Xiuuser')->where(array('id'=>$xiu_id,'closed'=>0))->find();
        if(!$xiu){
            $rs = array('success' => false, 'error_msg'=>'个人秀不存在,或已关闭!');
            die(json_encode($rs));
        }
        $liwu_id = (int)$this->_post('liwu_id');
        if(!$liwu_id){
            $rs = array('success' => false, 'error_msg'=>'礼物编号不能为空!');
            die(json_encode($rs));
        }
        $liwu = D('Present')->where(array('id'=>$liwu_id,'status'=>1))->find();
        if(!$liwu){
            $rs = array('success' => false, 'error_msg'=>'礼物不存在,或已关闭!');
            die(json_encode($rs));
        }

        if($liwu['price'] > $this->member['integral']){
            $rs = array('success' => false, 'error_msg'=>'秀币余额不足!');
            die(json_encode($rs));
        }
        $liwu_data = array(
            'master_id'=>$xiu_id,
            'uid'=>$this->app_uid,
            'liwu_name'=>$liwu['name'],
            'liwu_price'=>$liwu['price'],
            'create_time'=>date('Y-m-d H:i:s')
        );

        D('Users')->addIntegral($this->app_uid,0 - $liwu['price'],"购买礼物[{$liwu['name']}],使用秀币");
        if($liwu['price'] < $liwu['get_price']){
            D('Users')->addIntegral($xiu['uid'],$liwu['price'],"收到礼物[{$liwu['name']}],得到秀币");
            $liwu_data['liwu_get_price']=$liwu['price'];
        }else{
            D('Users')->addIntegral($xiu['uid'],$liwu['get_price'],"收到礼物[{$liwu['name']}],得到秀币");
            $liwu_data['liwu_get_price']=$liwu['get_price'];
        }
        D('Xiuliwu')->add($liwu_data);
        //增加秀一秀的礼物数量
        D('Xiuuser')->where(array('id'=>$xiu_id))->setInc('liwu_count',1);
        //增加礼物的销量
        D('Present')->where(array('id'=>$liwu_id))->setInc('count',1);
        $rs = array('success' => true, 'error_msg' =>'');
        $this->ajaxReturn($rs,'JSON');
    }

    public function xiu_del(){
        $id = (int)$this->_post('id');
        if(!$id){
            $rs = array('success' => false, 'error_msg'=>'秀一秀编号不能为空!');
            die(json_encode($rs));
        }
        $xiu = D('Xiuuser')->where(array('id'=>$id,'closed'=>0))->find();
        if(!$xiu){
            $rs = array('success' => false, 'error_msg'=>'个人秀不存在,或已关闭!');
            die(json_encode($rs));
        }
        if($xiu['uid']!=$this->app_uid){
            $rs = array('success' => false, 'error_msg'=>'不可操作他人秀一秀信息!');
            die(json_encode($rs));
        }
        D('Xiuuser')->where(array('id'=>$id,'uid'=>$this->app_uid))->save(array('closed'=>1));

        $rs = array('success' => true, 'error_msg' =>'');
        $this->ajaxReturn($rs,'JSON');
    }

    public function get_xf_list(){
        $Goodsdianping = D('Goodsdianping');
        $map = array('closed' => 0, 'user_id' => $this->app_uid);
        $page = $this->_post('page', 'htmlspecialchars')?$this->_post('page', 'htmlspecialchars'):1;
        $list = $Goodsdianping->field('*,FROM_UNIXTIME(create_time) AS cdate')->where($map)->order(array('create_time' => 'desc'))->page($page.',10')->select();
        foreach ($list as $k => $val) {
            $user_ids[$val['user_id']] = $val['user_id'];
            $users= D('Users')->itemsByIds($user_ids);
            $list[$k]['username']=$users[$val['user_id']]['nickname'];
            $list[$k]['rank_id']=$users[$val['user_id']]['rank_id'];
            $list[$k]['face']=$users[$val['user_id']]['face'];
            $pic=D('Goodsdianpingpics')->where(array('order_id' => $val['order_id']))->select();
            $list[$k]['pic']=array();
            foreach ($pic as $a => $v){
                if(file_exists(BASE_PATH.'/attachs/'.$v['pic'])){
                    //$img_list[]=array('path'=>'statics/images/carousel1.jpg');
                    $list[$k]['pic'][]=$v['pic'];
                }
            }
        }

        $rs = array(
            'success' => true,
            'list'=>$list,
            'error_msg'=>''
        );
        die(json_encode($rs));
    }

    public function get_move_jpg(){
        if (extension_loaded('ffmpeg')) {//判断ffmpeg是否载入


                //$file = substr($file1,1);
                $mov = new ffmpeg_movie('http:\/\/be.51loveshow.com\/attachs\/xiu\/2017\/03\/16\/58ca3a8183e85.MP4'); //视频的路径
                $ff_frame = $mov->getFrame(20); //截取视频第2帧的图像
                $gd_image = $ff_frame->toGDImage();
                //return Yii::app()->params['front'] . "$file";
                //截取地址

                //图片保存路径
                $img = BASE_PATH.'/attachs/yy123.jpg'; //要生成图片的绝对路径
                imagejpeg($gd_image,$img); //创建jpg图像
                imagedestroy($gd_image); //销毁一图像

                // return $img;
            return 'true';
        }else{
            return 'false';
        }
    }
}