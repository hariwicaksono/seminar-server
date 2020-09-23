<?php  
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class IdentitasWeb extends REST_Controller{
	
	public function __construct($config = 'rest')
    {
        parent::__construct($config);
        $this->load->model('MasterModel','Model');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $method = $_SERVER['REQUEST_METHOD'];
        if($method == "OPTIONS") {
            die();
        }
    }
 
	public function index_get()
	{
		$id = '1';
		$data = $this->Model->get_identitasweb($id);
 
		if ($data) {
			$this->response([
				'status' => 1,
				'data' => $data
			],REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => 0,
				'data' => 'NOT FOUND'
			],REST_Controller::HTTP_NOT_FOUND);
		}

	}

	public function index_put()
	{
		$id = '1';
		$data = [
			'nm_website' => $this->put('nm_website'),
			'nama_pt' => $this->put('nama_pt'),
			'kode_pos' => $this->put('kode_pos'),
			'tlp_pt' => $this->put('tlp_pt'),
			'rekening_pt' => $this->put('rekening_pt'),
			'email_pt' => $this->put('email_pt'),
			'url' => $this->put('url'),
			'facebook' => $this->put('facebook'),
			'twitter' => $this->put('twitter'),
			'instagram' => $this->put('instagram'),
			'meta_deskripsi' => $this->put('meta_deskripsi'),
			'meta_keyword' => $this->put('meta_keyword'),
			'favicon' => 'favicon.ico'
		];

		

		if ($this->Model->put_identitasweb($id,$data) > 0 ) {
			$this->response([
				'status' => 1,
				'data' => 'Success Update Data'
			],REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => 0,
				'data' => 'Failed Update'
			],REST_Controller::HTTP_NOT_FOUND);
		}

	}


} 