<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Redis_tuts extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
            $this->load->library('redis', array('connection_group' => 'slave'), 'redis_slave');
            echo $this->redis_slave->command('PING');
            echo "<br>";
            echo $this->redis->hmset('foohash', array('key1' => 'value1', 'key2' => 'value2'));
            echo "<br>";
            $array = $this->redis->hmget('foohash','key1');
            print_r($array);
            
            
	}
}
