<?php

class Authenticate extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(array('auth_model'));
        $this->load->library(array('template', 'auth', 'table', 'form_validation', 'session'));
        $this->load->helper(array('url', 'form'));
    }

    public function email_check($str) {
        $ret = $this->auth_model->email_check($str)->row();
        if ($ret->id == 1) {
            return TRUE;
        } else {
            $this->form_validation->set_message('email_check', $ret->message);
            return FALSE;
        }
    }

    public function validate_form($mode) {
        if ($mode == null)
            return false;
        $val = $this->form_validation;
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

    private function content_main($data) {
        $this->template->set(array('auth/main', $data));
    }

    public function index() {
        $data['message'] = null;
        $user_id = $this->session->flashdata('user_id');
        $user_email = $this->session->flashdata('user_email');
        if ($user_id != null && $user_email != null) {
            $this->session->sess_destroy();
            $user = explode('@', $user_email);
            $r = explode('.', $user[1]);
            $data['message_history'] = 'Ringkasan Aktivitas <strong>' . $user[0] . ' [at] ' . $r[0] . ' [dot] ' . $r[1] . '</strong> :';
            $data['list_history'] = $this->auth_model->history($user_id);
        }
        $this->content_main($data);
    }

    public function login() {
        $data['message'] = null;

        $value = $this->validate_form("login");
        if ($value) {
            $ret = $this->auth_model->login(array($value['user_email'], $value['user_password']))->row();
            if (isset($ret->id) && $ret->id == -1) {
                $data['message'] = '<p style="color:red">' . $ret->message . '</p>';
            } else {
                $value['user_id'] = $ret->user_id;
                $value['user_type'] = $ret->user_type;
                $this->session->set_userdata($value);
                if ($ret->user_type == 1) {
                    redirect('admin');
                }
                redirect('member');
            }
        } else {
            $data['message'] = validation_errors('<p style="color:red">', '</p>');
        }

        $this->content_main($data);
    }

    public function register() {
        $data['message'] = null;

        $value = $this->validate_form("register");
        if ($value) {
            $ret = $this->auth_model->register($value)->row();
            $data['message'] = '<p style="color:' . ($ret->id == 1 ? 'green' : 'red') . '">' . $ret->message . '</p>';
        } else {
            $data['message'] = validation_errors('<p style="color:red">', '</p>');
        }

        $this->content_main($data);
    }

    public function logout() {
        $data = array(
            'user_id' => $this->session->userdata('user_id'),
            'user_email' => $this->session->userdata('user_email')
        );
        $array_items = array('user_email' => '', 'user_id' => '', 'user_type' => '', 'user_password' => '');
        $this->session->unset_userdata($array_items);
        $this->session->sess_destroy();
        $this->session->set_flashdata($data);
        redirect("/authenticate");
    }

}

?>