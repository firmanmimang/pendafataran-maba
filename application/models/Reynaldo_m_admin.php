<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Reynaldo_m_admin extends CI_Model 
{
// BAGIAN DASHBOARD
	
// AKHIR DASHBOARD

// BAGIAN PROFILE
	public function get_profile($username){
		$this->db->select('*');
		$this->db->from('user');
		$this->db->where('username', $username);

		return $this->db->get()->row_array();
	}

	public function edit_profile($data){
		$this->db->where('id', $data['id']);
		$this->db->update('user', $data);
	}

	public function get_profile_photo($username){
		$this->db->select('photo');
		return $this->db->get_where('user', ['username' => $username])->row_array();
	}
// AKHIR PROFILE

// BAGIAN PENDAFTAR
	public function get_all_pendaftar(){
		return $this->db->get('mahasiswa')->result_array();
	}

	public function get_pendaftar_by_id($id){
		return $this->db->get_where('mahasiswa', ['id' => $id])->row_array();	
	}

	public function get_foto_pendaftar($id){
		$this->db->select('foto');
		return $this->db->get_where('mahasiswa', ['id' => $id])->row_array();
	}

	public function get_ijazah_pendaftar($id){
		$this->db->select('document');
		return $this->db->get_where('mahasiswa', ['id' => $id])->row_array();
	}

	public function edit_pendaftar($data){
		$this->db->where('id', $data['id']);
		$this->db->update('mahasiswa', $data);
	}

	public function delete_pendaftar($data){
		$this->db->delete('mahasiswa', $data);
	}
// AKHIR PENDAFTAR
}