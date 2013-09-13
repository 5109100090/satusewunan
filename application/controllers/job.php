<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Job extends CI_Controller {
    var $user_id = null;
    var $user_type = null;
    
    function __construct() {
        parent::__construct();
        $this->load->library(array('template','job_library','session'));
        $this->load->helper(array('url','date','satusewunan'));
        $this->load->model(array('job_model','category_model'));
        $this->user_id = $this->session->userdata('user_id');
        $this->user_type = $this->session->userdata('user_type');
    }

    public function index() {
        $this->all();
    }
    
    private function content_main($data){
        $m = $data['message'];
        $data = $this->job_library->get_list($data['mode'], $data['param'], $data['offset']);
        $data['user_id'] = $this->user_id;
        $data['user_type'] = $this->user_type;
        $data['header'] = null; //'serba satusewunan'
        $data['message'] = $m;
        $this->template->set(array('job/list', $data));
    }
    
    private function show_category(){
        $message = anchor('job/all', 'Semua');
        foreach($this->category_model->get_list()->result() as $row)
            $message .= '&nbsp;&nbsp;&nbsp;'.anchor('job/category/'.$row->category_id, $row->category_name);
        return '<center>'.$message.'</center>';
    }
    
    public function all($offset = null){
        $data['message'] = $this->show_category();
        $data['mode'] = 'all';
        $data['param'] = 0;    //known as job_status
        $data['offset'] = $offset;
        $this->content_main($data);
    }
    
    public function category($category_id = null, $offset = null){
        $data['mode'] = 'category';
        $data['param'] = $category_id;
        $data['offset'] = $offset;
        $data['message'] = $this->show_category();
        $this->content_main($data);
    }
    
    public function search($offset = null){
        $q = $this->input->post('q');
        if(trim($q) != ""){
            $data['mode'] = 'search';
            $data['param'] = $q;
            $data['offset'] = $offset;
            $data['message'] = $this->show_category()."hasil pencarian dengan kata kunci &rarr; `<em>".$q."</em>`";
            $this->content_main($data);
        }else{
            $this->all();
        }
    }
    
    public function member($job_id = null) {
        $data['job_id'] = $job_id;
        $data['user_id'] = $this->user_id;
        $this->job_library->get_member($data);
    }

}