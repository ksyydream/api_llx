<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/20
 * Time: 11:03
 */
class XiushopAction extends XiuuserAction {
    protected $shop_id = 0;
    protected $shop = array();
    protected function _initialize(){
        parent::_initialize();
        $this->shop = D('Shop')->find(array("where" => array('user_id' => $this->app_uid, 'closed' => 0, 'audit' => 1)));
        if (empty($this->shop)) {
            $rs = array(
                'success' => false,
                'error_msg'=>'该用户没有开通商户!'
            );
            die(json_encode($rs));
        }
        $this->shop_id = $this->shop['shop_id']; //为了程序调用的时候方便
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
            'flag'=>2,
            'shop_id'=>$this->shop_id
        );

        $master_id = D('Xiuuser')->add($data);

        if($photos){
            foreach($photos as $file){
                if(file_exists(BASE_PATH.'/attachs/'.$file) and $file){
                    $path_data = array(
                        'master_id'=>$master_id,
                        'path'=>$file
                    );
                    $file_path = pathinfo(BASE_PATH.'/attachs/'.$file);
                    $f_extension = isset($file_path['extension'])?$file_path['extension']:'';
                    $f_extension_old = $f_extension;
                    $f_extension = strtolower($f_extension);
                    if($f_extension=='mp4' or $f_extension=='avi' or $f_extension=='3gp' or $f_extension=='wmv'){
                        $path_data['flag']=2;
                        $sp_path = BASE_PATH.'/attachs/'.$file;
                        $sp_logo = str_replace('.'.$f_extension_old,'',$file);
                        $sp_logo = $sp_logo."_logo".date('YmdHis').".jpg";
                        $sp_path_logo = BASE_PATH.'/attachs/'.$sp_logo;
                        @exec("ffmpeg -ss 00:00:00 -i {$sp_path} -f mjpeg -y {$sp_path_logo}");
                        if(file_exists(BASE_PATH.'/attachs/'.$sp_logo)){
                            $path_data['path_logo']=$sp_logo;
                        }else{
                            $path_data['path_logo']='xiaoxiong.jpg';
                        }
                    }else{
                        $path_data['flag']=1;
                        $path_data['path_logo']=$file;
                    }
                   D('Xiuuserfile')->add($path_data);
                }
            }
        }

        $rs = array('success' => true, 'error_msg' =>'','xiuuser_id'=>$master_id);
        $this->ajaxReturn($rs,'JSON');

    }

    public function xiushop_list_self(){
        /*$xiumodel = D('Xiuuser');
        $page = trim($this->_param('page')) ? trim($this->_param('page')) : 1;
        $list = $xiumodel->alias('a')->field('a.*,b.shop_name,b.logo')->where(array('a.uid'=>$this->app_uid,'a.flag'=>2,'a.closed'=>0))
            ->join('bao_shop b on a.shop_id = b.shop_id','LEFT')
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
        $list = $this->get_xiushop_list_new($order,$this->shop_id);
        $rs = array(
            'success'=>true,
            'list'=>$list,
            'error_msg'=>''
        );
        $this->ajaxReturn($rs,'JSON');
    }
}