<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ContactModel','cm');
		$this->cm->set_table_name('contact');
		$this->load->library('form_validation');
	}
	/**--------------GET----------------------*/
	public function add()
	{
		$this->load->view('Composants/add_contact');
	}
	public function liste()
	{
		$data['contacts'] = $this->cm->getAll();
		$this->load->view('Composants/liste_contact.php',$data);
	}
	public function delete($id_contact)
	{
		$this->cm->delete((int)$id_contact);
		echo json_encode(['success'=>true]);
	}

	/**---------------POST----------------------*/
	public function create()
	{
		$this->form_validation->set_rules("email_contact","email","required|valid_email",[
			"required" => "L'adresse email est obligatoire",
			"valid_email" => "Adresse email invalide"
		]);
		if(!$this->form_validation->run()){
			echo json_encode(['error'=>validation_errors()]);
			exit();
		}
		$fields = [];
		$values = [];
		foreach($_POST as $key=>$post)
		{
			if($key != 'id_contact')
			{
				if(!empty($post))
				{
					$fields[] = $key;
					$values[] = htmlspecialchars(trim($post));
				}
			}
		}
		$this->cm->create($fields,$values);
		echo json_encode(['success'=>true,'message'=>'Contact ajouté']);
	}
	public function update()
	{
		$this->form_validation->set_rules("email_contact","email","required|valid_email",[
			"required" => "L'adresse email est obligatoire",
			"valid_email" => "Adresse email invalide"
		]);
		if(!$this->form_validation->run()){
			echo json_encode(['error'=>validation_errors()]);
			exit();
		}
		$fields = [];
		$values = [];
		foreach($_POST as $key=>$post)
		{
			if($key !== 'id_contact'){
				if(!empty($post))
				{
					$fields[] = $key;
					$values[] = htmlspecialchars(trim($post));
				}
			}
		}
		$this->cm->update($fields,$values,"id_contact",(int)$_POST['id_contact']);
		echo json_encode(['success'=>true,'message'=>'Mise à jour effectué']);
	}

	
}
