<?= $this->extend('template/BaseView'); ?>
<?= $this->section('content'); ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $heading; ?></h1>
    </div>
    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Peta Sebaran</h6>
                </div>
                <div class="card-body">
                    <div id="mapid" style=" height: 400px;"></div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Input Data Sanggar</h6>
                </div>
                <div class="card-body">
                    <form action="/form/simpan" method="POST" enctype="multipart/form-data">
                        <?php if ($validation->hasError('checkbox')) { ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <strong>Silahkan Centang Kotak Di Bawah ! </strong>Untuk memastikan data yang kamu masukan sudah benar silahkan baca kembali inputan kamu
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label>Nama Sanggar</label>
                            <input type="text" class="form-control <?= ($validation->hasError('nama_sanggar')) ? 'is-invalid' : ''; ?>" name="nama_sanggar" value="<?= old('nama_sanggar'); ?>" autofocus>
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama_sanggar'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Pimpinan</label>
                            <input type="text" class="form-control <?= ($validation->hasError('nama_pimpinan')) ? 'is-invalid' : ''; ?>" name="nama_pimpinan" value="<?= old('nama_pimpinan'); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('nama_pimpinan'); ?>
                            </div>

                        <div class="form-group">
                            <label>Foto Sanggar</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="foto_sanggar" name="foto_sanggar" onchange="img()">
                                <label class="custom-file-label">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea type="text" id="ckeditor" class="ckeditor form-control" name="deskripsi"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Website Sanggar</label>
                            <input type="url" class="form-control" name="website">
                        </div>
                        <div class="form-group">
                            <label>No.telp</label>
                            <input type="text" class="form-control" name="no_telp">
                        </div>
                        <div class="form-group">
                            <label>Latitude</label>
                            <input id="Latitude" type="text" class="form-control <?= ($validation->hasError('latitude')) ? 'is-invalid' : ''; ?>" name="latitude" value="<?= old('latitude'); ?>" readonly>
                            <div class="invalid-feedback">
                                <?= $validation->getError('latitude'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Longitude</label>
                            <input id="Longitude" type="text" class="form-control <?= ($validation->hasError('longitude')) ? 'is-invalid' : ''; ?>" name="longitude" value="<?= old('longitude'); ?>" readonly>
                            <div class="invalid-feedback">
                                <?= $validation->getError('longitude'); ?>
                            </div>
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" name="checkbox">
                            <label class="form-check-label">Data Sudah Benar</label>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

</div>

<script type='text/javascript'>
    var curLocation = [0, 0];
    if (curLocation[0] == 0 && curLocation[1] == 0) {
        curLocation = [-5.3561227871120005, 104.97706267599585];
    }

    var L = window.L;

    var mymap = L.map('mapid').setView([-5.3561227871120005, 104.97706267599585], 11);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
            '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
            'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        id: 'mapbox/streets-v11'
    }).addTo(mymap);

    mymap.attributionControl.setPrefix(false);
    var marker = new L.marker(curLocation, {
        draggable: 'true'
    });

    marker.on('dragend', function(event) {
        var position = marker.getLatLng();
        marker.setLatLng(position, {
            draggable: 'true'
        }).bindPopup(position).update();
        $("#Latitude").val(position.lat);
        $("#Longitude").val(position.lng).keyup();
    });

    
    document.addEventListener("DOMContentLoaded", function(event) { 
        $("#Latitude, #Longitude").change(function() {
        var position = [parseInt($("#Latitude").val()), parseInt($("#Longitude").val())];
        marker.setLatLng(position, {
            draggable: 'true'
        }).bindPopup(position).update();
        mymap.panTo(position);
    });
});
    mymap.addLayer(marker);
</script>
<script>
    function img() {
        const gambarLabel = document.querySelector('.custom-file-label');
        gambarLabel.textContent = foto_sekolah.files[0].name;
    }
</script>
<?= $this->endSection(); ?>