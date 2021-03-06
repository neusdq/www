<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of set_model
 * 系列模型
 * @author pbchen
 */
class set_model extends CI_Model {
    
    private $_set_tb = '`gift_management`.`set`';
    const SET_START_STATUS = 1;
    const SET_STOP_STATUS = 2;
    private $_set_status = array(
        '1' => '启用',
        '2' => '停用'
    );
    
    function __construct() {
        $this->load->model('giftbook_model');
        parent::__construct();
    }
    
    /**
     * 状态
     * @return type
     */
    public function get_set_status(){
        return $this->_set_status;
    }
    
    /**
     * 获取系列列表
     * @param type $where
     */
    public function get_set($where=array('status'=>1)){
        $this->db->select('*')->from($this->_set_tb);
        if($where){
            $this->db->where($where);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    
    /**
     * 获取列表条件
     * @return type
     */
    public function get_set_page_where(){
        $cwhere = array();
        if (isset($_REQUEST['id']) && $_REQUEST['id']!=0) {
            $cwhere['`set`.`id`'] = $_REQUEST['id'];
        }
        if (isset($_REQUEST['name']) && $_REQUEST['name'] != '') {
            $cwhere['`set`.`name` LIKE '] = '%'.$_REQUEST['name'].'%';
        }
        if (isset($_REQUEST['status']) && $_REQUEST['status']!=0) {
            $cwhere['`set`.`status`'] = $_REQUEST['status'];
        }
        return $cwhere;
    }
    
    /**
     * 添加系列
     * @param type $goods_info
     * @return type
     */
    public function add_set($set_info){
        $this->db->insert($this->_set_tb, $set_info);
        return $this->db->insert_id();
    }
    
    /**
     * 更新信息
     * @param array $updata
     * @param type $where
     * @param type $where_in
     * @return type
     */
    public function update_set_info($updata,$where=array()){
        if($where){
            $this->db->where($where);
        }
        $this->db->update($this->_set_tb,$updata);
        return $this->db->affected_rows();
    }
    
     /**
     * 获取系列分页数据
     * @param type $dtparser datatable类库
     */
    public function set_page_data($dtparser){
        $cols = array('`set`.`id`','`set`.`name`','`set`.`status`'
            ,'IF(`gift_book`.`id`IS NULL,0,COUNT(DISTINCT(`gift_book`.`id`))) AS `num`','`set`.`remark`');
        $sort_cols = array('4'=>'`num`');
        $filter_cols = array();
        //查询主表
        $dtparser->select($cols, $sort_cols, $filter_cols, FALSE);
        $dtparser->from($this->_set_tb);
        $dtparser->join('`gift_management`.`gift_book`', 'gift_book.set_id=set.id', 'left');
        $group = array('`set`.`id`');
        //条件
        $cwhere = $this->get_set_page_where();
        $d['code'] = 0;
        $d['iTotal'] = 0;
        $d['iFilteredTotal'] = 0;
        $d['aaData'] = array();
        if( $d['code'] == 0 ){
            $d['iTotal'] = $dtparser->count_group($group,$cwhere);
            $d['iFilteredTotal'] = $d['iTotal'];
            $query = $dtparser->get_group($group, $cwhere);
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
        foreach($pageData as &$v){
            $v['checkbox'] = "<input name='row_sel' type='checkbox' id='{$v['id']}'>";
            $v['oper'] = "<a rel='{$v['id']}'class='edit oper'>编辑</a>";
            $v['oper'] .= "<a rel='{$v['id']}'class='load oper'>&nbsp;&nbsp;&nbsp;导入</a>";
            $v['status'] = isset($this->_set_status[$v['status']])?$this->_set_status[$v['status']]:'';
        }
    }
    
    /**
     * 检查更新系列信息
     * @param type $group_goods
     * @return string
     */
    public function check_set_update($set_ids,$status){
        $ret = '系列ID:';
        if($status==self::SET_STOP_STATUS){
            $goods = $this->giftbook_model->get_giftbook_groupby_col('set_id',$set_ids);
            foreach($goods as $k=>$v){
                if($v && intval($v)>0) $ret .= $k . '下有' . $v . '个,';
            }
        }
        $ret = $ret=='系列ID:' ? '' : $ret;
        return $ret;
    }
    
}
