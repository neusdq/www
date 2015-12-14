<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of order_model
 *
 * @author pbchen
 */
class order_model extends CI_Model {

    private $_order_tb = '`gift_management`.`change_order`';
    private $_eorder_tb = '`gift_management`.`entity_order`';
    private $_eorder_book_map_tb = '`gift_management`.`entity_order_book_map`';
    private $_order_gift_card = '`gift_management`.`gift_card`';
    private $_view_book_gift_tb = '`gift_management`.`view_book_gift`';
    private $_view_order_gift_card_tb = '`gift_management`.`view_order_gift_card`';
    private $_view_eorder_customer_user_tb = '`gift_management`.`view_eorder_customer_user`';

    const MEDIA_START_STATUS = 1;
    const MEDIA_STOP_STATUS = 2;

    private $_order_status = array(
        '1' => '启用',
        '2' => '停用'
    );
    private $_eorder_status = array(
        '1' => '未付款',
        '2' => '已付款'
    );
    private $_order_source = array(
        '1' => '电话',
        '2' => '微信',
        '3' => '蓝卡官网'
    );

    function __construct() {
        parent::__construct();
    }

    public function check_cardauth($numcode, $password) {
        $query = $this->db->query("SELECT num_code,password FROM gift_management.gift_card  where num_code='" . $numcode . "' and password='" . $password . "'");

        $row = $query->row();

        $result = FALSE;
        if (isset($row)) {
            $result = TRUE;
        }
        return $result;
    }

    public function get_card_info($numcode) {
        $query = $this->db->query("SELECT a.num_code,a.expire_date,b.id book_id,b.name book_name,b.sale_price FROM gift_management.gift_card a join gift_management.gift_book b on a.book_id=b.id  where num_code='" . $numcode . "'");

        $row = $query->row();
        $data['num_code'] = $row->num_code;
        $data['expire_date'] = $row->expire_date;
        $data['book_id'] = $row->book_id;
        $data['book_name'] = $row->book_name;
        $data['sale_price'] = $row->sale_price;
        return $data;
    }

    public function get_order_params() {
        $data['card_num'] = $this->input->post('card_num');
        $data['gift_id'] = $this->input->post('gift_id');
        $data['customer_name'] = $this->input->post('customer_name');
        $data['phone'] = $this->input->post('phone');
        $data['address'] = $this->input->post('address');
        $data['postcode'] = $this->input->post('postcode');
        $data['deliver_id'] = $this->input->post('deliver_id');
        $deliver_date = $this->input->post('deliver_date');
        $data['deliver_date'] = date('Y-m-d', strtotime($deliver_date));
        $data['remark'] = $this->input->post('remark');
        return $data;
    }

    public function add_order($order_info) {
        $this->db->insert($this->_order_tb, $order_info);
        return $this->db->insert_id();
    }

    /**
     * 获取上传资源信息
     * @param type $where
     * @param type $where_in
     * @return type
     */
    public function get_order($where = array(), $where_in = array()) {
        $this->db->select('*')->from($this->_order_tb);
        if ($where) {
            $this->db->where($where);
        }
        if ($where_in) {
            foreach ($where_in as $k => $v) {
                $this->db->where_in($k, $v);
            }
        }
        return $this->db->get()->result_array();
    }

    public function gift_page_data($dtparser) {
        $cols = array('`view_book_gift`.`gift_id`', '`view_book_gift`.`gift_name`', '`view_book_gift`.`book_id`',
            '`view_book_gift`.`sale_price`', '`view_book_gift`.`store_num`', '`view_book_gift`.`sold_num`');
        $sort_cols = array('4' => '`view_book_gift`.`gift_id`');
        $filter_cols = array();
        //查询主表
        $dtparser->select($cols, $sort_cols, $filter_cols, FALSE);
        $dtparser->from($this->_view_book_gift_tb);
        //条件
        $cwhere = array();
        $d['code'] = 0;
        $d['iTotal'] = 0;
        $d['iFilteredTotal'] = 0;
        $d['aaData'] = array();
        if ($d['code'] == 0) {
            $d['iTotal'] = $dtparser->count($cwhere);
            $d['iFilteredTotal'] = $d['iTotal'];
            $query = $dtparser->get($cwhere);
            $arr = $query->result_array();
            foreach ($arr as &$v) {
                $v['checkbox'] = "<input name='row_sel' type='checkbox' id='{$v['gift_id']}'>";
            }
            $d['aaData'] = $arr;
        }
        return $d;
    }

