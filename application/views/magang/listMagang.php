<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Data Pelamar Magang</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="mytable_mahasiswa" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Universitas / Sekolah Asal</th>
                                        <th>Jurusan</th>
                                        <th>Nomor Telepon</th>
                                        <th>Email</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($magang as $m): ?>
                                <?php if ($m->institute != 'batal'): ?>
                                    
                                    <tr>
                                        <td><?php echo $m->nama; ?></td> 
                                        <td><?php echo $m->institute; ?></td> 
                                        <td><?php echo $m->ps; ?></td> 
                                        <td><?php echo $m->no_tel; ?></td> 
                                        <td><?php echo $m->email; ?></td> 

                                        <td colspan="3">
                                            <!-- Tombol untuk membuka modal -->
                                            <button type="button" class="btn btn-info btn-sm view-details" 
                                                    data-toggle="modal" data-target="#detailModal" 
                                                    data-nama="<?php echo $m->nama; ?>"
                                                    data-email="<?php echo $m->email; ?>"
                                                    data-no_tel="<?php echo $m->no_tel; ?>"
                                                    data-institute="<?php echo $m->institute; ?>"
                                                    data-ps="<?php echo $m->ps; ?>"
                                                    data-tanggal_mulai="<?php echo $m->tanggal_mulai; ?>"
                                                    data-bidang="<?php echo $m->bidang; ?>"
                                                    data-cv="<?php echo base_url("uploads/".$m->cv); ?>"
                                                    data-surat_pengantar="<?php echo base_url("uploads/".$m->surat_pengantar); ?>"
                                                    data-foto="<?php echo base_url("uploads/".$m->foto); ?>"
                                                    data-status="<?php echo $m->status; ?>"> <!-- Added data-status here -->
                                                    <i class="fa fa-eye"></i> Detail
                                            </button>


                                            <?php if($m->status == 'proses'): ?>
                                                <!-- Tombol Aktifkan dengan data-id untuk id peserta -->
                                                <button type="button" class="btn btn-primary btn-sm activate-button" 
                                                    data-toggle="modal" data-target="#activateModal" 
                                                    data-id="<?php echo $m->id_pm; ?>">
                                                    <i class="fa fa-check"></i> Terima
                                                </button>
                                                <?= anchor(site_url("user/ControllerPM/ubah_status_batal/" . $m->id_pm), '<i class="fa fa-trash"></i> Tolak', 'class="btn btn-danger btn-sm" title="Tolak"') ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
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

<!-- Modal Bootstrap untuk upload file PDF -->
<div class="modal fade" id="activateModal" tabindex="-1" role="dialog" aria-labelledby="activateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo site_url('user/ControllerPM/ubah_status_dan_upload'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="activateModalLabel">Upload Rincian Magang (PDF)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_pm" id="id_pm">
                    <div class="form-group">
      
                        <input type="file" name="file_pdf" id="file_pdf" class="form-control" accept=".pdf" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!--  -->



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
                <div class="card mb-3">
                    <img id="foto" class="card-img-top" alt="Thumbnail Image" style="max-height: 200px; object-fit: cover;">
                </div>

                <p><strong>Nama            :</strong> <span id="nama"></span></p>
                <p><strong>Email           :</strong> <span id="email"></span></p>
                <p><strong>Nomor Telepon   :</strong> <span id="no_tel"></span></p>
                <p><strong>Universitas / Sekolah Asal     :</strong> <span id="institute"></span></p>
                <p><strong>Jurusan         :</strong> <span id="ps"></span></p>
                <p><strong>Tanggal Mulai   :</strong> <span id="tanggal_mulai"></span></p>
                <p><strong>Bidang          :</strong> <span id="bidang"></span></p>
                <p><strong>CV              :</strong> <span><a id="cv_link" href="#" target='_blank'>Download</a></span></p>
                <p><strong>Status          :</strong> <span id="status"></span></p>

                <p><strong>Surat Pengantar :</strong> <span><a id="surat_pengantar_link" href="#" target='_blank'>Download </a></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
 document.addEventListener('DOMContentLoaded', function() {
    // Populate the View Details Modal
    $('.view-details').on('click', function() {
        $('#nama').text($(this).data('nama'));
        $('#email').text($(this).data('email'));
        $('#no_tel').text($(this).data('no_tel'));
        $('#institute').text($(this).data('institute'));
        $('#ps').text($(this).data('ps'));
        $('#tanggal_mulai').text($(this).data('tanggal_mulai'));
        $('#bidang').text($(this).data('bidang'));
        $('#cv_link').attr('href', $(this).data('cv'));
        $('#surat_pengantar_link').attr('href', $(this).data('surat_pengantar'));
        $('#foto').attr('src', $(this).data('foto'));
        
        // Set the status dynamically
        var status = $(this).data('status');
        if (status == 'proses') {
            $('#status').text('Menunggu Persetujuan');
        } else if (status == 'aktif') {
            $('#status').text('Diterima');
        } else if (status == 'selesai') {
            $('#status').text('Selesai');
        }
    });

    // Populate the Activate Modal
    $('.activate-button').on('click', function() {
        var id_pm = $(this).data('id');
        $('#id_pm').val(id_pm); // Set id_pm in the modal form
    });
});

</script>

<script>
    // Script untuk mengisi id peserta ke dalam modal
    document.addEventListener('DOMContentLoaded', function() {
        $('.activate-button').on('click', function() {
            var id_pm = $(this).data('id');
            $('#id_pm').val(id_pm); // Set id_pm di modal
        });
    });
</script>
