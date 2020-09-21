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
			return $this->db->get('pembayaran')->result_array();
		} else { 
		return $this->db->get_where('pembayaran',['id_pembayaran'=>$id])->result_array();
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

	public function get_profil()
	{
		$this->db->select('*');
		$this->db->from('profil_web');
		$this->db->where('aktif_profil','Y');
		return $this->db->get()->result_array();
	}

	public function get_caradaftar()
	{
		$this->db->select('*');
		$this->db->from('cara_daftar');
		$this->db->where('aktif_caradaftar','Y');
		return $this->db->get()->result_array();
	}
 
	public function get_identitasweb()
	{
		$this->db->select('*');
		$this->db->from('identitas_web');
		$this->db->where('id_identitas','1');
		return $this->db->get()->result_array();
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
			return $this->db->get('peserta')->result_array();
		} else {
			return $this->db->get_where('peserta',['id_peserta'=>$id])->result_array();
		}
	}

	public function post_peserta($data)
	{
		$this->db->insert('peserta',$data);
		return $this->db->affected_rows();
	}

	public function delete_peserta($id = null)
	{
		$this->db->delete('peserta',['id_peserta' => $id]);
		return $this->db->affected_rows();
	}

	public function put_peserta($id,$data)
	{
		$this->db->update('peserta',$data,['id_peserta'=>$id]);
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
		$this->db->join('seminar s', 's.id_seminar = p.id_seminar','left');
		$this->db->join('kabupaten kb', 'kb.id = p.kota_kab_peserta','left');
		$this->db->join('pembayaran pb', 'pb.id_seminar = s.id_seminar','left');
		$this->db->join('pembayaran pc', 'pc.id_peserta = p.id_peserta','left');
		$this->db->where('email_peserta', $id);
		$this->db->group_by('p.id_peserta');   
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




}