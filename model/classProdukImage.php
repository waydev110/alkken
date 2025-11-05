<?php
require_once("classConnection.php");
class classProdukImage
{

    protected $attributes = [];

    // Magic method untuk mengakses properti
    public function __get($property)
    {
        if (array_key_exists($property, $this->attributes)) {
            return $this->attributes[$property];
        }
        return null;
    }

    // Magic method untuk mengatur properti
    public function __set($property, $value)
    {
        $this->attributes[$property] = $value;
    }

    public function index($id_produk)
    {
        $sql  = "SELECT pi.*
                        FROM mlm_produk_image pi
                        WHERE pi.deleted_at IS NULL 
                        AND pi.id_produk = '$id_produk'
                        ORDER BY pi.sorting ASC";
        $c    = new classConnection();
        $query     = $c->_query($sql);
        return $query;
    }

    public function update($id)
    {
        $updates = [];

        foreach ($this->attributes as $column => $value) {
            $updates[] = "$column = '" . $value . "'";
        }

        $updates_str = implode(", ", $updates);

        $sql = "UPDATE mlm_produk_image SET $updates_str WHERE id = '" . addslashes($id) . "'";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM mlm_produk_image WHERE id = '" . addslashes($id) . "'";
        $c = new classConnection();
        $query = $c->_query($sql);
        return $query;
    }

    public function is_primary($id_produk)
    {
        $sql = "SELECT gambar FROM mlm_produk_image WHERE id_produk = '$id_produk' AND is_primary = 1 AND deleted_at IS NULL";
        $c = new classConnection();
        $query = $c->_query_fetch($sql);
        if($query){
            return $query->gambar;
        }
        return '';
    }
}
