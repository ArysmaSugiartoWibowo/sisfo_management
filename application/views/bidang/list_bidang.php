<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Data Bidang Yang Dibutuhkan</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <a href="<?php echo site_url('bidang/create'); ?>" class="btn btn-primary mb-3">Tambah Bidang</a>
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>

                                        <th>Nama Bidang</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($bidang as $b): ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td> <!-- Menampilkan nomor urut -->
                
                                            <td><?php echo $b->nama_bidang; ?></td>
                                            <td><?php echo $b->status; ?></td>
                                            <td>
                                                <a href="<?php echo site_url('bidang/edit/' . $b->id_bidang); ?>" class="btn btn-warning btn-sm">Edit</a>
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

<script src="<?= base_url('vendor') ?>/plugins/jquery/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
</script>
