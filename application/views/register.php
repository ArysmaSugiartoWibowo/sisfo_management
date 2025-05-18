
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Register</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <form action="<?= site_url('ControllerLogin/register_action') ?>" method="post">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label for="username">Username:</label>
                                   <input type="text" id="username" class="form-control" name="username" value="<?= set_value('username') ?>">
                                    <span class="text-danger"><?= form_error('username') ?></span>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input type="password" id="password" class="form-control" name="password"><br>
                                    <span class="text-danger"><?= form_error('password') ?></span>
                                </div>
                                <div class="form-group">
                                <label for="level">Level:</label>
                                    <select id="level" name="level" class="form-control">
                                        <option value="admin">Admin</option>
                                        <option value="kepala">Kepala</option>
                                    </select>
                                    <span class="text-danger"><?= form_error('level') ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light m-r-10">Simpan</button>
                                        
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>





