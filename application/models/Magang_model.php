<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Magang_model extends CI_Model {

    public function get_all_magang() {
        return $this->db->get( 'tb_magang' )->result();
    }

    public function get_all_magang_proses() {
        return $this->db->where( 'status', 'proses' ) // Menambahkan kondisi untuk status 'proses'
        ->get( 'tb_magang' )
        ->result();
    }

    public function insert_magang( $data ) {
        return $this->db->insert( 'tb_magang', $data );
    }

    public function get_magang_by_id( $id ) {
        return $this->db->get_where( 'tb_magang', [ 'id_pm' => $id ] )->row();
    }

    public function update_magang( $id, $data ) {
        $this->db->where( 'id', $id );
        return $this->db->update( 'tb_magang', $data );
    }

    public function delete_magang( $id ) {
        $this->db->where( 'id_pm', $id );
        return $this->db->delete( 'tb_magang' );
    }

    public function get_magang_by_user( $id_user ) {
        // Pastikan parameter id_user adalah angka
        if ( !is_numeric( $id_user ) ) {
            return false;
        }

        // Query untuk mendapatkan data barang berdasarkan id_user
        $this->db->where( 'id_user', $id_user );
        $query = $this->db->get( 'tb_magang' );

        // Periksa apakah data ditemukan
        if ( $query->num_rows() > 0 ) {
            return $query->result_array();
            // Mengembalikan data sebagai array
        } else {
            return false;
            // Jika tidak ada data
        }
    }

    public function get_magang_by_user_aktif ( $id_user ) {
        // Pastikan parameter id_user adalah angka
        if ( !is_numeric( $id_user ) ) {
            return false;
        }

        // Query untuk mendapatkan data barang berdasarkan id_user dan status aktif
        $this->db->where( 'id_user', $id_user );
        $this->db->where( 'status', 'aktif' );
        // Tambahkan persyaratan status = 'aktif'
        $query = $this->db->get( 'tb_magang' );

        // Periksa apakah data ditemukan
        if ( $query->num_rows() > 0 ) {
            return $query->result_array();
            // Mengembalikan data sebagai array
        } else {
            return false;
            // Jika tidak ada data
        }
    }

    public function get_magang_by_user_aktiff($id_user) {
        // Pastikan parameter id_user adalah angka
        if (!is_numeric($id_user)) {
            return false;
        }
    
        // Query untuk mendapatkan data magang dengan join ke tb_bidang
        $this->db->select('tb_magang.*, tb_bidang.nama_bidang'); // Pilih semua dari tb_magang dan nama_bidang dari tb_bidang
        $this->db->from('tb_magang'); // Tabel utama
        $this->db->join('tb_bidang', 'tb_magang.bidang = tb_bidang.id_bidang', 'left'); // Join dengan tb_bidang
        $this->db->where('tb_magang.id_user', $id_user);
        $this->db->where_in('tb_magang.status', ['aktif', 'selesai']); // Filter status
        
        $query = $this->db->get(); // Eksekusi query
    
        // Periksa apakah data ditemukan
        if ($query->num_rows() > 0) {
            return $query->row_array(); // Mengembalikan data baris pertama sebagai array
        } else {
            return false; // Jika tidak ada data
        }
    }
    
    
    

}
