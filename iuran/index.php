<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Iuran</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="container">

  <!-- Header -->
  <div class="page-header">
    <h1>Manajemen <span>Iuran</span></h1>
    <button class="btn btn-teal" onclick="openModal()">
      + Tambah Anggota
    </button>
  </div>

  <!-- Stats -->
  <div class="stats">
    <div class="stat-card">
      <div class="stat-label">Total Anggota</div>
      <div class="stat-val" id="s-total">—</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Sudah Transfer</div>
      <div class="stat-val green" id="s-done">—</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Belum Transfer</div>
      <div class="stat-val red" id="s-belum">—</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Dana Terkumpul</div>
      <div class="stat-val money" id="s-terkumpul">—</div>
    </div>
    <div class="stat-card">
      <div class="stat-label">Total Target</div>
      <div class="stat-val money" id="s-target">—</div>
    </div>
  </div>

  <!-- Controls -->
  <div class="controls">
    <input type="text" id="search" placeholder="🔍  Cari nama...">
    <select id="filterStatus">
      <option value="">Semua Status</option>
      <option value="DONE">Sudah Transfer (DONE)</option>
      <option value="FALSE">Belum Transfer (FALSE)</option>
    </select>
    <select id="filterTipe">
      <option value="">Semua Tipe</option>
      <option value="makan">Pakai Makan</option>
      <option value="tanpa">Tanpa Makan</option>
    </select>
  </div>

  <!-- Tabel -->
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th style="width:42px">#</th>
          <th>Nama</th>
          <th style="width:130px">Tipe</th>
          <th style="width:130px">Nominal</th>
          <th style="width:110px">Status TF</th>
          <th style="width:80px">Aksi</th>
        </tr>
      </thead>
      <tbody id="tbody">
        <tr class="empty-row"><td colspan="6">Memuat data...</td></tr>
      </tbody>
    </table>
  </div>

</div><!-- /container -->

<!-- Modal -->
<div class="modal-overlay" id="modal">
  <div class="modal">
    <h2 id="modal-title">Tambah Anggota</h2>

    <div class="field">
      <label>Nama</label>
      <input type="text" id="f-nama" placeholder="Masukkan nama lengkap..." maxlength="100">
    </div>

    <div class="field">
      <label>Tipe</label>
      <select id="f-tipe">
        <option value="makan">Pakai Makan — Rp 138.000</option>
        <option value="tanpa">Tanpa Makan — Rp 100.000</option>
      </select>
    </div>

    <div class="field">
      <label>Status Transfer</label>
      <select id="f-status">
        <option value="FALSE">FALSE — Belum Bayar</option>
        <option value="DONE">DONE — Sudah Bayar</option>
      </select>
    </div>

    <div class="modal-actions">
      <button class="btn btn-ghost" onclick="closeModal()">Batal</button>
      <button class="btn btn-teal" id="save-btn" onclick="saveModal()">Simpan</button>
    </div>
  </div>
</div>

<!-- Toast -->
<div id="toast"></div>

<script src="assets/js/app.js"></script>
</body>
</html>
