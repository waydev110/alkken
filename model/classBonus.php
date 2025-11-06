<?php 
require_once 'classConnection.php';

class classBonus{

    private function _SQL($id) {
        $sql = "SELECT 
                    id,
                    id_member,
                    type,
                    nominal,
                    autosave,
                    admin,
                    total,
                    status_transfer,
                    tanggal,
                    created_at,
                    updated_at,
                    keterangan
                FROM (
                    SELECT 
                        id,
                        id_member,
                        'bonus_sponsor' AS type,
                        nominal,
                        autosave,
                        admin,
                        total,
                        status_transfer,
                        CASE WHEN status_transfer = '1' THEN updated_at ELSE created_at END AS tanggal,
                        created_at,
                        updated_at,
                        keterangan
                    FROM mlm_bonus_sponsor
                    WHERE id_member = '$id' 
                    AND jenis_bonus NOT IN (15,16,17)
                    AND nominal > 0
                    AND deleted_at IS NULL

                    UNION ALL

                    SELECT 
                        id,
                        id_member,
                        'bonus_sponsor_netborn' AS type,
                        nominal,
                        autosave,
                        admin,
                        total,
                        status_transfer,
                        CASE WHEN status_transfer = '1' THEN updated_at ELSE created_at END AS tanggal,
                        created_at,
                        updated_at,
                        keterangan
                    FROM mlm_bonus_sponsor
                    WHERE id_member = '$id' 
                    AND jenis_bonus IN (15,16,17)
                    AND nominal > 0
                    AND deleted_at IS NULL

                    UNION ALL
    
                    SELECT 
                        bp.id,
                        bp.id_member,
                        'bonus_pasangan' AS type,
                        bp.nominal,
                        bp.autosave,
                        bp.admin,
                        bp.total,
                        bp.status_transfer,
                        CASE WHEN bp.status_transfer = '1' THEN bp.updated_at ELSE bp.created_at END AS tanggal,
                        bp.created_at,
                        bp.updated_at,
                        bp.keterangan
                    FROM mlm_bonus_pasangan bp
                    WHERE bp.id_member = '$id'
                    AND bp.id_plan = '4'
                    AND bp.nominal > 0
                    AND bp.deleted_at IS NULL

                    UNION ALL
    
                    SELECT 
                        bp.id,
                        bp.id_member,
                        'bonus_pasangan_netborn' AS type,
                        bp.nominal,
                        bp.autosave,
                        bp.admin,
                        bp.total,
                        bp.status_transfer,
                        CASE WHEN bp.status_transfer = '1' THEN bp.updated_at ELSE bp.created_at END AS tanggal,
                        bp.created_at,
                        bp.updated_at,
                        bp.keterangan
                    FROM mlm_bonus_pasangan bp
                    WHERE bp.id_member = '$id' 
                    AND bp.id_plan = '15' 
                    AND bp.nominal > 0
                    AND bp.deleted_at IS NULL

                    UNION ALL
    
                    SELECT 
                        bp.id,
                        bp.id_member,
                        'bonus_pasangan_level_netborn' AS type,
                        bp.nominal,
                        bp.autosave,
                        bp.admin,
                        bp.total,
                        bp.status_transfer,
                        CASE WHEN bp.status_transfer = '1' THEN bp.updated_at ELSE bp.created_at END AS tanggal,
                        bp.created_at,
                        bp.updated_at,
                        bp.keterangan
                    FROM mlm_bonus_pasangan_level bp
                    WHERE bp.id_member = '$id' AND bp.nominal > 0
                    AND bp.deleted_at IS NULL
    
                    UNION ALL
    
                    SELECT 
                        b.id,
                        b.id_member,
                        'bonus_generasi' AS type,
                        b.nominal,
                        b.autosave,
                        b.admin,
                        b.total,
                        b.status_transfer,
                        CASE WHEN b.status_transfer = '1' THEN b.updated_at ELSE b.created_at END AS tanggal,
                        b.created_at,
                        b.updated_at,
                        b.keterangan
                    FROM mlm_bonus_generasi b
                    WHERE b.id_member = '$id' 
                    AND b.nominal > 0
                    AND b.deleted_at IS NULL
    
                    UNION ALL
    
                    SELECT 
                        b.id,
                        b.id_member,
                        'bonus_upline' AS type,
                        b.nominal,
                        b.autosave,
                        b.admin,
                        b.total,
                        b.status_transfer,
                        CASE WHEN b.status_transfer = '1' THEN b.updated_at ELSE b.created_at END AS tanggal,
                        b.created_at,
                        b.updated_at,
                        b.keterangan
                    FROM mlm_bonus_upline b
                    WHERE b.id_member = '$id' 
                    AND b.nominal > 0
                    AND b.deleted_at IS NULL
    
                    UNION ALL
    
                    SELECT 
                        b.id,
                        b.id_member,
                        'bonus_titik_netborn' AS type,
                        b.nominal,
                        b.autosave,
                        b.admin,
                        b.total,
                        b.status_transfer,
                        CASE WHEN b.status_transfer = '1' THEN b.updated_at ELSE b.created_at END AS tanggal,
                        b.created_at,
                        b.updated_at,
                        b.keterangan
                    FROM mlm_bonus_upline b 
                    WHERE b.id_member = '$id' 
                    AND b.jenis_bonus IN (15,16,17)
                    AND b.nominal > 0
                    AND b.deleted_at IS NULL
    
                    UNION ALL
    
                    SELECT 
                        b.id,
                        b.id_member,
                        'bonus_generasi_ro_aktif' AS type,
                        b.nominal,
                        b.autosave,
                        b.admin,
                        b.total,
                        b.status_transfer,
                        CASE WHEN b.status_transfer = '1' THEN b.updated_at ELSE b.created_at END AS tanggal,
                        b.created_at,
                        b.updated_at,
                        b.keterangan
                    FROM mlm_bonus_generasi b
                    LEFT JOIN mlm_plan pl ON b.jenis_bonus = pl.id
                    WHERE b.id_member = '$id' 
                    AND pl.jenis_plan = '1' 
                    AND pl.id = 14
                    AND b.nominal > 0
                    AND b.deleted_at IS NULL
    
                    UNION ALL
    
                    SELECT 
                        b.id,
                        b.id_member,
                        'bonus_titik_ro_aktif' AS type,
                        b.nominal,
                        b.autosave,
                        b.admin,
                        b.total,
                        b.status_transfer,
                        CASE WHEN b.status_transfer = '1' THEN b.updated_at ELSE b.created_at END AS tanggal,
                        b.created_at,
                        b.updated_at,
                        b.keterangan
                    FROM mlm_bonus_upline b
                    LEFT JOIN mlm_plan pl ON b.jenis_bonus = pl.id
                    WHERE b.id_member = '$id' 
                    AND pl.jenis_plan = '1' 
                    AND pl.id = 14
                    AND b.nominal > 0
                    AND b.deleted_at IS NULL

                    UNION ALL
    
                    SELECT 
                        id,
                        id_member,
                        'bonus_founder' AS type,
                        nominal,
                        autosave,
                        admin,
                        total,
                        status_transfer,
                        CASE WHEN status_transfer = '1' THEN updated_at ELSE created_at END AS tanggal,
                        created_at,
                        updated_at,
                        keterangan
                    FROM mlm_bonus_founder
                    WHERE id_member = '$id' AND nominal > 0
                    AND deleted_at IS NULL

                    UNION ALL
    
                    SELECT 
                        id,
                        id_member,
                        'bonus_royalti_omset' AS type,
                        nominal,
                        autosave,
                        admin,
                        total,
                        status_transfer,
                        CASE WHEN status_transfer = '1' THEN updated_at ELSE created_at END AS tanggal,
                        created_at,
                        updated_at,
                        keterangan
                    FROM mlm_bonus_royalti_omset
                    WHERE id_member = '$id' AND nominal > 0
                    AND deleted_at IS NULL
    
                    UNION ALL
    
                    SELECT 
                        id,
                        id_member,
                        'bonus_cashback' AS type,
                        nominal,
                        autosave,
                        admin,
                        total,
                        status_transfer,
                        CASE WHEN status_transfer = '1' THEN updated_at ELSE created_at END AS tanggal,
                        created_at,
                        updated_at,
                        keterangan
                    FROM mlm_bonus_cashback
                    WHERE id_member = '$id' AND nominal > 0
                    AND deleted_at IS NULL
    
                    UNION ALL
    
                    SELECT 
                        r.id,
                        r.id_member,
                        'bonus_reward' AS type,
                        r.nominal,
                        r.autosave,
                        r.admin,
                        r.total,
                        r.status_transfer,
                        CASE WHEN r.status_transfer = '1' THEN r.updated_at ELSE r.created_at END AS tanggal,
                        r.created_at,
                        r.updated_at,
                        r.keterangan
                    FROM mlm_bonus_reward r
                    LEFT JOIN mlm_bonus_reward_setting s ON r.id_bonus_reward_setting = s.id
                    LEFT JOIN mlm_plan pl ON s.id_plan = pl.id
                    WHERE r.id_member = '$id' 
                    AND pl.id <> 15
                    AND pl.jenis_plan = '0' AND r.nominal > 0
                    AND r.deleted_at IS NULL
    
                    UNION ALL
    
                    SELECT 
                        r.id,
                        r.id_member,
                        'bonus_reward_netborn' AS type,
                        r.nominal,
                        r.autosave,
                        r.admin,
                        r.total,
                        r.status_transfer,
                        CASE WHEN r.status_transfer = '1' THEN r.updated_at ELSE r.created_at END AS tanggal,
                        r.created_at,
                        r.updated_at,
                        r.keterangan
                    FROM mlm_bonus_reward r
                    LEFT JOIN mlm_bonus_reward_setting s ON r.id_bonus_reward_setting = s.id
                    LEFT JOIN mlm_plan pl ON s.id_plan = pl.id
                    WHERE r.id_member = '$id' 
                    AND pl.id = 15
                    AND pl.jenis_plan = '0' AND r.nominal > 0
                    AND r.deleted_at IS NULL
    
                    UNION ALL
    
                    SELECT 
                        r.id,
                        r.id_member,
                        'bonus_reward_paket' AS type,
                        r.nominal,
                        r.autosave,
                        r.admin,
                        r.total,
                        r.status_transfer,
                        CASE WHEN r.status_transfer = '1' THEN r.updated_at ELSE r.created_at END AS tanggal,
                        r.created_at,
                        r.updated_at,
                        r.keterangan
                    FROM mlm_bonus_reward_paket r
                    LEFT JOIN mlm_bonus_reward_paket_setting s ON r.id_bonus_reward_setting = s.id
                    WHERE r.id_member = '$id' AND r.nominal > 0
                    AND r.deleted_at IS NULL
    
                    UNION ALL
    
                    SELECT 
                        r.id,
                        r.id_member,
                        'bonus_balik_modal' AS type,
                        r.nominal,
                        r.autosave,
                        r.admin,
                        r.total,
                        r.status_transfer,
                        CASE WHEN r.status_transfer = '1' THEN r.updated_at ELSE r.created_at END AS tanggal,
                        r.created_at,
                        r.updated_at,
                        r.keterangan
                    FROM mlm_bonus_balik_modal r
                    WHERE r.id_member = '$id' AND r.nominal > 0
                    AND r.deleted_at IS NULL
                ) AS combined_data
                WHERE combined_data.status_transfer IN ('-1', '0', '1')
                ORDER BY tanggal DESC";
    
        return $sql;
    }    

