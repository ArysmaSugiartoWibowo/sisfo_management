<?php if ( !empty( $laporan ) ): ?>
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
                        <?php foreach ( $laporans as $l ): ?>
                        <tr>
                            <td><?php echo $l['nama']; ?></td>
                            <td>
                            <!-- Laporan Download Button -->
                            <a href="<?php echo base_url('uploads/'.$l['nama_file']); ?>" class="btn btn-success btn-sm" download>Download Laporan</a>
                            </td>
                            <?php if ( !empty( $l['file_penilaian'] ) ): ?>
                            <td>
                            <!-- Keterangan Download Button -->
                            <a href="<?php echo base_url('uploads/'.$l['file_penilaian']); ?>" class="btn btn-success btn-sm" download>Download Penilaian</a>
                            </td>
                            <?php else : ?>
                            <td> - </td>
                            <?php endif; ?>
                            <?php if ( !empty( $l['Sertifikat'] ) ): ?>
                            <td>
                            <!-- Keterangan Download Button -->
                            <a href="<?php echo base_url('uploads/'.$l['Sertifikat']); ?>" class="btn btn-success btn-sm" download>Download Sertifikat</a>
                            </td>
                            <?php else : ?>
                            <td> - </td>
                            <?php endif; ?>
                            <?php if ( !empty( $l['penilaian_dosen'] ) ): ?>
                            <td>
                            <!-- Keterangan Download Button -->
                            <a href="<?php echo base_url('uploads/'.$l['penilaian_dosen']); ?>" class="btn btn-success btn-sm" download>Download Penilaian Dosen</a>
                            </td>
                            <?php else : ?>
                            <td> - </td>
                            <?php endif; ?>
                        
                            
                            
                            <td><?php echo $l['keterangan']; ?></td>

                            <td><?php echo $l['status']; ?></td>

                            <td>
                            <?php if ( $l['status'] == 'pending'  || $l['status'] == 'reject' ) : ?>
                                <?= anchor( site_url( 'Laporan/hapus/'. $l['id_laporan'] ), '<i class="fa-solid fa-trash"></i> Batal', 'class="btn btn-danger btn-sm" title="Batal"' ) ?>
                            <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach;?>
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



<?php else: ?>
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
                   
                        <div class="alert alert-dismissible fade show" role="alert">
                                    <strong><?= $this->session->flashdata('error'); ?></strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                   
                        <div class="alert alert-dismissible fade show" role="alert">
                                    <strong><?= $this->session->flashdata('success'); ?></strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                  

                        <form action="<?= site_url('laporan/upload') ?>" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="keterangan" class="form-label">Keterangan (Jika Tidak ada "-")</label>
                                <textarea class="form-control" name="keterangan" id="keterangan" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="file" class="form-label">Upload File Laporan (PDF)</label>
                                <input type="file" class="form-control" name="file" id="file" accept=".pdf" required>
                            </div>


                            <button type="submit" class="btn btn-primary">Kirim</button>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
