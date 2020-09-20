<?php  
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Peserta extends REST_Controller{
	
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
			//$this->response(['id'=> 'kosong']);
			$user = $this->Model->get_peserta();
		} else {
			$user = $this->Model->get_peserta($id);
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
		$password_baru = substr(md5(uniqid(rand(),1)),3,10);
		$kode_aktivasi = substr(md5(uniqid(rand(),1)),3,20);
		$today = date("Ym");
		$query = $this->db->query("SELECT max(id_peserta) AS last FROM peserta WHERE id_peserta LIKE '$today%'");
		$data = $query->row_array();
		$lastCard = $data['last'];
		$lastKdUrut = substr($lastCard, 8, 4);
		$nextKdUrut = $lastKdUrut + 1;
		$nextKd = $today.sprintf('%04s', $nextKdUrut);
		$token_pst = sha1($nextKd);

		$data = [
			'id_peserta' => $nextKd,
			'id_seminar' => $this->post('id_seminar'),
			'id_kartu' => $this->post('jns_id'),
			'id_pendidikan' => $this->post('pendidikan'),
			'no_kartuid' => $this->post('no_id'),
			'nama_peserta' => $this->post('nm_peserta'),
			'range_usia' => $this->post('usia'),
			'jns_kelamin' => $this->post('kelamin'),
			'alamat_peserta' => $this->post('alamat'),
			'kota_kab_peserta' => $this->post('kota_kab'),
			'kode_pos' => $this->post('kodepos'),
			'no_hp' => $this->post('no_hp'),
			'email_peserta' => $this->post('email'),
			'tgl_daftar' => $tgl_sekarang,
			'jam_daftar' => $jam_sekarang,
			'kode_aktivasi' => $kode_aktivasi,
			'password' => $password_baru,
			'token_peserta' => $token_pst
		];

		if ($this->Model->post_peserta($data) > 0) {
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
		$id = $this->put('id');
		$data = [
			'nama' => $this->put('nama'),
			'telp' => $this->put('telp'),
			'email' => $this->put('email'),
			'foto' => $this->put('foto')
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