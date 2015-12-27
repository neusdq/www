<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of giftcard_model
 *
 * @author pbchen
 */
class giftcard_model extends CI_Model {
    
    private $_card_order_tb = '`gift_management`.`card_order`';
    
    private $_gift_card_tb = '`gift_management`.`gift_card`';
    
    private $_map_order_card_tb = '`gift_management`.`map_order_card`';
    
    private $_cancel_order_tb = '`gift_management`.`cancel_card_order`';
    
    private $_cancel_order_card_tb = '`gift_management`.`cancel_order_card`';
    
    private $_pay_status = array(
        '1' => '已付款',
        '2' => '未付款',
    );
    
    private $_card_status = array(
        '1' => '已开卡',
        '2' => '未开卡',
    );
            
    function __construct() {
        parent::__construct();
    }
    
    /**
     * 后去下单参数
     */
    public function get_giftcard_order_params(){
        $data['sales_id'] = $this->input->post('sales');
        $data['trade_date'] = $this->input->post('trade_date');
        $data['custom_id'] = $this->input->post('customer');
        $data['wechat_id'] = $this->input->post('wechat');
        $data['expire_date'] = $this->input->post('expiration_date');
        $data['remark'] = trim($this->input->post('remark'));
        $data['gift_book_arr'] = $this->input->post('gift_book_arr');
        return $data;
    }
    
    /**
     * 添加订单
     * @param type $order_data
     */
    public function add_giftcard_order($order_data){
        $gift_books = $order_data['gift_book_arr'];
        unset($order_data['gift_book_arr']);
        $order_data['order_name'] = '';
        $order_book = array();
        foreach($gift_books as $v){
            $order_book[] = array(
                'book_id'=>$v['gift_book_id'],
                'book_name'=>$v['gift_book_name'],
                'price'=>$v['gift_price'],
                'discount'=>$v['discount'],
                'scode'=>$v['start_num'],
                'ecode'=>$v['end_num'],
                'num'=>$v['num'],
            );
            $order_data['order_name'] .= trim($v['gift_book_name']) . '*' . $v['num'];
        }
        $this->db->insert($this->_card_order_tb,$order_data);
        $order_id = $this->db->insert_id();
        foreach($order_book as &$v){
            $v['order_id'] = $order_id;
        }
        $this->db->insert_batch('`gift_management`.`sales_order_book`',$order_book);
        return $order_id;
    }
    
