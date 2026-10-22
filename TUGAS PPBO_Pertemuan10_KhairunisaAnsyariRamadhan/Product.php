<?php

require_once 'DatabaseConnection.php';

class Product
{
    public $nama;
    public $band;
    public $ukuran;
    public $harga;
    public $stok;

    public function __construct($nama, $band, $ukuran, $harga, $stok)
    {
        $this->nama   = $nama;
        $this->band   = $band;
        $this->ukuran = $ukuran;
        $this->harga  = $harga;
        $this->stok   = $stok;
    }

    // CREATE - tambah data
    public function save()
    {
        $db   = DatabaseConnection::getConnection();
        $stmt = $db->prepare(
            "INSERT INTO products (nama, band, ukuran, harga, stok)
             VALUES (?, ?, ?, ?, ?)"
        );
        return $stmt->execute([$this->nama, $this->band, $this->ukuran, $this->harga, $this->stok]);
    }

    // READ - lihat semua
    public static function findAll()
    {
        $db   = DatabaseConnection::getConnection();
        $stmt = $db->query("SELECT * FROM products ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ - lihat satu
    public static function findById($id)
    {
        $db   = DatabaseConnection::getConnection();
        $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE - update data
    public function update($id)
    {
        $db   = DatabaseConnection::getConnection();
        $stmt = $db->prepare(
            "UPDATE products
             SET nama = ?, band = ?, ukuran = ?, harga = ?, stok = ?
             WHERE id = ?"
        );
        return $stmt->execute([$this->nama, $this->band, $this->ukuran, $this->harga, $this->stok, $id]);
    }

    // DELETE - hapus data
    public static function delete($id)
    {
        $db   = DatabaseConnection::getConnection();
        $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }
}