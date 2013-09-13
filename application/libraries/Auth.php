<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth {

    var $CI = null;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->library(array('session', 'form_validation'));
        $this->CI->load->model(array('auth_model'));
    }

    public function check($page = null, $type = null) {
        if ($this->CI->session->userdata('user_email') && $this->CI->session->userdata('user_password')) {
            $data = array(
                'user_id' => $this->CI->session->userdata('user_id'),
                'user_email' => $this->CI->session->userdata('user_email'),
                'user_type' => $this->CI->session->userdata('user_type'),
            );
            if ($type == 'admin') {
                if ($this->CI->session->userdata('user_type') == 1) {
                    return $data;
                } else {
                    if ($page == null)
                        return FALSE;
                    else
                        redirect($page);
                }
            }else{
                return $data;
            }
        } else {
            if ($page == null)
                return FALSE;
            else
                redirect($page);
        }
    }

    public function email_check($str) {
        $ret = $this->CI->auth_model->email_check($str)->row();
        if ($ret->id == 1) {
            return TRUE;
        } else {
            $this->CI->form_validation->set_message('email_check', $ret->message);
            return FALSE;
        }
    }

    public function validate_form($mode) {
        if ($mode == null)
            return false;
        $val = $this->CI->form_validation;
        $val->set_rules('email', 'email', 'trim|required|max_length[100]|valid_email' . ($mode == "register" ? '|callback_email_check' : '') . '|xss_clean');
        $val->set_rules('password', 'password', 'trim|required|xss_clean');

        if ($mode == "register")
            $val->set_rules('again', 'ulangi password', 'trim|required|matches[password]|xss_clean');

        if ($val->run())
            return array(
                'user_email' => $val->set_value('email'),
                'user_password' => $val->set_value('password')
            );

        return false;
    }

}

?>