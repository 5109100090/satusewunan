<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of member
 *
 * @author spondbob
 */
class Admin extends CI_Controller {

    //put your code here
    private $user_id = null;

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url', 'form','date'));
        $this->load->library(array('template', 'auth', 'session', 'table', 'form_validation', 'pagination', 'job_library'));
        $this->auth->check('/', 'admin');
        $this->load->model(array('job_model','category_model'));
        $this->user_id = $this->session->userdata('user_id');
    }

    private function content_main($data) {
        if(!isset($data['offset'])) $data['offset'] = null;
        if(!isset($data['message'])) $data['message'] = null;
        
        $d = $this->job_library->get_list($data['mode'], $data['id'], $data['offset'], 0);
        $data['jobs'] = $d['jobs'];
        $data['pagination'] = $d['pagination'];
        
        $data['user_id'] = $this->user_id;
        $data['user_type'] = 1;
        $data['header'] = 'admin';
        $this->template->set(array('job/list', $data));
    }

    public function index() {
        $this->job();
    }
    
    public function job($offset = null){
        $data['message'] = null;
        $data['offset'] = $offset;
        $data['mode'] = 'admin';
        $data['id'] = 0; //get job_status = 0
        $this->content_main($data);
    }
    
    public function status($job_id = null, $job_status = null){
        if($job_id != null && $job_status != null){
            $ret = $this->job_model->admin_status_job(array($job_id, $job_status))->row();
            $data['message'] = $ret->message;
            $data['mode'] = 'admin';
            $data['id'] = 0; //get job_status = 0
            $this->content_main($data);
        }
    }

}

?>
