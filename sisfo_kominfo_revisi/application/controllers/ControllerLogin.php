<?php
defined( 'BASEPATH' ) or exit( 'No direct script access allowed' );

class ControllerLogin extends CI_Controller
 {
    function __construct()
 {
        parent::__construct();
        $this->load->database();
        $this->load->library( 'form_validation' );
        $this->load->model( 'LoginModel' );
    }

    public function index()
 {
        if ( empty( $this->session->userdata( 'username' ) ) ) {
            $this->load->view( 'viewLogin' );
        } else {
            redirect( 'ControllerHome' );
        }
    }

    public function cekStatusLogin()
 {
        $this->form_validation->set_rules( 'username', 'Username', 'required' );
        $this->form_validation->set_rules( 'password', 'Password', 'required' );
        $this->form_validation->set_message( 'required', '* {field} Harus diisi' );

        if ( $this->form_validation->run() == FALSE ) {
            $this->index();
        } else {
            $username = $this->input->post( 'username', TRUE );
            $password = $this->input->post( 'password', TRUE );

            $where = [ 'username' => $username ];
            $cek = $this->LoginModel->validasi( 'user', $where )->row_array();

            if ( !empty( $cek ) && password_verify( $password, $cek[ 'password' ] ) ) {
                $data_session = [
                    'username' => $cek[ 'username' ],
                    'level'    => $cek[ 'level' ],
                    'id'    => $cek[ 'id' ],
                    'asal_sekolah'    => $cek[ 'sekolah_asal' ],
                    'jurusan'    => $cek[ 'jurusan' ],

                ];

                $this->session->set_userdata( 'session_login', $data_session );
                redirect( site_url( 'controllerHome' ) );
            } else {
                $this->session->set_flashdata( 'pesan', 'Username atau Password salah.' );
                redirect( 'ControllerLogin' );
            }
        }
    }

    public function register()
 {
        // $this->load->view( 'header' );
        $this->load->view( 'viewRegister' );
        // $this->load->view( 'footer' );
}

    public function register_action()
 {
        $this->form_validation->set_rules( 'username', 'Username', 'required|is_unique[user.username]' );
        $this->form_validation->set_rules( 'password', 'Password', 'required' );
        $this->form_validation->set_rules( 'level', 'Level', 'required' );
        $this->form_validation->set_message( 'required', '* {field} Harus diisi' );
        $this->form_validation->set_message( 'is_unique', '* {field} sudah ada' );

        if ( $this->form_validation->run() == FALSE ) {
            $this->register();
        } else {
            $data = [
                'username' => $this->input->post( 'username' ),
                'password' => password_hash( $this->input->post( 'password' ), PASSWORD_DEFAULT ),
                'level'    => $this->input->post( 'level' ),
            ];

            $this->LoginModel->registerUser( $data );
            $this->session->set_flashdata( 'success', 'Registrasi berhasil' );
            redirect( 'controllerLogin' );
        }
    }


    public function register_pendamping()
    {
      
    
        // Ambil data unik institute dan ps
        $data['institutes'] = $this->LoginModel->getUniqueInstitutes();
        $data['prodi'] = $this->LoginModel->getUniqueProdi();
    
        // Tampilkan view dengan data
        $this->load->view('register_pendamping', $data);
    }
    
   
       public function register_action_pendamping()
    {
           $this->form_validation->set_rules( 'username', 'Username', 'required|is_unique[user.username]' );
           $this->form_validation->set_rules( 'password', 'Password', 'required' );
           $this->form_validation->set_rules( 'sekolah_asal', 'Sekolah_asal', 'required' );
           $this->form_validation->set_rules( 'jurusan', 'Jurusan', 'required' );
           $this->form_validation->set_rules( 'level', 'Level', 'required' );
           $this->form_validation->set_message( 'required', '* {field} Harus diisi' );
           $this->form_validation->set_message( 'is_unique', '* {field} sudah ada' );
   
           if ( $this->form_validation->run() == FALSE ) {
               $this->register();
           } else {
               $data = [
                   'username' => $this->input->post( 'username' ),
                   'jurusan' => $this->input->post( 'jurusan' ),
                   'sekolah_asal' => $this->input->post( 'sekolah_asal' ),
                   'password' => password_hash( $this->input->post( 'password' ), PASSWORD_DEFAULT ),
                   'level'    => $this->input->post( 'level' ),
               ];
   
               $this->LoginModel->registerUser( $data );
               $this->session->set_flashdata( 'success', 'Registrasi berhasil' );
               redirect( 'controllerLogin' );
           }
       }
   

    public function deleteUser()
 {
        $this->load->view( 'viewDeleteUser' );
    }

    public function deleteUser_action()
 {
        $this->form_validation->set_rules( 'username', 'Username', 'required' );
        $this->form_validation->set_message( 'required', '* {field} Harus diisi' );

        if ( $this->form_validation->run() == FALSE ) {
            $this->deleteUser();
        } else {
            $username = $this->input->post( 'username' );

            $this->LoginModel->deleteUser( $username );
            $this->session->set_flashdata( 'success', 'Pengguna berhasil dihapus' );
            redirect( 'controllerLogin' );
        }
    }

    public function ubahPassword()
 {
        $this->load->view( 'admin/header' );
        $this->load->view( 'admin/formUbahPassword' );
        $this->load->view( 'admin/footer' );
    }

    public function ubahPassword_action()
 {
        $this->form_validation->set_rules( 'password', 'password', 'required' );
        $this->form_validation->set_message( 'required', '* {field} Harus diisi' );

        if ( $this->form_validation->run() == FALSE ) {
            $this->ubahPassword();
        } else {
            $username_lama  = $this->input->post( 'username_lama' );
            $username       = $this->input->post( 'username' );
            $password       = password_hash( $this->input->post( 'password' ), PASSWORD_DEFAULT );

            $data = [
                'username'  => $username,
                'password'  => $password
            ];
            $this->LoginModel->updateUser( $username_lama, $data );
            $this->session->set_flashdata( 'success', 'Berhasil ubah password' );
            redirect( 'controllerHome' );
        }
    }

    public function logout()
 {
        $this->session->sess_destroy();
        redirect( 'controllerLogin' );
    }
}
