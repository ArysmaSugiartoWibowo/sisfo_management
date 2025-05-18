<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Laporan & Penilaian</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="mytable_mahasiswa" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Peserta</th>
                                        <th>Laporan</th>
                                        <th>Penilaian</th>
                                        <th>Sertifikat</th>
                                        <th>Penilaian Dosen</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($laporans as $l): ?>
                                        <tr>
                                            <td><?php echo $l->nama; ?></td>
                                            <td>
                                                <a href="<?php echo base_url('uploads/'.$l->nama_file); ?>" class="btn btn-success btn-sm" download>Download Laporan</a>
                                            </td>
                                            <?php if (!empty($l->file_penilaian)): ?>
                                                <td>
                                                    <a href="<?php echo base_url('uploads/'.$l->file_penilaian); ?>" class="btn btn-success btn-sm" download>Download Penilaian</a>
                                                </td>

                                            <?php else: ?>
                                                <td>-</td>
                                            <?php endif; ?>
                                            <?php if (!empty($l->Sertifikat)): ?>
                                                <td>
                                                    <a href="<?php echo base_url('uploads/'.$l->Sertifikat); ?>" class="btn btn-success btn-sm" download>Download Sertifikat</a>
                                                </td>
                                             
                                            <?php else: ?>
                                                <td>-</td>
                                            <?php endif; ?>
                                            <?php if (!empty($l->penilaian_dosen)): ?>
                                                <td>
                                                    <a href="<?php echo base_url('uploads/'.$l->penilaian_dosen); ?>" class="btn btn-success btn-sm" download>Download Penilaian Dosen</a>
                                                </td>
                                                <td>
                                            <?php else: ?>
                                                <td>-</td>
                                            <?php endif; ?>
                                            
                                            <td><?php echo $l->keterangan; ?></td>
                                            <td><?php echo $l->status; ?></td>

                                            <td>
                                                <?php if ($l->status == 'acc kominfo'): ?>
                                                    <button type="button" class="btn btn-primary btn-sm activate-button" 
                                                    data-toggle="modal" data-target="#activateModal" 
                                                    data-id="<?php echo $l->id_laporan; ?>">
                                                    <i class="fa fa-check"></i> Terima
                                                </button>
                                                <?= anchor(site_url("Laporan/tolak_pendamping/" . $l->id_laporan), '<i class="fa fa-trash"></i> Tolak', 'class="btn btn-danger btn-sm" title="Tolak"') ?>
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

<!-- Modal untuk menerima laporan -->
<div class="modal fade" id="activateModal" tabindex="-1" role="dialog" aria-labelledby="activateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo site_url('/Laporan/ubah_status_dan_upload_pendamping'); ?>" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="activateModalLabel">Upload Penilaian Magang (PDF)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_laporan" id="id_laporan">
                    <div class="form-group">
                    <label for="file_penilaian">Penilaian</label>
                        <input type="file" name="file_penilaian" id="file_penilaian" class="form-control" accept=".pdf" required>
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

<!-- Javascript untuk mengisi data modal -->
<script>
    // Script untuk mengisi id peserta ke dalam modal
    document.addEventListener('DOMContentLoaded', function() {
        $('.activate-button').on('click', function() {
            var id_laporan = $(this).data('id');
            $('#id_laporan').val(id_laporan); // Set id_pm di modal
        });
    });
</script>
