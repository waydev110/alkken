<?php

require_once 'Database.php';  // Memastikan Database.php selalu dimuat

class Model {
    protected $table;
    protected $attributes = [];
    protected $fillable = [];
    protected $conn;
    protected $where = [];
    protected $joins = [];
    protected $select = '*'; // Default untuk memilih semua kolom
    protected $deleted_at = false; // Default untuk tidak menerapkan whereNull
    protected $data = [];

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Method untuk mengatur kolom yang akan dimasukkan
    public function data(array $data) {
        $this->data = $data;
        return $this;
    }

    // Magic method untuk mengakses properti
    public function __get($property) {
        if (array_key_exists($property, $this->attributes)) {
            return $this->attributes[$property];
        }
        return null;
    }

    // Magic method untuk mengatur properti
    public function __set($property, $value) {
        $this->attributes[$property] = $value;
    }

    public function store(array $data) {
        try {
            foreach ($data as $key => $value) {
                if (in_array($key, $this->fillable)) {
                    $this->attributes[$key] = $value;
                }
            }
    
            $columns = implode(", ", array_keys($this->attributes));
            $placeholders = ":" . implode(", :", array_keys($this->attributes));
    
            $sql = "INSERT INTO $this->table ($columns) VALUES ($placeholders)";
            $stmt = $this->conn->prepare($sql);
    
            foreach ($this->attributes as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
    
            $result = $stmt->execute();
    
            if ($result) {
                $id = $this->conn->lastInsertId();
                $this->attributes['id'] = $id;
                return true;
            } else {
                // echo json_encode($stmt->errorInfo());
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage(); // Debugging: tampilkan pesan error
            return false;
        }
    }
     

    // Method untuk menyimpan data dengan SELECT
    public function storeAll() {
        $columns = implode(", ", array_keys($this->data));
        $placeholders = implode(", ", array_map(function($col) {
            return "$col";
        }, $this->data));

        $select = implode(", ", array_map(function($col) {
            return "$col";
        }, $this->data));

        $joins = implode(" ", $this->joins);

        $conditions = implode(" AND ", $this->where);
        if ($conditions) {
            $conditions = "WHERE " . $conditions;
        }

        $sql = "
            INSERT INTO {$this->table} ($columns)
            SELECT 
                $select
            FROM mlm_stokis_deposit_cart
            $joins
            $conditions
        ";

        $stmt = $this->conn->prepare($sql);

        // Bind parameters
        foreach ($this->data as $key => $value) {
            if (is_string($value) && strpos($value, ':') !== false) {
                $stmt->bindValue(":$key", $value);
            }
        }

        // Execute the query
        return $stmt->execute();
    }

    // Menemukan data berdasarkan ID
    public static function find($id)
    {
        $instance = new static();
        $table = $instance->table;
        $sql = "SELECT * FROM $table WHERE id = :id";
    
        // Tambahkan whereNull untuk deleted_at jika diaktifkan
        if ($instance->deleted_at) {
            $sql .= " AND deleted_at IS NULL";
        }
    
        $stmt = $instance->conn->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        if ($result) {
            // Set attributes of the instance to the fetched result
            foreach ($result as $key => $value) {
                $instance->$key = $value;
            }
            return $instance;
        }
        return null;
    }

    // Menambahkan kondisi WHERE
    public function where($column, $operator = '=', $value = null) {
        $this->where[] = [$column, $operator, $value];
        return $this;
    }

    // Menambahkan kondisi WHERE IN
    public function whereIn($column, array $values) {
        $placeholders = implode(", ", array_fill(0, count($values), '?'));
        $sql = "SELECT $this->select FROM $this->table WHERE $column IN ($placeholders)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($values);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Menambahkan kondisi WHERE NULL
    public function whereNull($column) {
        $this->where[] = [$column, 'IS NULL'];
        return $this;
    }

    // Menjalankan query berdasarkan kondisi
    public function get() {
        $joinSql = '';
        if (!empty($this->joins)) {
            $joinSql = implode(' ', $this->joins);
        }

        $whereSql = '';
        if (!empty($this->where)) {
            $whereSql = 'WHERE ';
            $whereClauses = [];
            foreach ($this->where as $condition) {
                if ($condition[1] == 'IS NULL') {
                    $whereClauses[] = "{$condition[0]} IS NULL";
                } else {
                    $whereClauses[] = "{$condition[0]} {$condition[1]} :{$condition[0]}";
                }
            }
            $whereSql .= implode(' AND ', $whereClauses);
        }

        // Tambahkan whereNull untuk deleted_at jika diaktifkan
        if ($this->deleted_at) {
            $whereSql .= !empty($whereSql) ? ' AND deleted_at IS NULL' : 'WHERE deleted_at IS NULL';
        }

        $sql = "SELECT $this->select FROM $this->table $joinSql $whereSql";
        $stmt = $this->conn->prepare($sql);

        foreach ($this->where as $condition) {
            if ($condition[1] != 'IS NULL') {
                $stmt->bindValue(":{$condition[0]}", $condition[2]);
            }
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Menambahkan JOIN
    public function join($table, $first, $operator, $second) {
        $this->joins[] = "JOIN $table ON $first $operator $second";
        return $this;
    }

    // Menambahkan LEFT JOIN
    public function leftJoin($table, $first, $operator, $second) {
        $this->joins[] = "LEFT JOIN $table ON $first $operator $second";
        return $this;
    }

    // Menjalankan query dengan JOIN
    public function getWithJoins() {
        $joinSql = '';
        if (!empty($this->joins)) {
            $joinSql = implode(' ', $this->joins);
        }

        $whereSql = '';
        if (!empty($this->where)) {
            $whereSql = 'WHERE ';
            $whereClauses = [];
            foreach ($this->where as $condition) {
                if ($condition[1] == 'IS NULL') {
                    $whereClauses[] = "{$condition[0]} IS NULL";
                } else {
                    $whereClauses[] = "{$condition[0]} {$condition[1]} :{$condition[0]}";
                }
            }
            $whereSql .= implode(' AND ', $whereClauses);
        }

        // Tambahkan whereNull untuk deleted_at jika diaktifkan
        if ($this->deleted_at) {
            $whereSql .= !empty($whereSql) ? ' AND deleted_at IS NULL' : 'WHERE deleted_at IS NULL';
        }

        $sql = "SELECT $this->select FROM $this->table $joinSql $whereSql";
        $stmt = $this->conn->prepare($sql);

        foreach ($this->where as $condition) {
            if ($condition[1] != 'IS NULL') {
                $stmt->bindValue(":{$condition[0]}", $condition[2]);
            }
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Menghapus data berdasarkan ID
    public function delete() {
        if (isset($this->attributes['id'])) {
            $id = $this->attributes['id'];
            $sql = "DELETE FROM $this->table WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id);

            return $stmt->execute();
        }
        return false;
    }

    // Method untuk pembaruan data dengan kondisi
    public function update(array $data) {
        $columns = array_keys($data);
        $set = implode(", ", array_map(function($col) {
            return "$col = :$col";
        }, $columns));

        $sql = "UPDATE $this->table SET $set WHERE id = :id";

        // Tambahkan kondisi untuk where
        if (!empty($this->where)) {
            $whereSql = 'AND ' . implode(' AND ', array_map(function($condition) {
                return "{$condition[0]} {$condition[1]} :{$condition[0]}";
            }, $this->where));
            $sql .= ' ' . $whereSql;
        }

        // Tambahkan whereNull untuk deleted_at jika diaktifkan
        if ($this->deleted_at) {
            $sql .= !empty($this->where) ? ' AND deleted_at IS NULL' : 'WHERE deleted_at IS NULL';
        }

        $stmt = $this->conn->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindValue(':id', $this->attributes['id']);

        return $stmt->execute();
    }


    // Method untuk eksekusi raw SQL
    public function rawQuery($sql, $bindings = []) {
        // Prepare SQL query
        $stmt = $this->conn->prepare($sql);
        
        // Bind parameters if provided
        foreach ($bindings as $key => $value) {
            $stmt->bindValue(is_int($key) ? $key + 1 : ":$key", $value);
        }

        // Execute the query
        $stmt->execute();
        
        // Return the result as associative array
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    // Method untuk eksekusi raw SQL tanpa pengambilan data (insert/update/delete)
    public function rawExecute($sql, $bindings = []) {
        // Prepare SQL query
        $stmt = $this->conn->prepare($sql);
        
        // Bind parameters if provided
        foreach ($bindings as $key => $value) {
            $stmt->bindValue(is_int($key) ? $key + 1 : ":$key", $value);
        }

        // Execute the query
        return $stmt->execute();
    }
}
