<?php  

class MasterModel extends CI_Model {
 
	public function get_seminar($id = null)
	{
		if ($id == null) {
			return $this->db->get('seminar')->result_array();
		} else { 
			return $this->db->get_where('seminar',['id_seminar'=>$id])->result_array();
		}
	}

	public function put_seminar($id,$data)
	{
		$this->db->update('seminar',$data,['id_seminar'=>$id]);
		return $this->db->affected_rows();
	}

	public function put_status_seminar($id,$data)
	{
		$this->db->update('seminar',$data,['id_seminar'=>$id]);
		return $this->db->affected_rows();
	}

	public function get_aktif_seminar()
	{
		$this->db->select('*');
		$this->db->from('seminar');
		$this->db->where('aktif_seminar','Y');
		return $this->db->get()->result_array();
	}

	public function get_arsip_seminar()
	{
		$this->db->select('*');
		$this->db->from('seminar');
		$this->db->where('aktif_seminar','N');
		return $this->db->get()->result_array();
	}

	public function get_pembayaran($id = null)
	{
		if ($id == null) {
			$this->db->select('pb.id_pembayaran, pb.tgl_transfer, pb.jam_transfer, pb.jml_transfer, pb.nm_pemilik_rek, p.id_peserta, p.nama_peserta, b.nm_bank, b.no_rek, pb.bank_transfer, pb.informasi_tambahan, pb.status_bayar, pb.img_bayar, s.id_seminar, s.nm_seminar');
			$this->db->from('pembayaran pb');
			$this->db->join('peserta p', 'p.id_peserta = pb.id_peserta');
			$this->db->join('seminar s', 's.id_seminar = pb.id_seminar');
			$this->db->join('bank b', 'b.id_bank = pb.id_bank');
			$this->db->group_by('pb.id_pembayaran');   
			$query = $this->db->get();
			return $query->result_array();
		} else { 
			$this->db->select('pb.id_pembayaran, pb.tgl_transfer, pb.jam_transfer, pb.jml_transfer, pb.nm_pemilik_rek, p.id_peserta, p.nama_peserta, b.nm_bank, b.no_rek, pb.bank_transfer, pb.informasi_tambahan, pb.status_bayar, pb.img_bayar, s.id_seminar, s.nm_seminar');
			$this->db->from('pembayaran pb');
			$this->db->join('peserta p', 'p.id_peserta = pb.id_peserta');
			$this->db->join('seminar s', 's.id_seminar = pb.id_seminar');
			$this->db->join('bank b', 'b.id_bank = pb.id_bank');
			$this->db->where('pb.id_pembayaran', $id);
			$this->db->group_by('pb.id_pembayaran');   
			$query = $this->db->get();
			return $query->result_array();
		}
	}

	public function post_pembayaran($data)
	{
		$this->db->insert('pembayaran',$data);
		return $this->db->affected_rows();
	}

	public function delete_pembayaran($id = null)
	{
		$this->db->delete('pembayaran',['id_pembayaran' => $id]);
		return $this->db->affected_rows();
	}

	public function put_pembayaran($id,$data)
	{
		$this->db->update('pembayaran',$data,['id_pembayaran'=>$id]);
		return $this->db->affected_rows();
	}

	public function get_bank($id = null)
	{
		if ($id == null) {
			return $this->db->get('bank')->result_array();
		} else { 
		return $this->db->get_where('bank',['id_bank'=>$id])->result_array();
		}
	}

	public function post_bank($data)
	{
		$this->db->insert('bank',$data);
		return $this->db->affected_rows();
	}

	public function delete_bank($id = null)
	{
		$this->db->delete('bank',['id_bank' => $id]);
		return $this->db->affected_rows();
	}

	public function put_bank($id,$data)
	{
		$this->db->update('bank',$data,['id_bank'=>$id]);
		return $this->db->affected_rows();
	}

	public function get_profilweb()
	{
		$this->db->select('*');
		$this->db->from('profil_web');
		$this->db->where('aktif_profil','Y');
		return $this->db->get()->result_array();
	}

	public function put_profilweb($id,$data)
	{
		$this->db->update('profil_web',$data,['id_profil'=>$id]);
		return $this->db->affected_rows();
	}

	public function get_caradaftar()
	{
		$this->db->select('*');
		$this->db->from('cara_daftar');
		$this->db->where('aktif_caradaftar','Y');
		return $this->db->get()->result_array();
	}

	public function put_caradaftar($id,$data)
	{
		$this->db->update('cara_daftar',$data,['id_caradaftar'=>$id]);
		return $this->db->affected_rows();
	}
 
	public function get_identitasweb($id)
	{
		return $this->db->get_where('identitas_web',['id_identitas'=>$id])->result_array();
	}

