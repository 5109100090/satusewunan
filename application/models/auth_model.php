<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of auth_model
 *
 * @author spondbob
 */
class Auth_model extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function email_check($params){
        $sql = "CALL sp_email_check(?)";
        return $this->db->query($sql, $params);
    }
    
    public function login($params){
        $sql = "CALL sp_login(?, ?)";
        return $this->db->query($sql, $params);
    }
    
    public function register($params){
        $sql = "CALL sp_register(?, ?)";
        return $this->db->query($sql, $params);
    }
    
    public function history($params){
        $sql = "CALL sp_list_history(?)";
        return $this->db->query($sql, $params);
    }
}

?>
