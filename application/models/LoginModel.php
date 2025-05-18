<?php
class LoginModel extends CI_Model
{
    public function validasi($table, $where)
    {
        return $this->db->get_where($table, $where);
    }

    public function updateUser($username_lama, $data)
    {
        $this->db->where('username', $username_lama);
        $this->db->update('user', $data);
    }

    public function registerUser($data)
    {
        $this->db->insert('user', $data);
    }

    public function deleteUser($username)
    {
        $this->db->where('username', $username);
        $this->db->delete('user');
    }

    public function getUniqueInstitutes()
    {
        $this->db->distinct();
        $this->db->select('institute');
        $this->db->from('tb_magang');
        $query = $this->db->get();

        return $query->result();
    }

    public function getUniqueProdi()
    {
        $this->db->distinct();
        $this->db->select('ps');
        $this->db->from('tb_magang');
        $query = $this->db->get();

        return $query->result();
    }
}
