CREATE DATABASE IF NOT EXISTS toko_merch_band;
USE toko_merch_band;

CREATE TABLE IF NOT EXISTS products (
  id     INT AUTO_INCREMENT PRIMARY KEY,
  nama   VARCHAR(100) NOT NULL,
  band   VARCHAR(50)  NOT NULL,
  ukuran VARCHAR(10)  NOT NULL,
  harga  INT NOT NULL,
  stok   INT NOT NULL
);

INSERT INTO products (nama, band, ukuran, harga, stok) VALUES
('Kaos Tipu Daya',             'The Panturas',    'L',  230000, 5),
('Kaos Gurita Kota',           'The Panturas',    'XL', 221000, 7),
('Kaos Album Kamar Gelap',     'Efek Rumah Kaca', 'M',  150000, 3),
('Kaos Cinta Melulu',          'Efek Rumah Kaca', 'L',  158000, 6),
('Kaos Pop',                   'Alkateri',       'L',  209000, 6),
('Kaos Dimana Merdeka',        'Kelompok Penerbang Roket','XL', 145000, 8),
('Kaos Apa Yang tak Bisa',     'Rumah Sakit',        'XXL',198000, 9);
