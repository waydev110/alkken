<?php 
/**
* 
*/
require_once 'classConnection.php';

class classHome{

    private function _SQL_ALL() {
        $sql = "SELECT 
                    id,
                    id_member,
                    'bonus_sponsor' AS type,
                    nominal,
                    status_transfer,
                    created_at,
                    updated_at,
                    keterangan,
                    'plan_a' AS group_bonus
                FROM mlm_bonus_sponsor
                WHERE nominal > 0

                UNION

                SELECT 
                    id,
                    id_member,
                    'bonus_pasangan' AS type,
                    nominal,
                    status_transfer,
                    created_at,
                    updated_at,
                    keterangan,
                    'plan_a' AS group_bonus
                FROM mlm_bonus_pasangan
                WHERE id_plan = 4
                AND nominal > 0

                UNION

                SELECT 
                    id,
                    id_member,
                    'bonus_pasangan_plan_b' AS type,
                    nominal,
                    status_transfer,
                    created_at,
                    updated_at,
                    keterangan,
                    'plan_b' AS group_bonus
                FROM mlm_bonus_pasangan
                WHERE id_plan = 8
                AND nominal > 0

                UNION

                SELECT 
                    id,
                    id_member,
                    'bonus_generasi' AS type,
                    nominal,
                    status_transfer,
                    created_at,
                    updated_at,
                    keterangan,
                    'plan_c' AS group_bonus
                FROM mlm_bonus_generasi
                WHERE nominal > 0

                UNION

                SELECT 
                    id,
                    id_member,
                    'bonus_founder' AS type,
                    nominal,
                    status_transfer,
                    created_at,
                    updated_at,
                    keterangan,
                    'plan_c' AS group_bonus
                FROM mlm_bonus_founder
                WHERE nominal > 0

                UNION

                SELECT 
                    id,
                    id_member,
                    'bonus_cashback' AS type,
                    nominal,
                    status_transfer,
                    created_at,
                    updated_at,
                    keterangan,
                    'plan_b' AS group_bonus
                FROM mlm_bonus_cashback
                WHERE nominal > 0

                UNION

                SELECT 
                    r.id,
                    r.id_member,
                    'bonus_reward' AS type,
                    r.nominal,
                    r.status_transfer,
                    r.created_at,
                    r.updated_at,
                    r.keterangan,
                    'plan_a' AS group_bonus
                FROM mlm_bonus_reward r
                LEFT JOIN mlm_bonus_reward_setting s
                ON r.id_bonus_reward_setting = s.id
                WHERE s.id_plan = 11
                AND r.nominal > 0

                UNION

                SELECT 
                    r.id,
                    r.id_member,
                    'bonus_reward_plan_b' AS type,
                    r.nominal,
                    r.status_transfer,
                    r.created_at,
                    r.updated_at,
                    r.keterangan,
                    'plan_a' AS group_bonus
                FROM mlm_bonus_reward r
                LEFT JOIN mlm_bonus_reward_setting s
                ON r.id_bonus_reward_setting = s.id
                WHERE s.id_plan = 8
                AND r.nominal > 0

                UNION

                SELECT 
                    r.id,
                    r.id_member,
                    'bonus_reward_fasttrack' AS type,
                    r.nominal,
                    r.status_transfer,
                    r.created_at,
                    r.updated_at,
                    r.keterangan,
                    'fasttrack' AS group_bonus
                FROM mlm_bonus_reward r
                LEFT JOIN mlm_bonus_reward_setting s
                ON r.id_bonus_reward_setting = s.id
                WHERE s.id_plan = 9
                AND r.nominal > 0

                UNION

                SELECT 
                    r.id,
                    r.id_member,
                    'bonus_reward_promo_sponsor' AS type,
                    r.nominal,
                    r.status_transfer,
                    r.created_at,
                    r.updated_at,
                    r.keterangan,
                    'plan_a' AS group_bonus
                FROM mlm_bonus_reward r
                LEFT JOIN mlm_bonus_reward_setting s
                ON r.id_bonus_reward_setting = s.id
                WHERE s.id_plan = 12
                AND r.nominal > 0

                UNION

                SELECT 
                    r.id,
                    r.id_member,
                    'bonus_reward_promo_poin_sponsor' AS type,
                    r.nominal,
                    r.status_transfer,
                    r.created_at,
                    r.updated_at,
                    r.keterangan,
                    'plan_a' AS group_bonus
                FROM mlm_bonus_reward r
                LEFT JOIN mlm_bonus_reward_setting s
                ON r.id_bonus_reward_setting = s.id
                WHERE s.id_plan = 13
                AND r.nominal > 0

                    ORDER BY (
                        CASE 
                            WHEN status_transfer = '1' THEN
                                updated_at
                            ELSE
                                created_at
                        END) DESC
                        ";
        return $sql;

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

	public function get_total_member_today(){
		$sql 	= "SELECT count(*) as total FROM mlm_member WHERE left(created_at,10)='".date('Y-m-d', time())."'";
		$c 		= new classConnection();
		$query 	= $c->_query_fetch($sql);
		if($query){
			return $query->total;
		}
        return 0;
	}

	public function get_total_member(){
		$sql 	= "SELECT count(*) as total FROM mlm_member";
		$c 		= new classConnection();
		$query 	= $c->_query_fetch($sql);
		if($query){
			return $query->total;
		}
        return 0;
	}

	public function get_total_pin($status){
		$sql 	= "SELECT count(*) as total_pin FROM mlm_kodeaktivasi where jenis_aktivasi = '0' and status_aktivasi='$status'";
		$c 		= new classConnection();
		$query 	= $c->_query_fetch($sql);
		if($query){
			return $query->total_pin;
		}else{
			return false;
		}
	}

	public function get_total_deposit(){
		$sql 	= "SELECT sum(nominal) as total FROM mlm_stokis_deposit where deleted_at is null";
		$c 		= new classConnection();
		$query 	= $c->_query_fetch($sql);
		if($query){
			return $query->total;
		}
        return 0;
	}

	public function get_total_transfer_deposit(){
		$sql 	= "SELECT sum(nominal) as total_transfer FROM mlm_stokis_transfer where deleted_at is null";
		$c 		= new classConnection();
		$query 	= $c->_query_fetch($sql);
		if($query){
			return $query->total_transfer;
		}else{
			return false;
		}
	}


	public function get_total_transaksi(){
		$sql 	= "SELECT sum(kredit) as total_transaksi FROM mlm_stokis_wallet where deleted_at is null";
		$c 		= new classConnection();
		$query 	= $c->_query_fetch($sql);
		if($query){
			return $query->total_transaksi;
		}else{
			return false;
		}
	}

	public function get_total_stokis(){
		$sql 	= "SELECT count(*) as total FROM mlm_stokis_member where deleted_at is null";
		$c 		= new classConnection();
		$query 	= $c->_query_fetch($sql);
		if($query){
			return $query->total;
		}
        return 0;
	}

	public function get_saldo($status = ''){
		$sql 	= "SELECT COALESCE(SUM(CASE WHEN status = 'd'
                                THEN nominal
                                ELSE 0 
                                END), 0) AS debet,
                            COALESCE(SUM(CASE WHEN status = 'k'
                                THEN nominal
                                ELSE 0 
                                END), 0) AS kredit
                        FROM mlm_stokis_wallet 
                        WHERE deleted_at is null";
		$c 		= new classConnection();
		$query 	= $c->_query_fetch($sql);
		if($query){
            switch ($status) {
                case 'debet':
                    return $query->debet;
                    break;
                case 'kredit':
                    return $query->kredit;
                    break;
                
                default:
                    return $query->debet-$query->kredit;
                    break;
            }
		}
        return 0;
	}

	public function get_deposit_stokis($jenis_saldo){
		$sql 	= "SELECT COALESCE(SUM($jenis_saldo), 0) AS total
                        FROM mlm_stokis_deposit
                        WHERE status = '1' 
                        AND deleted_at is null";
		$c 		= new classConnection();
		$query 	= $c->_query_fetch($sql);
		if($query){
            return $query->total;
		}
        return 0;
	}
	
	public function get_total_pin_ro($status){
		$sql 	= "SELECT count(*) as total FROM mlm_kodeaktivasi where jenis_aktivasi = '1' AND status_aktivasi='$status'";
		$c 		= new classConnection();
		$query 	= $c->_query_fetch($sql);
		if($query){
			return $query->total;
		}
        return 0;
	}
}