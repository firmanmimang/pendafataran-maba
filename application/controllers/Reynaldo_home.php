<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reynaldo_home extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->form_validation->set_rules('nama', 'Nama', 'required', array('required' => '%s Harus Diisi!'));
		$this->form_validation->set_rules('email', 'E-mail', 'required|trim|valid_email|is_unique[mahasiswa.email]', array(
				'required' => '%s Harus Diisi!',
				'valid_email' => '%s Belum Valid',
				'is_unique' => '%s Sudah Terdaftar'
		));
		$this->form_validation->set_rules('no_hp', 'No HP', 'required|is_unique[mahasiswa.no_hp]', array(
			'required' => '%s Harus Diisi!',
			'is_unique' => '%s Sudah Terdaftar'
		));
		$this->form_validation->set_rules('alamat', 'Alamat', 'required', array('required' => '%s Harus Diisi!'));
		$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required|callback_check_jk', array('required' => '%s Harus Dipilih!'));
		$this->form_validation->set_rules('kode_pos', 'Kode Pos', 'required', array('required' => '%s Harus Diisi!'));
		$this->form_validation->set_rules('asal_sekolah', 'Asal Sekolah', 'required', array('required' => '%s Harus Diisi!'));
		$this->form_validation->set_rules('tahun_lulus', 'Tahun Lulus', 'required', array('required' => '%s Harus Diisi!'));
		$this->form_validation->set_rules('jurusan', 'Jurusan', 'required', array('required' => '%s Harus Diisi!'));
		$this->form_validation->set_rules('ijazah', 'Ijazah', 'callback_check_ijazah');
		$this->form_validation->set_rules('foto', 'Foto', 'callback_check_foto');

		if ($this->form_validation->run() == TRUE) {
			$config['upload_path'] = './assets/img/img_pendaftar/';
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['max_size']     = '4096'; //dlm kilobyte

			$ekstensi = explode('.', $_FILES['foto']['name']);
			$newName = time() .'_'. htmlspecialchars($this->input->post('nama'));
			$config['file_name'] = 'foto_'.$newName.'.'.end($ekstensi);
			
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('foto')){
				$data['title'] = 'Pendaftaran';
				$data['profile'] = $this->reynaldo_m_front_end->get_profile();
				$data['error_upload'] = $this->upload->display_errors();
				$data['isi'] = 'front-end/reynaldo_v_home';

				$this->load->view('layout/reynaldo_v_wrapper_frontend', $data, FALSE);
			} else {
				$upload_foto = ['uploads' => $this->upload->data()];

				$config['upload_path'] = './assets/img/ijazah/';
				$config['allowed_types'] = 'pdf|docx';
				$config['max_size']     = '4096'; //dlm kilobyte

				$ekstensi = explode('.', $_FILES['ijazah']['name']);
				$newName = time() .'_'. htmlspecialchars($this->input->post('nama'));

				$config['file_name'] = 'ijazah_'.$newName.'.'.end($ekstensi);
				
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('ijazah')) {
					$data['title'] = 'Pendaftaran';
					$data['profile'] = $this->reynaldo_m_front_end->get_profile();
					$data['error_upload'] = $this->upload->display_errors();
					$data['isi'] = 'front-end/reynaldo_v_home';

					$this->load->view('layout/reynaldo_v_wrapper_frontend', $data, FALSE);
				} else{
					$upload_ijazah = ['uploads' => $this->upload->data()];

					$data = [
						'nama' => htmlspecialchars($this->input->post('nama')),
						'jenis_kelamin' => htmlspecialchars($this->input->post('jenis_kelamin')),
						'email' => htmlspecialchars($this->input->post('email')),
						'no_hp' => htmlspecialchars($this->input->post('no_hp')),
						'alamat' => htmlspecialchars($this->input->post('alamat')),
						'kode_pos' => htmlspecialchars($this->input->post('kode_pos')),
						'asal_sekolah' => htmlspecialchars($this->input->post('asal_sekolah')),
						'tahun_lulus' => htmlspecialchars($this->input->post('tahun_lulus')),
						'jurusan' => htmlspecialchars($this->input->post('jurusan')),
						'foto' => $upload_foto['uploads']['file_name'],
						'document' => $upload_ijazah['uploads']['file_name'],
					];

					$this->reynaldo_m_front_end->post_mahasiswa($data);
					$this->session->set_flashdata('pesan', 'Pendaftaran Berhasil!');
					redirect('');
				}
			}
		}
		$data['title'] = 'Pendaftaran';
		$data['profile'] = $this->reynaldo_m_front_end->get_profile();
		$data['isi'] = 'front-end/reynaldo_v_home';

		$this->load->view('layout/reynaldo_v_wrapper_frontend', $data, FALSE);
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

	// CALLBACK FUNGSI UTK VALIDATION ERROR INPUT FILE IJAZAH
	function check_ijazah($str){
		$allowed_mime_type_arr = ['application/pdf', 'application/docx'];
		$mime = get_mime_by_extension($_FILES['ijazah']['name']);
		if (isset($_FILES['ijazah']['name']) && $_FILES['ijazah']['name'] != '') {
			if (in_array($mime, $allowed_mime_type_arr)) {
				if ($_FILES['ijazah']['size'] <= 4096000) {
					return TRUE;
				} else{
					$this->form_validation->set_message('check_foto', 'Size File Foto Max 4mb');
					return FALSE;
				}
			} else{
				$this->form_validation->set_message('check_ijazah', 'Tipe File Ijazah Hanya Boleh pdf/docx.');
				return FALSE;
			}
		} else{
			$this->form_validation->set_message('check_ijazah', 'File Ijazah Harus Dilampirkan!');
			return FALSE;
		}
	}

	// CALLBACK FUNGSI UTK VALIDATION ERROR INPUT FILE FOTO
	function check_foto($str){
		$allowed_mime_type_arr = ['image/jpg', 'image/jpeg', 'image/png', 'image/x-png'];
		$mime = get_mime_by_extension($_FILES['foto']['name']);
		if (isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != '') {
			if (in_array($mime, $allowed_mime_type_arr)) {
				if ($_FILES['foto']['size'] <= 4096000) {
					return TRUE;
				} else{
					$this->form_validation->set_message('check_foto', 'Size File Foto Max 4mb');
					return FALSE;
				}
			} else{
				$this->form_validation->set_message('check_foto', 'Tipe File Foto Hanya Boleh jpg/jpeg/png.');
				return FALSE;
			}
		} else{
			$this->form_validation->set_message('check_foto', 'File Foto Harus Dilampirkan!');
			return FALSE;
		}
	}
}