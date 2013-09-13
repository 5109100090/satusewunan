<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Job_library{
    var $CI = null;
    public function __construct(){
	$this->CI =& get_instance();
        $this->CI->load->helper(array('url'));
        $this->CI->load->library(array('pagination','template'));
        $this->CI->load->model(array('job_model'));
    }
    
    public function get_list($mode, $param, $offset, $job_status = 1){
        if($mode == 'all')
            $url = 'job/all/';
        elseif($mode == 'admin')
            $url = 'admin/job/';
        else
            $url = 'member/'.$mode;
        $config['base_url'] = base_url() . $url;
        $config['total_rows'] = $this->CI->job_model->count_list_job($mode, $param, $job_status);
        $config['per_page'] = 5;
        $config['next_link'] = 'selanjutnya &rarr;';
        $config['prev_link'] = '&larr; sebelumnya';

        $offset = (!is_numeric($offset) || $offset < 1 || empty($offset)) ? 0 : $offset;

        $this->CI->pagination->initialize($config);
        $data['pagination'] = $this->CI->pagination->create_links();
        $data['jobs'] = $this->CI->job_model->list_job($mode, array($param, $offset, $config['per_page'], $job_status));
        
        return $data;
    }
    
    public function get_member($data){
        if(!isset($data['message'])) $data['message'] = null;
        $data['job_detail'] = $this->CI->job_model->detail_job($data['job_id'])->row();
        $data['members'] = $this->CI->job_model->member_job($data['job_id']);
        $this->CI->template->set(array('job/member', $data));
    }
}
?>