<?php  
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Pendidikan extends REST_Controller{
	
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
		$id = $this->get('id');
		if ($id == null) {
			$data = $this->Model->get_pendidikan();
		} else {
			$data = $this->Model->get_pendidikan($id);
		}
 
		if ($data > 0) {
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


	public function index_post()
	{
		$tgl_sekarang = date("Y-m-d");
		$jam_sekarang = date("H:i:s");
		$today = date("ym");
		$query = $this->db->query("SELECT max(id_pendidikan) AS last FROM pendidikan WHERE id_pendidikan LIKE '$today%'");
		$data = $query->row_array();
		$lastCard = $data['last'];
		$lastKdUrut = substr($lastCard, 5, 4);
		$nextKdUrut = $lastKdUrut + 1;
		$nextKd = $today.sprintf('%04s', $nextKdUrut);
		$token_pendidikan = sha1($nextKd);
		$data = [
			'id_pendidikan' => $nextKd,
			'pendidikan' => $this->post('pendidikan'),
			'aktif_pendidikan' => 'Y',
			'cr_dt_pendidikan' => $tgl_sekarang,
			'cr_tm_pendidikan' => $jam_sekarang,
			'cr_username_pendidikan' => $this->post('cr_username_pendidikan'),
			'token_pendidikan' => $token_pendidikan,
		];

		if ($this->Model->post_pendidikan($data) > 0) {
			$this->response([
				'status' => 1,
				'data' => 'Success Post Data'
			],REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => 0,
				'data' => 'Failed Post'
			],REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function index_put()
	{
		$id = $this->put('id_pendidikan');
		$tgl_sekarang = date("Y-m-d");
		$jam_sekarang = date("H:i:s");
		$data = [
			'pendidikan' => $this->put('pendidikan'),
			'aktif_pendidikan' => $this->put('aktif_pendidikan'),
			'md_dt_pendidikan' => $tgl_sekarang,
			'md_tm_pendidikan' => $jam_sekarang,
			'md_username_pendidikan' => $this->put('md_username_pendidikan')
		];

		if ($this->Model->put_pendidikan($id,$data) > 0 ) {
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

	public function index_delete()
	{
		$id = $_GET['id'];
		if ($id == null) {
			$this->response([
				'status' => 0,
				'data' => 'Id Null'
			],REST_Controller::HTTP_BAD_REQUEST);
		} else {
			if ($this->Model->delete_pendidikan($id)) {
				$this->response([
					'status' => 1,
					'data' => 'Success Delete'
				],REST_Controller::HTTP_OK);
			} else {
				$this->response([
					'status' => 0,
					'data' => 'Failed DELETE'
				],REST_Controller::HTTP_NOT_FOUND);
			}
		}
	}



}