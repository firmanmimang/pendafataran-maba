      

    <div class="card-body">
            <?php 
              if ($this->session->flashdata('pesan')) {
              echo '<div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <h5><i class="icon fas fa-check"></i>';
              echo $this->session->flashdata('pesan');
              echo '</h5></div>'
              ;} 
            ?>
            <!-- general form elements disabled -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Form <?= $title; ?></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">


                <?php 

                // // notifikasi form kosong
                // echo validation_errors('<div class="alert alert-danger alert-dismissible">
                //   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                //   <h5><i class="icon fas fa-exclamation-triangle"></i>', '</h5></div>');

                //notifikasi gagal upload gambar
                if (isset($error_upload)) {
                  echo '<div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <i class="icon fas fa-exclamation-triangle"></i>'. $error_upload . '</div>';
                }

                echo form_open_multipart(base_url()); 
                ?>

                  <div class="form-group">
                      <label>Nama</label>
                      <input type="text" class="form-control <?= form_error('nama')? 'is-invalid' : null ?>" placeholder="Nama..." name="nama" value="<?= set_value('nama') ?>">
                      <?= form_error('nama', '<small class="text-danger pl-1">', '</small>'); ?>
                  </div>
                  
                  <div class="row">

                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-control <?= form_error('jenis_kelamin')? 'is-invalid' : null ?>">
                          <option value="">--Pilih Jenis Kelamin--</option>
                          <option value="Laki-Laki" <?= (set_value('jenis_kelamin') == 'Laki-Laki')? 'selected': null?>>Laki-Laki</option>
                          <option value="Perempuan" <?= (set_value('jenis_kelamin') == 'Perempuan')? 'selected': null?>>Perempuan</option>
                        </select>
                        <?= form_error('jenis_kelamin', '<small class="text-danger pl-1">', '</small>'); ?>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>E-mail</label>
                        <input type="text" class="form-control <?= form_error('email')? 'is-invalid' : null ?>" placeholder="Email..." name="email" value="<?= set_value('email') ?>">
                        <?= form_error('email', '<small class="text-danger pl-1">', '</small>'); ?>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="form-group">
                        <label>Nomor HP</label>
                        <input type="text" class="form-control <?= form_error('no_hp')? 'is-invalid' : null ?>" placeholder="Nomor HP..." name="no_hp" value="<?= set_value('no_hp') ?>">
                        <?= form_error('no_hp', '<small class="text-danger pl-1">', '</small>'); ?>
                      </div>
                    </div>

                  </div>

                  <div class="form-group">
                      <label>Alamat</label>
                      <textarea name="alamat" class="form-control <?= form_error('alamat')? 'is-invalid' : null ?>" placeholder="Alamat..." rows="3"><?= set_value('alamat'); ?></textarea>
                      <?= form_error('alamat', '<small class="text-danger pl-1">', '</small>'); ?>
                  </div>

                  <div class="form-group">
                      <label>Kode Pos</label>
                      <input type="text" class="form-control <?= form_error('kode_pos')? 'is-invalid' : null ?>" placeholder="Kode Pos..." name="kode_pos" value="<?= set_value('kode_pos') ?>">
                      <?= form_error('kode_pos', '<small class="text-danger pl-1">', '</small>'); ?>
                  </div>

                  <div class="form-group">
                      <label>Asal Sekolah</label>
                      <input type="text" class="form-control <?= form_error('asal_sekolah')? 'is-invalid' : null ?>" placeholder="Asal Sekolah..." name="asal_sekolah" value="<?= set_value('asal_sekolah') ?>">
                      <?= form_error('asal_sekolah', '<small class="text-danger pl-1">', '</small>'); ?>
                  </div>

                  <div class="form-group">
                      <label>Tahun Lulus</label>
                      <input type="text" class="form-control <?= form_error('tahun_lulus')? 'is-invalid' : null ?>" placeholder="Tahun Lulus..." name="tahun_lulus" value="<?= set_value('tahun_lulus') ?>">
                      <?= form_error('tahun_lulus', '<small class="text-danger pl-1">', '</small>'); ?>
                  </div>

                  <div class="form-group">
                      <label>Jurusan</label>
                      <input type="text" class="form-control <?= form_error('jurusan')? 'is-invalid' : null ?>" placeholder="Jurusan..." name="jurusan" value="<?= set_value('jurusan') ?>">
                      <?= form_error('jurusan', '<small class="text-danger pl-1">', '</small>'); ?>
                  </div>

                  <h3 class="form-group">Lampiran</h3>

                  <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                        <label for="customFile">Ijazah</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" name="ijazah" class="custom-file-input <?= form_error('ijazah')? 'is-invalid' : null ?>">
                            <label class="custom-file-label" for="customFile">Choose file max 4mb (docx/pdf)</label>
                          </div>
                        </div>
                        <?= form_error('ijazah', '<small class="text-danger pl-1">', '</small>'); ?>
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="customFile">Foto</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" name="foto" id="preview_gambar" class="custom-file-input <?= form_error('foto')? 'is-invalid' : null ?>">
                            <label class="custom-file-label" for="customFile">Choose file max 4mb (jpg/jpeg/png)</label>
                          </div>
                        </div>
                        <?= form_error('foto', '<small class="text-danger pl-1">', '</small>'); ?>
                      </div>
                    </div>
                    <div class="col-sm-6">  
                      <div class="form-group">
                          <img src="<?= base_url('assets/img/no_image_content.png') ?>" id="image_load" width="200px" class="rounded mx-auto d-block my-1">
                      </div>
                    </div>
                  </div>



                  <div class="form-group">  
                      <button type="submit" class="btn btn-primary btn-sm">Daftar</button>
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