    private function _SQL_ALL_NEW() {
        $sql = "SELECT 
                    id,
                    id_member,
                    type,
                    sort,
                    nominal,
                    status_transfer,
                    tanggal,
                    created_at,
                    updated_at,
                    keterangan
                FROM (
                    SELECT 
                        id,
                        id_member,
                        'bonus_sponsor' AS type,
                        nominal,
                        status_transfer,
                        CASE WHEN status_transfer = '1' THEN updated_at ELSE created_at END AS tanggal,
                        created_at,
                        updated_at,
                        keterangan,
                        1 AS sort
                    FROM mlm_bonus_sponsor
                    WHERE nominal > 0
                    AND deleted_at IS NULL
                    
                    UNION ALL
    
                    SELECT 
                        bp.id,
                        bp.id_member,
                        'bonus_pasangan' AS type,
                        bp.nominal,
                        bp.status_transfer,
                        CASE WHEN bp.status_transfer = '1' THEN bp.updated_at ELSE bp.created_at END AS tanggal,
                        bp.created_at,
                        bp.updated_at,
                        bp.keterangan,
                        2 AS sort
                    FROM mlm_bonus_pasangan bp
                    LEFT JOIN mlm_plan pl ON bp.id_plan = pl.id
                    WHERE pl.jenis_plan = '0' AND bp.nominal > 0
                    AND bp.deleted_at IS NULL
    
                    UNION ALL
    
                    SELECT 
                        b.id,
                        b.id_member,
                        'bonus_generasi' AS type,
                        b.nominal,
                        b.status_transfer,
                        CASE WHEN b.status_transfer = '1' THEN b.updated_at ELSE b.created_at END AS tanggal,
                        b.created_at,
                        b.updated_at,
                        b.keterangan,
                        4 AS sort
                    FROM mlm_bonus_generasi b
                    LEFT JOIN mlm_plan pl ON b.jenis_bonus = pl.id
                    WHERE pl.jenis_plan = '1' 
                    AND pl.id <> 14
                    AND b.nominal > 0
                    AND b.deleted_at IS NULL
    
                    UNION ALL
    
                    SELECT 
                        b.id,
                        b.id_member,
                        'bonus_generasi_ro_aktif' AS type,
                        b.nominal,
                        b.status_transfer,
                        CASE WHEN b.status_transfer = '1' THEN b.updated_at ELSE b.created_at END AS tanggal,
                        b.created_at,
                        b.updated_at,
                        b.keterangan,
                        4 AS sort
                    FROM mlm_bonus_generasi b
                    LEFT JOIN mlm_plan pl ON b.jenis_bonus = pl.id
                    WHERE pl.jenis_plan = '1' 
                    AND pl.id = 14
                    AND b.nominal > 0
                    AND b.deleted_at IS NULL
    
                    UNION ALL
    
                    SELECT 
                        b.id,
                        b.id_member,
                        'bonus_titik_ro_aktif' AS type,
                        b.nominal,
                        b.status_transfer,
                        CASE WHEN b.status_transfer = '1' THEN b.updated_at ELSE b.created_at END AS tanggal,
                        b.created_at,
                        b.updated_at,
                        b.keterangan,
                        4 AS sort
                    FROM mlm_bonus_upline b
                    LEFT JOIN mlm_plan pl ON b.jenis_bonus = pl.id
                    WHERE pl.jenis_plan = '1' 
                    AND pl.id = 14
                    AND b.nominal > 0
                    AND b.deleted_at IS NULL
    
                    UNION ALL
    
                    SELECT 
                        id,
                        id_member,
                        'bonus_founder' AS type,
                        nominal,
                        status_transfer,
                        CASE WHEN status_transfer = '1' THEN updated_at ELSE created_at END AS tanggal,
                        created_at,
                        updated_at,
                        keterangan,
                        6 AS sort
                    FROM mlm_bonus_founder
                    WHERE nominal > 0
                    AND deleted_at IS NULL
    
                    UNION ALL
    
                    SELECT 
                        id,
                        id_member,
                        'bonus_cashback' AS type,
                        nominal,
                        status_transfer,
                        CASE WHEN status_transfer = '1' THEN updated_at ELSE created_at END AS tanggal,
                        created_at,
                        updated_at,
                        keterangan,
                        3 AS sort
                    FROM mlm_bonus_cashback
                    WHERE nominal > 0
                    AND deleted_at IS NULL
    
                    UNION ALL
    
                    SELECT 
                        r.id,
                        r.id_member,
                        'bonus_reward' AS type,
                        r.nominal,
                        r.status_transfer,
                        CASE WHEN r.status_transfer = '1' THEN r.updated_at ELSE r.created_at END AS tanggal,
                        r.created_at,
                        r.updated_at,
                        r.keterangan,
                        7 AS sort
                    FROM mlm_bonus_reward r
                    LEFT JOIN mlm_bonus_reward_setting s ON r.id_bonus_reward_setting = s.id
                    LEFT JOIN mlm_plan pl ON s.id_plan = pl.id
                    WHERE pl.id = '4' AND r.nominal > 0
                    AND r.deleted_at IS NULL
    
                    UNION ALL
    
                    SELECT 
                        r.id,
                        r.id_member,
                        'bonus_reward_ro' AS type,
                        r.nominal,
                        r.status_transfer,
                        CASE WHEN r.status_transfer = '1' THEN r.updated_at ELSE r.created_at END AS tanggal,
                        r.created_at,
                        r.updated_at,
                        r.keterangan,
                        8 AS sort
                    FROM mlm_bonus_reward r
                    LEFT JOIN mlm_bonus_reward_setting s ON r.id_bonus_reward_setting = s.id
                    LEFT JOIN mlm_plan pl ON s.id_plan = pl.id
                    WHERE pl.id = '11' AND r.nominal > 0
                    AND r.deleted_at IS NULL
    
                    UNION ALL
    
                    SELECT 
                        r.id,
                        r.id_member,
                        'bonus_reward_fasttrack' AS type,
                        r.nominal,
                        r.status_transfer,
                        CASE WHEN r.status_transfer = '1' THEN r.updated_at ELSE r.created_at END AS tanggal,
                        r.created_at,
                        r.updated_at,
                        r.keterangan,
                        9 AS sort
                    FROM mlm_bonus_reward r
                    LEFT JOIN mlm_bonus_reward_setting s ON r.id_bonus_reward_setting = s.id
                    LEFT JOIN mlm_plan pl ON s.id_plan = pl.id
                    WHERE pl.id = '13' AND r.nominal > 0
                    AND r.deleted_at IS NULL
    
                    UNION ALL
    
                    SELECT 
                        r.id,
                        r.id_member,
                        'bonus_reward_paket' AS type,
                        r.nominal,
                        r.status_transfer,
                        CASE WHEN r.status_transfer = '1' THEN r.updated_at ELSE r.created_at END AS tanggal,
                        r.created_at,
                        r.updated_at,
                        r.keterangan,
                        10 AS sort
                    FROM mlm_bonus_reward_paket r
                    LEFT JOIN mlm_bonus_reward_paket_setting s ON r.id_bonus_reward_setting = s.id
                    LEFT JOIN mlm_produk_jenis pj ON s.id_produk_jenis = pj.id
                    WHERE pj.id = 5 AND r.nominal > 0
                    AND r.deleted_at IS NULL
                ) AS combined_data
                ORDER BY tanggal DESC";
    
        return $sql;
    }

