<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/20
 * Time: 11:03
 */
class XiupublicAction extends CommonAction {

    public function xiu_list_all(){
        $xiumodel = D('Xiuuser');
        $page = trim($this->_param('page')) ? trim($this->_param('page')) : 1;
        $list = $xiumodel->alias('a')->field('a.*,b.nickname,b.face')->where(array('a.flag'=>1))
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
        }

        $rs = array(
            'success'=>true,
            'list'=>$list,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }

    public function xiushop_list_all(){
        $xiumodel = D('Xiuuser');
        $page = trim($this->_param('page')) ? trim($this->_param('page')) : 1;
        $list = $xiumodel->alias('a')->field('a.*,b.shop_name,b.logo')->where(array('a.flag'=>2))
            ->join('bao_shop b on a.shop_id = b.shop_id','LEFT')
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
        }

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
        $list = $xiulikemodel->alias('a')->field('a.*,b.nickname,b.face')->where(array('a.master_id'=>$id))
            ->join('bao_users b on a.uid = b.user_id','LEFT')
            ->order(array('a.id' => 'asc'))
            ->page($page.",20")
            ->select();
        $rs = array(
            'success'=>true,
            'list'=>$list,
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
        $list = $xiuhfmodel->alias('a')->field('a.*,b.nickname,b.face')->where(array('a.master_id'=>$id))
            ->join('bao_users b on a.uid = b.user_id','LEFT')
            ->order(array('a.id' => 'asc'))
            ->page($page.",20")
            ->select();
        $rs = array(
            'success'=>true,
            'list'=>$list,
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

}