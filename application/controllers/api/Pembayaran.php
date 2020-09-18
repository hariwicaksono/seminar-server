<?php  
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Pembayaran extends REST_Controller{
	
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
			$user = $this->Model->get_pembayaran();
		} else {
			$user = $this->Model->get_pembayaran($id);
		}
 
		if ($user) {
			$this->response([
				'status' => 1,
				'data' => $user
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
		$today = date("Ym");
		$query = $this->db->query("SELECT max(id_pembayaran) AS last FROM pembayaran WHERE id_pembayaran LIKE '$today%'");
		$data = $query->row_array();
		$lastCard = $data['last'];
		$lastKdUrut = substr($lastCard, 8, 4);
		$nextKdUrut = $lastKdUrut + 1;
		$nextKd = $today.sprintf('%04s', $nextKdUrut);
		$token_pay = sha1($nextKd);
		$data = [
			'id_pembayaran' => $nextKd,
			'id_peserta' => $this->post('id_peserta'),
			'id_seminar' => $this->post('id_seminar'),
			'id_bank' => $this->post('bank_tujuan'),
			'bank_transfer' => '1',
			'jml_transfer' => $this->post('jml_trf'),
			'nm_pemilik_rek' => $this->post('pemilik_rek'),
			'informasi_tambahan' => $this->post('info_tambahan'),
			'tgl_transfer' => $tgl_sekarang,
			'jam_transfer' => $jam_sekarang,
			'img_bayar' => $this->post('foto'),
			'status_bayar' => 'Baru',
			'token_bayar' => $token_pay,
		];

		if ($this->Model->post_pembayaran($data) > 0) {
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

	public function index_put()
	{
		$id = $this->put('id');
		$data = [
			'nama_user' => $this->put('nama'),
			'alamat_user' => $this->put('alamat'),
			'no_hp_user' => $this->put('hp'),
			'email_user' => $this->put('email'),
			'password_user' => $this->put('password'),
			'photo_user' => $this->put('foto')
		];

		

		if ($this->Model->put_user($id,$data) > 0 ) {
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