<?php
	class Users_model extends CI_Model {
		function __construct(){
			parent::__construct();
			$this->load->database();
		}

		public function show(){
			$query = $this->db->get('users');
			return $query->result(); 
		}

		public function insert($user){
			return $this->db->insert('users', $user);
		}

		public function getuser($id){
			$query = $this->db->get_where('users',array('id'=>$id));
			return $query->row_array();
		}

		public function updateuser($user, $id){
			$this->db->where('users.id', $id);
			return $this->db->update('users', $user);
		}

		public function delete($id){
			$this->db->where('users.id', $id);
			return $this->db->delete('users');
		}

	}
?>