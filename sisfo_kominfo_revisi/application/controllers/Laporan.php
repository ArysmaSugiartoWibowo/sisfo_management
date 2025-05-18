<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Laporan extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model( 'Laporan_model' );
        $this->load->model( 'Magang_model' );
        $this->load->library( 'form_validation' );
        $this->load->library( 'Datatables' );
        $this->load->helper( array( 'form', 'url', 'download', 'file' ) );
        
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
        $data[ 'p_aktif' ] = $this->Magang_model->get_magang_by_user_aktiff ( $id_user );
        $data[ 'laporan' ] = $this->Laporan_model->check_user_report( $id_user );
        $data[ 'laporans' ] = $this->Laporan_model->get_laporan_by_user( $id_user );
        $this->load->view("header",$data);
        $this->load->view( 'laporan/form_laporan',$data );
        $this->load->view( 'footer' );
    }

    public function upload() {
        if (empty($this->session->session_login['username'])) {
            $this->session->set_flashdata("pesan", "Anda harus login terlebih dahulu.");
            redirect(site_url("controllerLogin"));
        }
        if ($this->session->session_login['level']!= 'user') {
           
            redirect(site_url("controllerLogin"));
        }
        $id_user = $this->session->session_login[ 'id' ];

        // Cek apakah id_user sudah memiliki laporan
        if ( $this->Laporan_model->check_user_report( $id_user ) ) {
            $this->session->set_flashdata( 'error', 'Anda sudah mengunggah laporan sebelumnya. Hanya satu laporan yang diperbolehkan.' );
            redirect( 'laporan' );
            return;
        }

        // Konfigurasi upload
        $config[ 'upload_path' ] = './uploads/';
        $config[ 'allowed_types' ] = 'pdf';
        // 2MB
        $config[ 'encrypt_name' ] = TRUE;
        // Generate nama file unik

        $this->load->library( 'upload', $config );

        if ( !$this->upload->do_upload( 'file' ) ) {
            // Jika gagal upload
            $error = $this->upload->display_errors();
            $this->session->set_flashdata( 'error', $error );
            redirect( 'laporan' );
        } else {
            // Jika berhasil upload
            $data_upload = $this->upload->data();

            // Data yang akan disimpan ke database
            $data = [
                'id_user' => $id_user,
                'keterangan' => $this->input->post( 'keterangan' ),
                'status' => 'pending',
                'nama_file' => $data_upload[ 'file_name' ]
            ];

            // Simpan data
            if ( $this->Laporan_model->save( $data ) ) {
                $this->session->set_flashdata( 'success', 'File berhasil diunggah!' );
            } else {
                $this->session->set_flashdata( 'error', 'Gagal menyimpan data ke database.' );
            }

            redirect( 'laporan' );
        }
    }

    public function hapus( $id ) {
        if (empty($this->session->session_login['username'])) {
            $this->session->set_flashdata("pesan", "Anda harus login terlebih dahulu.");
            redirect(site_url("controllerLogin"));
        }
        if ($this->session->session_login['level']!= 'user') {
           
            redirect(site_url("controllerLogin"));
        }
        $this->Laporan_model->delete_laporan( $id );
        redirect( 'Laporan' );
    }

    // admin

    public function indexAdmin() {
        if (empty($this->session->session_login['username'])) {
        $this->session->set_flashdata("pesan", "Anda harus login terlebih dahulu.");
        redirect(site_url("controllerLogin"));
    }
    if ($this->session->session_login['level'] != 'admin') {
       
        redirect(site_url("controllerLogin"));
    }
        $data[ 'laporans' ] = $this->Laporan_model->get_all_by_pending();
        $this->load->view("header",$data);
        $this->load->view( 'laporan/listLaporan',$data );
        $this->load->view( 'footer' );
    }

    public function riwayat() {
        if (empty($this->session->session_login['username'])) {
            $this->session->set_flashdata("pesan", "Anda harus login terlebih dahulu.");
            redirect(site_url("controllerLogin"));
        }
        if ($this->session->session_login['level'] != 'admin'){
           
            redirect(site_url("controllerLogin"));
        }
        $data[ 'laporans' ] = $this->Laporan_model->get_all_by_setuju();
        $this->load->view("header",$data);
        $this->load->view( 'laporan/riwayat_laporan',$data );
        $this->load->view( 'footer' );
    }

    public function tolak( $id_laporan ) {
        if (empty($this->session->session_login['username'])) {
            $this->session->set_flashdata("pesan", "Anda harus login terlebih dahulu.");
            redirect(site_url("controllerLogin"));
        }
        if ($this->session->session_login['level']!= 'admin') {
           
            redirect(site_url("controllerLogin"));
        }
        $data = array(
            'status' => 'reject'
        );
        $this->db->where( 'id_laporan', $id_laporan );
        $this->db->update( 'tb_laporan', $data );
        // Redirect ke halaman sebelumnya atau tampilkan pesan sukses
        redirect( 'Laporan/indexAdmin' );
        // Sesuaikan dengan URL halaman utama
    }


    public function ubah_status_dan_upload() {
        if (empty($this->session->session_login['username'])) {
            $this->session->set_flashdata("pesan", "Anda harus login terlebih dahulu.");
            redirect(site_url("controllerLogin"));
        }
        if ($this->session->session_login['level'] != 'admin') {
            redirect(site_url("controllerLogin"));
        }
    
        $id_laporan = $this->input->post('id_laporan');
    
        // Konfigurasi upload untuk file_penilaian
        $config_penilaian['upload_path'] = './uploads/';
        $config_penilaian['allowed_types'] = 'pdf';
        $config_penilaian['max_size'] = 2048; // Maksimum 2MB
        $newFileNamePenilaian = time() . '_penilaian.pdf'; // Mengubah nama file menjadi Unix timestamp
        $config_penilaian['file_name'] = $newFileNamePenilaian;
    
        $this->load->library('upload', $config_penilaian, 'penilaianUpload');
        $this->penilaianUpload->initialize($config_penilaian);
    
        // Konfigurasi upload untuk sertifikat
        $config_sertifikat['upload_path'] = './uploads/';
        $config_sertifikat['allowed_types'] = 'pdf';
        $config_sertifikat['max_size'] = 2048; // Maksimum 2MB
        $newFileNameSertifikat = time() . '_sertifikat.pdf'; // Mengubah nama file menjadi Unix timestamp
        $config_sertifikat['file_name'] = $newFileNameSertifikat;
    
        $this->load->library('upload', $config_sertifikat, 'sertifikatUpload');
        $this->sertifikatUpload->initialize($config_sertifikat);
    
        // Flag untuk memeriksa apakah kedua file berhasil diunggah
        $upload_success = true;
    
        // Proses upload file_penilaian
        if ($this->penilaianUpload->do_upload('file_penilaian')) {
            $file_penilaian = $this->penilaianUpload->data('file_name');
        } else {
            $upload_success = false;
            $this->session->set_flashdata('error_penilaian', $this->penilaianUpload->display_errors());
        }
    
        // Proses upload sertifikat
        if ($this->sertifikatUpload->do_upload('sertifikat')) {
            $file_sertifikat = $this->sertifikatUpload->data('file_name');
        } else {
            $upload_success = false;
            $this->session->set_flashdata('error_sertifikat', $this->sertifikatUpload->display_errors());
        }
    
        if ($upload_success) {
            // Update status dan simpan nama file di database
            $data = array(
                'status' => 'acc kominfo',
                'file_penilaian' => isset($file_penilaian) ? $file_penilaian : null,
                'Sertifikat' => isset($file_sertifikat) ? $file_sertifikat : null,
            );
            $this->db->where('id_laporan', $id_laporan);
            $this->db->update('tb_laporan', $data);
    
            // Redirect dengan pesan sukses
            $this->session->set_flashdata('message', 'Peserta berhasil diaktifkan dan file diunggah.');
            redirect('ControllerAbsensi/indexAdmin');
        } else {
            // Jika salah satu upload gagal
            $this->session->set_flashdata('error', 'Gagal mengunggah file. Silakan periksa pesan error.');
            redirect('Laporan/indexAdmin');
        }
    }

    // pendamping


    public function indexPendamping() {
        if (empty($this->session->session_login['username'])) {
        $this->session->set_flashdata("pesan", "Anda harus login terlebih dahulu.");
        redirect(site_url("controllerLogin"));
    }
    if ($this->session->session_login['level'] != 'pendamping') {
       
        redirect(site_url("controllerLogin"));
    }
        $data[ 'laporans' ] = $this->Laporan_model->get_all_by_pending_pendamping();
        $this->load->view("header",$data);
        $this->load->view( 'laporan/listLaporan_pendamping',$data );
        $this->load->view( 'footer' );
    }

    public function riwayatPendamping() {
        if (empty($this->session->session_login['username'])) {
            $this->session->set_flashdata("pesan", "Anda harus login terlebih dahulu.");
            redirect(site_url("controllerLogin"));
        }
        if ($this->session->session_login['level'] != 'pendamping'){
           
            redirect(site_url("controllerLogin"));
        }
        $data[ 'laporans' ] = $this->Laporan_model->get_all_by_setuju_pendamping();
        $this->load->view("header",$data);
        $this->load->view( 'laporan/riwayat_laporan_pendamping',$data );
        $this->load->view( 'footer' );
    }

    public function Pendamping( $id_laporan ) {
        if (empty($this->session->session_login['username'])) {
            $this->session->set_flashdata("pesan", "Anda harus login terlebih dahulu.");
            redirect(site_url("controllerLogin"));
        }
        if ($this->session->session_login['level']!= 'pendamping') {
           
            redirect(site_url("controllerLogin"));
        }
        $data = array(
            'status' => 'reject Pendamping'
        );
        $this->db->where( 'id_laporan', $id_laporan );
        $this->db->update( 'tb_laporan', $data );
        // Redirect ke halaman sebelumnya atau tampilkan pesan sukses
        redirect( 'Laporan/indexPendamping' );
        // Sesuaikan dengan URL halaman utama
    }


    public function ubah_status_dan_upload_pendamping() {
        if (empty($this->session->session_login['username'])) {
            $this->session->set_flashdata("pesan", "Anda harus login terlebih dahulu.");
            redirect(site_url("controllerLogin"));
        }
        if ($this->session->session_login['level'] != 'pendamping') {
            redirect(site_url("controllerLogin"));
        }
    
        $id_laporan = $this->input->post('id_laporan');
    
        // Konfigurasi upload untuk file_penilaian
        $config_penilaian['upload_path'] = './uploads/';
        $config_penilaian['allowed_types'] = 'pdf';
        $config_penilaian['max_size'] = 2048; // Maksimum 2MB
        $newFileNamePenilaian = time() . '_penilaian.pdf'; // Mengubah nama file menjadi Unix timestamp
        $config_penilaian['file_name'] = $newFileNamePenilaian;
    
        $this->load->library('upload', $config_penilaian, 'penilaianUpload');
        $this->penilaianUpload->initialize($config_penilaian);
    
        // Flag untuk memeriksa apakah kedua file berhasil diunggah
        $upload_success = true;
    
        // Proses upload file_penilaian
        if ($this->penilaianUpload->do_upload('file_penilaian')) {
            $file_penilaian = $this->penilaianUpload->data('file_name');
        } else {
            $upload_success = false;
            $this->session->set_flashdata('error_penilaian', $this->penilaianUpload->display_errors());
        }
    
     
    
        if ($upload_success) {
            // Update status dan simpan nama file di database
            $data = array(
                'status' => 'disetujui',
                'penilaian_dosen' => isset($file_penilaian) ? $file_penilaian : null,
              
            );
            $this->db->where('id_laporan', $id_laporan);
            $this->db->update('tb_laporan', $data);
    
            // Redirect dengan pesan sukses
            $this->session->set_flashdata('message', 'Peserta berhasil diaktifkan dan file diunggah.');
            redirect('ControllerAbsensi/indexPendamping');
        } else {
            // Jika salah satu upload gagal
            $this->session->set_flashdata('error', 'Gagal mengunggah file. Silakan periksa pesan error.');
            redirect('Laporan/indexPendamping');
        }
    }



    

}
