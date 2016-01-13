<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of website_model
 * website 管理
 */
class website_model extends CI_Model {

    private $_website_tb = '`gift_management`.`website`';
    private $_website_status = array(
        '1' => '启用',
        '2' => '停用'
    );
    private $_website_type = array(
        '1' => '兑换网站',
        '2' => '礼册商城'
    );

    function __construct() {
        $this->load->model('media_model');
        parent::__construct();
    }

    /**
     * 获取客户参数
     * @return data
     */
    public function get_website_params() {
        $data['name'] = $this->input->post('name');
        $data['type'] = $this->input->post('type');
        $data['domain'] = $this->input->post('domain');
        $data['hotline'] = $this->input->post('hotline');
        $data['qq'] = $this->input->post('qq');
        $data['expire_date'] = $this->input->post('expire_date');
        $expire_date = $this->input->post('expire_date');
        $data['expire_date'] = date('Y-m-d', strtotime($expire_date));
        //$date['expire_date']=date('Y-m-d', mktime(0,0,0,  int(substr($expire_date, 4,2)),int(substr($expire_date, 6,2)),int(substr($expire_date, 0,4))));
        $data['pic_id'] = $this->input->post('pic_id');
        $data['description'] = $this->input->post('description');
        $data['remark'] = $this->input->post('remark');
        return $data;
    }

    /**
     * 状态
     * @return type
     */
    public function get_website_status() {
        return $this->_website_status;
    }

    /*
     * 获取website信息
     */

    public function get_website($where) {
        $this->db->select('*')->from($this->_website_tb);
        $this->db->where($where);
        $query = $this->db->get();
        $res = $query->result_array();       
        foreach ($res as &$value) {
            $value['pic_ids'] = $this->media_model->get_media(array(),array('id'=>explode(',',$value['pic_id'])));
        }
        return $res;
    }

    /*
     * 更新website
     */

    public function update_website_info($updata, $where = array()) {
        if ($where) {
            $this->db->where($where);
        }
        $this->db->update($this->_website_tb, $updata);
        return $this->db->affected_rows();
    }

    /*
     * 更新状态
     */

    public function update_status($updata, $where = array()) {
        if ($where) {
            $this->db->where_in('id', $where);
        }
        $this->db->update($this->_website_tb, $updata);
        return $this->db->affected_rows();
    }

    /**
     * 获取列表条件
     * @return type
     */
    public function get_website_page_where() {
        $cwhere = array();
        if (isset($_REQUEST['id']) && $_REQUEST['id'] != 0) {
            $cwhere['`website`.`id`'] = $_REQUEST['id'];
        }
        if (isset($_REQUEST['name']) && $_REQUEST['name'] != '') {
            $cwhere['`website`.`name` LIKE '] = '%' . $_REQUEST['name'] . '%';
        }
        if (isset($_REQUEST['domain']) && $_REQUEST['domain'] != '') {
            $cwhere['`website`.`domain` LIKE '] = '%' . $_REQUEST['domain'] . '%';
        }
        if (isset($_REQUEST['type']) && $_REQUEST['type'] != 0) {
            $cwhere['`website`.`type`'] = $_REQUEST['type'];
        }
        if (isset($_REQUEST['status']) && $_REQUEST['status'] != 0) {
            $cwhere['`website`.`status`'] = $_REQUEST['status'];
        }
        return $cwhere;
    }

    /**
     * 添加网站
     * @param type $goods_info
     * @return type
     */
    public function add_website($website_info) {
        $this->db->insert($this->_website_tb, $website_info);
        return $this->db->insert_id();
    }

    /**
     * 获取客户分页数据
     * @param type $dtparser datatable类库
     */
    public function website_page_data($dtparser) {
        $cols = array('`website`.`id`', '`website`.`name`', '`website`.`status`'
            , '`website`.`type`', '`website`.`hotline`', '`website`.`qq`', '`website`.`expire_date`', '`website`.`domain`');
        $sort_cols = array('4' => '`website`.`status`');
        $filter_cols = array();
        //查询主表
        $dtparser->select($cols, $sort_cols, $filter_cols, FALSE);
        $dtparser->from($this->_website_tb);
        //条件
        $cwhere = $this->get_website_page_where();
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
            $v['oper'] = "<a rel='{$v['id']}'class='edit oper' href='/website_manage/edit_website?id={$v['id']}'>编辑</a>";
            $v['status'] = isset($this->_website_status[$v['status']]) ? $this->_website_status[$v['status']] : '';
            $v['type'] = isset($this->_website_type[$v['type']]) ? $this->_website_type[$v['type']] : '';
        }
    }

}
