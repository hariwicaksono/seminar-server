<?php  
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Bank extends REST_Controller{
	
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
			$bank = $this->Model->get_bank();
		} else {
			$bank = $this->Model->get_bank($id);
		}
 
		if ($bank > 0) {
			$this->response([
				'status' => 1,
				'data' => $bank
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
		$query = $this->db->query("SELECT max(id_bank) AS last FROM bank WHERE id_bank LIKE '$today%'");
		$data = $query->row_array();
		$lastCard = $data['last'];
		$lastKdUrut = substr($lastCard, 5, 4);
		$nextKdUrut = $lastKdUrut + 1;
		$nextKd = $today.sprintf('%04s', $nextKdUrut);
		$token_bank = sha1($nextKd);
		$data = [
			'id_bank' => $nextKd,
			'nm_bank' => $this->post('nm_bank'),
			'no_rek' => $this->post('no_rek'),
			'pemilik_rek' => $this->post('pemilik_rek'),
			'kantor_cabang' => $this->post('kantor_cabang'),
			'aktif_bank' => 'Y',
			'cr_dt_bank' => $tgl_sekarang,
			'cr_tm_bank' => $jam_sekarang,
			'cr_username_bank' => $this->post('cr_username_bank'),
			'token_bank' => $token_bank,
		];

		if ($this->Model->post_bank($data) > 0) {
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
		$id = $this->put('id_bank');
		$tgl_sekarang = date("Y-m-d");
		$jam_sekarang = date("H:i:s");
		$data = [
			'nm_bank' => $this->put('nm_bank'),
			'no_rek' => $this->put('no_rek'),
			'pemilik_rek' => $this->put('pemilik_rek'),
			'kantor_cabang' => $this->put('kantor_cabang'),
			'aktif_bank' => $this->put('aktif_bank'),
			'md_dt_bank' => $tgl_sekarang,
			'md_tm_bank' => $jam_sekarang,
			'md_username_bank' => $this->put('md_username_bank')
		];

		

		if ($this->Model->put_bank($id,$data) > 0 ) {
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
			if ($this->Model->delete_user($id)) {
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