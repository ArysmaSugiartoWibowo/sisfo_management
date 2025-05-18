<?php if ( !empty( $magang ) ): ?>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Data Pendaftaran Magang</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="table-responsive">
              <table id="mytable_mahasiswa" class="table table-striped">
                <thead>
                  <tr>
                    <th>Nama</th>
                    <th>Universitas/Sekolah Asal</th>
                    <th>Jurusan</th>
                    <th>Nomor Telepon</th>
                    <th>Email</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ( $magang as $m ): ?>
                  <tr>
                    <td><?php echo $m['nama']; ?></td>
                    <td><?php echo $m['institute']; ?></td>
                    <td><?php echo $m['ps']; ?></td>
                    <td><?php echo $m['no_tel']; ?></td>
                    <td><?php echo $m['email']; ?></td>
                    <td>
                      <!-- Tombol untuk membuka modal -->
                      <button type="button" class="btn btn-info btn-sm view-details" data-toggle="modal" data-target="#detailModal">
                        <i class="fa fa-eye"></i> Lihat Detail
                      </button>

                      <?php if ( $m['status'] == 'proses' ): ?>
                      <?= anchor( site_url( 'user/ControllerPM/hapus/'. $m['id_pm'] ), '<i class="fa-solid fa-trash"></i> Batal', 'class="btn btn-danger btn-sm" title="Batal"' ) ?>
                      <?php elseif ( $m['status'] == 'batal' ): ?>
                      <?= anchor( site_url( 'user/ControllerPM/hapus/'. $m['id_pm'] ), '<i class="fa-solid fa-trash"></i> Hapus', 'class="btn btn-danger btn-sm" title="Hapus"' ) ?>
                      <?php endif; ?>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
</section>

<?php foreach ( $magang as $m ): ?>

<?php if ( $m['status'] == 'proses' ): ?>
<div class="container-fluid">
  <div class="alert alert-success">
    <p class="text-center">Data Anda Sedang Di Proses!! Mohon Ditunggu</p>
  </div>
</div>
<?php elseif ( $m['status'] == 'aktif' ): ?>
<div class="container-fluid">
  <div class="alert alert-primary">
    <p class="text-center">
      Selamat Anda Diterima!
      <p class="text-center">Silahkan Unduh Rincian Dan Aturan Magang <a href='<?php echo base_url("uploads/".$m['keterangan']); ?>' target='_blank'>Disini</a></p>
    </p>
  </div>
</div>
<?php elseif ( $m['status'] == 'selesai' ): ?>
<div class="container-fluid">
  <div class="alert alert-success">
    <p class="text-center">Selamat Magang Anda Sudah Selesai! Semoga Sukses</p>
  </div>
</div>
<?php elseif ( $m['status'] == 'batal' ): ?>
<div class="container-fluid">
  <div class="alert alert-danger">
    <p class="text-center">Mohon Maaf Anda Ditolak !!! Silahkan Hapus Data Dan Coba Lagi Nanti</p>
  </div>
</div>
<?php endif; ?>

<?php endforeach; ?>

