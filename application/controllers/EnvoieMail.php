<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EnvoieMail extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('email');
		
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;

		$this->email->initialize($config);
	}

	public function index()
	{
		$this->load->view('Composants/Envoie_Mail.php');
	}
	public function getContact()
	{
		$this->load->model('ContactModel','cm');
		$this->cm->set_table_name('contact');
		$contacts = $this->cm->getAll();
		echo json_encode($contacts);
	}
	public function envoie()
	{

		$type_message = htmlspecialchars(trim($this->input->post('type-message')));

		//$this->form_validation->set_rules("objet","objet","required");
		$this->form_validation->set_rules("message","message","required");

		if(!$this->form_validation->run())
		{
			echo json_encode(['success' => false]);
			exit();
		}

		$objet = htmlspecialchars(trim($this->input->post('objet')));
		$message = htmlspecialchars(trim($this->input->post('message')));
		$email_destinataire = htmlspecialchars(trim($this->input->post('destinataire')));

		/*------------------Pièce jointe---------------------*/
		$piece_file = $_FILES['piece-jointe'];
		$name_file = null;
		if(($piece_file['name'] !== "" && $piece_file['size'] > 0))
		{
			$extension = strtolower(pathinfo($piece_file['name'],PATHINFO_EXTENSION));
			$name_file = time().'.'.$extension;
			if(move_uploaded_file($piece_file['tmp_name'], 'public/tmp/'.$name_file))
			{
				if($this->startSending($type_message,$email_destinataire,$objet,$message,$name_file))
				{
					$_SESSION['piece-jointe'] = $name_file;
					echo json_encode(['success' => true]);
				}
				else
				{
					echo json_encode(['success' => false]);
				}
			}
		}else{
			if($this->startSending($type_message,$email_destinataire,$objet,$message,$name_file))
			{
				echo json_encode(['success' => true]);
			}
			else
			{
				echo json_encode(['success' => false]);
			}
		}
	}
	public function sendmail()
	{

		$type_message = htmlspecialchars(trim($this->input->post('type-message')));

		//$this->form_validation->set_rules("objet","objet","required");
		$this->form_validation->set_rules("message","message","required");

		if(!$this->form_validation->run())
		{
			echo json_encode(['error' => 'Le champs message ne doit pas être vide']);
			exit();
		}

		$objet = htmlspecialchars(trim($this->input->post('objet')));
		$message = htmlspecialchars(trim($this->input->post('message')));
		$email_destinataire = htmlspecialchars(trim($this->input->post('destinataire')));
		$index_email = (int)$this->input->post('index-email');
		$nbre_contact = (int)$this->input->post('nbre-contact');

		/*------------------Pièce jointe---------------------*/
		$name_file = null;
		if(isset($_SESSION['piece-jointe']))
		{
			$name_file = $_SESSION['piece-jointe'];
		}

		if($this->startSending($type_message,$email_destinataire,$objet,$message,$name_file))
		{
			if($index_email === $nbre_contact){
				unset($_SESSION['piece-jointe']);
			}
			echo json_encode(['success' => true,'index' => $index_email]);
		}
		else
		{
			echo json_encode(['success' => false]);
		}

	}
	public function getContentText()
	{
		$file = $_FILES['destinataire-text'];
		$file_extension = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
		if($file_extension !== 'txt'){
			echo json_encode(['error' => 'Fichier non autorisé']);
			exit();
		}
		$final_name = time().".".$file_extension;
		if(move_uploaded_file($file['tmp_name'], 'public/tmp/'.$final_name ))
		{
			if($txt_string = file_get_contents('public/tmp/'.$final_name)){
				
				unlink('public/tmp/'.$final_name);
				
				echo json_encode(['success' => true,'contacts' => explode("\n", $txt_string)]);
			}	
		}
	}

	private function startSending($type_message,string $destinataire,$objet,$message,$piece_jointe = null)
	{
		$this->email->clear();

        $this->email->to($destinataire);
        $this->email->from('suzannemarienathalie@gmail.com');
        $this->email->subject($objet);
        $this->email->message($message);
        if($piece_jointe)
        {
        	$this->email->attach('public/tmp/' . $piece_jointe);
        }
        if(!$this->email->send())
        {
        	return false;
        }
        return true;
	}
}