    public function order_page_data($dtparser) {
        $cols = array('`view_order_gift_card`.`id`', '`view_order_gift_card`.`deliver_num`', '`view_order_gift_card`.`deliver_id`', '`view_order_gift_card`.`gift_name`'
            , '`view_order_gift_card`.`customer_name`', '`view_order_gift_card`.`phone`', '`view_order_gift_card`.`address`'
            , '`view_order_gift_card`.`status`'
            , '`view_order_gift_card`.`order_source`');
        $sort_cols = array('4' => '`view_order_gift_card`.`status`');
        $filter_cols = array();
        //查询主表
        $dtparser->select($cols, $sort_cols, $filter_cols, FALSE);
        $dtparser->from($this->_view_order_gift_card_tb);
        //条件
        $cwhere = $this->get_order_page_where();
        $d['code'] = 0;
        $d['iTotal'] = 0;
        $d['iFilteredTotal'] = 0;
        $d['aaData'] = array();
        if ($d['code'] == 0) {
            $d['iTotal'] = $dtparser->count($cwhere);
            $d['iFilteredTotal'] = $d['iTotal'];
            $query = $dtparser->get($cwhere);
            $arr = $query->result_array();
            $this->ajax_orderlist_table_data($arr);
            $d['aaData'] = $arr;
        }
        return $d;
    }

    public function ajax_orderlist_table_data(&$pageData) {
        foreach ($pageData as &$v) {
            $v['checkbox'] = "<input name='row_sel' type='checkbox' id='{$v['id']}'>";
            $v['oper'] = "<a rel='{$v['id']}'class='edit oper'>编辑</a>";
            $v['oper'] .= "<a rel='{$v['id']}'class='edit oper'>&nbsp;&nbsp;&nbsp;打印</a>";
            $v['status'] = isset($this->_order_status[$v['status']]) ? $this->_order_status[$v['status']] : '';
            $v['order_source'] = isset($this->_order_source[$v['order_source']]) ? $this->_order_source[$v['order_source']] : '';
        }
    }

    public function get_orderlist_params() {
        $data['id'] = $this->input->post('card_num');
        $data['deliver_num'] = $this->input->post('deliver_num');
        $data['customer_name'] = $this->input->post('customer_name');
        $data['book_id'] = $this->input->post('book_id');
        $data['status'] = $this->input->post('status');
        $data['order_source'] = $this->input->post('order_source');
        return $data;
    }

    public function ajax_list_table_data(&$pageData) {
        foreach ($pageData as &$v) {
            $v['checkbox'] = "<input name='row_sel' type='checkbox' id='{$v['id']}'>";
            $v['oper'] = "<a rel='{$v['id']}'class='edit oper'>编辑</a>";
            //$v['oper'] .= "<a rel='{$v['id']}'class='load oper'>&nbsp;&nbsp;&nbsp;导入</a>";
            $v['status'] = isset($this->_order_status[$v['status']]) ? $this->_order_status[$v['status']] : '';
            $v['type'] = isset($this->_order_type[$v['type']]) ? $this->_order_type[$v['type']] : '';
        }
    }

    public function get_order_page_where() {
        $cwhere = array();
        if (isset($_REQUEST['id']) && $_REQUEST['id'] != 0) {
            $cwhere['`order`.`id`'] = $_REQUEST['id'];
        }
        if (isset($_REQUEST['deliver_num']) && $_REQUEST['deliver_num'] != '') {
            $cwhere['`order`.`deliver_num` LIKE '] = '%' . $_REQUEST['deliver_num'] . '%';
        }
        if (isset($_REQUEST['customer_name']) && $_REQUEST['customer_name'] != 0) {
            $cwhere['`order`.`customer_name`'] = $_REQUEST['customer_name'];
        }
        if (isset($_REQUEST['phone']) && $_REQUEST['phone'] != '') {
            $cwhere['`order`.`phone`'] = $_REQUEST['phone'];
        }
        return $cwhere;
    }

