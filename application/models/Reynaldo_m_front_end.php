<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Reynaldo_m_front_end extends CI_Model 
{
// BAGIAN TABLE USER
	public function get_profile(){
		$this->db->select('name_user, nim, email, photo, jurusan, fakultas');
		$this->db->from('user');

		return $this->db->get()->row_array();
	}
// AKHIR TABLE USER

// BAGIAN TABLE MAHASISWA
	public function post_mahasiswa($data){
		$this->db->insert('mahasiswa', $data);
	}
//AKHIR TABLE MAHASISWA

}