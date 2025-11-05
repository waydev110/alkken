<?php
require_once 'Model.php';

class Member extends Model
{
    protected $table = 'mlm_member';

    public function detail($id)
    {
        // Pastikan $id adalah integer atau valid
        $id = intval($id);

        // Menyusun query SQL
        $sql = "SELECT m.*, 
                       p.nama_provinsi, 
                       k.nama_kota, 
                       c.nama_kecamatan, 
                       l.nama_kelurahan, 
                       b.nama_bank 
                FROM mlm_member m
                LEFT JOIN mlm_bank b ON m.id_bank = b.id
                LEFT JOIN mlm_provinsi p ON m.id_provinsi = p.id
                LEFT JOIN mlm_kota k ON m.id_kota = k.id
                LEFT JOIN mlm_kecamatan c ON m.id_kecamatan = c.id
                LEFT JOIN mlm_kelurahan l ON m.id_kelurahan = l.id
                WHERE m.id = :id AND m.deleted_at IS NULL";

        $result = $this->rawQuery($sql, [
            'id' => $id
        ]);

        $result = $query[0] ?? null;
        return $result;
    }
}
?>
