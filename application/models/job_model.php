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
class Job_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('pagination');
    }

    public function count_list_job($mode, $param, $job_status){
        if ($mode == "post")
            $sql = "SELECT * from `job` left join `user` on `user`.user_id = `job`.job_author where `job`.`job_author` = $param";
        elseif ($mode == "join")
            $sql = "SELECT `job_id` FROM `user_job` WHERE `user_id` = $param";
        elseif ($mode == "category")
            $sql = "SELECT *
		from (`job` left join `category` on `job`.job_category = `category`.category_id)
		left join `user`
		on `user`.user_id = `job`.job_author
		where `job`.job_category = $param and `job`.job_status = $job_status";
        elseif ($mode == "search")
            $sql = "select * from `job` where `job`.job_status = $job_status and `job_detail` like concat('%',$param,'%')";
        elseif ($mode == "job_status")
            $sql = "select * from `job` where `job`.job_status = $job_status and `job_author` = $param";
        elseif ($mode == "my_job_status")
            $sql = "select * from `user_job` where status = $job_status and user_id = $param";
        else
            $sql = "SELECT * from `job` where `job`.job_status = $job_status";

        return $this->db->query($sql)->num_rows();
    }
    
    public function list_job($mode, $params) {
        if ($mode == "post")
            $sql = "CALL sp_list_posted_job(?, ?, ?)";
        elseif ($mode == "join")
            $sql = "CALL sp_list_joined_job(?, ?, ?)";
        elseif ($mode == "category")
            $sql = "CALL sp_list_category_job(?, ?, ?, ?)";
        elseif ($mode == "search")
            $sql = "CALL sp_search_job(?, ?, ?, ?)";
        elseif ($mode == "job_status")
            $sql = "CALL sp_list_job_by_status(?, ?, ?, ?)";
        else
            $sql = "CALL sp_list_all_job(?, ?, ?, ?)";

        return $this->db->query($sql, $params);
    }

    public function join_job($params) {
        $sql = "CALL sp_join_job(?, ?)";
        return $this->db->query($sql, $params);
    }

    public function post_job($params) {
        $sql = "CALL sp_post_job(?, ?, ?)";
        return $this->db->query($sql, $params);
    }

    public function member_job($params) {
        $sql = "CALL sp_member_job(?)";
        return $this->db->query($sql, $params);
    }
    
    public function detail_job($params) {
        $sql = "CALL sp_detail_job(?)";
        return $this->db->query($sql, $params);
    }
    
    public function delete_job($params) {
        $sql = "CALL sp_delete_job(?, ?)";
        return $this->db->query($sql, $params);
    }
    
    public function status_job($params) {
        $sql = "CALL sp_status_job(?, ?, ?)";
        return $this->db->query($sql, $params);
    }
    
    public function admin_status_job($params) {
        $sql = "CALL sp_admin_status_job(?, ?)";
        return $this->db->query($sql, $params);
    }
}

?>
