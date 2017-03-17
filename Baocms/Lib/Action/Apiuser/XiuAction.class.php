<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/20
 * Time: 11:03
 */
class XiuAction extends CommonAction {

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
        die(var_dump($photos));
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

    public function xiu_list_all(){
        $xiumodel = D('Xiuuser');
        $page = trim($this->_param('page')) ? trim($this->_param('page')) : 1;
        $list = $xiumodel->where(array('flag'=>1))
            ->order(array('id' => 'desc'))
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
        }

        $rs = array(
            'success'=>true,
            'list'=>$list,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }

    public function xiu_list_self(){
        $xiumodel = D('Xiuuser');
        $page = trim($this->_param('page')) ? trim($this->_param('page')) : 1;
        $list = $xiumodel->where(array('uid'=>$this->app_uid,'flag'=>1))
            ->order(array('id' => 'desc'))
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

    public function xiu_like_list(){
        $id = (int)$this->_post('id');
        if(!$id){
            $rs = array('success' => false, 'error_msg'=>'秀一秀编号不能为空!');
            die(json_encode($rs));
        }
        $xiulikemodel = D('Xiuuserlike');
        $page = trim($this->_param('page')) ? trim($this->_param('page')) : 1;
        $list = $xiulikemodel->alias('a')->field('a.*,b.nickname,b.face')->where(array('a.master_id'=>$id))
            ->join('bao_users b on a.uid = b.user_id','LEFT')
            ->order(array('a.id' => 'asc'))
            ->page($page.",10")
            ->select();
        $rs = array(
            'success'=>true,
            'list'=>$list,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }
}