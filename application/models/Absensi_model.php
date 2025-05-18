<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Absensi_model extends CI_Model {

    public function insert_absen_masuk( $data ) {
        return $this->db->insert( 'tb_absensi', $data );
    }

    public function update_absen_pulang( $id_peserta, $tanggal, $jam_keluar ) {
        $this->db->set( 'jam_keluar', $jam_keluar );
        $this->db->where( 'id_peserta', $id_peserta );
        $this->db->where( 'tanggal', $tanggal );
        $this->db->update( 'tb_absensi' );
    }

    // Mendapatkan data peserta magang yang diterima

    public function getAcceptedMagang()
 {
        $this->db->select( 'tb_magang.*, tb_bidang.nama_bidang' );
        // Menambahkan nama_bidang dari tb_bidang
        $this->db->from( 'tb_magang' );
        $this->db->join( 'tb_bidang', 'tb_magang.bidang = tb_bidang.id_bidang', 'left' );
        // Melakukan join dengan tb_bidang berdasarkan id_bidang
        $this->db->where( 'tb_magang.status', 'aktif' );
        return $this->db->get()->result_array();
    }

    public function getAcceptedMagangSelesai()
 {
        $this->db->select( 'tb_magang.*, tb_bidang.nama_bidang' );
        // Menambahkan nama_bidang dari tb_bidang
        $this->db->from( 'tb_magang' );
        $this->db->join( 'tb_bidang', 'tb_magang.bidang = tb_bidang.id_bidang', 'left' );
        // Melakukan join dengan tb_bidang berdasarkan id_bidang
        $this->db->where( 'tb_magang.status', 'selesai' );
        return $this->db->get()->result_array();
    }

    // Mendapatkan data absensi berdasarkan id_peserta

    public function getAbsensiByPeserta( $id_pm )
 {
        $this->db->select( 'tanggal, jam_masuk, status_masuk, jam_keluar, keterangan' );
        $this->db->from( 'tb_absensi' );
        $this->db->where( 'id_peserta', $id_pm );
        return $this->db->get()->result_array();
    }



    public function getAcceptedMagangPendamping()
{
    // Mengambil data asal sekolah dan jurusan dari session
    $asal_sekolah = $this->session->session_login['asal_sekolah'];
    $jurusan = $this->session->session_login['jurusan'];

    $this->db->select('tb_magang.*, tb_bidang.nama_bidang');
    // Menambahkan nama_bidang dari tb_bidang
    $this->db->from('tb_magang');
    $this->db->join('tb_bidang', 'tb_magang.bidang = tb_bidang.id_bidang', 'left');
    // Melakukan join dengan tb_bidang berdasarkan id_bidang
    $this->db->where('tb_magang.status', 'aktif');
    // Menambahkan filter berdasarkan asal_sekolah dan jurusan
    $this->db->where('tb_magang.institute', $asal_sekolah); // Filter berdasarkan institute (asal_sekolah)
    $this->db->where('tb_magang.ps', $jurusan); // Filter berdasarkan ps (jurusan)

    return $this->db->get()->result_array();
}

public function getAcceptedMagangSelesaiPendamping()
{
    // Mengambil data asal sekolah dan jurusan dari session
    $asal_sekolah = $this->session->session_login['asal_sekolah'];
    $jurusan = $this->session->session_login['jurusan'];

    $this->db->select('tb_magang.*, tb_bidang.nama_bidang');
    // Menambahkan nama_bidang dari tb_bidang
    $this->db->from('tb_magang');
    $this->db->join('tb_bidang', 'tb_magang.bidang = tb_bidang.id_bidang', 'left');
    // Melakukan join dengan tb_bidang berdasarkan id_bidang
    $this->db->where('tb_magang.status', 'selesai');
    // Menambahkan filter berdasarkan asal_sekolah dan jurusan
    $this->db->where('tb_magang.institute', $asal_sekolah); // Filter berdasarkan institute (asal_sekolah)
    $this->db->where('tb_magang.ps', $jurusan); // Filter berdasarkan ps (jurusan)

    return $this->db->get()->result_array();
}

}
