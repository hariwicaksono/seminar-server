<?php  

class ModelMaster extends CI_Model {
 
	public function get_jenismhs($id = null)
	{
		if ($id == null) {
			return $this->db->get('MASTER_JENISMHS')->result_array();
		} else { 
		return $this->db->get_where('MASTER_JENISMHS',['ID_JENISMHS'=>$id])->result_array();
		}
	}

	public function get_kabupaten($id = null)
	{
		if ($id == null) {
			return $this->db->get('Kabupaten')->result_array();
		} else { 
		return $this->db->get_where('Kabupaten',['KdKab'=>$id])->result_array();
		}
	}

	public function get_provinsi($id = null)
	{
		if ($id == null) {
			return $this->db->get('Propinsi')->result_array();
		} else { 
		return $this->db->get_where('Propinsi',['KdProp'=>$id])->result_array();
		}
	}

	public function get_prodi($id = null)
	{
		if ($id == null) {
			return $this->db->get('DEPARTMENT')->result_array();
		} else { 
		return $this->db->get_where('DEPARTMENT',['KD_DEPT'=>$id])->result_array();
		}
	}

	public function get_soal($id = null)
	{
		if ($id == null) {
			$this->db->select('*');
			$this->db->from('tbl_soal');
			$this->db->where('aktif','Y');
			$this->db->order_by('id_soal', 'RANDOM');
			$this->db->limit(50);
			return $this->db->get()->result_array();
		} else {
			return $this->db->get_where('tbl_soal',['id_soal'=>$id])->result_array();
		}
	}
 
	function count_soal(){
		$this->db->select('*');
			$this->db->from('tbl_soal');
			$this->db->where('aktif','Y');
			$this->db->order_by('id_soal', 'RANDOM');
			$this->db->limit(50);
			return $this->db->get()->num_rows();
    }

	public function post_soal($data)
	{
		$this->db->insert('tbl_soal',$data);
		return $this->db->affected_rows();
	}

	public function delete_soal($id = null)
	{
		$this->db->delete('tbl_soal',['id_soal' => $id]);
		return $this->db->affected_rows();
	}

	public function put_soal($id,$data)
	{
		$this->db->update('tbl_soal',$data,['id_soal'=>$id]);
		return $this->db->affected_rows();
	}
	

	public function get_admin($id = null)
	{
		if ($id == null) {
			return $this->db->get('admin')->result_array();
		} else {
			return $this->db->get_where('admin',['id_admin'=>$id])->result_array();
		}
	} 

	public function post_admin($data)
	{
		 $this->db->insert('admin',$data);
		 return $this->db->affected_rows();
	}
	public function delete_admin($id)
	{
		$this->db->delete('admin',['id_admin' => $id]);
		return $this->db->affected_rows();
	}

	public function put_admin($id,$data)
	{
		$this->db->update('admin',$data,['id_admin'=>$id]);
		return $this->db->affected_rows();
	}

	public function put_pemesanan($id,$data)
	{
		$this->db->update('pesan',$data,['id_pemesanan'=>$id]);
		return $this->db->affected_rows();
	}
 
	public function get_user($id = null)
	{
		if ($id == null) {
			return $this->db->get('registrasi_pmb')->result_array();
		} else {
			return $this->db->get_where('registrasi_pmb',['username'=>$id])->result_array();
		}
	}

	public function post_user($data)
	{
		$this->db->insert('registrasi_pmb',$data);
		return $this->db->affected_rows();
	}

	public function delete_user($id = null)
	{
		$this->db->delete('registrasi_pmb',['username' => $id]);
		return $this->db->affected_rows();
	}

	public function put_user($id,$data)
	{
		$this->db->update('registrasi_pmb',$data,['username'=>$id]);
		return $this->db->affected_rows();
	}

	public function get_produk($id = null)
	{
		if ($id == null) {
			return $this->db->get('produk')->result_array();
		} else {
			return $this->db->get_where('produk',['id_produk'=>$id])->result_array();
		}
	}

	public function post_produk($data)
	{
		$this->db->insert('produk',$data);
		return $this->db->affected_rows();
	}

	public function delete_produk($id = null)
	{
		$this->db->delete('produk',['id_produk' => $id]);
		return $this->db->affected_rows();
	}

	public function put_produk($id,$data)
	{
		$this->db->update('produk',$data,['id_produk'=>$id]);
		return $this->db->affected_rows();
	}


	public function get_pesan($id = null)
	{
		if ($id == null) {
			return $this->db->get('pesan')->result_array();
		} else { 
			return $this->db->get_where('pesan',['id_user'=>$id])->result_array();
		}
	}

	public function get_pesans($id)
	{
		return $this->db->get_where('pesan',['id_pemesanan'=>$id])->result_array();
	}

	public function post_pemesanan($data)
	{
		$this->db->insert('pesan',$data);
		return $this->db->affected_rows();
	}

	public function delete_pesan($id = null)
	{
		$this->db->delete('pesan',['id_pemesanan' => $id]);
		return $this->db->affected_rows();
	}

	public function cek_login_user($user,$password)
	{
		return $this->db->get_where('registrasi_pmb',['username' => $user , 'password'=>$password ])->result_array();
		//return $this->db->result_array();
	}
 
	public function cek_login_admin($user,$password)
	{
		return $this->db->get_where('admin',['username_admin' => $user , 'password_admin'=>$password ])->result_array();
		//return $this->db->result_array();
	}

	public function get_judul_tupoksi($id = null)
	{
		if ($id == null) {
			return $this->db->get('tupoksi')->result_array();
		} else { 
		return $this->db->get_where('tupoksi',['id_tupoksi'=>$id])->result_array();
		}
	}

	public function cari_orang($id='')
	{
		if ($id === '') {
			return $this->db->get('calonsiswa')->result_array();
		} else {
			$this->db->from('calonsiswa');
			$this->db->like('nodaf', $id);
			$this->db->or_like('nama', $id);
			$query = $this->db->get();
			return $query->result_array();
		}
	}

	public function username_exist($id='')
	{
		if ($id === '') {
			return $this->db->get('registrasi_pmb')->result_array();
		} else {
			return $this->db->get_where('registrasi_pmb',['username'=>$id])->result_array();
		}
	}

	public function get_calonsiswa($id='')
	{
		$this->db->select('c.*, dg.gelombang as gelombang, de.NAMA_DEPT as pilihan1, df.NAMA_DEPT as pilihan2, kb.NamaKab as kabupaten, pr.NamaProp as propinsi, kbo.NamaKab as KABUPATEN_ORTU, pro.NamaProp as PROPINSI_ORTU, mj.NAMA as JENIS_MHS');
		$this->db->from('calonsiswa c');
		$this->db->join('Kabupaten kb', 'kb.KdKab = c.kabupaten');
		$this->db->join('Propinsi pr', 'pr.kdProp = c.propinsi');
		$this->db->join('Kabupaten kbo', 'kbo.KdKab = c.KABUPATEN_ORTU');
		$this->db->join('Propinsi pro', 'pro.kdProp = c.PROPINSI_ORTU');
		$this->db->join('data_gelombang dg', 'dg.kode = c.gelombang');
		$this->db->join('DEPARTMENT de', 'de.KD_DEPT = c.pilihan1');
		$this->db->join('DEPARTMENT df', 'df.KD_DEPT = c.pilihan2');
		$this->db->join('MASTER_JENISMHS mj', 'mj.KODE_JENIS = c.JENIS_MHS');
		$this->db->where('email', $id);
		$query = $this->db->get();
		return $query->result_array();
	}




}