<?php
class Default_modelo extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->db->query("SET lc_time_names = 'es_ES'");
    }
}