	public function put_identitasweb($id,$data)
	{
		$this->db->update('identitas_web',$data,['id_identitas'=>$id]);
		return $this->db->affected_rows();
	}

	public function cek_login_user($user,$password)
	{
		return $this->db->get_where('peserta',['email_peserta' => $user , 'password'=>$password, 'status_aktivasi'=>'Y' ])->result_array();
		//return $this->db->result_array();
	}
 
	public function cek_login_admin($user,$password)
	{
		return $this->db->get_where('pengguna',['usernm' => $user , 'passwd'=>$password, 'blokir'=>'N' ])->result_array();
		//return $this->db->result_array();
	}
 
	public function get_peserta($id = null)
	{
		if ($id == null) {
			$this->db->select('p.id_peserta, p.id_seminar, s.nm_seminar, p.nama_peserta, jk.nama_jenkel, kt.jns_kartuid, p.no_kartuid, pd.pendidikan, p.range_usia, p.alamat_peserta, kb.name as kota_kab_peserta, p.kode_pos, p.no_hp, p.email_peserta, p.tgl_daftar, p.jam_daftar, p.status_aktivasi');
			$this->db->from('peserta p');
			$this->db->join('seminar s', 's.id_seminar = p.id_seminar');
			$this->db->join('kabupaten kb', 'kb.id = p.kota_kab_peserta');
			$this->db->join('kartu_identitas kt', 'kt.id_kartu = p.id_kartu');
			$this->db->join('pendidikan pd', 'pd.id_pendidikan = p.id_pendidikan');
			$this->db->join('jenis_kelamin jk', 'jk.id_jenkel = p.jns_kelamin');
			$this->db->group_by('p.id_peserta');   
			$query = $this->db->get();
			return $query->result_array();
		} else {
			$this->db->select('p.id_peserta, p.id_seminar, s.nm_seminar, p.nama_peserta, jk.nama_jenkel, kt.jns_kartuid, p.no_kartuid, pd.pendidikan, p.range_usia, p.alamat_peserta, kb.name as kota_kab_peserta, p.kode_pos, p.no_hp, p.email_peserta, p.tgl_daftar, p.jam_daftar, p.status_aktivasi');
			$this->db->from('peserta p');
			$this->db->join('seminar s', 's.id_seminar = p.id_seminar');
			$this->db->join('kabupaten kb', 'kb.id = p.kota_kab_peserta');
			$this->db->join('kartu_identitas kt', 'kt.id_kartu = p.id_kartu');
			$this->db->join('pendidikan pd', 'pd.id_pendidikan = p.id_pendidikan');
			$this->db->join('jenis_kelamin jk', 'jk.id_jenkel = p.jns_kelamin');
			$this->db->where('p.id_peserta', $id);
			$this->db->group_by('p.id_peserta');   
			$query = $this->db->get();
			return $query->result_array();
		}
	}

	public function post_peserta($data)
	{
		$this->db->insert('peserta',$data);
		return $this->db->affected_rows();
	}

	public function put_peserta($id,$data)
	{
		$this->db->update('peserta',$data,['id_peserta'=>$id]);
		return $this->db->affected_rows();
	}

	public function delete_peserta($id = null)
	{
		$this->db->delete('peserta',['id_peserta' => $id]);
		return $this->db->affected_rows();
	}

	public function get_pengguna($id = null)
	{
		if ($id == null) {
			return $this->db->get('pengguna')->result_array();
		} else {
			return $this->db->get_where('pengguna',['usernm'=>$id])->result_array();
		}
	}

	public function post_pengguna($data)
	{
		$this->db->insert('pengguna',$data);
		return $this->db->affected_rows();
	}

	public function delete_pengguna($id = null)
	{
		$this->db->delete('pengguna',['usernm' => $id]);
		return $this->db->affected_rows();
	}

	public function put_pengguna($id,$data)
	{
		$this->db->update('pengguna',$data,['usernm'=>$id]);
		return $this->db->affected_rows();
	}

	public function get_kartuidentitas($id = null)
	{
		if ($id == null) {
			$this->db->select('*');
			$this->db->from('kartu_identitas');
			$this->db->where('aktif_kartuid','Y');
			return $this->db->get()->result_array();
		} else { 
			$this->db->select('*');
			$this->db->from('kartu_identitas');
			$this->db->where('id_kartu',$id);
			$this->db->where('aktif_kartuid','Y');
			return $this->db->get()->result_array();
		}
	}

	public function post_kartuidentitas($data)
	{
		$this->db->insert('kartu_identitas',$data);
		return $this->db->affected_rows();
	}

