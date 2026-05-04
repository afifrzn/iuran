<?php
require_once __DIR__ . '/includes/config.php';

header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

$action = $_POST['action'] ?? $_GET['action'] ?? '';

try {
    $pdo = getDB();

    switch ($action) {

        // ── Ambil semua member ───────────────────────────────────────────
        case 'get_members':
            $q    = '%' . trim($_GET['q'] ?? '') . '%';
            $fs   = $_GET['status'] ?? '';
            $fm   = $_GET['tipe']   ?? '';

            $sql  = "SELECT * FROM members WHERE nama LIKE :q";
            $params = [':q' => $q];

            if ($fs !== '') { $sql .= " AND status_tf = :status"; $params[':status'] = $fs; }
            if ($fm !== '') { $sql .= " AND tipe = :tipe";         $params[':tipe']   = $fm; }
            $sql .= " ORDER BY tipe, nama";

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            $members = $stmt->fetchAll();

            // Hitung statistik dari SEMUA member (tidak terfilter)
            $stats = $pdo->query("
                SELECT
                    COUNT(*) AS total,
                    SUM(status_tf = 'DONE') AS done,
                    SUM(status_tf = 'FALSE') AS belum,
                    SUM(CASE WHEN status_tf='DONE' AND tipe='makan' THEN " . HARGA_MAKAN . "
                              WHEN status_tf='DONE' AND tipe='tanpa' THEN " . HARGA_TANPA . "
                              ELSE 0 END) AS terkumpul,
                    SUM(CASE WHEN tipe='makan' THEN " . HARGA_MAKAN . "
                              ELSE " . HARGA_TANPA . " END) AS target
                FROM members
            ")->fetch();

            echo json_encode(['ok' => true, 'members' => $members, 'stats' => $stats]);
            break;

        // ── Toggle status transfer ───────────────────────────────────────
        case 'toggle_status':
            $id = (int)($_POST['id'] ?? 0);
            if (!$id) throw new Exception('ID tidak valid');

            $pdo->prepare("
                UPDATE members
                SET status_tf = IF(status_tf='DONE','FALSE','DONE')
                WHERE id = :id
            ")->execute([':id' => $id]);

            $member = $pdo->prepare("SELECT status_tf FROM members WHERE id=:id");
            $member->execute([':id' => $id]);
            $row = $member->fetch();

            echo json_encode(['ok' => true, 'status_tf' => $row['status_tf']]);
            break;

        // ── Tambah member ────────────────────────────────────────────────
        case 'tambah':
            $nama      = trim($_POST['nama']      ?? '');
            $tipe      = $_POST['tipe']            ?? '';
            $status_tf = $_POST['status_tf']       ?? 'FALSE';

            if ($nama === '')                          throw new Exception('Nama wajib diisi');
            if (!in_array($tipe, ['makan','tanpa']))   throw new Exception('Tipe tidak valid');
            if (!in_array($status_tf, ['DONE','FALSE'])) throw new Exception('Status tidak valid');

            $stmt = $pdo->prepare("INSERT INTO members (nama, tipe, status_tf) VALUES (:nama, :tipe, :status)");
            $stmt->execute([':nama' => $nama, ':tipe' => $tipe, ':status' => $status_tf]);

            echo json_encode(['ok' => true, 'id' => $pdo->lastInsertId()]);
            break;

        // ── Hapus member ─────────────────────────────────────────────────
        case 'hapus':
            $id = (int)($_POST['id'] ?? 0);
            if (!$id) throw new Exception('ID tidak valid');

            $pdo->prepare("DELETE FROM members WHERE id=:id")->execute([':id' => $id]);
            echo json_encode(['ok' => true]);
            break;

        // ── Edit member ──────────────────────────────────────────────────
        case 'edit':
            $id        = (int)($_POST['id']   ?? 0);
            $nama      = trim($_POST['nama']  ?? '');
            $tipe      = $_POST['tipe']        ?? '';
            $status_tf = $_POST['status_tf']   ?? 'FALSE';

            if (!$id || $nama === '')                  throw new Exception('Data tidak lengkap');
            if (!in_array($tipe, ['makan','tanpa']))   throw new Exception('Tipe tidak valid');

            $pdo->prepare("UPDATE members SET nama=:nama, tipe=:tipe, status_tf=:status WHERE id=:id")
                ->execute([':nama' => $nama, ':tipe' => $tipe, ':status' => $status_tf, ':id' => $id]);

            echo json_encode(['ok' => true]);
            break;

        default:
            throw new Exception('Action tidak dikenal');
    }

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}
