<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of wechat_model
 * wechat 管理
 */
class wechat_model extends CI_Model {

    private $_wechat_tb = '`gift_management`.`wechat`';
    private $_wechat_status = array(
        '1' => '启用',
        '2' => '停用'
    );
    private $_wechat_style = array(
        '1' => '样式1',
        '2' => '样式2',
        '3' => '样式3'
    );

    function __construct() {
        parent::__construct();
    }

    /**
     * 获取客户参数
     * @return data
     */
    public function get_wechat_params() {
        $data['name'] = $this->input->post('name');
        $data['style'] = $this->input->post('style');
        $data['vedio_id'] = $this->input->post('vedio_id');
        $data['pic_id'] = $this->input->post('pic_id');
        $data['audio_id'] = $this->input->post('audio_id');
        $data['sender'] = $this->input->post('sender');
        $data['reciver'] = $this->input->post('reciver');
        $data['copywriter'] = $this->input->post('copywriter');
        $data['remark'] = $this->input->post('remark');
        return $data;
    }

    public function get_wechat($where) {
        $this->db->select('*')->from($this->_wechat_tb);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();
    }

    /*
     * 更新wechat
     */

    public function update_wechat_info($updata, $where = array()) {
        if ($where) {
            $this->db->where($where);
        }
        $this->db->update($this->_wechat_tb, $updata);
        return $this->db->affected_rows();
    }

    /*
     * 更新状态
     */

    public function update_status($updata, $where = array()) {
        if ($where) {
            $this->db->where_in('id', $where);
        }
        $this->db->update($this->_wechat_tb, $updata);
        return $this->db->affected_rows();
    }

    /**
     * 获取列表条件
     * @return type
     */
    public function get_wechat_page_where() {
        $cwhere = array();
        if (isset($_REQUEST['id']) && $_REQUEST['id'] != 0) {
            $cwhere['`wechat`.`id`'] = $_REQUEST['id'];
        }
        if (isset($_REQUEST['name']) && $_REQUEST['name'] != '') {
            $cwhere['`wechat`.`name` LIKE '] = '%' . $_REQUEST['name'] . '%';
        }
        if (isset($_REQUEST['style']) && $_REQUEST['style'] != 0) {
            $cwhere['`wechat`.`style`'] = $_REQUEST['style'];
        }
        if (isset($_REQUEST['status']) && $_REQUEST['status'] != 0) {
            $cwhere['`wechat`.`status`'] = $_REQUEST['status'];
        }
        return $cwhere;
    }

    /**
     * 添加微信模版
     * @param type $goods_info
     * @return type
     */
    public function add_wechat($wechat_info) {
        $this->db->insert($this->_wechat_tb, $wechat_info);
        return $this->db->insert_id();
    }

    /**
     * 获取客户分页数据
     * @param type $dtparser datatable类库
     */
    public function wechat_page_data($dtparser) {
        $cols = array('`wechat`.`id`', '`wechat`.`name`', '`wechat`.`style`', '`wechat`.`status`'
            , '`wechat`.`vedio_id`', '`wechat`.`pic_id`', '`wechat`.`audio_id`', '`wechat`.`sender`'
            , '`wechat`.`reciver`', '`wechat`.`remark`', '`wechat`.`copywriter`');
        $sort_cols = array('4' => '`wechat`.`status`');
        $filter_cols = array();
        //查询主表
        $dtparser->select($cols, $sort_cols, $filter_cols, FALSE);
        $dtparser->from($this->_wechat_tb);
        //条件
        $cwhere = $this->get_wechat_page_where();
        $d['code'] = 0;
        $d['iTotal'] = 0;
        $d['iFilteredTotal'] = 0;
        $d['aaData'] = array();
        if ($d['code'] == 0) {
            $d['iTotal'] = $dtparser->count($cwhere);
            $d['iFilteredTotal'] = $d['iTotal'];
            $query = $dtparser->get($cwhere);
            $arr = $query->result_array();
            $this->ajax_list_table_data($arr);
            $d['aaData'] = $arr;
        }
        return $d;
    }

    /**
     * 转化前端datatable要求的样式
     * @param type $pageData
     */
    public function ajax_list_table_data(&$pageData) {
        foreach ($pageData as &$v) {
            $v['checkbox'] = "<input name='row_sel' type='checkbox' id='{$v['id']}'>";
            $v['oper'] = "<a rel='{$v['id']}'class='edit oper' href='/wechat_manage/edit_wechat?id={$v['id']}'>编辑</a>";
            //$v['oper'] .= "<a rel='{$v['id']}'class='load oper'>&nbsp;&nbsp;&nbsp;导入</a>";
            $v['status'] = isset($this->_wechat_status[$v['status']]) ? $this->_wechat_status[$v['status']] : '';
            $v['style'] = isset($this->_wechat_style[$v['style']]) ? $this->_wechat_style[$v['style']] : '';
        }
    }

}