    /**
     * 获取订单礼册
     * @param type $where
     */
    public function get_order_book($where){
        $cols = array('*');
        $this->db->select($cols);
        $this->db->from('`gift_management`.`sales_order_book`');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * 
     * @param type $cancel_id
     */
    public function get_cancel_order_book($cancel_id){
        $sql = "SELECT `sales_order_book`.*
            FROM `gift_management`.`cancel_order_card`
            INNER JOIN `gift_management`.`cancel_card_order` ON `cancel_card_order`.`id`=`cancel_order_card`.`cancel_id`
            INNER JOIN `gift_management`.`card_order` ON `card_order`.`custom_id`=`cancel_card_order`.`custom_id`
            INNER JOIN `gift_management`.`sales_order_book` ON (`sales_order_book`.`order_id`=`card_order`.`id`
            AND `sales_order_book`.`scode`<=`cancel_order_card`.`start_code` 
            AND `sales_order_book`.`ecode`>=`cancel_order_card`.`end_code`)
            WHERE `cancel_card_order`.`id`=" . $cancel_id;
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    /**
     * 更新礼品卡订单信息
     * @param type $where
     * @param type $where_in
     */
    public function update_giftcard_order_info($updata,$where=array(),$where_in=array()){
        if($where){
            $this->db->where($where);
        }
        if($where_in){
            $this->db->where_in($where_in);
        }
        $this->db->update($this->_card_order_tb,$updata);
        return $this->db->affected_rows();
    }
    
    /**
     * 获取列表条件
     * @return type
     */
    public function get_giftcard_order_page_where(){
        $cwhere = array();
        if (isset($_REQUEST['customer']) && $_REQUEST['customer']!='') {
            $cwhere['`customer`.`name` LIKE '] = '%'.$_REQUEST['customer'].'%';
        }
        if (isset($_REQUEST['giftbook']) && $_REQUEST['giftbook'] != '') {
            $cwhere['`card_order`.`order_name` LIKE '] = '%'.$_REQUEST['giftbook'].'%';
        }
        if (isset($_REQUEST['sales']) && $_REQUEST['sales'] != '') {
            $cwhere['`user`.`nick_name` LIKE '] = '%'.$_REQUEST['sales'].'%';
        }
        if (isset($_REQUEST['paystatus']) && $_REQUEST['paystatus']!=0) {
            $cwhere['`card_order`.`pay_status`'] = $_REQUEST['paystatus'];
        }
        return $cwhere;
    }
    
   /**
    * 礼品卡开卡列表
    * @param type $dtparser
    * @return type
    */
    public function giftcard_order_list_page_data($dtparser){
        
        $cols = array('`card_order`.`id`','`card_order`.`trade_date`','`user`.`nick_name` as `sales`','`customer`.`name` as `customer`'
            ,'`card_order`.`contact_person`','`card_order`.`order_name`','`card_order`.`price`',
            '`card_order`.`pay_status`','`card_order`.`pay_remark`','`card_order`.`remark`',
            '`card_order`.`trade_date`','`card_order`.`wechat_id`','`card_order`.`custom_id`',
            '`card_order`.`sales_id`','`card_order`.`end_user`');
        $sort_cols = array('6'=>'`price`');
        $filter_cols = array();
        //查询主表
        $dtparser->select($cols, $sort_cols, $filter_cols, FALSE);
        $dtparser->from($this->_card_order_tb);
        $dtparser->join('`gift_management`.`user`', 'user.id=card_order.sales_id', 'left');
        $dtparser->join('`gift_management`.`customer`', 'customer.id=card_order.custom_id', 'left');
        
        //条件
        $cwhere = $this->get_giftcard_order_page_where();
        $d['code'] = 0;
        $d['iTotal'] = 0;
        $d['iFilteredTotal'] = 0;
        $d['aaData'] = array();
        if( $d['code'] == 0 ){
            $d['iTotal'] = $dtparser->count($cwhere);
            $d['iFilteredTotal'] = $d['iTotal'];
            $query = $dtparser->get($cwhere);
            $arr = $query->result_array();
            $this->ajax_list_table_data($arr);
            $d['aaData']=$arr;
        }
        return $d;
    }
    
     /**
     * 转化前端datatable要求的样式
     * @param type $pageData
     */
    public function ajax_list_table_data(&$pageData){
        $ewm_server = $this->config->item('ewm_server');
        foreach($pageData as &$v){
            $v['checkbox'] = "<input name='row_sel' type='checkbox' id='{$v['id']}'>";
            //$v['oper'] = "<a rel='{$v['id']}' class='info oper'>查看</a>";
            $v['oper'] = "<a href='/giftcard_manage/print_sales_order?id={$v['id']}' target='_blank' class='print oper'>&nbsp;&nbsp;&nbsp;打印</a>";
            $v['oper'] .= "<a rel='{$v['id']}' trade_date='{$v['trade_date']}' wechat_id='{$v['wechat_id']}' custom_id='{$v['custom_id']}' sales_id='{$v['sales_id']}' end_user='{$v['end_user']}' class='edit oper'>&nbsp;&nbsp;&nbsp;编辑</a>";
            $v['oper'] .= "<a rel='{$v['id']}' ewm_url='{$ewm_server}{$v['wechat_id']}' class='ewm oper'>&nbsp;&nbsp;&nbsp;二维码</a>";
            $v['pay_status'] = isset($this->_pay_status[$v['pay_status']])?$this->_pay_status[$v['pay_status']]:'';
        }
    }
    
    /**
     * 礼品卡列表
     * @return type
     */
    public function giftcard_inventory_page_data($dtparser){
        
        $cols = array('`gift_card`.`id`','`gift_card`.`num_code`','`gift_card`.`status`'
            ,'`gift_card`.`ctime`','`gift_card`.`password`'
           );
        $sort_cols = array('1'=>'`num_code`','3'=>'`ctime`');
        $filter_cols = array();
        //查询主表
        $dtparser->select($cols, $sort_cols, $filter_cols, FALSE);
        $dtparser->from($this->_gift_card_tb);
        //条件
        $cwhere = $this->giftcard_inventory_page_where();
        $d['code'] = 0;
        $d['iTotal'] = 0;
        $d['iFilteredTotal'] = 0;
        $d['aaData'] = array();
        if( $d['code'] == 0 ){
            $d['iTotal'] = $dtparser->count($cwhere);
            $d['iFilteredTotal'] = $d['iTotal'];
            $query = $dtparser->get($cwhere);
            $arr = $query->result_array();
            $this->ajax_inventory_table_data($arr);
            $d['aaData']=$arr;
        }
        return $d;
    }
    
    public function giftcard_inventory_page_where(){
        $cwhere = array();
        if (isset($_REQUEST['code']) && $_REQUEST['code']!='') {
            $cwhere['`gift_card`.`num_code`'] = $_REQUEST['code'];
        }
        if (isset($_REQUEST['status']) && $_REQUEST['status'] !=0) {
            $cwhere['`gift_card`.`status`'] = $_REQUEST['status'];
        }
        if (isset($_REQUEST['scode']) && $_REQUEST['scode'] != '') {
            $cwhere['`gift_card`.`num_code` >= '] = $_REQUEST['scode'];
        }
        if (isset($_REQUEST['ecode']) && $_REQUEST['ecode']!='') {
            $cwhere['`gift_card`.`num_code` <='] = $_REQUEST['ecode'];
        }
        if (isset($_REQUEST['date']) && $_REQUEST['date']!='') {
            $date = str_replace('/','-',$_REQUEST['date']);
            $current_date = date('Y-m-d',strtotime($date));
            list($y,$m,$d) = explode('-', $current_date);
            if( checkdate($m,$d,$y) ){
                $cwhere['`gift_card`.`ctime` >='] = $date;
                $cwhere['`gift_card`.`ctime` <='] = $current_date . ' 23:59:59';
            }
        }
        return $cwhere;
    }
    
    /**
     * 下载
     * @return type
     */
    public function download_giftcard_data(){
        $cols = array('`gift_card`.`num_code`','`gift_card`.`status`'
            ,'`gift_card`.`password`','`gift_card`.`ctime`'
           );
        $cwhere = $this->giftcard_inventory_page_where();
        $this->db->select($cols);
        $this->db->from($this->_gift_card_tb);
        if($cwhere){
            $this->db->where($cwhere);
        }
        $query = $this->db->get();
        $arr = $query->result_array();
        $this->ajax_inventory_table_data($arr);
        return $arr;
    }
    
    /**
     * 转化前端datatable要求的样式
     * @param type $pageData
     */
    public function ajax_inventory_table_data(&$pageData){
        foreach($pageData as &$v){
            $v['status'] = isset($this->_card_status[$v['status']])?$this->_card_status[$v['status']]:'';
        }
    }
    
    /**
     * 生产礼卡
     */
    public function create_giftcard($d){
        $data = array();
        $num = $d['ecode']-$d['scode'];
        $time = date('Y-m-d H:i:s');
        for($i=0;$i<=$num;$i++){
            $num_code = $d['scode'] + $i;
            $password = substr(create_uniqid(), 2, 6);
            $data[] = array('num_code'=>$num_code,'password'=>$password,'ctime'=>$time);
        }
        $rt = FALSE;
        if($data){
            $this->db->insert_batch($this->_gift_card_tb, $data);
            $rt = $this->db->affected_rows();
        }
        return $rt;
    }
    
    /**
     * 退卡
     * @return type
     */
    public function cancel_giftcard_page_data($dtparser){
        $cols = array('`cancel_card_order`.`id`','`cancel_card_order`.`cancel_date`'
            ,'`user`.`nick_name` as `sales`','`customer`.`name` as `customer`'
            ,'`cancel_card_order`.`remark`','`cancel_card_order`.`end_user`'
            ,'`cancel_card_order`.`custom_id`','`cancel_card_order`.`sales_id`'
            ,'`u`.`nick_name` as `modify_user`','SUM(`cancel_order_card`.`num`) AS `cancel_num`');
        $sort_cols = array('1'=>'`cancel_date`','6'=>'`cancel_num`');
        $filter_cols = array();
        $group = array('`cancel_card_order`.`id`');
        //查询主表
        $dtparser->select($cols, $sort_cols, $filter_cols, FALSE);
        $dtparser->from($this->_cancel_order_tb);
        $dtparser->join('`gift_management`.`user`', 'user.id=cancel_card_order.sales_id', 'left');
        $dtparser->join('`gift_management`.`customer`', 'customer.id=cancel_card_order.custom_id', 'left');
        $dtparser->join('`gift_management`.`user` AS `u`', 'u.id=cancel_card_order.modify_user', 'left');
        $dtparser->join('`gift_management`.`cancel_order_card`', 'cancel_order_card.cancel_id=cancel_card_order.id', 'inner');
        //条件
        $cwhere = $this->cancel_giftcard_page_where();
        $d['code'] = 0;
        $d['iTotal'] = 0;
        $d['iFilteredTotal'] = 0;
        $d['aaData'] = array();
        if( $d['code'] == 0 ){
            $d['iTotal'] = $dtparser->count_group($group, $cwhere);
            $d['iFilteredTotal'] = $d['iTotal'];
            $query = $dtparser->get_group($group,$cwhere);
            $arr = $query->result_array();
            $this->ajax_cancel_giftcard_table_data($arr);
            $d['aaData']=$arr;
        }
        return $d;
    }
    
    /**
     * 
     */
    public function cancel_giftcard_page_where(){
        $cwhere = array();
        if (isset($_REQUEST['sales']) && $_REQUEST['sales'] != '') {
            $cwhere['`user`.`nick_name` LIKE '] = '%'.$_REQUEST['sales'].'%';
        }
        if (isset($_REQUEST['sdate']) && $_REQUEST['sdate']!='') {
            $cwhere['`cancel_card_order`.`cancel_date` >='] = $_REQUEST['sdate'];
        }
        if (isset($_REQUEST['edate']) && $_REQUEST['edate']!='') {
            $cwhere['`cancel_card_order`.`cancel_date` <='] = $_REQUEST['edate'];
        }
        return $cwhere;
    }
    
    /**
     * 转化前端datatable要求的样式
     */
    public function ajax_cancel_giftcard_table_data(&$pageData){
        foreach($pageData as &$v){
            $v['checkbox'] = "<input name='row_sel' type='checkbox' id='{$v['id']}'>";
            $v['oper'] = "<a href='/giftcard_manage/print_cancel_order?id={$v['id']}' target='_blank' class='print oper'>&nbsp;&nbsp;&nbsp;打印</a>";
            $v['oper'] .= "<a rel='{$v['id']}' cancel_date='{$v['cancel_date']}' custom_id='{$v['custom_id']}' sales_id='{$v['sales_id']}' end_user='{$v['end_user']}' class='edit oper'>&nbsp;&nbsp;&nbsp;修改</a>";
        }
    }
    
    /**
     * 后去下单参数
     */
    public function cancel_giftcard_params(){
        $data['sales_id'] = $this->input->post('sales');
        $data['cancel_date'] = $this->input->post('cancel_date');
        $data['custom_id'] = $this->input->post('customer');
        $data['remark'] = trim($this->input->post('remark'));
        $data['code_arr'] = $this->input->post('code_arr');
        return $data;
    }
    
    /**
     * 添加退卡
     * @param type $order_data
     */
    public function add_cancel_giftcard($data){
        $codes = $data['code_arr'];
        unset($data['code_arr']);
        $this->db->insert($this->_cancel_order_tb,$data);
        $id = $this->db->insert_id();
        $d = array();
        foreach($codes as $v){
            $d[] = array(
                        'cancel_id'=>$id,'start_code'=>$v['start_num']
                        ,'end_code'=>$v['end_num'],'num'=>$v['num']
                    );
        }
        if($d){
            $this->db->insert_batch($this->_cancel_order_card_tb,$d);
        }
        return $id;
    }
    
    /**
     * 更新
     * @param type $updata
     * @param type $where
     * @param type $where_in
     * @return type
     */
    public function update_cancel_giftcard($updata,$where,$where_in=array()){
        if($where){
            $this->db->where($where);
        }
        if($where_in){
            $this->db->where_in($where_in);
        }
        $this->db->update($this->_cancel_order_tb,$updata);
        return $this->db->affected_rows();
    }
    
    /**
     * 销售订单信息
     * @param type $where
     * @return type
     */
    public function sales_order_info($where){
        $cols = array('`card_order`.`sales_id`','`card_order`.`custom_id`','`user`.`user_name`',
            '`card_order`.`order_name`','`card_order`.`trade_date`','`card_order`.`end_user`',
            '`card_order`.`modify_user`','`customer`.`name`','`customer`.`contact_person`',
            '`customer`.`phone`','`customer`.`address`');
        $this->db->select($cols);
        $this->db->from($this->_card_order_tb);
        $this->db->join('`gift_management`.`customer`', 'customer.id = card_order.custom_id', 'left');
        $this->db->join('`gift_management`.`user`', 'user.id = card_order.sales_id', 'left');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();
    }
    
}
