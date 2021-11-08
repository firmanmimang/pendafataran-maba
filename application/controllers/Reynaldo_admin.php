<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reynaldo_admin extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('reynaldo_m_admin');
	}

// DASHBOARD
	public function index()
	{

		$data['title'] = 'Dashboard';
		$data['pendaftars'] = $this->reynaldo_m_admin->get_all_pendaftar();
		$data['isi'] = 'back-end/reynaldo_v_dashboard';

		$this->load->view('layout/reynaldo_v_wrapper_backend', $data, FALSE);
	}
// AKHIR DASHBOARD

// BAGIAN PROFILE
	public function profile()
	{
		$data['title'] = 'Profile ';
		$data['profile'] = $this->reynaldo_m_admin->get_profile($this->session->userdata('username'));
		$data['isi'] = 'back-end/reynaldo_v_profile';

		$this->load->view('layout/reynaldo_v_wrapper_backend', $data, FALSE);
	}

	public function editProfile($username){
		// CEK USERNAME
		$user=$this->db->get_where('user', ['username' => $username])->row_array();
		// VERIFIKASI PROFILE BENAR TIDAK
		($user['username'] != $this->session->userdata('username'))
			? redirect('reynaldo_admin/profile')
			: null;
		if ($user) {
			$usernameBaru = htmlspecialchars($this->input->post('username', true));
			$emailBaru = htmlspecialchars($this->input->post('email', true));
			if ($user['username'] == $usernameBaru || $user['email'] == $emailBaru) {
				goto cekUsername;
			}
			$this->form_validation->set_rules('name_user', 'Nama User', 'required', array('required' => '%s Harus Diisi!'));
			$this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email|is_unique[user.email]', array(
				'required' => '%s Harus Diisi!',
				'valid_email' => '%s Belum Valid',
				'is_unique' => '%s Sudah Terdaftar'
			));
			$this->form_validation->set_rules('nim', 'NIM', 'trim|required|min_length[11]|max_length[11]', array(
				'required' => '%s Harus Diisi!',
				'min_length' => '%s Minimal 11 Karakter',
				'max_length' => '%s Maximal 11 Karakter',
			));
			$this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]', array(
				'required' => '%s Harus Diisi!',
				'is_unique' => '%s Sudah Terdaftar'
			));
			$this->form_validation->set_rules('jurusan', 'Jurusan', 'required', array('required' => '%s Harus Diisi!'));
			$this->form_validation->set_rules('fakultas', 'Fakultas', 'required', array('required' => '%s Harus Diisi!'));

			if ($this->form_validation->run() == FALSE) {
				$data['title'] = 'Edit Profile';
				$data['profile'] = $this->reynaldo_m_admin->get_profile($username);
				$data['isi'] = 'back-end/reynaldo_v_profile_edit';

				$this->load->view('layout/reynaldo_v_wrapper_backend', $data, FALSE);
			}
		}

		cekUsername:
		$this->form_validation->set_rules('name_user', 'Nama User', 'required', array('required' => '%s Harus Diisi!'));
		$this->form_validation->set_rules('nim', 'NIM', 'trim|required|min_length[11]|max_length[11]', array(
			'required' => '%s Harus Diisi!',
			'min_length' => '%s Minimal 11 Karakter',
			'max_length' => '%s Maximal 11 Karakter',
		));
		$this->form_validation->set_rules('jurusan', 'Jurusan', 'required', array('required' => '%s Harus Diisi!'));
		$this->form_validation->set_rules('fakultas', 'Fakultas', 'required', array('required' => '%s Harus Diisi!'));
	
		if ($this->form_validation->run() == TRUE) {
			$config['upload_path'] = './assets/img/img_user/';
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['max_size']     = '4000'; //dlm kilobyte

			// CEK USER TIDAK GANTI FOTO
			if ($_FILES['photo']['error'] == 4 ) {
				goto b;
			};
			$ekstensi = explode('.', $_FILES['photo']['name']);
			$newName = time() .'_'. $this->session->userdata('username');
			$config['file_name'] = $newName.'_profile.'.end($ekstensi);
			
			b:
			$this->upload->initialize($config);

			if (!$this->upload->do_upload('photo')) {
				$data = array(
					'title' =>'Edit Profile',
					'profile' => $this->reynaldo_m_admin->get_profile($username),
					'error_upload' => $this->upload->display_errors(),
					'isi' => 'back-end/reynaldo_v_profile_edit',
				);
						
				if ($this->upload->data('file_name') == "") {
					goto a;
				} 
				
				$this->load->view('layout/reynaldo_v_wrapper_backend', $data, FALSE);

			} elseif($this->upload->data('is_image') == 1){
				// hapus foto
				$photo = $this->reynaldo_m_admin->get_profile($username);
				if ($photo['photo'] != "") {
					unlink('./assets/img/img_user/'.$photo['photo']);
				}
				// end hapus gambar
				// ketika ganti gambar
				$upload_data = ['uploads' => $this->upload->data()];
				$config['image_library'] = 'gd2';
				$config['source_image'] = './assets/img/img_user/'.$upload_data['uploads']['file_name'];
				$this->load->library('image_lib', $config);

				$data = array(
					'id' => $photo['id'],
					'name_user'=> htmlspecialchars($this->input->post('name_user', true)),
					'nim' => htmlspecialchars($this->input->post('nim', true)),
					'email'=> htmlspecialchars($this->input->post('email', true)),
					'username'=> htmlspecialchars($this->input->post('username', true)),
					'jurusan'=> htmlspecialchars($this->input->post('jurusan', true)),
					'fakultas'=> htmlspecialchars($this->input->post('fakultas', true)),
					'photo' => $upload_data['uploads']['file_name'],
				);

				$this->reynaldo_m_admin->edit_profile($data);
				// set session user
				$this->session->set_userdata('username', $data['username']);
				$this->session->set_userdata('name_user', $data['name_user']);
				$this->session->set_userdata('photo', $data['photo']);
				//set notif pesan
				$this->session->set_flashdata('pesan', 'Profile Berhasil Diedit!');
				redirect('reynaldo_admin/profile');
			} else{
				a:
				// ketika tanpa ganti gambar
				$data = array(
					'id' => $user['id'],
					'name_user'=> htmlspecialchars($this->input->post('name_user', true)),
					'nim' => htmlspecialchars($this->input->post('nim', true)),
					'email'=> htmlspecialchars($this->input->post('email', true)),
					'username'=> htmlspecialchars($this->input->post('username', true)),
					'jurusan'=> htmlspecialchars($this->input->post('jurusan', true)),
					'fakultas'=> htmlspecialchars($this->input->post('fakultas', true)),
				);

				$this->reynaldo_m_admin->edit_profile($data);
				// set session user
				$this->session->set_userdata('username', $data['username']);
				$this->session->set_userdata('name_user', $data['name_user']);
				//set notif pesan
				$this->session->set_flashdata('pesan', 'Profile Berhasil Diedit!');
				redirect('reynaldo_admin/profile');
			}
			
		}
		$data['title'] = 'Edit Profile';
		$data['profile'] = $this->reynaldo_m_admin->get_profile($username);
		$data['isi'] = 'back-end/reynaldo_v_profile_edit';

		$this->load->view('layout/reynaldo_v_wrapper_backend', $data, FALSE);
	}

	public function editPassword(){
		checkLagi:
		// GET DATA
		$data['profile'] = $this->reynaldo_m_admin->get_profile($this->session->userdata('username'));

		$this->form_validation->set_rules('password_sekarang', 'Password Lama', 'required|trim|callback_check_password_lama', array(
			'required' => '%s Harus Diisi!'
		));
		$this->form_validation->set_rules('password_baru', 'Password Baru', 'required|trim|min_length[6]|matches[ulangi_password]|callback_check_password_baru', array(
			'required' => '%s Harus Diisi!',
			'min_length' => '%s Minimal 6 Karakter',
			'matches' => '%s Tidak Sama Dengan Retype Password'
		));
		$this->form_validation->set_rules('ulangi_password', 'Retype Password', 'required|trim|matches[password_baru]', array(
			'required' => '%s Harus Diisi!',
			'matches' => '%s Tidak Sama Dengan Password Baru'
		));

		if ($this->form_validation->run() == FALSE) {
			$data['title'] = 'Change Password';
			$data['isi'] = 'back-end/reynaldo_v_profile_change_password';

			$this->load->view('layout/reynaldo_v_wrapper_backend', $data, FALSE);
		} else{
			$password_baru = $this->input->post('password_baru');
			$password_hash = password_hash($password_baru, PASSWORD_DEFAULT);

			$this->db->set('password', $password_hash);
			$this->db->where('username', $this->session->userdata('username'));
			$this->db->update('user');

			$this->session->set_flashdata('pesan', 'Password Berhasil Diubah!');
			redirect('reynaldo_admin/profile');
		}
	}

	// CALLBACK FUNGSI UTK VALIDATION ERROR INPUT PASSWORD LAMA
	function check_password_lama($post_string){
		$data['profile'] = $this->reynaldo_m_admin->get_profile($this->session->userdata('username'));
		
		if (!password_verify($post_string, $data['profile']['password']) && !empty($post_string)) 
		{
			$this->form_validation->set_message('check_password_lama', 'Password Lama Salah!');

			return FALSE;
		} else{
			return TRUE;
		}
	}

	// CALLBACK FUNGSI UTK VALIDATION ERROR INPUT PASSWORD BARU
	function check_password_baru($post_string){
		$data['profile'] = $this->reynaldo_m_admin->get_profile($this->session->userdata('username'));
		
		if (password_verify($post_string, $data['profile']['password'])) {
			$this->form_validation->set_message('check_password_baru', 'Password Sama Dengan Password Lama!');

			return FALSE;
		} 
		else{
			return TRUE;
		}
	}
