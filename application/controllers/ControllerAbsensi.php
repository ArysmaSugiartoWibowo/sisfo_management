<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class ControllerAbsensi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model( 'Absensi_model' );
        $this->load->model( 'Magang_model' );
        date_default_timezone_set( 'Asia/Jakarta' );
    }

    public function index() {
        if (empty($this->session->session_login['username'])) {
            $this->session->set_flashdata("pesan", "Anda harus login terlebih dahulu.");
            redirect(site_url("controllerLogin"));
        }
        if ($this->session->session_login['level']!= 'user') {
           
            redirect(site_url("controllerLogin"));
        }
        $id_user = $this->session->session_login[ 'id' ];
        $data[ 'peserta' ] = $this->Magang_model->get_magang_by_user_aktif( $id_user );
        $data[ 'p_aktif' ] = $this->Magang_model->get_magang_by_user_aktiff( $id_user );
        $this->load->view( 'header',$data);
        $this->load->view( 'absensi/form_absensi', $data );
        $this->load->view( 'footer' );
    }

    public function absen_masuk() {
        // Ambil input dari form
        $id_peserta = $this->input->post( 'id_peserta' );
        $current_time = date( 'H:i:s' );
        $current_date = date( 'Y-m-d' );

        // Cek apakah peserta sudah absen pada tanggal yang sama
        $existing_absen = $this->db->get_where( 'tb_absensi', [
            'id_peserta' => $id_peserta,
            'tanggal' => $current_date
        ] )->row_array();

        // Jika sudah ada absen, cek status
        if ( $existing_absen ) {
            if ( $existing_absen[ 'status_masuk' ] == 'Hadir' || $existing_absen[ 'status_masuk' ] == 'Terlambat' ) {
                $this->session->set_flashdata( 'error', 'Absensi sudah dicatat pada hari ini.' );
                redirect( 'ControllerAbsensi' );
                return;
            }
        }

        // Tentukan status berdasarkan waktu absensi
        if ( $current_time >= '07:30:00' && $current_time < '08:00:00' ) {
            $status_masuk = 'Hadir';
        } elseif ( $current_time >= '08:00:00' && $current_time <= '15:00:00' ) {
            $status_masuk = 'Terlambat';
        } else {
            // Jika absensi dilakukan sebelum 07:30:00 ( tidak valid )
            $this->session->set_flashdata( 'error', 'Absensi hanya dapat dilakukan mulai pukul 07:30. Hingga Pukul 12.00' );
            redirect( 'ControllerAbsensi' );
            return;
        }

        // Data untuk disimpan
        $data = [
            'id_peserta' => $id_peserta,
            'tanggal' => $current_date,
            'jam_masuk' => $current_time,
            'status_masuk' => $status_masuk,
        ];

        // Simpan data ke database melalui model
        if ( $this->Absensi_model->insert_absen_masuk( $data ) ) {
            $this->session->set_flashdata( 'success', 'Absensi masuk berhasil!' );
        } else {
            $this->session->set_flashdata( 'error', 'Gagal mencatat absensi masuk.' );
        }

        // Redirect kembali ke form absensi
        redirect( 'ControllerAbsensi' );
    }

    public function absen_izin() {
        // Ambil input dari form
        $id_peserta = $this->input->post( 'id_peserta' );
        $keterangan = $this->input->post( 'keterangan' );
        $current_time = date( 'H:i:s' );
        $current_date = date( 'Y-m-d' );

        // Cek apakah peserta sudah absen pada tanggal yang sama
        $existing_absen = $this->db->get_where( 'tb_absensi', [
            'id_peserta' => $id_peserta,
            'tanggal' => $current_date
        ] )->row_array();

        // Jika sudah ada absen, cek status
        if ( $existing_absen ) {
            if ( $existing_absen[ 'status_masuk' ] == 'Hadir' || $existing_absen[ 'status_masuk' ] == 'Terlambat' ) {
                $this->session->set_flashdata( 'error', 'Absensi sudah dicatat pada hari ini.' );
                redirect( 'ControllerAbsensi' );
                return;
            }
        }

        // Tentukan status izin
        $status_masuk = 'Izin';

        // Data untuk disimpan
        $data = [
            'id_peserta' => $id_peserta,
            'tanggal' => $current_date,
            'jam_masuk' => $current_time,
            'keterangan' => $keterangan,
            'status_masuk' => $status_masuk,
        ];

        // Simpan data ke database melalui model
        if ( $this->Absensi_model->insert_absen_masuk( $data ) ) {
            $this->session->set_flashdata( 'success', 'Absensi izin berhasil!' );
        } else {
            $this->session->set_flashdata( 'error', 'Gagal mencatat absensi izin.' );
        }

        // Redirect kembali ke form absensi
        redirect( 'ControllerAbsensi' );
    }

    public function absen_pulang() {
        $id_peserta = $this->input->post( 'id_peserta' );
        $current_time = date( 'H:i:s' );
        $current_date = date( 'Y-m-d' );

        // Cek apakah peserta sudah hadir atau terlambat
        $existing_absen = $this->db->get_where( 'tb_absensi', [
            'id_peserta' => $id_peserta,
            'tanggal' => $current_date
        ] )->row_array();

        if ( $existing_absen && ( $existing_absen[ 'status_masuk' ] == 'Hadir' || $existing_absen[ 'status_masuk' ] == 'Terlambat' ) ) {
            // Validasi waktu absensi pulang
            if ( $current_time >= '16:00:00' ) {
                $this->Absensi_model->update_absen_pulang( $id_peserta, $current_date, $current_time );
                $this->session->set_flashdata( 'success', 'Absensi pulang berhasil!' );
            } else {
                $this->session->set_flashdata( 'error', 'Absensi pulang hanya dapat dilakukan setelah jam 16:00.' );
            }
        } else {
            $this->session->set_flashdata( 'error', 'Absensi pulang hanya dapat dilakukan oleh peserta yang sudah hadir atau terlambat.' );
        }

        redirect( 'ControllerAbsensi' );
    }

    public function IndexAdmin()
 {
        // Mendapatkan data peserta magang yang diterima
        $data[ 'peserta_magang' ] = $this->Absensi_model->getAcceptedMagang();
        $this->load->view( 'header' );
        $this->load->view( 'absensi/list_absensi', $data );
        $this->load->view( 'footer' );
    }

    public function Riwayat()
 {
        // Mendapatkan data peserta magang yang diterima
        $data[ 'peserta_magang' ] = $this->Absensi_model->getAcceptedMagangSelesai();
        $this->load->view( 'header' );
        $this->load->view( 'absensi/riwayat_absensi', $data );
        $this->load->view( 'footer' );
    }

    public function IndexPendamping()
    {
           // Mendapatkan data peserta magang yang diterima
           $data[ 'peserta_magang' ] = $this->Absensi_model->getAcceptedMagangPendamping();
           $this->load->view( 'header' );
           $this->load->view( 'absensi/list_absensi_pendamping', $data );
           $this->load->view( 'footer' );
       }
   
       public function RiwayatPendamping()
    {
           // Mendapatkan data peserta magang yang diterima
           $data[ 'peserta_magang' ] = $this->Absensi_model->getAcceptedMagangSelesaiPendamping();
           $this->load->view( 'header' );
           $this->load->view( 'absensi/riwayat_absensi_pendamping', $data );
           $this->load->view( 'footer' );
       }

    public function getAbsensiByPeserta( $id_pm )
 {
        // Mendapatkan data absensi berdasarkan peserta magang
        $absensi = $this->Absensi_model->getAbsensiByPeserta( $id_pm );
        echo json_encode( $absensi );
    }

    public function ubah_status_selesai( $id_pm ) {
        $data = array(
            'status' => 'selesai'
        );
        $this->db->where( 'id_pm', $id_pm );
        $this->db->update( 'tb_magang', $data );

        // Redirect ke halaman sebelumnya atau tampilkan pesan sukses
        redirect( 'ControllerAbsensi/Riwayat' );
        // Sesuaikan dengan URL halaman utama
    }
    public function ubah_status_laporan( $id_pm ) {
        $data = array(
            'status' => 'laporan'
        );
        $this->db->where( 'id_pm', $id_pm );
        $this->db->update( 'tb_magang', $data );

        // Redirect ke halaman sebelumnya atau tampilkan pesan sukses
        redirect( 'ControllerAbsensi/Riwayat' );
        // Sesuaikan dengan URL halaman utama
    }
}
