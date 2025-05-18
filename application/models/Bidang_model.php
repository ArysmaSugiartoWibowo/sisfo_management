<?php
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Bidang_model extends CI_Model {

    public function __construct()
 {
        parent::__construct();
    }

    // Create ( insert data )

    public function create( $data )
 {
        return $this->db->insert( 'tb_bidang', $data );
    }

    // Read ( get all data )

    public function get_all()
 {
        return $this->db->get( 'tb_bidang' )->result();
    }

    // Read ( get single data )

    public function get_by_id( $id )
 {
        return $this->db->get_where( 'tb_bidang', [ 'id_bidang' => $id ] )->row();
    }

    public function get_by_status()
    {
           return $this->db->get_where( 'tb_bidang', [ 'status' => 'Aktif' ] )->result();
       }

    // Update ( update data )

    public function update( $id, $data )
 {
        $this->db->where( 'id_bidang', $id );
        return $this->db->update( 'tb_bidang', $data );
    }

    // Delete ( delete data )

    public function delete( $id )
 {
        $this->db->where( 'id_bidang', $id );
        return $this->db->delete( 'tb_bidang' );
    }
}
