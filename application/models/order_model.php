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
    private $_return_order_tb = '`gift_management`.`return_order_detail`';
    private $_exchange_order_tb = '`gift_management`.`exchange_order_detail`';
    private $_eorder_book_map_tb = '`gift_management`.`entity_order_book_map`';
    private $_order_gift_card = '`gift_management`.`gift_card`';
    private $_view_book_gift_tb = '`gift_management`.`view_book_gift`';
    private $_view_order_gift_card_tb = '`gift_management`.`view_order_gift_card`';
    private $_view_eorder_customer_user_tb = '`gift_management`.`view_eorder_customer_user`';

    const MEDIA_START_STATUS = 1;
    const MEDIA_STOP_STATUS = 2;

    private $_order_status = array(
        '0' => '已作废',
        '1' => '未审核',
        '2' =>'未发货',
        '3'=> '已发货',
        '4'=> '已送达'
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
    private $_change_order_status = array(
        '1' => '未审核',
        '2' => '未入库',
        '3' => '未出库',
        '4' => '已退货',
        '5' => '已换货',
        '6' => '审核未通过'
    );

    function __construct() {
        parent::__construct();
        $this->load->model('goods_manage_model');
    }

    public function check_cardauth($numcode, $password) {
        $query = $this->db->query("SELECT id,num_code,password,is_draw FROM gift_management.gift_card  where num_code='" . $numcode . "' and password='" . $password . "'");
        $row = $query->row();
        if (isset($row)) {
            return $row;
        } else {
            return false;
        }
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function get_card_info($id) {
        $query = $this->db->query("SELECT a.id as card_id,a.num_code,a.expire_date,b.id book_id,b.name book_name,b.sale_price FROM gift_management.gift_card a join gift_management.gift_book b on a.book_id=b.id  where a.id='" . $id . "'");
        
        $row = $query->row();
        $data['card_id'] = $row->card_id;
        $data['num_code'] = $row->num_code;
        $data['expire_date'] = $row->expire_date;
        $data['book_id'] = $row->book_id;
        $data['book_name'] = $row->book_name;
        $data['sale_price'] = $row->sale_price;       
        return $data;
    }
    
    /**
     * 获取订单信息
     * @param type $where
     */
    public function get_order_info($where){
        $cols = array('card_id','card_num','gift_id','customer_name','phone','address',
            'postcode','deliver_id','deliver_date','remark','deliver_num','status');
        $this->db->select($cols);
        $this->db->from($this->_order_tb);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    /**
     * 
     * @param type $giftcard_id
     */
    public function get_gift_list($giftcard_id){
        $sql = 'SELECT `gift_book`.`group_ids` FROM `gift_card` LEFT JOIN `gift_book` '
            . ' ON `gift_book`.`id`=`gift_card`.`book_id`'
            . ' WHERE `gift_card`.`id`=' . $giftcard_id;
        $query = $this->db->query($sql);
        $row = $query->row();
        $gift = array();
        if($row && $row->group_ids){
            $tmp = explode(',', $row->group_ids);
            foreach($tmp as $t){
                if($t){
                    $t_arr = explode('*',$t);
                    $giftids[] = array_shift($t_arr);
                }
            }
            if(count($giftids)>0){
                $gift = $this->goods_manage_model->get_goods_info(array('store_num >'=>0),array('id'=>$giftids));
            }
        }
        return $gift;
    }
    
    /**
     * 获取礼品信息
     * @param type $where
     * @return type
     */
    public function get_gift_info($where){
        $cols = array('`id`','`name`');
        $this->db->select($cols);
        $this->db->from('`gift_management`.`gift`');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_order_params() {
        $data['card_id'] = $this->input->post('card_id');
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
    
    public function get_editorder_params() {
        $data['card_id'] = $this->input->post('card_id');
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
        $data['status'] = $this->input->post('status');
        $data['deliver_num'] = $this->input->post('delivernum');
        return $data;
    }

    public function add_order($order_info) {
        $row = $this->db->query("select `gift_book`.`type_id` 
        from `gift_management`.`gift_book` 
        where `gift_book`.`id`={$order_info['gift_id']}")->row();
        $order_num = 1;
        if(isset($row->type_id)){
            if($row->type_id==2){
                $order_num=12;
            }elseif($row->type_id==3){
                $order_num=6;
            }else{
                $order_num=3;
            }
        }
        for($i=0;$i<$order_num;$i++){
            $order_info['deliver_date'] = date('Y-m-d',strtotime($order_info['deliver_date'])+86400*30);
            $this->db->insert($this->_order_tb, $order_info);
        }
        return TRUE;
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
    
    public function update_order_info($updata,$where=array(),$where_in=array()){
        if($where){
            $this->db->where($where); 
        }
        if($where_in){
            $this->db->where_in($where_in); 
        }
        $this->db->update($this->_order_tb,$updata);
        return $this->db->affected_rows();
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
        $cols = array('`change_order`.`id`', '`change_order`.`card_id`', '`change_order`.`gift_id`',
            '`gift`.`name` AS `gift_name`', '`change_order`.`customer_name`', '`change_order`.`phone`',
            '`change_order`.`address`','`change_order`.`postcode`','`change_order`.`deliver_id`','`change_order`.`deliver_num`',
            '`change_order`.`deliver_date`','`change_order`.`deliver_date`','`change_order`.`remark`',
            '`change_order`.`status`','`change_order`.`order_source`','`deliver`.`name` AS `deliver`');
        $sort_cols = array();
        $filter_cols = array();
        //查询主表
        $dtparser->select($cols, $sort_cols, $filter_cols, FALSE);
        $dtparser->from($this->_order_tb);
        $dtparser->join('`gift_management`.`deliver`', 'deliver.id=change_order.deliver_id', 'left');
        $dtparser->join('`gift_management`.`gift`', 'gift.id=change_order.gift_id', 'left');
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
            $v['deliver_date'] = date('Y-m-d',strtotime($v['deliver_date']));
            $v['checkbox'] = "<input name='row_sel' type='checkbox' id='{$v['id']}'>";
            $v['oper'] = "<a href='/order_manage/edit_order?id={$v['id']}' class='edit oper'>编辑</a>";
            $v['oper'] .= "<a href='/order_manage/print_out_order?id={$v['id']}' target='_blank' class='edit oper'>&nbsp;&nbsp;&nbsp;打印</a>";
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
        if (isset($_REQUEST['start_date']) && $_REQUEST['start_date'] != 'undefined' && $_REQUEST['start_date'] != '') {
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
            $v['oper'] = "<a rel='{$v['id']}'class='edit oper' href='/order_manage/edit_eorder?id={$v['id']}'>编辑</a>";
            $v['oper'] .= "<a href='/order_manage/print_eorder?id={$v['id']}' target='_blank' class='print oper'>&nbsp;&nbsp;&nbsp;打印</a>";
            $v['status'] = isset($this->_eorder_status[$v['status']]) ? $this->_eorder_status[$v['status']] : '';
        }
    }

    /*
     * 批量插入eorder book map batch
     */

    public function minsert_eorder_book($data) {
        $this->db->insert_batch($this->_eorder_book_map_tb, $data);
        return $this->db->affected_rows();
    }

    /*
     * 编辑 获取订单信息
     */

    public function get_eorder_info($where) {
        $this->db->select('*')->from($this->_eorder_tb);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();
    }

    /*
     * 获取实物订单下关联礼册信息
     */

    public function get_eorder_book_list($where) {
        $this->db->select('*')->from($this->_eorder_book_map_tb);
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();
    }

    /*
     * 更新实物订单信息
     */

    public function update_eorder($updata, $where = array()) {
        if ($where) {
            $this->db->where($where);
        }
        $this->db->update($this->_eorder_tb, $updata);
        return $this->db->affected_rows();
    }

    /*
     * 更新实物订单下关联礼册信息,例如更新状态
     */

    public function update_eorder_book_list($updata, $where = array()) {
        if ($where) {
            $this->db->where($where);
        }
        $this->db->update($this->_eorder_book_map_tb, $updata);
        return $this->db->affected_rows();
    }

    public function update_eorder_status($updata, $where = array()) {
        if ($where) {
            $this->db->where_in('id', $where);
        }
        $this->db->update($this->_eorder_tb, $updata);
        return $this->db->affected_rows();
    }

    /*
     * 查询订单信息
     */

    public function search_order_info($dtparser, $id) {
        $cols = array(
            '`change_order`.`card_num`',
            '`change_order`.`customer_name`',
            '`change_order`.`phone`',
            '`change_order`.`ctime`',
            '`change_order`.`card_num`',
            '`change_order`.`address`',
            '`gift`.`id`  as `gift_id`',
            '`gift`.`name`  as `gift_name`',
            '`gift_book`.`id`  as `book_id`',
            '`gift_book`.`name`  as `book_name`',
            '`gift_book`.`sale_price`'
        );
        $cwhere = array('change_order.id' => $id);

        $dtparser->select($cols, array(), array(), FALSE);
        $dtparser->from($this->_order_tb);
        $dtparser->join('`gift_management`.`gift`', 'gift.id=change_order.gift_id');
        $dtparser->join('`gift_management`.`gift_card`', 'gift_card.num_code=change_order.card_num');
        $dtparser->join('`gift_management`.`gift_book`', 'gift_book.id=gift_card.book_id');
        $query = $dtparser->get($cwhere);
        $data = $query->result_array();
        return $data;
    }

    /*
     * 查询礼册下的礼品列表
     */

    public function search_gifts_by_book($dtparser, $id) {
        $cols = array(
            '`gift_management`.`gift`.`id`',
            '`gift_management`.`gift`.`name`'
        );
        $cwhere = array('`book_goods_mapping`.`gift_book_id`' => $id);
        $dtparser->select($cols, array(), array(), FALSE);
        $dtparser->from('`gift_management`.`book_goods_mapping`');
        $dtparser->join('`gift_management`.`gift`', 'gift.id=book_goods_mapping.gift_id');
        $query = $dtparser->get($cwhere);
        $data = $query->result_array();
        return $data;
    }

    /*
     * 保存退货单
     */

    public function save_return_order($data) {
        $this->db->insert($this->_return_order_tb, $data);
        return $this->db->insert_id();
    }

    /*
     * 保存换货单
     */

    public function save_exchange_order($data) {
        $this->db->insert($this->_exchange_order_tb, $data);
        return $this->db->insert_id();
    }

    /*
     * 查询退货列表
     */

    public function rorder_page_data($dtparser) {
        $cols = array(
            '`change_order`.`id`',
            '`change_order`.`customer_name`',
            '`change_order`.`phone`',
            '`change_order`.`status`',
            '`return_order_detail`.`oper_person`',
            '`return_order_detail`.`ctime`',
            '`return_order_detail`.`remark`',
            '`return_order_detail`.`return_amount`',
            '`return_order_detail`.`remark`');
        $cwhere = array();
        if (isset($_REQUEST['customer_name']) && $_REQUEST['customer_name'] != '') {
            $cwhere['`change_order`.`customer_name` LIKE '] = '%' . $_REQUEST['customer_name'] . '%';
        }
        if (isset($_REQUEST['order_id']) && $_REQUEST['order_id'] != '') {
            $cwhere['`change_order`.`id` LIKE '] = '%' . $_REQUEST['order_id'] . '%';
        }
        if (isset($_REQUEST['status']) && $_REQUEST['status'] != 0) {
            $cwhere['`change_order`.`status`'] = $_REQUEST['status'];
        }
        $sort_cols = array('4' => '`return_order_detail`.`ctime`');
        //查询主表
        $dtparser->select($cols,$sort_cols,array());
        $dtparser->from('change_order');
        $dtparser->join('return_order_detail', '`change_order`.`id`=`return_order_detail`.`order_id`');
        //$dtparser->order_by('`return_order_detail`.`ctime`', 'DESC');


        $query = $dtparser->get($cwhere);
        $arr = $query->result_array();
        $this->ajax_rorderlist_table_data($arr);


        return $arr;
    }

    public function ajax_rorderlist_table_data(&$pageData) {
        foreach ($pageData as &$v) {
            $v['checkbox'] = "<input name='row_sel' type='checkbox' id='{$v['id']}'>";
            $v['oper'] = "<a rel='{$v['id']}'class='edit oper' href='/order_manage/edit_return_order?id={$v['id']}'>编辑</a>";
            $v['oper'] .= "<a href='/order_manage/print_in_rorder?id={$v['id']}' target='_blank' class='edit oper'>&nbsp入库单</a>";
            $v['status'] = isset($this->_change_order_status[$v['status']]) ? $this->_change_order_status[$v['status']] : '';
            $v['type'] = '退货';
        }
    }
/*
     * 查询换货列表
     */

    public function exorder_page_data($dtparser) {
        $cols = array(
            '`change_order`.`id`',
            '`change_order`.`customer_name`',
            '`change_order`.`phone`',
            '`change_order`.`status`',
            '`exchange_order_detail`.`oper_person`',
            '`exchange_order_detail`.`ctime`',
            '`exchange_order_detail`.`remark`'
            );
        $cwhere = array();
        if (isset($_REQUEST['customer_name']) && $_REQUEST['customer_name'] != '') {
            $cwhere['`change_order`.`customer_name` LIKE '] = '%' . $_REQUEST['customer_name'] . '%';
        }
        if (isset($_REQUEST['order_id']) && $_REQUEST['order_id'] != '') {
            $cwhere['`change_order`.`id` LIKE '] = '%' . $_REQUEST['order_id'] . '%';
        }
        if (isset($_REQUEST['status']) && $_REQUEST['status'] != 0) {
            $cwhere['`change_order`.`status`'] = $_REQUEST['status'];
        }
        $sort_cols = array('4' => '`exchange_order_detail`.`ctime`');
        //查询主表
        $dtparser->select($cols,$sort_cols,array());
        $dtparser->from('change_order');
        $dtparser->join('exchange_order_detail', '`change_order`.`id`=`exchange_order_detail`.`order_id`');
        //$dtparser->order_by('`return_order_detail`.`ctime`', 'DESC');


        $query = $dtparser->get($cwhere);
        $arr = $query->result_array();
        $this->ajax_exorderlist_table_data($arr);


        return $arr;
    }
    public function ajax_exorderlist_table_data(&$pageData) {
        foreach ($pageData as &$v) {
            $v['checkbox'] = "<input name='row_sel' type='checkbox' id='{$v['id']}'>";
            $v['oper'] = "<a rel='{$v['id']}'class='edit oper' href='/order_manage/edit_exchange_order?id={$v['id']}'>编辑</a>";
            $v['oper'] .= "<a href='/order_manage/print_in_exorder?id={$v['id']}' target='_blank' class='edit oper'>&nbsp入库单</a>";
            $v['oper'] .= "<a href='/order_manage/print_out_exorder?id={$v['id']}' target='_blank' class='edit oper'>出库单</a>";
            $v['status'] = isset($this->_change_order_status[$v['status']]) ? $this->_change_order_status[$v['status']] : '';
            $v['type'] = '换货';
            $v['return_amount'] = '0';
        }
    }
    
    public function search_return_info($where=array()) {
         $this->db->select('*')->from('return_order_detail');     
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function search_exchange_info($where=array()) {
         $this->db->select('*')->from('exchange_order_detail');     
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function update_return_order($updata, $where = array()) {
        if ($where) {
            $this->db->where($where);
        }
        $this->db->update('return_order_detail', $updata);
        return $this->db->affected_rows();
    }
    
    public function update_exchange_order($updata, $where = array()) {
        if ($where) {
            $this->db->where($where);
        }
        $this->db->update('exchange_order_detail', $updata);
        return $this->db->affected_rows();
    }
    
}