	public function delete_kartuidentitas($id = null)
	{
		$this->db->delete('kartu_identitas',['id_kartu' => $id]);
		return $this->db->affected_rows();
	}

	public function put_kartuidentitas($id,$data)
	{
		$this->db->update('kartu_identitas',$data,['id_kartu'=>$id]);
		return $this->db->affected_rows();
	}
	
	public function put_status_kartu($id,$data)
	{
		$this->db->update('kartu_identitas',$data,['id_kartu'=>$id]);
		return $this->db->affected_rows();
	}

	public function get_pendidikan($id = null)
	{
		if ($id == null) {
			$this->db->select('*');
			$this->db->from('pendidikan');
			$this->db->where('aktif_pendidikan','Y');
			return $this->db->get()->result_array();
		} else { 
			$this->db->select('*');
			$this->db->from('pendidikan');
			$this->db->where('id_pendidikan',$id);
			$this->db->where('aktif_pendidikan','Y');
			return $this->db->get()->result_array();
		}
	}

	public function post_pendidikan($data)
	{
		$this->db->insert('pendidikan',$data);
		return $this->db->affected_rows();
	}

	public function delete_pendidikan($id = null)
	{
		$this->db->delete('pendidikan',['id_pendidikan' => $id]);
		return $this->db->affected_rows();
	}

	public function put_pendidikan($id,$data)
	{
		$this->db->update('pendidikan',$data,['id_pendidikan'=>$id]);
		return $this->db->affected_rows();
	}

	public function cari_seminar($id='')
	{
		if ($id === '') {
			
		} else {
			$this->db->select('*');
			$this->db->from('seminar');
			$this->db->like('nm_seminar', $id);
			$this->db->or_like('headline_seminar', $id);
			$this->db->or_like('deskripsi_seminar', $id);
			$query = $this->db->get();
			return $query->result_array();
		}
	}

	public function check_peserta($id, $nama)
	{

		$this->db->select('no_kartuid, nama_peserta');
		$this->db->from('peserta');
		$this->db->like('no_kartuid', $id, FALSE);
		$this->db->or_like('nama_peserta', $nama, FALSE);
		$query = $this->db->get();
		return $query->result_array();
	}
 
	public function check_pembayaran($peserta, $seminar)
	{
	
		$this->db->select('*');
		$this->db->from('pembayaran pb, peserta p, seminar s');
		$this->db->where('pb.id_seminar = s.id_seminar');
		$this->db->where('pb.id_peserta = p.id_peserta');
		$this->db->where('pb.id_peserta', $peserta);
		$this->db->where('pb.id_seminar', $seminar);
		$query = $this->db->get();
		return $query->result_array();
		
	}

	public function get_kabupaten($id = null)
	{
		if ($id == null) {
			return $this->db->get('kabupaten')->result_array();
		} else {
			return $this->db->get_where('kabupaten',['id'=>$id])->result_array();
		}
	}

	public function put_aktivasiakun($id,$data)
	{
		$this->db->update('peserta',$data,['kode_aktivasi'=>$id]);
		return $this->db->affected_rows();
	}

	public function get_pembayaran_byid($id)
	{
		$this->db->select('*, kb.name as kota_kab_peserta');
		$this->db->from('peserta p');
		$this->db->join('seminar s', 's.id_seminar = p.id_seminar');
		$this->db->join('kabupaten kb', 'kb.id = p.kota_kab_peserta','left');
		$this->db->join('pembayaran pb', 'pb.id_seminar = s.id_seminar');
		$this->db->join('pembayaran pc', 'pc.id_peserta = p.id_peserta');
		$this->db->where('p.email_peserta', $id);
		$this->db->group_by('p.email_peserta');   
		$query = $this->db->get();
		return $query->result_array();
	}

	public function get_seminar_byid($id)
	{
		$this->db->select('*');
		$this->db->from('seminar s');
		$this->db->join('peserta p', 'p.id_seminar = s.id_seminar');
		$this->db->where('email_peserta', $id);
		$query = $this->db->get();
		return $query->result_array();
	}


	public function get_kalender($id = null)
	{
		$this->db->select('nm_seminar as title, tgl_seminar as date');
		$this->db->from('seminar');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function count_seminar()
	{
		return $this->db->count_all('seminar');  
	}

	public function count_peserta()
	{
		return $this->db->count_all('peserta');  
	}

	public function count_bayarnew()
	{
		$this->db->select('count(*) as  new');
		$this->db->from('pembayaran');
		$this->db->where('status_bayar','Baru');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function count_bayarcancel()
	{
		$this->db->select('count(*) as  cancel');
		$this->db->from('pembayaran');
		$this->db->where('status_bayar','Batal');
		$query = $this->db->get();
		return $query->result_array();
	}
	


}