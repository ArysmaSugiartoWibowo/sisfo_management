<?php
defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );

class ControllerPM extends CI_Controller
 {

    function __construct()
 {
        parent::__construct();
        $this->load->database();
        $this->load->model( 'Magang_model' );
        $this->load->model( 'Bidang_model' );
        $this->load->library( 'form_validation' );
        $this->load->library( 'Datatables' );
        $this->load->helper( array( 'form', 'url', 'download', 'file' ) );
        if ( empty( $this->session->session_login[ 'username' ] ) ) {
            $this->session->set_flashdata( 'pesan', 'Anda harus login terlebih dahulu.' );
            redirect( site_url( 'controllerLogin' ) );
        }
    }

    public function index() {
        $data[ 'magang' ] = $this->Magang_model->get_all_magang_proses();
        $this->load->view( 'header' );
        $this->load->view( 'magang/listMagang', $data );
        $this->load->view( 'footer' );
    }

    public function tambah() {

        $data[ 'bidang' ] = $this->Bidang_model->get_by_status();
        $data[ 'bidangs' ] = $this->Bidang_model->get_all();
        $id_user = $this->session->session_login[ 'id' ];
        $data[ 'magang' ] = $this->Magang_model->get_magang_by_user( $id_user );
        $data[ 'p_aktif' ] = $this->Magang_model->get_magang_by_user_aktiff ( $id_user );

        $this->load->view( 'header', $data );
        $this->load->view( 'magang/form_magang', $data );
        $this->load->view( 'footer' );
    }

    public function simpan() {
        // Load library upload untuk mengelola file upload
        $this->load->library( 'upload' );

        // Konfigurasi dasar untuk file upload
        $config[ 'upload_path' ] = './uploads/';
        // Tentukan folder penyimpanan
        $config[ 'allowed_types' ] = 'pdf|doc|docx|jpg|jpeg|png';
        // Jenis file yang diizinkan
        $config[ 'max_size' ] = 2048;
        // Ukuran maksimum file ( dalam KB )

        // Fungsi untuk membuat nama file unik berbasis Unix timestamp

        function generate_file_name( $original_name ) {
            $timestamp = time();
            $extension = pathinfo( $original_name, PATHINFO_EXTENSION );
            return $timestamp . '.' . $extension;
        }

        // Upload file CV
        $cv_name = generate_file_name( $_FILES[ 'cv' ][ 'name' ] );
        $config[ 'file_name' ] = $cv_name;
        $this->upload->initialize( $config );
        if ( !$this->upload->do_upload( 'cv' ) ) {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata( 'error', 'Gagal mengupload CV: ' . $error );
            redirect( 'magang/form_magang' );
            return;
        }

        // Upload file Surat Pengantar
        $surat_pengantar_name = generate_file_name( $_FILES[ 'surat_pengantar' ][ 'name' ] );
        $config[ 'file_name' ] = $surat_pengantar_name;
        $this->upload->initialize( $config );
        if ( !$this->upload->do_upload( 'surat_pengantar' ) ) {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata( 'error', 'Gagal mengupload Surat Pengantar: ' . $error );
            redirect( 'user/ControllerPM/tambah' );
            return;
        }

        // Upload file Foto
        $foto_name = generate_file_name( $_FILES[ 'foto' ][ 'name' ] );
        $config[ 'file_name' ] = $foto_name;
        $this->upload->initialize( $config );
        if ( !$this->upload->do_upload( 'foto' ) ) {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata( 'error', 'Gagal mengupload Foto: ' . $error );
            redirect( 'user/ControllerPM/tambah' );
            return;
        }

        // Menyiapkan data untuk disimpan ke database
        $data = [
            'nama' => $this->input->post( 'nama' ),
            'id_user' =>$this->session->session_login[ 'id' ],
            'alamat' => $this->input->post( 'alamat' ),
            'no_tel' => $this->input->post( 'no_tel' ),
            'email' => $this->input->post( 'email' ),
            'institute' => $this->input->post( 'institute' ),
            'ps' => $this->input->post( 'ps' ),
            'tanggal_berakhir' => $this->input->post( 'durasi_magang' ),
            'tanggal_mulai' => $this->input->post( 'tanggal_mulai' )
            ,
            'bidang' => $this->input->post( 'bidang' ),
            'cv' => $cv_name,
            'surat_pengantar' => $surat_pengantar_name,
            'foto' => $foto_name,
            'status' => $this->input->post( 'status' ),
        ];

        // Simpan data ke database
        $this->Magang_model->insert_magang( $data );
        $this->session->set_flashdata( 'success', 'Data magang berhasil disimpan' );
        redirect( 'user/ControllerPM/tambah' );
    }

    public function ubah_status_dan_upload() {
        $id_pm = $this->input->post( 'id_pm' );

        // Konfigurasi upload
        $config[ 'upload_path' ] = './uploads/';
        $config[ 'allowed_types' ] = 'pdf';
        $config[ 'max_size' ] = 2048;
        // Maksimum 2MB

        // Mengubah nama file menjadi angka Unix
        $newFileName = time() . '.pdf';
        // Menambahkan ekstensi .pdf
        $config[ 'file_name' ] = $newFileName;

        $this->load->library( 'upload', $config );

        if ( $this->upload->do_upload( 'file_pdf' ) ) {
            $uploadData = $this->upload->data();
            $file_name = $uploadData[ 'file_name' ];

            // Update status dan simpan nama file di database
            $data = array(
                'status' => 'aktif',
                'keterangan' => $file_name
            );
            $this->db->where( 'id_pm', $id_pm );
            $this->db->update( 'tb_magang', $data );

            // Redirect dengan pesan sukses
            $this->session->set_flashdata( 'message', 'Peserta berhasil diaktifkan dan file diunggah.' );
            redirect( 'controllerAbsensi/indexAdmin' );
        } else {
            // Jika upload gagal
            $this->session->set_flashdata( 'error', $this->upload->display_errors() );
            redirect( 'controllerAbsensi/indexAdmin' );
        }
    }

    public function ubah_status_batal( $id_pm ) {
        $data = array(
            'status' => 'batal'
        );
        $this->db->where( 'id_pm', $id_pm );
        $this->db->update( 'tb_magang', $data );

        // Redirect ke halaman sebelumnya atau tampilkan pesan sukses
        redirect( 'user/ControllerPM/tambah' );
        // Sesuaikan dengan URL halaman utama
    }

    public function ubah_status_selesai( $id_pm ) {
        $data = array(
            'status' => 'selesai'
        );
        $this->db->where( 'id_pm', $id_pm );
        $this->db->update( 'tb_magang', $data );

        // Redirect ke halaman sebelumnya atau tampilkan pesan sukses
        redirect( 'user/ControllerPM' );
        // Sesuaikan dengan URL halaman utama
    }

    public function hapus( $id ) {
        $this->Magang_model->delete_magang( $id );
        redirect( 'user/ControllerPM' );
    }

}
