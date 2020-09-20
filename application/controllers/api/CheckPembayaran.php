<?php  
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';
class CheckPembayaran extends REST_Controller{
 
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
		$peserta = $this->get('id_peserta');
		$seminar = $this->get('id_seminar');
		$orang = $this->Model->check_pembayaran($peserta, $seminar);
		
		if ($orang > 0) {
			$this->response([
				'status' => 1,
				'results' => $orang
			],REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => 0,
				'results' => 'Not Found'
			],REST_Controller::HTTP_NOT_FOUND);
		}

	} 

}