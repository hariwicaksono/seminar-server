<?php  
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Seminar extends REST_Controller{
	
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
			$seminar = $this->Model->get_seminar();
		} else {
			$seminar = $this->Model->get_seminar($id);
		}
 
		if ($seminar > 0) {
			$this->response([
				'status' => 1,
				'data' => $seminar
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
		$query = $this->db->query("SELECT max(id_seminar) AS last FROM seminar WHERE id_seminar LIKE '$today%'");
		$data = $query->row_array();
		$lastCard = $data['last'];
		$lastKdUrut = substr($lastCard, 5, 4);
		$nextKdUrut = $lastKdUrut + 1;
		$nextKd = $today.sprintf('%04s', $nextKdUrut);
		$token_seminar = sha1($nextKd);
		$data = [
			'id_seminar' => $nextKd,
			'nm_seminar' => $this->post('nm_seminar'),
			'tgl_seminar' => $this->post('tgl_seminar'),
			'jam_seminar' => $this->post('jam_seminar'),
			'lokasi_seminar' => $this->post('lokasi_seminar'),
			'biaya_seminar' =>$this->post('biaya_seminar'),
			'headline_seminar' =>$this->post('headline_seminar'),
			'deskripsi_seminar' =>$this->post('deskripsi_seminar'),
			'aktif_seminar' => 'Y',
			'cr_dt_seminar' => $tgl_sekarang,
			'cr_tm_seminar' => $jam_sekarang,
			'cr_username_seminar' =>$this->post('cr_username_seminar'),
			'token_seminar' =>$token_seminar,
			'id_sertifikat' =>$this->post('id_sertifikat'),
		];

		if ($this->Model->post_seminar($data) > 0) {
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
			if ($this->Model->delete_seminar($id)) {
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
		$id = $this->put('id_seminar');
		$tgl_sekarang = date("Y-m-d");
		$jam_sekarang = date("H:i:s");
		$data = [
			'nm_seminar' => $this->put('nm_seminar'),
			'tgl_seminar' => $this->put('tgl_seminar'),
			'jam_seminar' => $this->put('jam_seminar'),
			'biaya_seminar' => $this->put('biaya_seminar'),
			'lokasi_seminar' => $this->put('lokasi_seminar'),
			'headline_seminar' => $this->put('headline_seminar'),
			'deskripsi_seminar' => $this->put('deskripsi_seminar'),
			'aktif_seminar' => $this->put('aktif_seminar'),
			'md_dt_seminar' => $tgl_sekarang,
			'md_tm_seminar' => $jam_sekarang,
			'md_username_seminar' => $this->put('md_username_seminar'),
		];

		

		if ($this->Model->put_seminar($id,$data) > 0 ) {
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