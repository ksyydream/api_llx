<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 17/2/6
 * Time: 下午1:29
 */

class XlkdetailModel extends CommonModel{
    protected $pk   = 'id';
    protected $tableName =  'xlk_detail';

    protected $id = 0;

    public function get_list($uid,$page=1){
        $list = $this->alias('a')->field('a.*,b.title,c.shop_name')
            ->join('bao_xlk_master b on a.master_id = b.id','LEFT')
            ->join('bao_shop c on b.shop_id = c.shop_id','LEFT')
            ->where(array('a.flag'=>2,'a.uid'=>$uid))
            ->order(array('a.used_time' => 'asc'))->page($page.',10')->select();
        return $list;
    }
}