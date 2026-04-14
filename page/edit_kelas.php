<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Kelas</h1>
            </div>
        </div>
    </div>
</div>

<?php
$kd = $_GET['kd'];
$edit = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM kelas WHERE id_kelas='$kd'"));

if(isset($_POST['tambah'])){
    $id_kelas = $_POST['id_kelas'];
    $nm_kelas = $_POST['nm_kelas'];

    $update = mysqli_query($koneksi, "UPDATE kelas SET Nm_kelas='$nm_kelas' WHERE id_kelas='$kd'");
    if($update){
        echo '<div class="alert alert-info-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
        <h5><i class="icon fas fa-info"></i> Info </h5>
        <h4>Berhasil Disimpan</h4></div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=kelas">';
    }else{
        echo '<div class="alert alert-danger-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
        <h5><i class="icon fas fa-ban"></i> Error </h5>
        <h4>Gagal Disimpan</h4></div>';
    }
}
?>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="card-body p-2">
                    <form method="POST" action="">
                        <div class="form-group">
                            <label>ID Kelas</label>
                            <input type="text" name="id_kelas" class="form-control" value="<?php echo $edit['id_kelas']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Nama Kelas</label>
                            <input type="text" name="nm_kelas" class="form-control" value="<?php echo $edit['nm_kelas']; ?>" required>
                        </div>
                        <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>