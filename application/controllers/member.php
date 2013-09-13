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
class Member extends CI_Controller {

    //put your code here
    private $user_id = null;

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url','form','date','satusewunan'));
        $this->load->library(array('template', 'auth', 'session', 'table', 'form_validation', 'pagination', 'job_library'));
        $this->auth->check('/');
        $this->load->model(array('job_model', 'category_model'));
        $this->user_id = $this->session->userdata('user_id');
    }

    private function content_main($data) {
        $data['category'] = $this->category_model->get_list()->result();
        $data['post_num'] = $this->job_model->count_list_job('post', $this->user_id, 0);
        $data['join_num'] = $this->job_model->count_list_job('join', $this->user_id, 0);
        $data['job_close_num'] = $this->job_model->count_list_job('job_status', $this->user_id, 2);
        $data['my_job_status_num'] = $this->job_model->count_list_job('my_job_status', $this->user_id, 2);
        $this->template->set(array('member/main', $data));
    }
    
    private function content_list($data) {
        if(!isset($data['message'])) $data['message'] = null;
        if(!isset($data['user_id'])) $data['user_id'] = $this->user_id;
        if(!isset($data['mode'])) $data['mode'] = 'post';
        if(!isset($data['header'])) $data['header'] = 'Job saya buat';
        if(!isset($data['offset'])) $data['offset'] = null;
        
        $d = $this->job_library->get_list($data['mode'], $this->user_id, $data['offset']);
        $data['jobs'] = $d['jobs'];
        $data['pagination'] = $d['pagination'];
        $this->template->set(array('job/list', $data));
    }

    public function index() {
        $data['message'] = null;
        $this->content_main($data);
    }

    public function post($offset = null) {
        $data['offset'] = $offset;
        if ($this->input->post('simpan')) {
            $val = $this->form_validation;
            $val->set_rules('category', 'Kategori', 'trim|required');
            $val->set_rules('detail', 'Detail', 'trim|required|min_length[10]|max_length[140]');
            if ($val->run()) {
                $params = array(
                    $this->user_id,
                    $val->set_value('detail'),
                    $val->set_value('category'),
                );
                $ret = $this->job_model->post_job($params)->row();
                $data['message'] = $ret->message;
                if ($ret->id == -1) {
                    $this->content_main($data);
                } else {
                    $this->content_list($data);
                }
            } else {
                $data['message'] = validation_errors('<p style="color:red">', '</p>');
                $this->content_main($data);
            }
        } else {
            $this->content_list($data);
        }
    }

    public function join($job_id = null) {
        $data['mode'] = 'join';
        $data['header'] = 'Job saya ikuti';
        if ($job_id != null && $job_id > 0) {
            $ret = $this->job_model->join_job(array($this->user_id, $job_id))->row();
            $data['message'] = $ret->message;
        } else {
            if ($this->uri->segment(3) == "page" && $this->uri->segment(4) > 0)
                $data['offset'] = $this->uri->segment(4);
        }
        $this->content_list($data);
    }

    public function delete($job_id = null) {
        if ($job_id != null) {
            $ret = $this->job_model->delete_job(array($this->user_id, $job_id))->row();
            $data['message'] = '<p style="color:red">'.$ret->message.'</p>';
            $this->content_list($data);
        }
    }

    public function job($job_id = null, $job_status = null) {
        if($job_id != null && $job_status != null){
            $ret = $this->job_model->admin_status_job(array($job_id, $job_status))->row();
            $data['message'] = $ret->message;
            $this->content_list($data);
        }/*else{
            $data['mode'] = 'all';
            $data['param'] = 2;    //known as job_status
            $this->content_list($data);
        }*/
    }

    public function status($user_id = null, $job_id = null, $job_status = null) {
        if ($user_id != null && $user_id > 0 && $job_id != null && $job_id > 0 && $job_status != null && $job_status > 0) {
            $ret = $this->job_model->status_job(array($user_id, $job_id, $job_status))->row();
            $data['message'] = '<p style="color:red">'.$ret->message.'</p>';
            $data['job_id'] = $job_id;
            $data['user_id'] = $this->user_id;
            $this->job_library->get_member($data);
        }
    }

}

?>
