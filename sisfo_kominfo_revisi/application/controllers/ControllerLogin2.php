<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ControllerLogin2 extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(['form_validation', 'session']);
        $this->load->model('LoginModel');
    }

    public function index()
    {
        // Check if user is already logged in
        if ($this->session->userdata("logged_in")) {
            redirect("ControllerHome");
        } else {
            $this->load->view("viewLogin");
        }
    }

    public function register()
    {
        $this->load->view('viewRegister'); // View for the registration form
    }

    public function register_action()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_message('required', '* {field} Harus diisi');
        $this->form_validation->set_message('is_unique', '* {field} sudah terdaftar');
        $this->form_validation->set_message('matches', '* {field} tidak cocok dengan Password');

        if ($this->form_validation->run() == FALSE) {
            $this->register();
        } else {
            $username = $this->input->post('username', TRUE);
            $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT); // Secure password

            $data = [
                'username' => $username,
                'password' => $password,
                'level' => 'user', // Assuming a default level
            ];

            if ($this->LoginModel->registerUser($data)) {
                $this->session->set_flashdata('success', 'Registrasi berhasil, silakan login.');
                redirect('ControllerLogin');
            } else {
                $this->session->set_flashdata('error', 'Registrasi gagal, coba lagi.');
                redirect('ControllerLogin/register');
            }
        }
    }

    public function cekStatusLogin()
    {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_message('required', '* {field} Harus diisi');

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $username = $this->input->post("username", TRUE);
            $password = $this->input->post("password", TRUE);

            $user = $this->LoginModel->checkUser($username);

            if ($user && password_verify($password, $user['password'])) {
                // Set session data
                $this->session->set_userdata([
                    'username' => $user['username'],
                    'level' => $user['level'],
                    'logged_in' => TRUE
                ]);
                redirect("ControllerHome");
            } else {
                $this->session->set_flashdata("error", "Username atau password salah");
                redirect("ControllerLogin");
            }
        }
    }

    public function ubahPasssword()
    {
        $this->load->view("admin/header");
        $this->load->view('admin/formUbahPassword');
        $this->load->view("admin/footer");
    }

    public function ubahPasssword_action()
    {
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_message('required', '* {field} Harus diisi');

        if ($this->form_validation->run() == FALSE) {
            $this->ubahPasssword();
        } else {
            $username_lama  = $this->input->post("username_lama");
            $username       = $this->input->post("username");
            $password       = password_hash($this->input->post("password"), PASSWORD_DEFAULT); // Secure password

            $data = [
                "username"  => $username,
                "password"  => $password
            ];
            $this->LoginModel->updateUser($username_lama, $data);
            $this->session->set_flashdata("success", "Berhasil ubah password");
            redirect("ControllerHome");
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect("ControllerLogin");
    }
}