    public function get_save_eorder_params() {
        $data['sales'] = $this->input->post('sales');
        $data['deal_date'] = $this->input->post('deal_date');
        $data['customer_id'] = $this->input->post('customer');
        $data['enduser'] = $this->input->post('enduser');
        $data['expire_date'] = $this->input->post('expire_date');
        $data['remark'] = trim($this->input->post('remark'));
        //$data['gift_book_arr'] = $this->input->post('gift_book_arr');
        return $data;
    }

    public function save_eorder($eorder_info) {
        $this->db->insert($this->_eorder_tb, $eorder_info);
        return $this->db->insert_id();
    }
    
    public function eorder_page_data($dtparser) {
        $cols = array(
            '`view_eorder_customer_user`.`id`', 
            '`view_eorder_customer_user`.`deal_date`', 
            '`view_eorder_customer_user`.`sales_name`', 
            '`view_eorder_customer_user`.`customer_name`',
            '`view_eorder_customer_user`.`oper_person`',
            '`view_eorder_customer_user`.`order_name`',
            '`view_eorder_customer_user`.`price`',
            '`view_eorder_customer_user`.`status`',
            '`view_eorder_customer_user`.`pay_remark`',
            '`view_eorder_customer_user`.`remark`');
        $sort_cols = array('4' => '`view_eorder_customer_user`.`deal_date`');
        $filter_cols = array();
        //查询主表
        $dtparser->select($cols, $sort_cols, $filter_cols, FALSE);
        $dtparser->from($this->_view_eorder_customer_user_tb);
        //条件
        $cwhere = $this->get_eorder_page_where();
        $d['code'] = 0;
        $d['iTotal'] = 0;
        $d['iFilteredTotal'] = 0;
        $d['aaData'] = array();
        if ($d['code'] == 0) {
            $d['iTotal'] = $dtparser->count($cwhere);
            $d['iFilteredTotal'] = $d['iTotal'];
            $query = $dtparser->get($cwhere);
            $arr = $query->result_array();
            $this->ajax_eorderlist_table_data($arr);
            $d['aaData'] = $arr;
        }
        //return $this->db->last_query();
        return $d;
    }
    
    public function get_eorder_page_where() {
        $cwhere = array();
        if (isset($_REQUEST['customer_name']) && $_REQUEST['customer_name'] != '') {
            $cwhere['`view_eorder_customer_user`.`customer_name` LIKE '] = '%' . $_REQUEST['customer_name'] . '%';
        }
        if (isset($_REQUEST['order_name']) && $_REQUEST['order_name'] != '') {
            $cwhere['`view_eorder_customer_user`.`order_name` LIKE '] = '%' . $_REQUEST['order_name'] . '%';
        }
        if (isset($_REQUEST['sales_name']) && $_REQUEST['sales_name'] != '') {
            $cwhere['`view_eorder_customer_user`.`sales_name` LIKE '] = '%' . $_REQUEST['sales_name'] . '%';
        }
        if (isset($_REQUEST['status']) && $_REQUEST['status'] != 0) {
            $cwhere['`view_eorder_customer_user`.`status`'] = $_REQUEST['status'];
        }
        if (isset($_REQUEST['start_date']) && $_REQUEST['start_date'] != 'undefined' &&$_REQUEST['start_date'] != '') {
            $cwhere['`view_eorder_customer_user`.`deal_date` >='] = $_REQUEST['start_date'];
        }
        if (isset($_REQUEST['end_date']) && $_REQUEST['end_date'] != 'undefined' && $_REQUEST['end_date'] != '') {
            $cwhere['`view_eorder_customer_user`.`deal_date` <='] = $_REQUEST['end_date'];
        }
        return $cwhere;
    }
      public function ajax_eorderlist_table_data(&$pageData) {
        foreach ($pageData as &$v) {
            $v['checkbox'] = "<input name='row_sel' type='checkbox' id='{$v['id']}'>";
            $v['oper'] = "<a rel='{$v['id']}'class='edit oper'>编辑</a>";
            $v['oper'] .= "<a rel='{$v['id']}'class='edit oper'>&nbsp;打印</a>";
            $v['status'] = isset($this->_eorder_status[$v['status']]) ? $this->_eorder_status[$v['status']] : '';
            
        }
    }
    /*
     * 批量插入eorder book map batch
     */
    public function minsert_eorder_book($data){
        $this->db->insert_batch($this->_eorder_book_map_tb, $data);
        return $this->db->affected_rows();
        
    }

}