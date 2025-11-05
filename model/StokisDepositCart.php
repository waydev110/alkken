<?php 
    require_once 'Model.php'; 

    class StokisDepositCart extends Model{
        protected $table = 'mlm_stokis_deposit_cart';
        protected $fillable = [
            'id_stokis',
            'id_stokis_tujuan',
            'id_produk',
            'qty',
            'status',
            'created_at',
            'updated_at',
            'deleted_at'
        ];
        protected $deleted_at = true;

        public function update_status($id_stokis, $id_stokis_tujuan) {
            $sql = "UPDATE mlm_stokis_deposit_cart SET status = 1, updated_at = NOW() WHERE id_stokis = :id_stokis AND id_stokis_tujuan = :id_stokis_tujuan";
            
            return $this->rawExecute($sql, [
                'id_stokis' => $id_stokis, 
                'id_stokis_tujuan' => $id_stokis_tujuan
            ]);
        }

        public function update_keranjang($id_stokis, $id_produk, $qty) {
            $sql = "UPDATE mlm_stokis_deposit_cart 
                    SET qty = qty+:qty, updated_at = NOW() 
                    WHERE id_stokis = :id_stokis AND id_produk = :id_produk";
            
            return $this->rawExecute($sql, [
                'id_stokis' => $id_stokis, 
                'id_produk' => $id_produk, 
                'qty' => $qty
            ]);
        }
        
        public function total_cart($id_stokis, $id_stokis_tujuan = 0){
            $sql  = "SELECT COUNT(*) AS total 
                        FROM mlm_stokis_deposit_cart 
                        WHERE id_stokis = :id_stokis
                        AND id_stokis_tujuan = :id_stokis_tujuan
                        AND status = '0'
                        AND deleted_at IS NULL";

            $query = $this->rawQuery($sql, [
                'id_stokis' => $id_stokis,
                'id_stokis_tujuan' => $id_stokis_tujuan
            ]);

            $result = $query[0] ?? null;
            return $result->total ?? 0;
        }

        public function total_diskon($id_stokis, $id_stokis_tujuan, $persentase_fee) {    
            if ($persentase_fee > 0) {
                $sql  = "SELECT COALESCE(SUM(p.harga * c.qty * :persentase_fee), 0) AS total
                            FROM mlm_stokis_deposit_cart c
                            LEFT JOIN mlm_produk p ON c.id_produk = p.id 
                            WHERE c.id_stokis = :id_stokis
                            AND c.id_stokis_tujuan = :id_stokis_tujuan
                            AND c.status = 0
                            AND c.deleted_at IS NULL";
    
                $query = $this->rawQuery($sql, [
                    'id_stokis' => $id_stokis,
                    'id_stokis_tujuan' => $id_stokis_tujuan,
                    'persentase_fee' => $persentase_fee
                ]);

                $result = $query[0] ?? null;
                return $result->total ?? 0;
            }
    
            return 0;
        }
        
        public function total_order($id_stokis, $id_stokis_tujuan){
            $sql  = "SELECT COALESCE(SUM(p.harga*c.qty),0) AS total
                        FROM mlm_stokis_deposit_cart c
                        LEFT JOIN mlm_produk p ON c.id_produk = p.id
                        
                        WHERE c.id_stokis = '$id_stokis'
                        AND c.id_stokis_tujuan = '$id_stokis_tujuan'
                        AND c.status = '0'
                        AND c.deleted_at IS NULL";
            $query = $this->rawQuery($sql, [
                'id_stokis' => $id_stokis,
                'id_stokis_tujuan' => $id_stokis_tujuan
            ]);

            $result = $query[0] ?? null;
            return $result->total ?? 0;
        }

        public function cek_keranjang($id_stokis, $id_stokis_tujuan, $id_produk){
            $sql  = "SELECT COUNT(*) AS total 
                        FROM mlm_stokis_deposit_cart 
                        WHERE id_stokis = :id_stokis
                        AND id_stokis_tujuan = :id_stokis_tujuan
                        AND id_produk = :id_produk
                        AND status = '0'
                        AND deleted_at IS NULL";
            $query = $this->rawQuery($sql, [
                'id_stokis' => $id_stokis,
                'id_stokis_tujuan' => $id_stokis_tujuan,
                'id_produk' => $id_produk
            ]);
            $result = $query[0] ?? null;
            return $result->total ?? 0;
        }
        public function get_cart($id_stokis, $id_stokis_tujuan){
            $sql  = "SELECT c.*, 
                        p.gambar, 
                        p.nama_produk, 
                        p.harga, 
                        p.fee_stokis, 
                        p.qty as qty_produk, 
                        p.satuan, 
                        j.name
                        FROM mlm_stokis_deposit_cart c
                        LEFT JOIN mlm_produk p ON c.id_produk = p.id  
                        LEFT JOIN mlm_produk_jenis j ON p.id_produk_jenis = j.id  
                        WHERE c.id_stokis = :id_stokis
                        AND c.id_stokis_tujuan = :id_stokis_tujuan
                        AND c.status = '0'
                        AND c.deleted_at IS NULL
                        ORDER BY c.id ASC";
            $query = $this->rawQuery($sql, [
                'id_stokis' => $id_stokis,
                'id_stokis_tujuan' => $id_stokis_tujuan
            ]);
            return $query;
        }
        public function delete_cart($id_stokis, $id_stokis_tujuan){
            $sql  = "DELETE FROM mlm_stokis_deposit_cart 
                        WHERE id_stokis = :id_stokis
                        AND id_stokis_tujuan = :id_stokis_tujuan
                        AND status = '0'
                        AND deleted_at IS NULL";
            $query = $this->rawExecute($sql, [
                'id_stokis' => $id_stokis,
                'id_stokis_tujuan' => $id_stokis_tujuan
            ]);
            return $query;
        }
    }