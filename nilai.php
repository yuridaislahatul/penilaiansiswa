<div class="custom-card">
  <h4><i class="bi bi-clipboard-data-fill"></i> Data Nilai Siswa</h4>

  <?php
  // Ambil data untuk edit
  if (isset($_GET['edit'])) {
    $id_edit = $_GET['edit'];
    $edit_nilai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM nilai WHERE id_nilai = $id_edit"));
  }
  ?>

  <!-- Form Input / Edit Nilai -->
  <form action="" method="post" class="mt-3 mb-4">
    <input type="hidden" name="id_nilai" value="<?= isset($edit_nilai) ? $edit_nilai['id_nilai'] : '' ?>">
    <div class="form-row">
      <div class="col-md-4">
        <label for="siswa">Nama Siswa</label>
        <select name="id_siswa" class="form-control" required>
          <option value="">-- Pilih Siswa --</option>
          <?php
          $siswa = mysqli_query($koneksi, "
            SELECT siswa.id_siswa, siswa.nama, kelas.nama_kelas 
            FROM siswa 
            LEFT JOIN kelas ON siswa.id_kelas = kelas.id_kelas
            ORDER BY siswa.nama
          ");
          while ($s = mysqli_fetch_assoc($siswa)) {
            $selected = (isset($edit_nilai) && $edit_nilai['id_siswa'] == $s['id_siswa']) ? 'selected' : '';
            echo "<option value='{$s['id_siswa']}' $selected>{$s['nama']} - {$s['nama_kelas']}</option>";
          }
          ?>
        </select>
      </div>
      <div class="col-md-2">
        <label for="mapel">Mata Pelajaran</label>
        <input type="text" name="mapel" class="form-control" required value="<?= isset($edit_nilai) ? $edit_nilai['mapel'] : '' ?>">
      </div>
      <div class="col-md-2">
        <label for="nilai">Nilai</label>
        <input type="number" name="nilai" class="form-control" min="0" max="100" required value="<?= isset($edit_nilai) ? $edit_nilai['nilai'] : '' ?>">
      </div>
      <div class="col-md-2">
        <label for="predikat">Predikat</label>
        <select name="predikat" class="form-control" required>
          <?php
          $predikats = ['A', 'B', 'C', 'D'];
          foreach ($predikats as $p) {
            $selected = (isset($edit_nilai) && $edit_nilai['predikat'] == $p) ? 'selected' : '';
            echo "<option value='$p' $selected>$p</option>";
          }
          ?>
        </select>
      </div>
      <div class="col-md-2 mt-4">
        <?php if (isset($edit_nilai)) { ?>
          <button type="submit" name="update" class="btn btn-warning btn-block mt-1">
            <i class="bi bi-pencil-square"></i> Update
          </button>
        <?php } else { ?>
          <button type="submit" name="simpan" class="btn btn-success btn-block mt-1">
            <i class="bi bi-plus-circle"></i> Simpan
          </button>
        <?php } ?>
      </div>
    </div>
  </form>

  <?php
  // Simpan data nilai baru
  if (isset($_POST['simpan'])) {
    $id_siswa = $_POST['id_siswa'];
    $mapel = $_POST['mapel'];
    $nilai = $_POST['nilai'];
    $predikat = $_POST['predikat'];
    mysqli_query($koneksi, "INSERT INTO nilai (id_siswa, mapel, nilai, predikat) VALUES ('$id_siswa', '$mapel', '$nilai', '$predikat')");
    echo "<script>location.href='?page=nilai';</script>";
  }

  // Update data nilai
  if (isset($_POST['update'])) {
    $id_nilai = $_POST['id_nilai'];
    $id_siswa = $_POST['id_siswa'];
    $mapel = $_POST['mapel'];
    $nilai = $_POST['nilai'];
    $predikat = $_POST['predikat'];
    mysqli_query($koneksi, "UPDATE nilai SET id_siswa='$id_siswa', mapel='$mapel', nilai='$nilai', predikat='$predikat' WHERE id_nilai=$id_nilai");
    echo "<script>location.href='?page=nilai';</script>";
  }

  // Hapus nilai
  if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM nilai WHERE id_nilai=$id");
    echo "<script>location.href='?page=nilai';</script>";
  }
  ?>

  <!-- Tabel Nilai -->
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>No</th>
        <th>Nama Siswa</th>
        <th>Kelas</th>
        <th>Mata Pelajaran</th>
        <th>Nilai</th>
        <th>Predikat</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      $nilai = mysqli_query($koneksi, "
        SELECT nilai.*, siswa.nama, kelas.nama_kelas 
        FROM nilai 
        LEFT JOIN siswa ON nilai.id_siswa = siswa.id_siswa 
        LEFT JOIN kelas ON siswa.id_kelas = kelas.id_kelas
        ORDER BY siswa.nama
      ");
      while ($row = mysqli_fetch_assoc($nilai)) {
        echo "<tr>
                <td>{$no}</td>
                <td>{$row['nama']}</td>
                <td>{$row['nama_kelas']}</td>
                <td>{$row['mapel']}</td>
                <td>{$row['nilai']}</td>
                <td>{$row['predikat']}</td>
                <td>
                  <a href='?page=nilai&edit={$row['id_nilai']}' class='btn btn-sm btn-warning'>
                    <i class='bi bi-pencil'></i> Edit
                  </a>
                  <a href='?page=nilai&hapus={$row['id_nilai']}' class='btn btn-sm btn-danger' onclick=\"return confirm('Yakin hapus nilai ini?')\">
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
