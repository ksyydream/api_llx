<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/11
 * Time: 16:21
 */
class UsergoodModel extends CommonModel
{
    protected $pk = 'id';
    protected $tableName = 'user_good';

    public function check($goods_id, $user_id)
    {
        $data = $this->find(array('where' => array('good_id' => (int)$goods_id, 'uid' => (int)$user_id)));
        return $this->_format($data);
    }
}