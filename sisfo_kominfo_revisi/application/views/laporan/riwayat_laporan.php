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
                                                
                                            <?php else: ?>
                                                <td>-</td>
                                            <?php endif; ?>
                                            
                                            <td><?php echo $l->keterangan; ?></td>
                                            <td><?php echo $l->status; ?></td>
                                            
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
