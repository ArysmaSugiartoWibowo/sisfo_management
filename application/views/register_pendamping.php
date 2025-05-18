<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('vendor/') ?>plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?= base_url('vendor/') ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('vendor/') ?>dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/') ?>css/styles.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
    <?php if ($this->session->flashdata('pesan')): ?>
        <script type="text/javascript">
            alert("<?php echo $this->session->flashdata('pesan'); ?>");
        </script>
        <?php $this->session->flashdata('pesan'); ?>
    <?php endif; ?>
    <?php if ($this->session->flashdata('success')): ?>
        <script type="text/javascript">
            alert("<?php echo $this->session->flashdata('success'); ?>");
        </script>
        <?php $this->session->flashdata('success'); ?>
    <?php endif; ?>
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Sistem Informasi Layanan Magang </b></a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Register Akun KOMINFO TANAH DATAR</p>
                    <form action="<?= site_url('ControllerLogin/register_action_pendamping') ?>" method="post">
                            <div class="col-md-12">
                                <div class="form-group">
                                <label for="username">username:</label>
                                   <input type="hidden" id="level" class="form-control" name="level" value="pendamping">
                                   <input type="text" id="username" class="form-control" name="username" value="<?= set_value('username') ?>">
                                    <span class="text-danger"><?= form_error('username') ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input type="password" id="password" class="form-control" name="password"><br>
                                    <span class="text-danger"><?= form_error('password') ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="sekolah_asal">Sekolah Asal:</label>
                                    <select id="sekolah_asal" name="sekolah_asal" class="form-control">
                                        <option value="">Pilih Sekolah Asal</option>
                                        <?php if (!empty($institutes)): ?>
                                            <?php foreach ($institutes as $institute): ?>
                                                <option value="<?= htmlspecialchars($institute->institute) ?>">
                                                    <?= htmlspecialchars($institute->institute) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="">Data tidak tersedia</option>
                                        <?php endif; ?>
                                    </select>
                                    <span class="text-danger"><?= form_error('sekolah_asal') ?></span>
                                </div>
                                <label for="jurusan">Jurusan/Prodi:</label>
                                    <select id="jurusan" name="jurusan" class="form-control">
                                        <option value="">Pilih Jurusan/Prodi</option>
                                        <?php if (!empty($prodi)): ?>
                                            <?php foreach ($prodi as $p): ?>
                                                <option value="<?= htmlspecialchars($p->ps) ?>">
                                                    <?= htmlspecialchars($p->ps) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="">Data tidak tersedia</option>
                                        <?php endif; ?>
                                    </select>
                                    <span class="text-danger"><?= form_error('jurusan') ?></span>
                                </div>

                                <div class="row">
                                <div class="col-8">
                        <a href="<?= base_url('ControllerLogin'); ?>" class="btn btn-link">Kembali</a>
                        </div>
                                <div class="col-md-4">
                                    
                                        <button type="submit" class="btn btn-primary waves-effect waves-light m-r-10">Simpan</button>
                                        
                                 
                                </div>
    </div>
                            </div>

                        </form>
                        </div>
            <!-- /.login-card-body -->
        </div>
                        </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="<?= base_url('vendor/') ?>plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('vendor/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('vendor/') ?>dist/js/adminlte.min.js"></script>

</body>

</html>