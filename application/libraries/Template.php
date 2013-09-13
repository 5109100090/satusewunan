<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Template{	
    var $CI = null;
    function __construct(){
	$this->CI =& get_instance();
        $this->CI->load->library(array('auth'));
        $this->CI->load->model(array('category_model'));
    }
    
    public function set($data){
        $this->get_header();
        $this->get_sidebar();
        $this->CI->load->view($data[0], $data[1]);
        $this->get_footer();
    }
    
    private function get_header(){
        $this->CI->load->view('template/header');
    }

    private function get_sidebar(){
        $data['auth'] = $this->CI->auth->check();
        //$data['category'] = $this->CI->category_model->get_list();
	$this->CI->load->view('template/sidebar', $data);
    }

    private function get_footer(){
        $this->CI->load->view('template/footer');
    }
}
?>