<div class ="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
               <h1 class="m-0 text-dark">Data Kelas</h1>
            </div>
          </div>
       </div>
    </div>

    <?php
    if(isset($_GET['action'])) {
      if($_GET['action'] == "hapus") {
        $kd = $_GET['kd'];
        $query = mysqli_query($koneksi, "DELETE FROM kelas WHERE id_kelas='$kd'");
        if($query) {
          echo'
          <div class="alert alert-warning alert -dismissible">
          Berhasil di Hapus</div>';
          echo '<meta http-equiv="refresh" content="1;url=index.php?page=kelas">';
        }
      }
    }
    ?>
    <div class="content">
      <div class="container-fluid">
        <div class="card">
          <div class="card-body">
            <a href="index.php?page=tambah_kelas" class="btn btn-primary btn-sm">
          Tambah Kelas</a>
            <table class="table table-striped">
              <tread>
                <tr>
                  <th>No</th>
                  <th>Kode Kelas</th>
                  <th>Nama Kelas</th>
                  <th>Aksi</th>
                </tr>
              <tread>
              <?php
                $no = 0;
                $query = mysqli_query($koneksi, "SELECT * FROM kelas");
                while ($result = mysqli_fetch_array($query)) {
                  $no++;
                ?>
                <tbody>
                <tr>
                <td><?=$no; ?></td>
                <td><?=$result['id_kelas']; ?></td>
                <td><?=$result['nm_kelas']; ?></td>
                <td>
                  <a href="index.php?page=kelas&action=hapus&kd=<?=$result['id_kelas']?>" title="">
                  <span class="badge badge-danger">Hapus</span></a>
                  <a href="index.php?page=edit_kelas&kd=<?=$result['id_kelas'] ?>" title=""><span class
                  ="badge badge-warning">Edit</span></a>
                </td>
                </tr>
                </tbody>
                <?php } ?>
            </table>
          </div>
        </div>
      </div>
    </div>