<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ControllerHome extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('Magang_model');
        $this->load->library('form_validation');
        $this->load->library('upload');
        if (empty($this->session->session_login['username'])) {
            $this->session->set_flashdata("pesan", "Anda harus login terlebih dahulu.");
            redirect(site_url("controllerLogin"));
        }
    }

    public function index()
    {     
        $session_data = $this->session->userdata('session_login');
        $data['level'] = $session_data['level'];
        $id_user = $this->session->session_login[ 'id' ];
        $data[ 'p_aktif' ] = $this->Magang_model->get_magang_by_user_aktiff ( $id_user );
        $this->load->view("header",$data);
        $this->load->view("dashboard", $data);
        $this->load->view("footer");
    }

}
