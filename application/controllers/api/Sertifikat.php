<?php  
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Sertifikat extends REST_Controller{
	
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
			$sertifikat = $this->Model->get_sertifikat();
		} else {
			$sertifikat = $this->Model->get_sertifikat($id);
		}
 
		if ($sertifikat > 0) {
			$this->response([
				'status' => 1,
				'data' => $sertifikat
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
		$query = $this->db->query("SELECT max(id_sertifikat) AS last FROM sertifikat WHERE id_sertifikat LIKE '$today%'");
		$data = $query->row_array();
		$lastCard = $data['last'];
		$lastKdUrut = substr($lastCard, 5, 4);
		$nextKdUrut = $lastKdUrut + 1;
		$nextKd = "SRT".$today.sprintf('%04s', $nextKdUrut);
		$token_sertifikat = sha1($nextKd);
		$data = [
			'id_sertifikat' => $nextKd,
			'img_sertifikat' => $this->post('foto'),
			'ketua_sertifikat' => $this->post('ketua_sertifikat'),
			'pejabat1_sertifikat' => $this->post('pejabat1_sertifikat'),
			'pejabat2_sertifikat' => $this->post('pejabat1_sertifikat'),
			'tanggal_sertifikat' => $this->post('tanggal_sertifikat'),
			'cr_dt_sertifikat' => $tgl_sekarang,
			'cr_tm_sertifikat' => $jam_sekarang,
			'cr_username_sertifikat' =>$this->post('cr_username_sertifikat'),
			'token_sertifikat' =>$token_sertifikat,
		];

		if ($this->Model->post_sertifikat($data) > 0) {
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
			if ($this->Model->delete_sertifikat($id)) {
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
		$id = $this->put('id_sertifikat');
		$tgl_sekarang = date("Y-m-d");
		$jam_sekarang = date("H:i:s");
		$data = [
			//'img_sertifikat' => $this->put('foto'),
			'ketua_sertifikat' => $this->put('ketua_sertifikat'),
			'pejabat1_sertifikat' => $this->put('pejabat1_sertifikat'),
			'pejabat2_sertifikat' => $this->put('pejabat2_sertifikat'),
			'tanggal_sertifikat' => $this->put('tanggal_sertifikat'),
			'md_dt_sertifikat' => $tgl_sekarang,
			'md_tm_sertifikat' => $jam_sekarang,
			'md_username_sertifikat' => $this->put('md_username_sertifikat'),
		];

		

		if ($this->Model->put_sertifikat($id,$data) > 0 ) {
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