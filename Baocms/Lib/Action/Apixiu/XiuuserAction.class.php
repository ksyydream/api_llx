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
        $xiumodel = D('Xiuuser');
        $page = trim($this->_param('page')) ? trim($this->_param('page')) : 1;
        $list = $xiumodel->alias('a')->field('a.*,b.nickname,b.face')->where(array('a.uid'=>$this->app_uid,'a.flag'=>1))
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
        }
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
        $xiu = D('Xiuuser')->where(array('id'=>$xiu_id,'flag'=>1))->find();
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

        D('Users')->addIntegral($this->app_uid,0 - $liwu['price'],"购买礼物[{$liwu['name']}],使用秀币");
        if($liwu['price'] < $liwu['get_price']){
            D('Users')->addIntegral($xiu['uid'],$liwu['price'],"收到礼物[{$liwu['name']}],得到秀币");
        }else{
            D('Users')->addIntegral($xiu['uid'],$liwu['get_price'],"收到礼物[{$liwu['name']}],得到秀币");
        }

        //增加秀一秀的礼物数量
        D('Xiuuser')->where(array('id'=>$xiu_id))->setInc('liwu_count',1);
        //增加礼物的销量
        D('Present')->where(array('id'=>$liwu_id))->setInc('count',1);
        $rs = array('success' => true, 'error_msg' =>'');
        $this->ajaxReturn($rs,'JSON');
    }
}