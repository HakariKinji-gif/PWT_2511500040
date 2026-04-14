<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Edit Data Guru</h1>
            </div>
        </div>
    </div>
</div>

<?php
$kd = $_GET['kd'];
$edit = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM guru WHERE kd_guru='$kd'"));

if(isset($_POST['tambah'])){
    $kd_guru = $_POST['kd_guru'];
    $nm_guru = $_POST['nm_guru'];
    $jenkel = $_POST['jenkel'];
    $pend_terakhir = $_POST['pend_terakhir'];
    $hp = $_POST['hp'];
    $alamat = $_POST['alamat'];

    $update = mysqli_query($koneksi, "UPDATE guru SET nm_guru='$nm_guru', jenkel='$jenkel', pend_terakhir='$pend_terakhir', hp='$hp', alamat='$alamat' WHERE kd_guru='$kd'");
    if($update){
        echo '<div class="alert alert-info-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
        <h5><i class="icon fas fa-info"></i> Info </h5>
        <h4>Berhasil Disimpan</h4></div>';
        echo '<meta http-equiv="refresh" content="1;url=index.php?page=guru">';
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
                            <label>ID Guru</label>
                            <input type="text" name="kd_guru" class="form-control" value="<?php echo $edit['kd_guru']; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Nama Guru</label>
                            <input type="text" name="nm_guru" class="form-control" value="<?php echo $edit['nm_guru']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="jenkel" class="form-control" value="<?php echo $edit['jenkel']; ?>" required>
                                <option value="Laki-laki" <?php if($edit['jenkel'] == "Laki-laki") echo "selected"; ?>>Laki-laki</option>
                                <option value="Perempuan" <?php if($edit['jenkel'] == "Perempuan") echo "selected"; ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Pendidikan Terakhir</label>
                            <select name="pend_terakhir" class="form-control" value="<?php echo $edit['pend_terakhir']; ?>" required>
                                <option value="Strata 1" <?php if($edit['pend_terakhir'] == "Strata 1") echo "selected"; ?>>Strata 1</option>
                                <option value="Strata 2" <?php if($edit['pend_terakhir'] == "Strata 2") echo "selected"; ?>>Strata 2</option>
                                <option value="Diploma 3" <?php if($edit['pend_terakhir'] == "Diploma 3") echo "selected"; ?>>Diploma 3</option>
                                <option value="SMA" <?php if($edit['pend_terakhir'] == "SMA") echo "selected"; ?>>SMA Sederajat</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nomor Telepon</label>
                            <input type="text" name="hp" class="form-control" value="<?php echo $edit['hp']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control" required><?php echo $edit['alamat']; ?></textarea>
                        </div>
                        <button type="submit" name="tambah" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>