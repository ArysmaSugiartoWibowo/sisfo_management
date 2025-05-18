<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Bidang extends CI_Controller {

    public function __construct()
 {
        parent::__construct();
        $this->load->model( 'Bidang_model' );
        $this->load->helper( 'url' );
        if (empty($this->session->session_login['username'])) {
            $this->session->set_flashdata("pesan", "Anda harus login terlebih dahulu.");
            redirect(site_url("controllerLogin"));
        }
        if ($this->session->session_login['level']!= 'admin') {
           
            redirect(site_url("controllerLogin"));
        }
    }

    // Menampilkan semua data

    public function index()
 {
        $data[ 'bidang' ] = $this->Bidang_model->get_all();
        $this->load->view( 'header' );
        $this->load->view( 'bidang/list_bidang', $data );
        $this->load->view( 'footer' );

    }

    // Menampilkan form tambah data

    public function create()
 {
        $this->load->view( 'header' );
        $this->load->view( 'bidang/form_bidang' );
        $this->load->view( 'footer' );
    }

    // Menyimpan data baru

    public function store()
 {
        $data = [
            'nama_bidang' => $this->input->post( 'nama_bidang' ),
            'status' => $this->input->post( 'status' )
        ];
        $this->Bidang_model->create( $data );
        redirect( 'bidang' );
    }

    // Menampilkan form edit data

    public function edit( $id )
 {
        $data[ 'bidang' ] = $this->Bidang_model->get_by_id( $id );
        $this->load->view( 'header' );
        $this->load->view( 'bidang/edit', $data );
        $this->load->view( 'footer' );
    }

    // Menyimpan perubahan data

    public function update( $id )
 {
        $data = [
            'nama_bidang' => $this->input->post( 'nama_bidang' ),
            'status' => $this->input->post( 'status' )
        ];
        $this->Bidang_model->update( $id, $data );
        redirect( 'bidang' );
    }

    // Menghapus data

    public function delete( $id )
 {
        $this->Bidang_model->delete( $id );
        redirect( 'bidang' );
    }
}
