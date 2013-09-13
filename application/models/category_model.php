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
class Category_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_list(){
        return $this->db->get('category');
    }
    
}
?>
