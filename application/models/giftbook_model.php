<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of giftbook_model
 *
 * @author pbchen
 */
class giftbook_model extends CI_Model {

    private $_giftbook_tb = '`gift_management`.`gift_book`';

    //商品状态
    private $_giftbook_status = array(
        '1' => '启用',
        '2' => '停用'
    );
    //商品组合形式
    private $_giftbook_type = array(
        '1' => '普通卡',
        '2' => '年卡',
        '3' => '半年卡',
        '4' => '季卡',
    );

    function __construct() {
        $this->load->model('media_model');
        $this->load->model('bookgoods_model');
        parent::__construct();
    }

    /**
     * 获取商品参数
     * @return type
     */
    public function get_giftbook_params() {
        $data['name'] = $this->input->post('name');
        $data['type_id'] = $this->input->post('type');
        $data['group_ids'] = $this->input->post('gift_ids');
        $data['sale_price'] = $this->input->post('price');
        $data['theme_id'] = $this->input->post('theme');
        $data['set_id'] = $this->input->post('set');
        $data['pic_id'] = $this->input->post('pic_id');
        $data['describe'] = $this->input->post('desciption');
        $data['remark'] = $this->input->post('remark');
        return $data;
    }

    /**
     * 获取列表条件
     * @return type
     */
    public function get_giftbook_page_where() {
        $cwhere = array();
        if (isset($_REQUEST['id']) && $_REQUEST['id'] != 0) {
            $cwhere['`gift_book`.`id`'] = $_REQUEST['id'];
        }
        if (isset($_REQUEST['name']) && $_REQUEST['name'] != '') {
            $cwhere['`gift_book`.`name` LIKE '] = '%' . $_REQUEST['name'] . '%';
        }
        if (isset($_REQUEST['status']) && $_REQUEST['status'] != 0) {
            $cwhere['`gift_book`.`status`'] = $_REQUEST['status'];
        }
        if (isset($_REQUEST['type']) && $_REQUEST['type'] != 0) {
            $cwhere['`gift_book`.`type_id`'] = $_REQUEST['type'];
        }
        if (isset($_REQUEST['theme']) && $_REQUEST['theme'] != 0) {
            $cwhere['`gift_book`.`theme_id`'] = $_REQUEST['theme'];
        }
        if (isset($_REQUEST['set']) && $_REQUEST['set'] != 0) {
            $cwhere['`gift_book`.`set_id`'] = $_REQUEST['set'];
        }
        return $cwhere;
    }

    /**
     * 商品分页列
     */
    private function _giftbook_page_cols() {

        return $cols = array('`gift_book`.`id` AS `id`', '`gift_book`.`name` AS `name`'
            , '`gift_book`.`sale_price` AS `price`','`gift_book`.`type_id` AS `type`','`gift_book`.`status`'
            , '`theme`.`name` AS `theme`', '`set`.`name` AS `set`'
            ,'SUM(`book_goods_mapping`.`gift_num`) AS `goods_num`'
        );
    }

    /**
     * 获取商品分页数据
     * @param type $dtparser datatable类库
     */
    public function giftbook_page_data($dtparser) {
        $cols = $this->_giftbook_page_cols();
        $sort_cols = array('7' => '`goods_num`');
        $filter_cols = array();
        $goup_by = array('`gift_book`.`id`');
        //查询主表
        $dtparser->select($cols, $sort_cols, $filter_cols, FALSE);
        $dtparser->from($this->_giftbook_tb);
        $dtparser->join('`gift_management`.`theme`', 'theme.id=gift_book.theme_id', 'left');
        $dtparser->join('`gift_management`.`set`', 'set.id=gift_book.set_id', 'left');
        $dtparser->join('`gift_management`.`book_goods_mapping`', 'book_goods_mapping.gift_book_id=gift_book.id', 'left');
        //条件
        $cwhere = $this->get_giftbook_page_where();
        $d['code'] = 0;
        $d['iTotal'] = 0;
        $d['iFilteredTotal'] = 0;
        $d['aaData'] = array();
        if ($d['code'] == 0) {
            $d['iTotal'] = $dtparser->count_group($goup_by,$cwhere);
            $d['iFilteredTotal'] = $d['iTotal'];
            $query = $dtparser->get_group($goup_by,$cwhere);
            $arr = $query->result_array();
            $this->ajax_giftbook_list_table_data($arr);
            $d['aaData'] = $arr;
        }
        return $d;
    }

