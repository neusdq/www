<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user_model
 *
 * @author pbchen
 */
class User_model extends CI_Model {
    
    private $_user_tb = '`gift_management`.`user`';
    
    function __construct() {
        parent::__construct();
        $this->load->model('role_model');
    }
    
    /**
     * 获取数据库中的用户信息
     * @param type $where
     * @return type
     */
    public function get_user($where=array()){
        $this->db->select('`id`,`user_name`,`password`,`nick_name`,`email`,`phone`,`role`,`create_time`');
        $this->db->from($this->_user_tb);
        if($where){
            $this->db->where($where);
        }
        $query = $this->db->get();
        $role = $this->role_model->get_role();
        $user = array();
        foreach($query->result_array() as $row){
            $row['role_name'] = isset($role[$row['role']])?$role[$row['role']]:'';
            $user[] = $row;
        }
        return $user;
    }
    
    
    public function add_user($data){
        $this->db->insert($this->_user_tb, $data);
        return $this->db->insert_id();
    }
    
    /**
     * 修改用户信息
     * @param type $user_id
     * @param type $update_info
     * @return type
     */
    public function update_user_info($user_id,$update_info){
        $this->db->where('id', $user_id);
        $this->db->update($this->_user_tb, $update_info);
        return $this->db->affected_rows();
    }
    
    /**
     * 分页条件
     */
    public function user_list_page_where(){
        $cwhere = array();
        if (isset($_REQUEST['id']) && $_REQUEST['id']!='') {
            $cwhere['`user`.`id` LIKE '] = '%'.$_REQUEST['id'].'%';
        }
        if (isset($_REQUEST['account']) && $_REQUEST['account'] != '') {
            $cwhere['`user`.`user_name` LIKE '] = '%'.$_REQUEST['account'].'%';
        }
        if (isset($_REQUEST['name']) && $_REQUEST['name'] != '') {
            $cwhere['`user`.`nick_name` LIKE '] = '%'.$_REQUEST['name'].'%';
        }
        if (isset($_REQUEST['email']) && $_REQUEST['email']!='') {
            $cwhere['`user`.`email` LIKE '] = '%'. $_REQUEST['email'] .'%';
        }
        return $cwhere;
    }
    
    public function user_list_page_data($dtparser){
        $cols = array('`id`','`user_name` as `account`','`nick_name`'
            ,'`email`','`phone`','`role`');
        $sort_cols = array('0'=>'`id`');
        $filter_cols = array();
        //查询主表
        $dtparser->select($cols, $sort_cols, $filter_cols, FALSE);
        $dtparser->from($this->_user_tb);
        //条件
        $cwhere = $this->user_list_page_where();
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
    
    private function ajax_list_table_data(&$pageData){
        $role = $this->role_model->get_role();
        foreach($pageData as &$v){
            $role_name = array();
            $v['oper'] = "<a rel='{$v['id']}' role='{$v['role']}' class='edit oper'>编辑</a>";
            foreach(explode(',', $v['role']) as $r){
                if(isset($role[$r])){
                    $role_name[] = $role[$r];
                }
            }
            $v['role_name'] = implode(',', $role_name);
        }
    }
    
}
