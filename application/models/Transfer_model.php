<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transfer_model extends CI_Model {
  
    public function __construct() {
       parent::__construct();
       $this->load->database();
    }

    public function insert($data)
    {
        $this->db->insert('transaksi_transfer',$data);
        return $this->db->insert_id(); 
    }

    public function insert_last_Id($data)
     {
        $this->db->insert('generate_code',$data);
        return $this->db->insert_id();
     } 

    public function getLastId($tahun,$bulan)
    {
        $this->db->select('last_id');
        $this->db->from('generate_code');
        $this->db->where('tahun',$tahun);        
        $this->db->where('bulan',$bulan);
        $this->db->order_by('id','desc');
        $this->db->limit(1);
        return $this->db->get()->row();
    }

    public function get_rekening($nama_bank) {
        
        $this->db->select('a.nama_bank,b.no_rekening');
        $this->db->from('bank as a');
        $this->db->join('rekening_admin b', 'a.id_bank = b.id_bank');
        $this->db->where('a.nama_bank', $nama_bank);
        return $this->db->get()->row();
        
    }
     
}
