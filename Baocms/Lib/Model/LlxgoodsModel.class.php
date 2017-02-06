<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 17/2/6
 * Time: 下午1:29
 */

class LlxgoodsModel extends CommonModel{
    protected $pk   = 'goods_id';
    protected $tableName =  'llx_goods';

    protected $id = 0;


    public function  goods_list($page){
        $Model = new Model();
        $map =array('audit'=>1,'closed'=>0,'end_date'=> array('egt', TODAY));
        $items = $Model->table('bao_llx_goods')
            ->field("*")
            ->where($map)
            ->order(array('goods_id' => 'desc'))
            ->page("{$page},10")
            ->select();
        return $items;
    }

    public function unlock(){
        return $this->delete($this->id);
    }
}