    /**
     * 导出商品
     * @return type
     */
    public function download_giftbook_data() {
        $cols = $this->_giftbook_page_cols();
        $cwhere = $this->get_giftbook_page_where();
        $this->db->select($cols);
        $this->db->from($this->_giftbook_tb);
        $this->db->join('`gift_management`.`gift_brand`', 'gift_brand.id=gift.brand_id', 'left');
        $this->db->join('`gift_management`.`gift_classify`', 'gift_classify.id=gift.classify_id', 'left');
        $this->db->join('`gift_management`.`gift_supply`', 'gift_supply.id=gift.supply_id', 'left');
        if ($cwhere) {
            $this->db->where($cwhere);
        }
        $query = $this->db->get();
        $arr = $query->result_array();
        $this->ajax_giftbook_list_table_data($arr);
        $fun = function(&$val, $k) {
            if (isset($val['checkbox'])) {
                unset($val['checkbox']);
            }
            if (isset($val['oper'])) {
                unset($val['oper']);
            }
        };
        array_walk($arr, $fun);
        return $arr;
    }

    /**
     * 获取商品库存
     * @param type $good_ids
     * @return type
     */
    public function get_giftbook_num($giftbook_ids) {
        $this->db->select('store_num,id')->from($this->_giftbook_tb);
        $this->db->where_in('id', $giftbook_ids);
        $query = $this->db->get();
        $giftbook_num = array();
        foreach ($query->result() as $row) {
            $giftbook_num[$row->id] = $row->store_num;
        }
        return $giftbook_num;
    }
    
    /**
     * 添加或修改礼册商品数量
     * @param type $giftbook_id
     * @param type $group_ids
     * @return type
     */
    public function book_goods_num($giftbook_id,$group_ids){
        $aff_row = 0;
        $group_id_arr = explode(',', $group_ids);
        $data = array();
        foreach ($group_id_arr as $g){
            if( ! $g )  continue;
            $g_info = explode('*', $g);
            $num = isset($g_info[1])?$g_info[1]:1;
            $data[] = array(
                'gift_book_id'=>$giftbook_id,
                'gift_id'=>$g_info[0],
                'gift_num'=>$num,
                'ctime'=>  date('Y-m-d H:i:s')
            );
        }
        foreach ($data as $d){
            $aff_row += $this->bookgoods_model->replace_into_bg($d);
        }
        return $aff_row;
    }

    /**
     * 添加商品
     * @param type $giftbook_info
     * @return type
     */
    public function add_giftbook($giftbook_info) {
        $this->db->insert($this->_giftbook_tb, $giftbook_info);
        return $this->db->insert_id();
    }

    /**
     * 获取商品信息
     * @param type $where
     */
    public function get_giftbook_info($where = array()) {
        $this->db->select('*')->from($this->_giftbook_tb);
        if ($where) {
            $this->db->where($where);
        }
        $query = $this->db->get();
        $res = $query->result_array();
        foreach ($res as &$value) {
            $value['pic_id'] = $this->media_model->get_media(array(),array('id'=>explode(',',$value['pic_id'])));
        }
        return $res;
    }

    /**
     * 更新商品信息
     * @param array $updata
     * @param type $where
     * @param type $where_in
     * @return type
     */
    public function update_giftbook_info($updata, $where = array(),$where_in=array()) {
        if ($where) {
            $this->db->where($where);
        }
        if($where_in){
            $this->db->where_in('id',$where_in);
        }
        $this->db->update($this->_giftbook_tb, $updata);
        return $this->db->affected_rows();
    }

    /**
     * 转化前端datatable要求的样式
     * @param type $pageData
     */
    public function ajax_giftbook_list_table_data(&$pageData) {
        foreach ($pageData as &$v) {
            $v['checkbox'] = "<input name='row_sel' type='checkbox' id='{$v['id']}'>";
            $v['oper'] = "<a rel='{$v['id']}'class='edit oper'href='/giftbook_manage/edit_giftbook?id={$v['id']}'>编辑</a>";
            //$v['oper'] .= "<a rel='{$v['id']}'class='minus oper'>&nbsp;&nbsp;&nbsp;出库</a>";
            //$v['oper'] .= "<a rel='{$v['id']}'class='add oper'>&nbsp;&nbsp;&nbsp;入库</a>";
            $v['status'] = isset($this->_giftbook_status[$v['status']]) ? $this->_giftbook_status[$v['status']] : '';
            $v['type'] = isset($this->_giftbook_type[$v['type']]) ? $this->_giftbook_type[$v['type']] : '';
            $v['goods_num'] = $v['goods_num']? $v['goods_num']:0;
        }
    }

    /**
     * 通过字段值条件获取商品
     * @param type $col_name
     * @param type $val_arr
     */
    public function get_giftbook_groupby_col($col_name, $val_arr) {
        $cols = array('count(*) as `num`', $col_name);
        $this->db->select($cols)->from($this->_giftbook_tb);
        $this->db->where_in($col_name, $val_arr);
        $this->db->group_by($col_name);
        $query = $this->db->get();
        $result = array();
        foreach ($query->result() as $row) {
            $result[$row->$col_name] = $row->num;
        }
        return $result;
    }

}
