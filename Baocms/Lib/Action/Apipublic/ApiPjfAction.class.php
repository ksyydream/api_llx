<?php
/**
 * Created by PhpStorm.
 * User: yangyang
 * Date: 16/11/3
 * Time: 上午11:15
 */
class ApiPjfAction extends CommonAction{

    public function goodsdetail(){
        try{
            $goods_id = trim($this->_param('goods_id'))?trim($this->_param('goods_id')):0;
            $goods_id = (int)$goods_id;
            if (empty($goods_id)) {
                $rs = array(
                    'success' => false,
                    'error_msg'=>'商品不存在!'
                );
                die(json_encode($rs));
            }
            if (!($detail = D('Llxgoods')->find($goods_id))) {
                $rs = array(
                    'success' => false,
                    'error_msg'=>'商品不存在!'
                );
                die(json_encode($rs));
            }
            if ($detail['closed'] != 0 || $detail['audit'] != 1) {
                $rs = array(
                    'success' => false,
                    'error_msg'=>'商品不存在!'
                );
                die(json_encode($rs));
            }
           // $shop_id = $detail['shop_id'];

            //$recom = D('Llxgoods')->where(array('shop_id' => $shop_id,'audit'=>1,'closed'=>0,'goods_id' => array('neq', $goods_id),'end_date'=> array('egt', TODAY)))->select();

           // $json_pingnum = D('Goodsdianping')->where(array('goods_id' => $goods_id, 'show_date' => array('ELT', TODAY)))->count();

           /* $score = (int) D('Goodsdianping')->where(array('goods_id' => $goods_id))->avg('score');
            if ($score == 0) {
                $score = 5;
            }*/
            if(($detail['is_vs1'] || $detail['is_vs2'] || $detail['is_vs3'] || $detail['is_vs4'] || $detail['is_vs5'] || $detail['is_vs6']) ==1 ){
                $this->assign('is_vs', $is_vs = 1);
            }else{
                $this->assign('is_vs', $is_vs = 0);
            }
            $json_pics = D('Llxgoodsphoto')->getPics($detail['goods_id']);
            $rs = array(
                'success' => true,
                'error_msg'=>'',
                //'recom'=> $recom,
                'detail'=>$detail,
                //'shop'=>$json_shop,
               //'pingnum'=>$json_pingnum,
                //'score'=>$score,
                'is_vs'=>$is_vs,
                'pics'=>$json_pics,
                'instructions'=>strip_tags($detail['instructions'])
            );
            die(json_encode($rs));
        }catch(Exception $e) {
            $rs = array(
                'success' => false,
                'error_msg'=>'获取数据失败!'
            );
            die(json_encode($rs));
        }
    }

    public function goods_list(){
        $page = trim($this->_param('page')) ? trim($this->_param('page')) : 1;
        $recom = D('Llxgoods')->goods_list($page);
        $rs = array(
            'success' => true,
            'error_msg'=>'',
            'goods_list'=> $recom
        );
        die(json_encode($rs));
    }

    public function hot_goods(){
        /*$shop_id = trim($this->_param('shop_id'))?trim($this->_param('shop_id')):0;
        $shop_id = (int)$shop_id;
        if (empty($shop_id)) {
            $rs = array(
                'success' => false,
                'error_msg'=>'商铺不存在!'
            );
            die(json_encode($rs));
        }
        $recom = D('Goods')->where(array('shop_id' => $shop_id,'audit'=>1,'closed'=>0,'end_date'=> array('egt', TODAY)))
            ->order('sold_num desc')
            ->limit(2)
            ->select();
        $rs = array(
            'success' => true,
            'error_msg'=>'',
            'goods_list'=> $recom
        );
        die(json_encode($rs));*/
    }
}