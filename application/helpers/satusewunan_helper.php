<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function job_status($opt = -1) {
    $data = array(
        0 => array('message' => 'nunggu di approve', 'color' => 'brown'),
        1 => array('message' => 'lagi ngerjain', 'color' => 'blue'),
        2 => array('message' => 'udah selesai', 'color' => 'green'),
        3 => array('message' => 'gak iso ngerjake', 'color' => 'red'),
    );
    if ($opt != -1)
        return $data[$opt];
    return $data;
}

?>
