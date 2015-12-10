<?php
class business_manage extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('uc_service', array('cfg' => $this->config->item('alw_uc')));
    }
       /**
     * 客户列表
     */
    public function customer_list() {
        $d = array('title' => '客户列表', 'msg' => '');
        $this->layout->view('customer_manage/customer_list', $d);
    }
       public function website_list() {
        $d = array('title' => '兑换网站列表', 'msg' => '');
        $this->layout->view('website_manage/website_list', $d);
    }
       public function wechat_list() {
        $d = array('title' => '微信模版列表', 'msg' => '');
        $this->layout->view('wechat_manage/wechat_list', $d);
    }
       public function media_list() {
        $d = array('title' => '多媒体列表', 'msg' => '');
        $this->layout->view('media_manage/media_list', $d);
    }
    }
    

