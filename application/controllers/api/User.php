<?php
defined('BASEPATH') OR exit('No direct script access allowed');

    require(APPPATH.'/libraries/REST_Controller.php');
    use Restserver\Libraries\REST_Controller;

class User extends REST_Controller {

	public function __construct() {
		parent::__construct();
        $this->load->library('Authorization_Token');
		$this->load->model('user_model');
	}
	public function register_post() {

		// set validation rules
		$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|is_unique[users.username]', array('is_unique' => 'This username already exists. Please choose another one.'));
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		//$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');
		
		if ($this->form_validation->run() === false) {
            $this->response(['Validation rules violated'], REST_Controller::HTTP_OK);
		} else {
			
			// set variables from the form
			$username = $this->input->post('username');
			$email    = $this->input->post('email');
			$password = $this->input->post('password');
			
			if ($res = $this->user_model->create_user($username, $email, $password)) {
				
				// user creation ok
                $token_data['uid'] = $res; 
                $token_data['username'] = $username;
                $tokenData = $this->authorization_token->generateToken($token_data);

                $response = array();
                $response['status'] = true;
                $response['accessToken'] = $tokenData;
                $response['refreshToken'] = $tokenData;

                $this->response($response, REST_Controller::HTTP_OK); 

			} else {
                $this->response(['Gagal register. Coba Lagi.'], REST_Controller::HTTP_OK);
			}
			
		}
		
	}
		
	public function login_post() {
		
		// set validation rules
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run() == false) {
            $this->response(['Coba periksa data kembali'], REST_Controller::HTTP_OK);

		} else {
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			
			if ($this->user_model->resolve_user_login($username, $password)) {
				
				$user_id = $this->user_model->get_user_id_from_username($username);
				$user    = $this->user_model->get_user($user_id);
				
				// set session user datas
				$_SESSION['user_id']      = (int)$user->id;
				$_SESSION['username']     = (string)$user->username;
				$_SESSION['logged_in']    = (bool)true;
				$_SESSION['is_confirmed'] = (bool)$user->is_confirmed;
				$_SESSION['is_admin']     = (bool)$user->is_admin;
				
				// user login ok
                $token_data['uid'] = $user_id;
                $token_data['username'] = $user->username; 
                $tokenData = $this->authorization_token->generateToken($token_data);

                $response = array();
                $response['status'] = true;
                $response['accessToken'] = $tokenData;
                $response['refreshToken'] = $tokenData;

                $this->response($response, REST_Controller::HTTP_OK); 
				
			} else {
                $this->response(['Username atau Password Salah.'], REST_Controller::HTTP_OK);
				
			}
			
		}
		
	}
	
	
	public function logout_post() {

		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			foreach ($_SESSION as $key => $value) {
				unset($_SESSION[$key]);
			}
            $this->response(['Logout success!'], REST_Controller::HTTP_OK);
			
		} else {
            $this->response(['Gagal Logout. Coba Lagi.'], REST_Controller::HTTP_OK);	
		}
		
	}
	
}