<!-- Modal Bootstrap untuk Lihat Detail -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailModalLabel">Detail Pendaftar Magang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php foreach ( $magang as $m ): ?>
        <div class="card mb-3">
          <img src="<?php echo base_url("uploads/".$m['foto']); ?>" class="card-img-top" alt="Thumbnail Image" style="max-height: 200px; object-fit: cover;">
        </div>

        <p><strong>Nama            :</strong> <span><?php echo $m['nama']; ?></span></p>
        <p><strong>Email           :</strong> <span><?php echo $m['email']; ?></span></p>
        <p><strong>Nomor Telepon   :</strong> <span><?php echo $m['no_tel']; ?></span></p>
        <p><strong>Universitas/Sekolah Asal     :</strong> <span><?php echo $m['institute']; ?></span></p>
        <p><strong>Jurusan         :</strong> <span><?php echo $m['ps']; ?></span></p>
        <p><strong>Tanggal Mulai   :</strong> <span><?php echo $m['tanggal_mulai']; ?></span></p>
          <!-- Menampilkan Nama Bidang berdasarkan ID -->
          <p><strong>Bidang          :</strong> 
        <?php 
          // Mencari nama bidang berdasarkan id_bidang
          $bidangName = '';
          foreach ($bidangs as $item) {
            if ($item->id_bidang == $m['bidang']) {
              $bidangName = $item->nama_bidang;
              break;
            }
          }
          echo "<span>" . $bidangName . "</span>";
        ?>
        </p>
        <p><strong>Cv              :</strong> <span><a href='<?php echo base_url("uploads/".$m['cv']); ?>' target='_blank'>Download</a></span></p>
        <p><strong>Surat Pengantar :</strong> <span><a href='<?php echo base_url("uploads/".$m['surat_pengantar']); ?>' target='_blank'>Download </a></span></p>
        <?php endforeach; ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- jQuery dan Bootstrap JavaScript untuk mengisi data ke dalam modal -->
<script src="<?= base_url('vendor') ?>/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url('vendor') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<?php else: ?>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-8 mx-auto">
        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Pendaftaran Magang Kominfo Tanah Datar</h3>
          </div>
          <div class="card-body">
            <!-- Tampilkan pesan flash jika ada -->
            <?php if ( $this->session->flashdata( 'success' ) ): ?>
            <div class="alert alert-success"><?= $this->session->flashdata( 'success' ); ?></div>
            <?php elseif ( $this->session->flashdata( 'error' ) ): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata( 'error' ); ?></div>
            <?php endif; ?>

            <form id="formTambahData" action="<?= base_url('user/controllerPM/simpan') ?>" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
              <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" class="form-control" required></textarea>
              </div>
              <div class="form-group">
                <label for="no_tel">No. Telepon</label>
                <input type="number" name="no_tel" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="institute">Universitas Asal / Sekolah Asal</label>
                <input type="text" name="institute" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="ps">Jurusan</label>
                <input type="text" name="ps" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="durasi_magang">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="durasi_magang">Tanggal Berakhir</label>
                <input type="date" name="durasi_magang" class="form-control" required>
            </div>

              <div class="form-group">
                <label for="bidang">Bidang</label>
                <select name="bidang" class="form-control" required>
                  <option value="" disabled selected>Pilih Bidang</option>
                  <?php foreach ( $bidang as $item ): ?>
                  <option value="<?= $item->id_bidang ?>"> <?= $item->nama_bidang ?></option>
                  <?php endforeach; ?>
                </select>
              </div>

              <!-- Upload CV -->
              <div class="form-group">
                <label for="cv">Upload CV ( PDF )</label>
                <input type="file" name="cv" class="form-control-file" accept=".pdf" required>
              </div>

              <!-- Upload Surat Pengantar -->
              <div class="form-group">
                <label for="surat_pengantar">Upload Surat Pengantar ( PDF )</label>
                <input type="file" name="surat_pengantar" class="form-control-file" accept=".pdf" required>
              </div>

              <!-- Upload Foto -->
              <div class="form-group">
                <label for="foto">Upload Foto ( JPG )</label>
                <input type="file" name="foto" class="form-control-file" accept=".jpg" required>
              </div>
              <div class="form-group">
                <input type="hidden" name="status" class="form-control" value="proses" required>
              </div>

              <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
function validateForm() {
    // Mengambil semua elemen input yang bersifat required
    const form = document.getElementById('formTambahData');
    const inputs = form.querySelectorAll('[required]');

    for (let input of inputs) {
        if (!input.value.trim()) {
            alert('Harap isi semua bidang yang wajib diisi.');
            input.focus();
            // Mengarahkan fokus ke input yang kosong
            return false;
            // Mencegah pengiriman form
        }
    }
    return true;
    // Izinkan pengiriman form jika semua bidang telah terisi
}
</script>

<?php endif; ?>
