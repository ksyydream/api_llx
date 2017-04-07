<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/20
 * Time: 11:03
 */
class XiupublicAction extends CommonAction {

    public function xiu_list_all(){
        /*$xiumodel = D('Xiuuser');
        $page = trim($this->_param('page')) ? trim($this->_param('page')) : 1;
        $list = $xiumodel->alias('a')->field('a.*,b.nickname,b.face')->where(array('a.flag'=>1,'a.closed'=>0))
            ->join('bao_users b on a.uid = b.user_id','LEFT')
            ->order(array('a.id' => 'desc'))
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
        }*/
        $order = trim($this->_post('order')) ? trim($this->_post('order')) : 1;
        $list = $this->get_xiu_list($order);
        $rs = array(
            'success'=>true,
            'list'=>$list,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }

    public function xiushop_list_all(){
        $order = trim($this->_post('order')) ? trim($this->_post('order')) : 1;
        $list = $this->get_xiushop_list_new($order);
        $rs = array(
            'success'=>true,
            'list'=>$list,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }

    public function xiu_like_list(){
        $id = (int)$this->_post('id');
        if(!$id){
            $rs = array('success' => false, 'error_msg'=>'秀一秀编号不能为空!');
            die(json_encode($rs));
        }
        $xiulikemodel = D('Xiuuserlike');
        $page = trim($this->_param('page')) ? trim($this->_param('page')) : 1;
        $count_like = D('Xiuuserlike')->alias('a')->field('a.*,b.face')->where(array('a.master_id'=>$id))->join('bao_users b on a.uid = b.user_id','LEFT')->count();
        $count_hf = D('Xiuuserhf')->alias('a')->field('a.*,b.face')->where(array('a.master_id'=>$id))->join('bao_users b on a.uid = b.user_id','LEFT')->count();
        $count_liwu = D('Xiuliwu')->alias('a')->field('a.*,b.face')->where(array('a.master_id'=>$id))->join('bao_users b on a.uid = b.user_id','LEFT')->count();
        $list = $xiulikemodel->alias('a')->field('a.*,UNIX_TIMESTAMP(a.create_time) linux_time,b.nickname,b.face')->where(array('a.master_id'=>$id))
            ->join('bao_users b on a.uid = b.user_id','LEFT')
            ->order(array('a.id' => 'desc'))
            ->page($page.",20")
            ->select();
        $rs = array(
            'success'=>true,
            'list'=>$list,
            'count_like'=>$count_like,
            'count_hf'=>$count_hf,
            'count_liwu'=>$count_liwu,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }

    public function xiu_hf_list(){
        $id = (int)$this->_post('id');
        if(!$id){
            $rs = array('success' => false, 'error_msg'=>'秀一秀编号不能为空!');
            die(json_encode($rs));
        }
        $xiuhfmodel = D('Xiuuserhf');
        $page = trim($this->_param('page')) ? trim($this->_param('page')) : 1;
        $count_like = D('Xiuuserlike')->alias('a')->field('a.*,b.face')->where(array('a.master_id'=>$id))->join('bao_users b on a.uid = b.user_id','LEFT')->count();
        $count_hf = D('Xiuuserhf')->alias('a')->field('a.*,b.face')->where(array('a.master_id'=>$id))->join('bao_users b on a.uid = b.user_id','LEFT')->count();
        $count_liwu = D('Xiuliwu')->alias('a')->field('a.*,b.face')->where(array('a.master_id'=>$id))->join('bao_users b on a.uid = b.user_id','LEFT')->count();
        $list = $xiuhfmodel->alias('a')->field('a.*,UNIX_TIMESTAMP(a.create_time) linux_time,b.nickname,b.face')->where(array('a.master_id'=>$id))
            ->join('bao_users b on a.uid = b.user_id','LEFT')
            ->order(array('a.id' => 'desc'))
            ->page($page.",20")
            ->select();
        $rs = array(
            'success'=>true,
            'list'=>$list,
            'count_like'=>$count_like,
            'count_hf'=>$count_hf,
            'count_liwu'=>$count_liwu,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }

    public function xiu_liwu_list(){
        $id = (int)$this->_post('id');
        if(!$id){
            $rs = array('success' => false, 'error_msg'=>'秀一秀编号不能为空!');
            die(json_encode($rs));
        }
        $xiuliwumodel = D('Xiuliwu');
        $page = trim($this->_param('page')) ? trim($this->_param('page')) : 1;
        $count_like = D('Xiuuserlike')->alias('a')->field('a.*,b.face')->where(array('a.master_id'=>$id))->join('bao_users b on a.uid = b.user_id','LEFT')->count();
        $count_hf = D('Xiuuserhf')->alias('a')->field('a.*,b.face')->where(array('a.master_id'=>$id))->join('bao_users b on a.uid = b.user_id','LEFT')->count();
        $count_liwu = D('Xiuliwu')->alias('a')->field('a.*,b.face')->where(array('a.master_id'=>$id))->join('bao_users b on a.uid = b.user_id','LEFT')->count();
        $list = $xiuliwumodel->alias('a')->field('a.*,UNIX_TIMESTAMP(a.create_time) linux_time,b.nickname,b.face')->where(array('a.master_id'=>$id))
            ->join('bao_users b on a.uid = b.user_id','LEFT')
            ->order(array('a.id' => 'desc'))
            ->page($page.",20")
            ->select();
        $rs = array(
            'success'=>true,
            'list'=>$list,
            'count_like'=>$count_like,
            'count_hf'=>$count_hf,
            'count_liwu'=>$count_liwu,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }

    public function liwu_list(){
        $presentmodel = D('Present');
        $list = $presentmodel->where(array('status'=>1))->select();
        $rs = array(
            'success' => true,
            'list'=>$list,
            'error_msg' => ''
        );
        die(json_encode($rs));
    }

    public function xiu_list4one(){
       /* $xiumodel = D('Xiuuser');
        $page = trim($this->_param('page')) ? trim($this->_param('page')) : 1;

        $uid = (int)$this->_post('uid');
        if(!$uid){
            $rs = array('success' => false, 'error_msg'=>'用户编号不能为空!');
            die(json_encode($rs));
        }
        $list = $xiumodel->alias('a')->field('a.*,b.nickname,b.face')->where(array('a.uid'=>$uid,'a.flag'=>1,'a.closed'=>0))
            ->join('bao_users b on a.uid = b.user_id','LEFT')
            ->order(array('a.id' => 'desc'))
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
                    $list[$k]['files'][]=array('path'=>$v['path'],'flag'=>$v['flag']);
                }
            }
        }*/
        $order = trim($this->_post('order')) ? trim($this->_post('order')) : 1;
        $uid = (int)$this->_post('uid');
        if(!$uid){
            $rs = array('success' => false, 'error_msg'=>'用户编号不能为空!');
            die(json_encode($rs));
        }
        $list = $this->get_xiu_list($order,$uid);

        $rs = array(
            'success'=>true,
            'list'=>$list,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }

    public function xiushop_list4one(){
        $order = trim($this->_post('order')) ? trim($this->_post('order')) : 1;
        $shop_id = (int)$this->_post('shop_id');
        if(!$shop_id){
            $rs = array('success' => false, 'error_msg'=>'商户编号不能为空!');
            die(json_encode($rs));
        }
        $list = $this->get_xiu_list($order,$shop_id);
        $rs = array(
            'success'=>true,
            'list'=>$list,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }

    public function bendi(){
        echo rand(1,2);
/*echo '123';
        //echo shell_exec("id -a");
        @exec("/Users/yangyang/ffmpeg -ss 00:00:00 -i /Users/yangyang/1.MP4 -f mjpeg -y /Users/yangyang/ajk_xiaoqu/yy2.jpg",$r);
        var_dump($r);
        @system("ffmpeg -ss 00:00:00 -i /Users/yangyang/1.MP4 -f mjpeg -y /Users/yangyang/ajk_xiaoqu/yy3.jpg");
        @shell_exec("ffmpeg -ss 00:00:00 -i /Users/yangyang/1.MP4 -f mjpeg -y /Users/yangyang/ajk_xiaoqu/yy4.jpg");
        echo 'yy';*/
    }

    public function get_xf_list_new(){
        $Goodsdianping = D('Goodsdianping');
        $lng = (float)$this->_post('lng');
        $lat = (float)$this->_post('lat');
        $page = $this->_post('page', 'htmlspecialchars')?$this->_post('page', 'htmlspecialchars'):1;
        if(!$lng || !$lat){
            $lat = 31.2383718228;
            $lng = 121.3301816158;
        }
        $lat_lng = gcjTObd($lat,$lng);
        $lat = $lat_lng['lat'];
        $lng = $lat_lng['lng'];
        $list = $Goodsdianping->get_xf_list($page,$lat,$lng);
        /*$map = array('closed' => 0, 'user_id' => $this->app_uid);
        $list = $Goodsdianping->field('*,FROM_UNIXTIME(create_time) AS cdate')->where($map)->order(array('create_time' => 'desc'))->page($page.',10')->select();*/
        foreach ($list as $k => $val) {
            $user_ids[$val['user_id']] = $val['user_id'];
            $users= D('Users')->itemsByIds($user_ids);
            $list[$k]['username']=$users[$val['user_id']]['nickname'];
            $list[$k]['rank_id']=$users[$val['user_id']]['rank_id'];
            $list[$k]['face']=$users[$val['user_id']]['face'];
            $shop_info =D('Shop')->find(array("where" => array('shop_id' => $val['shop_id'])));
            $list[$k]['shop_name']=$shop_info['shop_name'];
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
}