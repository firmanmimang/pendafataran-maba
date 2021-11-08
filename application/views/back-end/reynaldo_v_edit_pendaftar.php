          <div class="col-md-12">
            <!-- general form elements disabled -->
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title"><?= $title; ?></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

              	<?php 

              	// notifikasi gagal upload gambar
              	if (isset($error_upload)) {
              		echo '<div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <i class="icon fas fa-exclamation-triangle"></i>'. $error_upload . '</div>';
              	}

              	echo form_open_multipart('reynaldo_admin/editpendaftar/'.$pendaftar['id']); 
              	?>

                  <div class="form-group">
                      <label>Nama</label>
                      <input type="text" class="form-control <?= form_error('nama')? 'is-invalid' : null ?>" placeholder="Nama..." name="nama" value="<?= $pendaftar['nama'] ?>">
                      <?= form_error('nama', '<small class="text-danger pl-1">', '</small>'); ?>
                  </div>
                  
                  <div class="row">

                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control <?= form_error('jenis_kelamin')? 'is-invalid' : null ?>">
                          <option value="">--Pilih Jenis Kelamin--</option>
                          <option value="Laki-Laki" <?= ($pendaftar['jenis_kelamin'] == 'Laki-Laki')? 'selected': null?>>Laki-Laki</option>
                          <option value="Perempuan" <?= ($pendaftar['jenis_kelamin'] == 'Perempuan')? 'selected': null?>>Perempuan</option>
                        </select>
                        <?= form_error('jenis_kelamin', '<small class="text-danger pl-1">', '</small>'); ?>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>E-mail</label>
                        <input type="text" class="form-control <?= form_error('email')? 'is-invalid' : null ?>" placeholder="Email..." name="email" value="<?= $pendaftar['email'] ?>">
                        <?= form_error('email', '<small class="text-danger pl-1">', '</small>'); ?>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Nomor HP</label>
                        <input type="text" class="form-control <?= form_error('no_hp')? 'is-invalid' : null ?>" placeholder="Nomor HP..." name="no_hp" value="<?= $pendaftar['no_hp'] ?>">
                        <?= form_error('no_hp', '<small class="text-danger pl-1">', '</small>'); ?>
                      </div>
                    </div>

                  </div>

                  <div class="form-group">
                      <label>Alamat</label>
                      <textarea name="alamat" class="form-control <?= form_error('alamat')? 'is-invalid' : null ?>" placeholder="Alamat..." rows="3"><?= $pendaftar['alamat'] ?></textarea>
                      <?= form_error('alamat', '<small class="text-danger pl-1">', '</small>'); ?>
                  </div>

                  <div class="form-group">
                      <label>Kode Pos</label>
                      <input type="text" class="form-control <?= form_error('kode_pos')? 'is-invalid' : null ?>" placeholder="Kode Pos..." name="kode_pos" value="<?= $pendaftar['kode_pos'] ?>">
                      <?= form_error('kode_pos', '<small class="text-danger pl-1">', '</small>'); ?>
                  </div>

                  <div class="form-group">
                      <label>Asal Sekolah</label>
                      <input type="text" class="form-control <?= form_error('asal_sekolah')? 'is-invalid' : null ?>" placeholder="Asal Sekolah..." name="asal_sekolah" value="<?= $pendaftar['asal_sekolah'] ?>">
                      <?= form_error('asal_sekolah', '<small class="text-danger pl-1">', '</small>'); ?>
                  </div>

                  <div class="form-group">
                      <label>Tahun Lulus</label>
                      <input type="text" class="form-control <?= form_error('tahun_lulus')? 'is-invalid' : null ?>" placeholder="Tahun Lulus..." name="tahun_lulus" value="<?= $pendaftar['tahun_lulus'] ?>">
                      <?= form_error('tahun_lulus', '<small class="text-danger pl-1">', '</small>'); ?>
                  </div>

                  <div class="form-group">
                      <label>Jurusan</label>
                      <input type="text" class="form-control <?= form_error('jurusan')? 'is-invalid' : null ?>" placeholder="Jurusan..." name="jurusan" value="<?= $pendaftar['jurusan'] ?>">
                      <?= form_error('jurusan', '<small class="text-danger pl-1">', '</small>'); ?>
                  </div>

                  <div class="row">
                    <div class="col-sm-12">  
                      <div class="form-group text-center">
                          <img src="<?= empty($pendaftar['foto'])? base_url('assets/img/no_image_content.png') : base_url('assets/img/img_pendaftar/'. $pendaftar['foto']) ?>" id="image_load" width="200px" class="rounded mx-auto d-block my-1">
                          <?php if ($pendaftar['foto']): ?>
                            <a href="<?= base_url('reynaldo_admin/download_foto/'. $pendaftar['id']); ?>" class="btn btn-primary btn-sm mt-2"><i class="fas fa-download"></i> Download Foto</a>
                          <?php endif ?>
                      </div>
                    </div>
	                </div>

                  <div class="form-group">  
                      <a href="<?= base_url('reynaldo_admin/pendaftar'); ?>" class="btn btn-warning btn-sm">Back</a>
                      <button type="submit" class="btn btn-success btn-sm">Edit</button>
                  </div>

                 <?php echo form_close(); ?>

              </div>
            </div>
          </div>


<script>
	function bacaGambar(input){
		if (input.files && input.files[0]) {
			let reader = new FileReader();
			reader.onload = function(e){
				$('#image_load').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}

	$('#preview_gambar').change(function(){
		bacaGambar(this);
	});
</script>