<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pagination extends CI_Controller 
{
    public function __construct() {
        parent:: __construct();
      
        $this->load->helper("url");
        $this->load->model("Countries");
        $this->load->library("pagination");
    }

    public function example1() {
        $config = array();
        $config["base_url"] = base_url() . "pagination/example1";
        $config["total_rows"] = $this->Countries->record_count();
        $config["per_page"] = 20;
        $config["uri_segment"] = 3;

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["results"] = $this->Countries->fetch_countries($config["per_page"], $page);
        $data["links"] = $this->pagination->create_links();

        $this->load->view("Pagination/example1", $data);
    }
}