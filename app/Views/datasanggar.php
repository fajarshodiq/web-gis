<?= $this->extend('template/BaseView'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $heading; ?></h1>
    </div>
    <div class="row">
        <div class="col">
            <?php if (session()->getFlashdata('pesan')) { ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Sukses !</strong> <?= session()->getFlashdata('pesan'); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php } ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Sanggar</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>Nama Sanggar</th>
                                    <th>Pimpinan</th>
                                    <th>Website</th>
                                    <th>No.Telp</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($data as $i) { ?>
                                    <tr>
                                        <td><img src="<?= base_url('img/sanggar') . "/" . $i['foto_sanggar']; ?>" width="90px" height="90px" class="img-fluid" alt="<?= $i['nama_sanggar']; ?>" caption="<?= $i['nama_sanggar']; ?>"></td>
                                        <td><?= $i['nama_sanggar']; ?></td>
                                        <td><?= $i['nama_pimpinan']; ?></td>
                                        <td><a href="<?= $i['website']; ?>" target="_blank"><?= $i['website']; ?></a></td>
                                        <td><?= $i['no_telp']; ?></td>
                                        <td><a href="<?= base_url('form/update/') . "/" . $i['slug']; ?>" class="btn btn-warning mb-2 btn-sm">Update</a><br><a href="<?= base_url('form/hapus/') . "/" . $i['id']; ?>" class="btn btn-danger btn-sm">Hapus</a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>