    public function update_transfer($table, $id_member, $tanggal, $updated_at){
        $sql = "UPDATE $table 
                SET status_transfer = '1', updated_at = '$updated_at'
                WHERE id_member = '$id_member'
                AND created_at < '$tanggal'
                AND status_transfer = '0'";
        $c    = new classConnection(); 
        $query  = $c->_query($sql);
        return $query;
    }

    public function update_pending($table, $id_member, $tanggal, $updated_at){
        $sql = "UPDATE $table 
                SET status_transfer = '0', updated_at = '$updated_at'
                WHERE id_member = '$id_member'
                AND created_at < '$tanggal'
                AND status_transfer = '2'";
        $c    = new classConnection(); 
        $query  = $c->_query($sql);
        return $query;
    }

    public function update_reject($table, $id_member, $tanggal, $updated_at){
        $sql = "UPDATE $table 
                SET status_transfer = '2', updated_at = '$updated_at'
                WHERE id_member = '$id_member'
                AND created_at < '$tanggal'
                AND status_transfer = '0'";
        $c    = new classConnection(); 
        $query  = $c->_query($sql);
        return $query;
    }
    
    public function get_total_bonus($status_transfer = '', $type = ''){
        $sql_bonus = $this->_SQL_ALL();
        $sql = "SELECT COALESCE(SUM(nominal), 0) AS total 
                    FROM ($sql_bonus) AS b
                    WHERE CASE WHEN LENGTH('$type') > 0 THEN type = '$type' ELSE 1 END
                    AND CASE WHEN LENGTH('$status_transfer') > 0 THEN status_transfer = '$status_transfer' ELSE 1 END";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        if($query){
            return $query->total;
        }
        return 0;
    }
    
    public function item_bonus(){
        $sql_bonus = $this->_SQL_ALL();
        $sql = "SELECT b.type
                    FROM ($sql_bonus) AS b
                    GROUP BY b.type ORDER BY b.group_bonus ASC";
                    // echo $sql;
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    public function index_member($id){
        $sql = $this->_SQL($id);
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    
    public function jumlah_bonus($id, $tanggal){
        $sql_bonus = $this->_SQL($id);
        $sql = "SELECT COALESCE(SUM(nominal), 0) AS total FROM ($sql_bonus) AS bonusTable
                WHERE LEFT(created_at, 7) = '$tanggal'
                AND type <> 'bonus_saldo'";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }

    public function jumlah_penarikan($id, $tanggal){
        $sql_bonus = $this->_SQL($id);
        $sql = "SELECT COALESCE(SUM(nominal), 0) AS total FROM ($sql_bonus) AS bonusTable
                WHERE LEFT(updated_at, 7) = '$tanggal'
                AND status_transfer = '1'
                AND type <> 'bonus_saldo'";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }
    
    
    public function total_bonus($id, $status_transfer= ''){
        $sql_bonus = $this->_SQL($id);
        $sql = "SELECT COALESCE(SUM(nominal), 0) AS total 
                    FROM ($sql_bonus) b 
                    WHERE b.type <> 'bonus_poin'
                    AND CASE WHEN LENGTH('$status_transfer') > 0 THEN status_transfer = '$status_transfer' ELSE 1 END";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }

    public function total_pending_bonus($id){
        $sql_bonus = $this->_SQL($id);
        $sql = "SELECT COALESCE(SUM(nominal), 0) AS total FROM ($sql_bonus) AS bonusTable
                WHERE status_transfer = '0'
                AND type <> 'bonus_saldo'";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }

    public function statement_bonus($id, $tanggal){
        $sql = $this->_SQL($id);
        $sql = "SELECT type, COALESCE(SUM(nominal), 0) AS jumlah FROM ($sql) AS bonusTable
                WHERE LEFT(created_at, 7) = '$tanggal'
                GROUP BY type";
                // echo $sql;
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function statement_penarikan($id, $tanggal){
        $sql = $this->_SQL($id);
        $sql = "SELECT type, COALESCE(SUM(nominal), 0) AS jumlah FROM ($sql) AS bonusTable
                WHERE LEFT(updated_at, 7) = '$tanggal'
                GROUP BY type";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    
    public function riwayat_transfer($id, $group_bonus){
        $sql = $this->_SQL($id);
        $sql = "SELECT id_member, type, COALESCE(SUM(nominal), 0) AS jumlah, updated_at FROM ($sql) AS bonusTable
                WHERE status_transfer = '1'
                AND group_bonus = '$group_bonus'
                GROUP BY updated_at
                ORDER BY updated_at DESC";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    
    public function detail_transfer($id, $updated_at){
        $sql = $this->_SQL($id);
        $sql = "SELECT id, type, nominal, keterangan, updated_at FROM ($sql) AS bonusTable
                WHERE status_transfer = '1'
                AND updated_at = '$updated_at'
                ORDER BY updated_at DESC";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function top_income($bulan = ''){
        $sql = $this->_SQL_ALL();
        $sql = "SELECT mm.nama_samaran, k.nama_kota, p.nama_plan, p.gambar, mm.id_member, mm.nama_member, SUM(b.nominal) AS total FROM ($sql) AS b
                LEFT JOIN mlm_member mm ON b.id_member = mm.id                
                LEFT JOIN mlm_plan p
                    ON mm.id_plan = p.id           
                LEFT JOIN mlm_kota k
                    ON mm.id_kota = k.id
                WHERE CASE WHEN LENGTH('$bulan') > 0 THEN LEFT(b.created_at, 7) = '$bulan' ELSE 1 END 
                AND b.id_member > 1
                GROUP BY b.id_member
                ORDER BY total DESC
                LIMIT 5";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    public function top_reward_ro(){
        $sql = "SELECT mm.id_member, mm.nama_member, mm.nama_samaran, k.nama_kota, p.gambar, p.nama_peringkat, b.nominal AS total 
                FROM mlm_bonus_reward AS b
                LEFT JOIN mlm_member mm ON b.id_member = mm.id
                LEFT JOIN mlm_kota k ON mm.id_kota = b.id
                LEFT JOIN mlm_peringkat p ON mm.id_peringkat = p.id
                WHERE b.deleted_at IS NULL
                GROUP BY b.id_member
                ORDER BY total DESC
                LIMIT 5";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    
    public function ajax($id_member, $start, $type, $keterangan, $status_transfer, $start_date, $end_date) {
        $id_member = (int)$id_member;
        $start = (int)$start;
    
        $sql = $this->_SQL($id_member);
    
        $sql = "SELECT *
                FROM ($sql) AS b
                WHERE CASE WHEN LENGTH('$type') > 0 THEN b.type = '$type' ELSE 1 END
                AND CASE WHEN LENGTH('$keterangan') > 0 THEN b.keterangan LIKE '%$keterangan%' ELSE 1 END
                AND CASE WHEN LENGTH('$status_transfer') > 0 THEN b.status_transfer = '$status_transfer' ELSE 1 END
                AND CASE WHEN LENGTH('$start_date') > 0 THEN LEFT(b.created_at,10) > '$start_date' ELSE 1 END
                AND CASE WHEN LENGTH('$end_date') > 0 THEN LEFT(b.created_at,10) > '$end_date' ELSE 1 END
                ORDER BY b.tanggal DESC
                LIMIT $start, 10";
                // echo $sql;
    
        $c = new classConnection();
    
        $query = $c->_query($sql);
    
        return $query;
    }
    
      
    
    
    public function ajax_wallet($id, $start, $jenis_saldo){
        $sql = $this->_SQL($id);
        $sql = "SELECT *
                FROM mlm_wallet
                WHERE  id_member = '$id'
                AND CASE WHEN LENGTH('$jenis_saldo') > 0 THEN jenis_saldo = '$jenis_saldo' ELSE 1 END
                AND deleted_at IS NULL
                ORDER BY created_at DESC
                LIMIT $start, 10";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    public function riwayat_saldo($jenis_saldo, $id, $status = ''){
        $sql = "SELECT 
                COALESCE(SUM(CASE 
                    WHEN w.status = 'd' 
                    THEN w.nominal
                    ELSE 0 
                END),0) AS debit,
                COALESCE(SUM(CASE 
                    WHEN w.status = 'k'
                    THEN w.nominal
                    ELSE 0 
                END),0) AS kredit,                
                COALESCE(SUM(CASE 
                    WHEN w.status = 'd' 
                    THEN w.nominal
                    ELSE 0 
                END) - SUM(CASE 
                    WHEN w.status = 'k'
                    THEN w.nominal
                    ELSE 0 
                END),0) AS sisa                
                FROM mlm_wallet w
                WHERE w.id_member = '$id'
                AND CASE WHEN LENGTH('$jenis_saldo') > 0 THEN w.jenis_saldo = '$jenis_saldo' ELSE 1 END
                AND w.deleted_at IS NULL";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query;
    }
    
	public function riwayat_investasi($id_member){
		$sql  = "SELECT k.*
		            FROM mlm_kodeaktivasi k
		            WHERE k.id_member = '$id_member'
                    AND k.jenis_aktivasi = 10
		            AND k.status_aktivasi = '1' 
		            AND k.deleted_at IS NULL 
		            ORDER BY k.id DESC";
	   // echo $sql;
	    $c    = new classConnection();
	    $query  = $c->_query($sql);
	    return $query;
	}
	public function riwayat_investasi_show($id_member, $id){
        $sql  = "SELECT a.*, 
                    p.gambar, 
                    p.nama_produk, 
                    p.slug, 
                    p.berat, 
                    p.satuan, 
                    p.keterangan, 
                    pl.id as id_plan,
                    pl.nama_plan,
                    pl.pasangan,
                    pl.parent_pasangan,
                    pl.reward,
                    pl.parent_reward,
                    pl.tingkat 
                FROM mlm_kodeaktivasi a
                LEFT JOIN mlm_plan pl
                    ON a.jenis_aktivasi = pl.id 
        		WHERE a.id = '$id'
                    AND a.id_member = '$id_member'
                    AND a.status_aktivasi='1' 
                    AND a.deleted_at is null";
	    $c    = new classConnection();
	    $query  = $c->_query_fetch($sql);
	    return $query;
	}
    
	public function riwayat_bonus_investasi($id_member){
		$sql  = "SELECT k.*, 
		            c.nominal,
		            COUNT(c.id_kodeaktivasi) AS jumlah,
		            MAX(c.created_at) AS last_date
		            FROM mlm_kodeaktivasi k
		            LEFT JOIN mlm_bonus_cashback c
		            ON c.id_kodeaktivasi = k.id
		            WHERE k.id_member = '$id_member'
                    AND k.jenis_aktivasi = 10
		            AND k.status_aktivasi = '1' 
		            AND k.deleted_at IS NULL 
		            GROUP BY k.id
		            ORDER BY k.id DESC";
	   // echo $sql;
	    $c    = new classConnection();
	    $query  = $c->_query($sql);
	    return $query;
	}

    public function jangka_waktu_bonus_investasi(){
        $sql = "SELECT COALESCE(jangka_waktu, 1) AS jangka_waktu FROM mlm_bonus_investasi_setting
                WHERE deleted_at IS NULL LIMIT 1";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->jangka_waktu;
    }
    public function riwayat_bonus($jenis_bonus, $id, $status_transfer = ''){
        $sql_bonus = $this->_SQL($id);
        $sql = "SELECT COALESCE(SUM(b.nominal), 0) AS total FROM ($sql_bonus) AS b
                WHERE b.type = '$jenis_bonus'
                AND CASE WHEN LENGTH('$status_transfer') > 0 THEN b.status_transfer = '$status_transfer' ELSE 1 END";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }
    
    public function ajax_reward($id_member, $start, $id_plan){
        $sql = "SELECT b.*, pl.nama_plan
                FROM mlm_bonus_reward as b
                LEFT JOIN mlm_bonus_reward_setting as s
                ON b.id_bonus_reward_setting = s.id
                LEFT JOIN mlm_plan as pl
                ON s.id_plan = pl.id
                WHERE s.id_plan = '$id_plan'
                AND b.id_member = '$id_member'
                ORDER BY b.created_at DESC
                LIMIT $start, 10";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function riwayat_bonus_reward($id_plan, $id_member, $status_transfer = ''){
        $sql = "SELECT COALESCE(SUM(b.nominal), 0) AS total 
                FROM mlm_bonus_reward as b
                LEFT JOIN mlm_bonus_reward_setting as s
                ON b.id_bonus_reward_setting = s.id
                LEFT JOIN mlm_plan as pl
                ON s.id_plan = pl.id
                WHERE s.id_plan = '$id_plan'
                AND b.id_member = '$id_member'
                AND CASE WHEN LENGTH('$status_transfer') > 0 THEN b.status_transfer = '$status_transfer' ELSE 1 END";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->total;
    }

    public function total_bonus_pending($id_member, $tgl_hari_ini){
        $sql = $this->_SQL($id_member);
        $sql = "SELECT COALESCE(SUM(bns.nominal), 0) AS total
                FROM ($sql) AS bns
                WHERE bns.status_transfer = '0'
                AND LEFT(bns.created_at, 10) < '$tgl_hari_ini'";
                // echo $sql;
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        if($query){
            return $query->total;
        } else {
            return 0;
        }
    }

    public function slip_bonus($id, $tahun='', $bulan=''){
        $sql = $this->_SQL($id);
        $sql = "SELECT type, COALESCE(SUM(nominal), 0) AS jumlah FROM ($sql) AS bonusTable
                WHERE CASE WHEN LENGTH('$tahun') > 0 THEN YEAR(created_at) = '$tahun' ELSE 1 END
                AND CASE WHEN LENGTH('$bulan') > 0 THEN MONTH(created_at) = '$bulan' ELSE 1 END
                GROUP BY type";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function slip_bonus_netborn($id, $tahun='', $bulan=''){
        $sql = $this->_SQL($id);
        $sql = "SELECT type, COALESCE(SUM(nominal), 0) AS jumlah FROM ($sql) AS bonusTable
                WHERE 
                type IN ('bonus_sponsor_netborn', 'bonus_pasangan_netborn', 'bonus_pasangan_level_netborn', 'bonus_generasi_netborn', 'bonus_titik_netborn', 'bonus_reward_netborn')
                AND CASE WHEN LENGTH('$tahun') > 0 THEN YEAR(created_at) = '$tahun' ELSE 1 END
                AND CASE WHEN LENGTH('$bulan') > 0 THEN MONTH(created_at) = '$bulan' ELSE 1 END
                GROUP BY type";
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }

    public function statistik_bonus(){
        $sql = $this->_SQL_ALL_NEW();
        $sql = "SELECT type, 
                    COALESCE(SUM(CASE WHEN status_transfer = '0' THEN nominal ELSE 0 END), 0) AS pending,
                    COALESCE(SUM(CASE WHEN status_transfer = '1' THEN nominal ELSE 0 END), 0) AS transfer,
                    COALESCE(SUM(CASE WHEN status_transfer = '2' THEN nominal ELSE 0 END), 0) AS reject,
                    COALESCE(SUM(nominal), 0) AS total 
                    FROM ($sql) AS bonusTable
                GROUP BY type
                ORDER BY sort ASC";
                // echo $sql;
        $c    = new classConnection();
        $query  = $c->_query($sql);
        return $query;
    }
    
    public function saldo_wd($id_member){
        $sql  = "SELECT 
                    COALESCE(SUM(CASE 
                        WHEN w.status = 'd'
                        THEN w.nominal
                        ELSE 0 
                    END),0) AS masuk,
                    COALESCE(SUM(CASE 
                        WHEN w.status = 'k'
                        THEN w.nominal
                        ELSE 0 
                    END),0) AS keluar, 
                    COALESCE(SUM(CASE 
                        WHEN w.status = 'd'
                        THEN w.nominal
                        ELSE 0 
                    END) - SUM(CASE 
                        WHEN w.status = 'k'
                        THEN w.nominal
                        ELSE 0 
                    END),0) AS sisa 
                    FROM mlm_saldo_penarikan w
                    WHERE w.id_member = '$id_member' 
                    AND w.jenis_saldo = 'saldo_wd' 
                    AND w.deleted_at is null";
        $c    = new classConnection();
        $query  = $c->_query_fetch($sql);
        return $query->sisa;
    }
}