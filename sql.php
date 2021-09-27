<?php
$host             = "localhost";
$user             = "root";
$pass             = "";
$db               = "crud";

$koneksi          = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
  die("tidak dapat terkoneksi ke data base");
}
$nik            = "";
$nama           = "";
$agama          = "";
$jenis_kelamin  = "";
$gol_darah      = "";
$sukses         = "";
$error          = "";

if (isset($_GET['op'])) {
  $op = $_GET;
} else {
  $op = "";
}
if ($op == 'delete') {
  $id    = $_GET['id'];
  $sql1  = "DELETE from personal where id='$id'";
  $q1    = mysqli_query($koneksi, $sql1);
  if ($q1) {
    $sukses = "Sukses menghapus data";
  } else {
    $error = "Gagal menghapus data";
  }
}
if ($op == 'edit') {
  $id   = $_GET['id'];
  $sql1 = "SELECT * from personal where id = '$id'";
  $q1   = mysqli_query($koneksi, $sql1);
  $r1   = mysqli_fetch_array($q1);
  $nik  = $r1['nik'];
  $nama  = $r1['nama'];
  $agama  = $r1['agama'];
  $jenis_kelamin  = $r1['jenis_kelamin'];
  $gol_darah  = $r1['gol_darah'];

  if ($nik == '') {
    $error = "Data tidak ditemukan";
  }
}


if (isset($_POST['simpan'])) { //create
  $nik            = $_POST['nik'];
  $nama           = $_POST['nama'];
  $jenis_kelamin  = $_POST['jenis_kelamin'];
  $gol_darah      = $_POST['gol_darah'];
  $agama          = $_POST['agama'];

  if ($nik && $nama && $jenis_kelamin && $gol_darah && $agama) {
    if ($op == 'edit') { //update
      $sql1  = "UPDATE personal set nik ='$nik',nama ='$nama',jenis_kelamin='$jenis_kelamin',gol_darah='$gol_darah',agama='$agama' where id = '$id'";
      $q1    = mysqli_query($koneksi, $sql1);
      if ($q1) {
        $sukses = "Data berhasil di-update";
      } else {
        $error = "Data gagal di-update";
      }
    } else { //insert
      $sql1 = "INSERT into personal (nik,nama,agama,jenis_kelamin,gol_darah) values ('$nik','$nama','$agama','$jenis_kelamin','$gol_darah')";
      $q1   = mysqli_query($koneksi, $sql1);
      if ($q1) {
        $sukses = "Berhasil memasukkan data";
      } else {
        $error  = "Gagal menyimpan";
      }
    }
  } else {
    $error = "Silahkan masukkan semua data";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Personal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
  <style>
    .mx-auto {
      width: 800px;
    }

    .card {
      margin-top: 10px
    }
  </style>
</head>

<body>
  <div class="mx-auto">
    <!-- memasukkan/ mengedit data-->
    <div class="card">
      <div class="card-header">
        Create / Edit Data
      </div>
      <div class="card-body">
        <?php
        if ($error) {
        ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $error ?>
          </div>
        <?php
        }
        ?>
        <?php
        if ($sukses) {
        ?>
          <div class="alert alert-success" role="alert">
            <?php echo $sukses ?>
          </div>
        <?php
        }
        ?>
        <!--form input-->
        <form action="" method="POST">
          <div class="mb-3 row">
            <label for="nik" class="col-sm-2 col-form-label">NIK</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nik" name="nik" value="<?php echo $nik ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="agama" class="col-sm-2 col-form-label">Agama</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="agama" name="agama" value="<?php echo $agama ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin" value="<?php echo $jenis_kelamin ?>">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="gol_darah" class="col-sm-2 col-form-label">Golongan Darah</label>
            <div class="col-sm-10">
              <select class="form-control" name="gol_darah" id="gol_darah">
                <option value="">-- Pilih Golongan Darah --</option>
                <option value="a-" <?php if ($gol_darah == "a-") {
                                      echo "selected";
                                    } ?>>A-</option>
                <option value="a+" <?php if ($gol_darah == "a+") {
                                      echo "selected";
                                    } ?>>A+</option>
                <option value="b-" <?php if ($gol_darah == "b-") {
                                      echo "selected";
                                    } ?>>B-</option>
                <option value="b+" <?php if ($gol_darah == "b+") {
                                      echo "selected";
                                    } ?>>B+</option>
                <option value="ab-" <?php if ($gol_darah == "ab-") {
                                      echo "selected";
                                    } ?>>AB-</option>
                <option value="ab+" <?php if ($gol_darah == "ab+") {
                                      echo "selected";
                                    } ?>>AB+</option>
                <option value="o-" <?php if ($gol_darah == "o-") {
                                      echo "selected";
                                    } ?>>O-</option>
                <option value="o+" <?php if ($gol_darah == "o+") {
                                      echo "selected";
                                    } ?>>O+</option>
              </select>
            </div>
          </div>
          <div class="col-12">
            <input type="submit" value="simpan" value="Simpan Data" class="btn btn-primary">
          </div>
        </form>
      </div>
    </div>
    <!-- mengeluarkan data-->
    <div class="card">
      <div class="card-header text-white bg-secondary">
        Data Pribadi
      </div>
      <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">No</th>
              <th scope="col">NIK</th>
              <th scope="col">Nama</th>
              <th scope="col">Agama</th>
              <th scope="col">Jenis Kelamin</th>
              <th scope="col">Golongan Darah</th>
              <th scope="col">Aksi</th>
            </tr>
          <tbody>
            <?php
            $sql2 = "SELECT * from personal order by id desc";
            $q2 = mysqli_query($koneksi, $sql2);
            $urut = 1;
            while ($r2 = mysqli_fetch_array($q2)) {
              $id = $r2['id'];
              $nik = $r2['nik'];
              $nama = $r2['nama'];
              $agama = $r2['agama'];
              $jenis_kelamin = $r2['jenis_kelamin'];
              $gol_darah = $r2['gol_darah'];
            ?>
              <tr>
                <th scope="row"><?php echo $urut++ ?>></th>
                <td scope="row"><?php echo $nik ?></td>
                <td scope="row"><?php echo $nama ?></td>
                <td scope="row"><?php echo $agama ?></td>
                <td scope="row"><?php echo $jenis_kelamin ?></td>
                <td scope="row"><?php echo $gol_darah ?></td>
                <td scope="row">
                  <a href="sql.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                  <a href="sql.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Anda yakin ingin menghapus data?')"><button type="button" class="btn btn-danger">Delete</button></a>

                </td>
              </tr>
            <?php
            }
            ?>
          </tbody>
          </thead>
        </table>
      </div>
    </div>
  </div>
</body>

</html>