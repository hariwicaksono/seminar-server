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
			$user = $this->Model->get_peserta();
		} else {
			$user = $this->Model->get_peserta($id);
		}
 
		if ($user > 0) {
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
		$kode_aktivasi = substr(md5(uniqid(rand(),1)),3,20);
		$today = date("Ym");
		$query = $this->db->query("SELECT max(id_peserta) AS last FROM peserta WHERE id_peserta LIKE '$today%'");
		$data = $query->row_array();
		$lastCard = $data['last'];
		$lastKdUrut = substr($lastCard, 8, 4);
		$nextKdUrut = $lastKdUrut + 1;
		$nextKd = $today.sprintf('%04s', $nextKdUrut);
		$token_pst = sha1($nextKd);
		$qrcode = base_url().'sertifikat/'.$nextKd;

		$this->load->library('ciqrcode'); //pemanggilan library QR CODE
		$config['cacheable']	= true; //boolean, the default is true
		$config['imagedir']		= './assets/images/qrcode/'; //direktori penyimpanan qr code
		$config['quality']		= true; //boolean, the default is true
		$config['size']			= '128'; //interger, the default is 1024
		$config['black']		= array(224,255,255); // array, default is array(255,255,255)
		$config['white']		= array(70,130,180); // array, default is array(0,0,0)
		$this->ciqrcode->initialize($config);
		$qrcode_name= 'qr'.$nextKd.'.png'; //buat name dari qr code sesuai dengan nim
		$params['data'] = $qrcode; //data yang akan di jadikan QR CODE
		$params['level'] = 'H'; //H=High
		$params['size'] = 25;
		$params['savename'] = FCPATH.$config['imagedir'].$qrcode_name; //simpan image QR CODE ke folder assets/images/
		$this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

		/**$url = "http://localhost:3000/aktivasi_akun/$kode_aktivasi"; //ganti url sesuaikan dengan url anda
		$get_email = $this->db->query("SELECT * FROM pengaturan WHERE id_pengaturan = '1'");
		$row = $get_email->row_array();
		$from = $row['email_from']; //alamat email anda
		$receiver = $this->post('email'); //email penerima
		$subject = 'Seminar - Aktivasi Akun Anda';  
		$message = '<h3>Hallo Pengguna</h3><p>Email yang anda daftarkan: '.$this->post('email').'<br>Password: '.$this->post('password').'</p><h2>Mohon Klik/Tap pada <u>Link aktivasi dibawah ini</u> untuk mengaktifkan akun anda. Setelah itu anda dapat Login</h2><a style="font-size:24px" href='.$url.'>'.$url.'</a><hr><br><br>Terima Kasih';
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = $row['smtp_host']; //ganti dengan host smtp anda
		$config['smtp_port'] = $row['smtp_port']; //ganti dengan port smtp anda
		$config['smtp_user'] = $row['smtp_user']; //ganti dengan username smtp anda
		$config['smtp_pass'] = $row['smtp_pass']; //ganti dengan password smtp anda
		$config['mailtype'] = 'html';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = 'TRUE';
		$config['newline'] = "\r\n"; 
		$this->load->library('email', $config);
		$this->email->initialize($config);
		$this->email->from($from);
		$this->email->to($receiver);
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->send();**/
				 
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
			'password' => md5($this->post('password')),
			'qrcode' => $qrcode_name,
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

	public function index_delete()
	{
		$id = $_GET['id'];
		if ($id == null) {
			$this->response([
				'status' => 404,
				'data' => 'id_not found'
			],REST_Controller::HTTP_BAD_REQUEST);
		} else {
			if($this->Model->delete_peserta($id) > 0){
					$this->response([
					'status' => 1,
					'data' => 'Succes Delete data'
				],REST_Controller::HTTP_OK);
			} else {
				$this->response([
					'status' => 0,
					'data' => 'Failed Delete Data'
				],REST_Controller::HTTP_NOT_FOUND);
			}
		} 
	}

	

}