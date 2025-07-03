<div class="custom-card">
  <h4><i class="bi bi-building"></i> Data Kelas</h4>

  <?php
  // Ambil data untuk edit
  if (isset($_GET['edit'])) {
    $id_edit = $_GET['edit'];
    $data_edit = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM kelas WHERE id_kelas = $id_edit"));
  }
  ?>

  <!-- Form Tambah / Edit Kelas -->
  <form action="" method="post" class="mb-4 mt-3">
    <input type="hidden" name="id_kelas" value="<?= isset($data_edit) ? $data_edit['id_kelas'] : '' ?>">
    <div class="form-row align-items-end">
      <div class="col-md-4">
        <label for="nama_kelas">Nama Kelas</label>
        <input type="text" name="nama_kelas" class="form-control" required placeholder="Contoh: IX-A"
               value="<?= isset($data_edit) ? $data_edit['nama_kelas'] : '' ?>">
      </div>
      <div class="col-md-3">
        <label for="wali_kelas">Wali Kelas</label>
        <input type="text" name="wali_kelas" class="form-control" placeholder="Contoh: Bpk. Andi"
               value="<?= isset($data_edit) ? $data_edit['wali_kelas'] : '' ?>">
      </div>
      <div class="col-md-2">
        <?php if (isset($data_edit)) { ?>
          <button type="submit" name="update" class="btn btn-warning btn-block">
            <i class="bi bi-pencil-square"></i> Update
          </button>
        <?php } else { ?>
          <button type="submit" name="simpan" class="btn btn-primary btn-block">
            <i class="bi bi-plus-circle"></i> Simpan
          </button>
        <?php } ?>
      </div>
    </div>
  </form>

  <?php
  // Simpan data baru
  if (isset($_POST['simpan'])) {
    $nama = $_POST['nama_kelas'];
    $wali = $_POST['wali_kelas'];
    mysqli_query($koneksi, "INSERT INTO kelas (nama_kelas, wali_kelas) VALUES ('$nama', '$wali')");
    echo "<script>location.href='?page=kelas';</script>";
  }

  // Update data
  if (isset($_POST['update'])) {
    $id = $_POST['id_kelas'];
    $nama = $_POST['nama_kelas'];
    $wali = $_POST['wali_kelas'];
    mysqli_query($koneksi, "UPDATE kelas SET nama_kelas='$nama', wali_kelas='$wali' WHERE id_kelas=$id");
    echo "<script>location.href='?page=kelas';</script>";
  }

  // Hapus data
  if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM kelas WHERE id_kelas=$id");
    echo "<script>location.href='?page=kelas';</script>";
  }
  ?>

  <!-- Tabel Data Kelas -->
  <table class="table table-striped table-bordered mt-3">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Kelas</th>
        <th>Wali Kelas</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      $kelas = mysqli_query($koneksi, "SELECT * FROM kelas");
      while ($row = mysqli_fetch_assoc($kelas)) {
        echo "<tr>
                <td>{$no}</td>
                <td>{$row['nama_kelas']}</td>
                <td>{$row['wali_kelas']}</td>
                <td>
                  <a href='?page=kelas&edit={$row['id_kelas']}' class='btn btn-sm btn-warning'>
                    <i class='bi bi-pencil'></i> Edit
                  </a>
                  <a href='?page=kelas&hapus={$row['id_kelas']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Hapus kelas ini?')\">
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
