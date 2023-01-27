<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'/libraries/REST_Controller.php');
use Restserver\Libraries\REST_Controller;

class Token extends REST_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->library('Authorization_Token');
		$this->load->model('user_model');
	}

	public function reGenToken_post() {

		$headers = $this->input->request_headers(); 
		
		if (isset($headers['Authorization'])) {
			$decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
			if ($decodedToken['status'])
			{
				$token_data['uid'] = $decodedToken['data']->uid; 
				$token_data['username'] = $decodedToken['data']->username; 
				$tokenData = $this->authorization_token->generateToken($token_data);

				$response = array();
				$response['status'] = true;
				$response['access_token'] = $tokenData;
				$response['refresh_token'] = $tokenData;

				$this->response($response, REST_Controller::HTTP_OK); 
			}else {
				$this->response($decodedToken);
			}
		}else {
			$this->response(['Authentication failed'], REST_Controller::HTTP_OK);
		}
	}
}
