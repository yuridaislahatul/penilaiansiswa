<div class="custom-card">
  <h4><i class="bi bi-person-fill"></i> Data Siswa</h4>

  <?php
  // Ambil data siswa untuk edit
  if (isset($_GET['edit'])) {
    $id_edit = $_GET['edit'];
    $data_edit = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM siswa WHERE id_siswa = $id_edit"));
  }
  ?>

  <!-- Form Tambah / Edit Siswa -->
  <form action="" method="post" class="mt-3 mb-4">
    <input type="hidden" name="id_siswa" value="<?= isset($data_edit) ? $data_edit['id_siswa'] : '' ?>">
    <div class="form-row">
      <div class="col-md-4">
        <label for="nama">Nama Lengkap</label>
        <input type="text" name="nama" class="form-control" required value="<?= isset($data_edit) ? $data_edit['nama'] : '' ?>">
      </div>
      <div class="col-md-3">
        <label for="nisn">NISN</label>
        <input type="text" name="nisn" class="form-control" required value="<?= isset($data_edit) ? $data_edit['nisn'] : '' ?>">
      </div>
      <div class="col-md-3">
        <label for="kelas">Kelas</label>
        <select name="id_kelas" class="form-control" required>
          <option value="">-- Pilih Kelas --</option>
          <?php
          $kelas = mysqli_query($koneksi, "SELECT * FROM kelas ORDER BY nama_kelas");
          while ($k = mysqli_fetch_assoc($kelas)) {
            $selected = (isset($data_edit) && $data_edit['id_kelas'] == $k['id_kelas']) ? 'selected' : '';
            echo "<option value='{$k['id_kelas']}' $selected>{$k['nama_kelas']}</option>";
          }
          ?>
        </select>
      </div>
      <div class="col-md-2 mt-4">
        <?php if (isset($data_edit)) { ?>
          <button type="submit" name="update" class="btn btn-warning btn-block mt-1">
            <i class="bi bi-pencil-square"></i> Update
          </button>
        <?php } else { ?>
          <button type="submit" name="simpan" class="btn btn-primary btn-block mt-1">
            <i class="bi bi-plus-circle"></i> Simpan
          </button>
        <?php } ?>
      </div>
    </div>
  </form>

  <?php
  // Simpan data siswa baru
  if (isset($_POST['simpan'])) {
    $nama = $_POST['nama'];
    $nisn = $_POST['nisn'];
    $id_kelas = $_POST['id_kelas'];
    mysqli_query($koneksi, "INSERT INTO siswa (nama, nisn, id_kelas) VALUES ('$nama', '$nisn', '$id_kelas')");
    echo "<script>location.href='?page=siswa';</script>";
  }

  // Update data siswa
  if (isset($_POST['update'])) {
    $id = $_POST['id_siswa'];
    $nama = $_POST['nama'];
    $nisn = $_POST['nisn'];
    $id_kelas = $_POST['id_kelas'];
    mysqli_query($koneksi, "UPDATE siswa SET nama='$nama', nisn='$nisn', id_kelas='$id_kelas' WHERE id_siswa=$id");
    echo "<script>location.href='?page=siswa';</script>";
  }

  // Hapus siswa
  if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM siswa WHERE id_siswa=$id");
    echo "<script>location.href='?page=siswa';</script>";
  }
  ?>

  <!-- Tabel Siswa -->
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Siswa</th>
        <th>NISN</th>
        <th>Kelas</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      $siswa = mysqli_query($koneksi, "
        SELECT siswa.*, kelas.nama_kelas 
        FROM siswa 
        LEFT JOIN kelas ON siswa.id_kelas = kelas.id_kelas
        ORDER BY siswa.nama
      ");
      while ($row = mysqli_fetch_assoc($siswa)) {
        echo "<tr>
                <td>{$no}</td>
                <td>{$row['nama']}</td>
                <td>{$row['nisn']}</td>
                <td>{$row['nama_kelas']}</td>
                <td>
                  <a href='?page=siswa&edit={$row['id_siswa']}' class='btn btn-sm btn-warning'>
                    <i class='bi bi-pencil'></i> Edit
                  </a>
                  <a href='?page=siswa&hapus={$row['id_siswa']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Yakin hapus siswa ini?')\">
                    <i class='bi bi-trash'></i> Hapus
                  </a>
                </td>
              </tr>";
        $no++;
      }
      ?>
    </tbody>
  </table>
</div>
