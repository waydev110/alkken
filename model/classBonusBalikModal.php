<?php
require_once 'classConnection.php';

class classBonusBalikModal
{
    private $conn;

    public function __construct()
    {
        $this->conn = new classConnection();
    }

    public function get_member($id)
    {
        $sql = "SELECT h.id_member, h.jenis_aktivasi, s.total_sponsori, (k.harga*2) AS max_bonus,  COALESCE(SUM(b.nominal), 0) AS total_bonus 
                    FROM mlm_kodeaktivasi_history h
                    JOIN mlm_kodeaktivasi k ON h.id_kodeaktivasi = k.id
                    JOIN mlm_member m ON h.id_member = m.id
                    LEFT JOIN mlm_bonus_balik_modal b ON h.id_member = b.id_member
                    LEFT JOIN (
                        SELECT sponsor, COUNT(*) AS total_sponsori
                        FROM mlm_member
                        WHERE id_plan IN (16, 17)
                        AND deleted_at IS NULL
                        AND reposisi = '0'
                        GROUP BY sponsor
                    ) s ON h.id_member = s.sponsor
                    WHERE h.deleted_at IS NULL
                    AND b.deleted_at IS NULL
                    AND k.jenis_aktivasi = '$id'
                    AND h.deleted_at IS NULL
                    AND k.harga > 0
                    AND s.total_sponsori >= 2
                    AND k.reposisi = '0'
					GROUP BY h.id_member
                    HAVING max_bonus > total_bonus";
        return $this->conn->_query($sql);
    }

    public function create($get_member, $jenis_bonus, $nominal_bonus, $keterangan, $id_kodeaktivasi, $created_at)
    {
        $values = [];
        $nominal = (float) $nominal_bonus;

        while ($member = $get_member->fetch_object()) {
            $id_member = (int) $member->id_member;

            $values[] = "($id_member, $nominal, 0, 0, $nominal, $jenis_bonus, 0, '$keterangan', $id_kodeaktivasi, '$created_at')";
        }

        if (!empty($values)) {
            $sql = "INSERT INTO mlm_bonus_balik_modal (
                    id_member, nominal, autosave, admin, total, jenis_bonus, status_transfer, keterangan, id_kodeaktivasi, created_at
                ) VALUES " . implode(', ', $values);

            return $this->conn->_query($sql); // cukup satu kali eksekusi
        }

        return false;
    }

    public function create_rekap($id_plan, $total_omset, $persentase, $total_bonus, $total_member, $nominal_bonus, $id_kodeaktivasi, $created_at)
    {
        $sql = "INSERT INTO mlm_bonus_balik_modal_rekap (
                    tgl_rekap,
                    id_plan,
                    total_omset,
                    persentase,
                    total_bonus,
                    total_member,
                    nominal,
                    keterangan,
                    id_kodeaktivasi,
                    created_at
                ) VALUES (
                    '$created_at',
                    $id_plan,
                    $total_omset,
                    $persentase,
                    $total_bonus,
                    $total_member,
                    $nominal_bonus,
                    '',
                    $id_kodeaktivasi,
                    '$created_at'
                )";
        return $this->conn->_query($sql);
    }

	public function history_rekap($id_kodeaktivasi){
		$sql  = "SELECT k.*, pl.nama_plan
                    FROM mlm_bonus_balik_modal_rekap k
                    LEFT JOIN mlm_plan pl ON k.id_plan = pl.id
                    WHERE k.id_kodeaktivasi = '$id_kodeaktivasi'";	
		$c    = new classConnection();
		$query  = $c->_query($sql);
		return $query;
	}

	public function history($id_kodeaktivasi){
		$sql  = "SELECT k.*, 
                        m.id_member, 
                        m.nama_member,
                        pl.nama_plan
                    FROM mlm_bonus_balik_modal k
                    LEFT JOIN mlm_member m ON k.id_member = m.id
                    LEFT JOIN mlm_plan pl ON k.jenis_bonus = pl.id
                    WHERE k.id_kodeaktivasi = '$id_kodeaktivasi'";	
		$c    = new classConnection();
		$query  = $c->_query($sql);
		return $query;
	}
}
