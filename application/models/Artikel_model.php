<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	/**
	* 
	*/
	class Artikel_model extends CI_model{
		var $table = 'artikel';
		
		public function __construct(){
			parent::__construct();
			$this->load->database();
		}

		public function get_all_artikel(){
			$this->db->from('artikel');
			$query = $this->db->get();
			return $query->result();
		}

		public function get_by_id($kd_artikel){
			$this->db->from($this->table);
			$this->db->where('kd_artikel', $kd_artikel);
			$query = $this->db->get();
			return $query->row();
		}

		public function artikel_add($data){
			$this->db->insert($this->table, $data);
			return $this->db->insert_id();
		}

		public function artikel_update($where, $data){
			$this->db->update($this->table, $data, $where);
			return $this->db->affected_rows();
		}

		public function delete_by_id($kd_artikel){
			$this->db->where('kd_artikel', $kd_artikel);
			$this->db->delete($this->table);
		}
	}
?>