<?php  
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class CheckPeserta extends REST_Controller{
 
	public function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('MasterModel','Model');
        header('Access-Control-Allow-Origin: *');
       header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
       header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT ,DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
    }
 
	public function index_get()
	{
		$id = $this->get('no_id');
		$nama = $this->get('nm_peserta');
		$orang = $this->Model->check_peserta($id, $nama);
		

		if ($orang > 0) {
			$this->response([
				'status' => 1,
				'results' => $orang
			],REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => 0,
				'results' => 'not available'
			],REST_Controller::HTTP_NOT_FOUND);
		}

	} 

}