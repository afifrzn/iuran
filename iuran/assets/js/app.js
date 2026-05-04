const API = 'api.php';
const HARGA = { makan: 138000, tanpa: 100000 };
const fmt = n => 'Rp ' + parseInt(n).toLocaleString('id-ID');

let editId = null;

/* ── Toast ───────────────────────────────────────────── */
function toast(msg, type = 'ok') {
  const el = document.getElementById('toast');
  el.textContent = msg;
  el.className = 'show ' + type;
  clearTimeout(el._t);
  el._t = setTimeout(() => el.className = '', 2800);
}

/* ── AJAX helper ─────────────────────────────────────── */
async function api(params) {
  const body = new URLSearchParams(params);
  const res = await fetch(API, { method: 'POST', body });
  return res.json();
}

async function apiGet(params) {
  const qs = new URLSearchParams(params);
  const res = await fetch(API + '?' + qs);
  return res.json();
}

/* ── Render stats ────────────────────────────────────── */
function renderStats(s) {
  document.getElementById('s-total').textContent    = s.total;
  document.getElementById('s-done').textContent     = s.done;
  document.getElementById('s-belum').textContent    = s.belum;
  document.getElementById('s-terkumpul').textContent = fmt(s.terkumpul);
  document.getElementById('s-target').textContent   = fmt(s.target);
}

/* ── Render tabel ────────────────────────────────────── */
function renderTable(members) {
  const tbody = document.getElementById('tbody');
  if (!members.length) {
    tbody.innerHTML = '<tr class="empty-row"><td colspan="6">Tidak ada data yang cocok</td></tr>';
    return;
  }

  tbody.innerHTML = members.map((m, i) => {
    const isDone  = m.status_tf === 'DONE';
    const isMakan = m.tipe === 'makan';
    return `<tr data-id="${m.id}">
      <td style="color:#9ca3af;font-weight:600">${i + 1}</td>
      <td style="font-weight:600">${esc(m.nama)}</td>
      <td>
        <span class="badge ${isMakan ? 'badge-makan' : 'badge-tanpa'}">
          ${isMakan ? 'Pakai Makan' : 'Tanpa Makan'}
        </span>
      </td>
      <td style="font-weight:600">${fmt(isMakan ? HARGA.makan : HARGA.tanpa)}</td>
      <td>
        <button class="badge ${isDone ? 'badge-done' : 'badge-false'} status-btn"
                onclick="toggleStatus(${m.id}, this)" title="Klik untuk ubah status">
          ${isDone ? '✓ DONE' : '✗ FALSE'}
        </button>
      </td>
      <td>
        <div class="action-btns">
          <button class="icon-btn edit"  onclick="openEdit(${m.id},'${esc(m.nama)}','${m.tipe}','${m.status_tf}')" title="Edit">✏</button>
          <button class="icon-btn hapus" onclick="hapusMember(${m.id})" title="Hapus">🗑</button>
        </div>
      </td>
    </tr>`;
  }).join('');
}

function esc(s) { return s.replace(/[&<>"']/g, c => ({ '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;' }[c])); }

/* ── Load data ───────────────────────────────────────── */
async function loadData() {
  const q      = document.getElementById('search').value;
  const status = document.getElementById('filterStatus').value;
  const tipe   = document.getElementById('filterTipe').value;

  const data = await apiGet({ action: 'get_members', q, status, tipe });
  if (!data.ok) { toast(data.error, 'err'); return; }

  renderStats(data.stats);
  renderTable(data.members);
}

/* ── Toggle status ───────────────────────────────────── */
async function toggleStatus(id, btn) {
  btn.disabled = true;
  const data = await api({ action: 'toggle_status', id });
  if (!data.ok) { toast(data.error, 'err'); btn.disabled = false; return; }

  const isDone = data.status_tf === 'DONE';
  btn.className  = `badge ${isDone ? 'badge-done' : 'badge-false'} status-btn`;
  btn.textContent = isDone ? '✓ DONE' : '✗ FALSE';
  btn.disabled   = false;

  toast(isDone ? 'Transfer DONE ✓' : 'Dikembalikan ke FALSE');
  loadData(); // refresh stats
}

/* ── Hapus ───────────────────────────────────────────── */
async function hapusMember(id) {
  if (!confirm('Yakin hapus anggota ini?')) return;
  const data = await api({ action: 'hapus', id });
  if (!data.ok) { toast(data.error, 'err'); return; }
  toast('Anggota dihapus');
  loadData();
}

/* ── Modal Tambah / Edit ─────────────────────────────── */
function openModal() {
  editId = null;
  document.getElementById('modal-title').textContent = 'Tambah Anggota';
  document.getElementById('f-nama').value      = '';
  document.getElementById('f-tipe').value      = 'makan';
  document.getElementById('f-status').value    = 'FALSE';
  document.getElementById('modal').classList.add('active');
  document.getElementById('f-nama').focus();
}

function openEdit(id, nama, tipe, status) {
  editId = id;
  document.getElementById('modal-title').textContent = 'Edit Anggota';
  document.getElementById('f-nama').value   = nama;
  document.getElementById('f-tipe').value   = tipe;
  document.getElementById('f-status').value = status;
  document.getElementById('modal').classList.add('active');
  document.getElementById('f-nama').focus();
}

function closeModal() {
  document.getElementById('modal').classList.remove('active');
}

async function saveModal() {
  const nama      = document.getElementById('f-nama').value.trim();
  const tipe      = document.getElementById('f-tipe').value;
  const status_tf = document.getElementById('f-status').value;

  if (!nama) { toast('Nama wajib diisi', 'err'); return; }

  const btn = document.getElementById('save-btn');
  btn.innerHTML = '<span class="spinner"></span>';
  btn.disabled  = true;

  const params = editId
    ? { action: 'edit', id: editId, nama, tipe, status_tf }
    : { action: 'tambah', nama, tipe, status_tf };

  const data = await api(params);

  btn.innerHTML = 'Simpan';
  btn.disabled  = false;

  if (!data.ok) { toast(data.error, 'err'); return; }

  toast(editId ? 'Data diperbarui ✓' : 'Anggota ditambahkan ✓');
  closeModal();
  loadData();
}

/* ── Event listeners ─────────────────────────────────── */
document.getElementById('search').addEventListener('input', loadData);
document.getElementById('filterStatus').addEventListener('change', loadData);
document.getElementById('filterTipe').addEventListener('change', loadData);

// Tutup modal klik luar
document.getElementById('modal').addEventListener('click', e => {
  if (e.target === document.getElementById('modal')) closeModal();
});

// Enter di form
document.getElementById('f-nama').addEventListener('keydown', e => {
  if (e.key === 'Enter') saveModal();
});

// Init
loadData();