// AKHIR PROFILE

// BAGIAN PENDAFTAR
	public function pendaftar()
	{
		$data = [
			'title' => 'Pendaftar',
			'pendaftars' => $this->reynaldo_m_admin->get_all_pendaftar(),
			'isi' => 'back-end/reynaldo_v_pendaftar'
		];

		$this->load->view('layout/reynaldo_v_wrapper_backend', $data, FALSE);
	}

	public function editPendaftar($id)
	{
		$data['pendaftar'] = $this->reynaldo_m_admin->get_pendaftar_by_id($id);

		$this->form_validation->set_rules('nama', 'Nama', 'required', array('required' => '%s Harus Diisi!'));
		
		// jika email tidak diubah
		if ($data['pendaftar']['email'] == $this->input->post('email')) {
			goto skipEmail;
		}
		$this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email|is_unique[mahasiswa.email]', array(
				'required' => '%s Harus Diisi!',
				'valid_email' => '%s Belum Valid',
				'is_unique' => '%s Sudah Terdaftar'
		));
		skipEmail:

		// jika no_hp tidak diubah
		if ($data['pendaftar']['no_hp'] == $this->input->post('no_hp')) {
			goto skipNo_hp;
		}
		$this->form_validation->set_rules('no_hp', 'No HP', 'required|is_unique[mahasiswa.no_hp]', array(
			'required' => '%s Harus Diisi!',
			'is_unique' => '%s Sudah Terdaftar'
		));
		skipNo_hp:

		$this->form_validation->set_rules('alamat', 'Alamat', 'required', array('required' => '%s Harus Diisi!'));
		$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|callback_check_jk', array('required' => '%s Harus Dipilih!'));
		$this->form_validation->set_rules('kode_pos', 'Kode Pos', 'required', array('required' => '%s Harus Diisi!'));
		$this->form_validation->set_rules('asal_sekolah', 'Asal Sekolah', 'required', array('required' => '%s Harus Diisi!'));
		$this->form_validation->set_rules('tahun_lulus', 'Tahun Lulus', 'required', array('required' => '%s Harus Diisi!'));
		$this->form_validation->set_rules('jurusan', 'Jurusan', 'required', array('required' => '%s Harus Diisi!'));

		if ($this->form_validation->run() == TRUE)
		{
			$data = array(
				'id' => $id,
				'nama' => htmlspecialchars($this->input->post('nama')),
				'jenis_kelamin' => htmlspecialchars($this->input->post('jenis_kelamin')),
				'email' => htmlspecialchars($this->input->post('email')),
				'no_hp' => htmlspecialchars($this->input->post('no_hp')),
				'alamat' => htmlspecialchars($this->input->post('alamat')),
				'kode_pos' => htmlspecialchars($this->input->post('kode_pos')),
				'asal_sekolah' => htmlspecialchars($this->input->post('asal_sekolah')),
				'tahun_lulus' => htmlspecialchars($this->input->post('tahun_lulus')),
				'jurusan' => htmlspecialchars($this->input->post('jurusan')),
			);

			$this->reynaldo_m_admin->edit_pendaftar($data);
			$this->session->set_flashdata('pesan', 'Pendaftar Berhasil Diedit!');
			redirect('reynaldo_admin/pendaftar');
		}

		$data = array(
			'title' =>'Edit Pendaftar',
			'pendaftar' => $this->reynaldo_m_admin->get_pendaftar_by_id($id),
			'isi' => 'back-end/reynaldo_v_edit_pendaftar',
		);

		$this->load->view('layout/reynaldo_v_wrapper_backend', $data, FALSE);
	}

	// CALLBACK FUNGSI UTK VALIDATION ERROR INPUT JENIS KELAMIN
	function check_jk($post_string){
		if (is_null($post_string)) {
			$this->form_validation->set_message('jenis_kelamin', 'Jenis Kelamin Harus Diisi!');
			return FALSE;
		} else{
			return TRUE;
		}
	}

	public function delete_pendaftar($id)
	{
		$data = [
			'id' => $id
		];

		// hapus foto
		$foto = $this->reynaldo_m_admin->get_foto_pendaftar($id);
		if ($foto['foto'] != "") {
			unlink('./assets/img/img_pendaftar/'.$foto['foto']);
		}
		// end hapus foto
		// hapus ijazah
		$ijazah = $this->reynaldo_m_admin->get_ijazah_pendaftar($id);
		if ($ijazah['document'] != "") {
			unlink('./assets/img/ijazah/'.$ijazah['document']);
		}
		// end hapus ijazah

		$this->reynaldo_m_admin->delete_pendaftar($data);
		$this->session->set_flashdata('pesan', 'Delete Pendaftar Success!');
		redirect('reynaldo_admin/pendaftar');
	}

	public function download_foto($id){
		$foto = $this->reynaldo_m_admin->get_foto_pendaftar($id);
		force_download('./assets/img/img_pendaftar/'. $foto['foto'], null);
		redirect('reynaldo_admin/editpendaftar');
	}

	public function download_ijazah($id){
		$ijazah = $this->reynaldo_m_admin->get_ijazah_pendaftar($id);
		force_download('./assets/img/ijazah/'. $ijazah['document'], null);
		redirect('reynaldo_admin/pendaftar');
	}
//AKHIR PENDAFTAR
}