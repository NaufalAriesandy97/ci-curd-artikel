<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artikel extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('artikel_model');
	}

	public function index(){
		$data['artikel'] = $this->artikel_model->get_all_artikel();
		$this->load->view('artikel_view', $data);
	}

	public function artikel_add(){
		$data = array(
			'judul' => $this->input->post('judul'),
			'isi' => $this->input->post('isi'),
			'penulis' => $this->input->post('penulis'),
			'tanggal' => $this->input->post('tanggal') );

		$insert = $this->artikel_model->artikel_add($data);
		echo json_encode(array("status" => true));
	}

	public function ajax_edit($kd_artikel){
		$data = $this->artikel_model->get_by_id($kd_artikel);
		echo json_encode($data);
	}

	public function artikel_update(){
		$data = array(
			'judul' => $this->input->post('judul'),
			'isi' => $this->input->post('isi'),
			'penulis' => $this->input->post('penulis'),
			'tanggal' => $this->input->post('tanggal') );

		$this->artikel_model->artikel_update(array('kd_artikel' => $this->input->post('kd_artikel')), $data);
		echo json_encode(array("status" => true));
	}

	public function artikel_delete($kd_artikel){
		$this->artikel_model->delete_by_id($kd_artikel);
		echo json_encode(array("status" => true));
	}

}
?>