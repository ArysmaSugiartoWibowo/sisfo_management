<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Laporan_model extends CI_Model {
    public function save( $data ) {
        return $this->db->insert( 'tb_laporan', $data );
    }

    public function get_all()
    {
        // Melakukan join dengan tabel tb_magang berdasarkan id_user
        $this->db->select('tb_laporan.*, tb_magang.nama'); // Ambil semua kolom dari tb_laporan dan nama dari tb_magang
        $this->db->from('tb_laporan');
        $this->db->join('tb_magang', 'tb_magang.id_user = tb_laporan.id_user'); // Join berdasarkan id_user
        return $this->db->get()->result(); // Mengambil hasil query dan mengembalikannya
    }

    public function get_all_by_pending()
{
    // Melakukan join dengan tabel tb_magang berdasarkan id_user
    $this->db->select('tb_laporan.*, tb_magang.nama'); // Ambil semua kolom dari tb_laporan dan nama dari tb_magang
    $this->db->from('tb_laporan');
    $this->db->join('tb_magang', 'tb_magang.id_user = tb_laporan.id_user'); // Join berdasarkan id_user
    
    // Menambahkan kondisi WHERE untuk status = 'pending'
    $this->db->where('tb_laporan.status !=', 'disetujui'); // Menambahkan filter status = 'pending'

    return $this->db->get()->result(); // Mengambil hasil query dan mengembalikannya
}

public function get_all_by_pending_pendamping()
{
    // Mengambil data asal sekolah dan jurusan dari session
    $asal_sekolah = $this->session->session_login['asal_sekolah'];
    $jurusan = $this->session->session_login['jurusan'];

    // Melakukan join dengan tabel tb_magang berdasarkan id_user
    $this->db->select('tb_laporan.*, tb_magang.nama'); // Ambil semua kolom dari tb_laporan dan nama dari tb_magang
    $this->db->from('tb_laporan');
    $this->db->join('tb_magang', 'tb_magang.id_user = tb_laporan.id_user'); // Join berdasarkan id_user
    
    // Menambahkan kondisi WHERE untuk status = 'acc kominfo' dan memfilter berdasarkan asal sekolah dan jurusan
    $this->db->where('tb_laporan.status', 'acc kominfo'); // Filter status
    $this->db->where('tb_magang.institute', $asal_sekolah); // Filter berdasarkan institute (asal_sekolah)
    $this->db->where('tb_magang.ps', $jurusan); // Filter berdasarkan ps (jurusan)

    return $this->db->get()->result(); // Mengambil hasil query dan mengembalikannya
}


public function get_all_by_setuju()
{
    // Melakukan join dengan tabel tb_magang berdasarkan id_user
    $this->db->select('tb_laporan.*, tb_magang.nama'); // Ambil semua kolom dari tb_laporan dan nama dari tb_magang
    $this->db->from('tb_laporan');
    $this->db->join('tb_magang', 'tb_magang.id_user = tb_laporan.id_user'); // Join berdasarkan id_user
    
    // Menambahkan kondisi WHERE untuk status = 'pending'
    $this->db->where('tb_laporan.status', 'disetujui'); // Menambahkan filter status = 'pending'

    return $this->db->get()->result(); // Mengambil hasil query dan mengembalikannya
}

public function get_all_by_setuju_pendamping()
{
    // Mengambil data asal sekolah dan jurusan dari session
    $asal_sekolah = $this->session->session_login['asal_sekolah'];
    $jurusan = $this->session->session_login['jurusan'];

    // Melakukan join dengan tabel tb_magang berdasarkan id_user
    $this->db->select('tb_laporan.*, tb_magang.nama'); // Ambil semua kolom dari tb_laporan dan nama dari tb_magang
    $this->db->from('tb_laporan');
    $this->db->join('tb_magang', 'tb_magang.id_user = tb_laporan.id_user'); // Join berdasarkan id_user
    
    // Menambahkan kondisi WHERE untuk status = 'disetujui' dan memfilter berdasarkan asal sekolah dan jurusan
    $this->db->where('tb_laporan.status', 'disetujui'); // Filter status
    $this->db->where('tb_magang.institute', $asal_sekolah); // Filter berdasarkan institute (asal_sekolah)
    $this->db->where('tb_magang.ps', $jurusan); // Filter berdasarkan ps (jurusan)

    return $this->db->get()->result(); // Mengambil hasil query dan mengembalikannya
}


    

    public function check_user_report( $id_user ) {
        $this->db->where( 'id_user', $id_user );
        $query = $this->db->get( 'tb_laporan' );
        return $query->num_rows() > 0;
        // Jika ada data, kembalikan true
    }

    public function get_laporan_by_user($id_user) {
        // Pastikan parameter id_user adalah angka
        if (!is_numeric($id_user)) {
            return false;
        }
    
        // Query untuk mendapatkan data barang berdasarkan id_user dengan join ke tb_magang
        $this->db->select('tb_laporan.*, tb_magang.nama');  // Pilih semua data dari tb_laporan dan kolom nama dari tb_magang
        $this->db->from('tb_laporan');
        $this->db->join('tb_magang', 'tb_laporan.id_user = tb_magang.id_user', 'left');  // Join dengan tb_magang berdasarkan id_user
    
        // Tambahkan filter berdasarkan id_user
        $this->db->where('tb_laporan.id_user', $id_user);
    
        // Eksekusi query
        $query = $this->db->get();
    
        // Periksa apakah data ditemukan
        if ($query->num_rows() > 0) {
            return $query->result_array();  // Mengembalikan hasil sebagai array
        } else {
            return false;  // Jika tidak ada data
        }
    }

    public function delete_laporan( $id ) {
        $this->db->where( 'id_laporan', $id );
        return $this->db->delete( 'tb_laporan' );
    }
    
    

}
