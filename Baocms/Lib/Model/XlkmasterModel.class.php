<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 17/2/6
 * Time: 下午1:29
 */

class XlkmasterModel extends CommonModel{
    protected $pk   = 'id';
    protected $tableName =  'xlk_master';

    protected $id = 0;
    public function add_used($id){
        $this->where(array('id'=>$id))->setInc('used_num',1);
    }
}