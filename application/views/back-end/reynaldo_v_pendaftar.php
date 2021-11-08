          <div class="col-md-12">
            <div class="card card-warning">
              <div class="card-header">
                <h3 class="card-title">Data <?= $title; ?></h3>

                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->

              <div class="card-body">

                <?php if ($this->session->flashdata('pesan')) {
                  echo '<div class="alert alert-success alert-dismissible">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                          <i class="icon fas fa-check"></i>';
                  echo $this->session->flashdata('pesan');
                  echo '</div>'
                  ;} 
                ?>

                <table class="table table-bordered table-striped" id="example1">
                  <thead class="text-center">
                    <tr>
                      <th>No.</th>
                      <th>Nama</th>
                      <th>Email</th>
                      <th>Nomor HP</th>
                      <th>Alamat</th>
                      <th>Jenis Kelamin</th>
                      <th>Kode Pos</th>
                      <th>Asal Sekolah</th>
                      <th>Tahun Lulus</th>
                      <th>Jurusan</th>
                      <th>Document</th>
                      <th>Foto</th>
                      <th>Action</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php $no = 1; foreach ($pendaftars as $c) :?>
                      <tr>
                        <td class="text-center"><?= $no++; ?></td>
                        <td><?= $c['nama']; ?></td>
                        <td><?= $c['email']; ?></td>
                        <td><?= $c['no_hp']; ?></td>
                        <td><?= $c['alamat']; ?></td>
                        <td><?= $c['jenis_kelamin']; ?></td>
                        <td><?= $c['kode_pos']; ?></td>
                        <td><?= $c['asal_sekolah']; ?></td>
                        <td><?= $c['tahun_lulus']; ?></td>
                        <td><?= $c['jurusan']; ?></td>
                        <td class="text-center">
                          <?= $c['document']; ?><br>
                          <a href="<?= base_url('reynaldo_admin/download_ijazah/'. $c['id']); ?>" class="btn btn-primary btn-sm mt-2"><i class="fas fa-download"></i> Download Ijazah</a>
                        </td>
                        <?php if (empty($c['foto'])): ?>
                          <td class="text-center"><img src="<?= base_url('assets/img/no_image_content.png'); ?>" width="150px" class="img-thumbnail"></td>
                        <?php else: ?>
                          <td class="text-center"><img src="<?= base_url('assets/img/img_pendaftar/'. $c['foto']); ?>" width="150px" class="img-thumbnail" ></td>
                        <?php endif ?>
                        <td class="text-center">
                          <a href="<?= base_url('reynaldo_admin/editpendaftar/'.$c['id']); ?>" class="btn btn-warning btn-sm mt-1"><i class="fas fa-fw fa-edit"></i></a><br>
                          <button class="btn btn-danger btn-sm mt-1" data-toggle="modal" data-target="#delete<?= $c['id']; ?>"><i class="fas fa-fw fa-trash"></i></button><br>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

          
        <!-- modal delete -->
        <?php foreach ($pendaftars as $c) :?>
          <div class="modal fade" id="delete<?= $c['id']; ?>">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Delete <?= $title ?></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <h5>Apakah Anda Yakin Menghapus <?= $c['nama']; ?>?</h5>
                </div>
                <div class="modal-footer justify-content-between">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                  <a href="<?= base_url('reynaldo_admin/delete_pendaftar/'. $c['id']); ?>" class="btn btn-danger">Delete</a>
                </div>
              
              </div>
              <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->
        <?php endforeach; ?>