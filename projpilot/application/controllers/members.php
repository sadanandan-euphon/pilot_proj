<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Members extends MX_Controller {
	
	//sets rules for login form validation	
	private $rules = array(
						array(
							'field'   => 'username',
							'label'   => 'lang:email',
							//'rules'   => 'trim|required|valid_email',
							'rules'   => 'trim|required',
						),
						array(
							'field'   => 'password',
							'label'   => 'lang:password',
							'rules'   => 'trim|required|min_length[6]',
						)
					);		
	
	/**
	 * constructor
	 *
	 */
	function __construct() {
        parent::__construct();
	}
	
	// -----------------------------------------------------------------------------------------
	
	/**
	 * This function 'll load the login page
	 *
	 */
	function index(){
		$this->login();
	}
	
	// -----------------------------------------------------------------------------------------
	
	/**
	 * This function 'll do login process
	 *
	 * @access public
	 * @return redirect to users home if success else shows the login page
	 */
	
	function login(){
									
		//if not logged in show login window
		if ($this->session->userdata('logged_in') == FALSE){
			
			$data['error'] = FALSE;
			$this->load->library('form_validation');
			$this->form_validation->set_rules($this->rules);
			$this->form_validation->set_error_delimiters('<br>');
			
			if ($this->form_validation->run() != FALSE){
												  
				$this->db->select("pp_users.*,pp_user_details.user_id,pp_user_details.email,pp_user_details.first_name,pp_user_details.last_name");
				$this->db->from('pp_users');
				$this->db->where('pp_users.password',md5($this->input->post('password')));
				$this->db->where('pp_users.user_name', $this->input->post('username')); 
				$this->db->or_where('pp_user_details.email', $this->input->post('username')); 
				$this->db->join('pp_user_details', 'pp_user_details.user_id = pp_users.user_id');
				$this->db->limit(1);
				
				$query 		=	$this->db->get();
		
				//if user exists								  
				if ($query->num_rows() === 1) {
					$result		=	$query->row();					
					
					$cur_date = date("Y-m-d G:i:s Z");				
					
					$update_access = array(
										"last_login" => $cur_date										
									);
					$this->db->where('user_id',$result->user_id);
					$this->db->update("pp_users", $update_access);
					
					//for user session
					$dataArr	=	array(
										'logged_in' 	=> TRUE,
										'user_id' 		=> $result->user_id,
										'user_name' 	=> $result->user_name,
										'user_role_id' 	=> $result->user_role_id,
										'first_name'	=>	$result->first_name,
										'last_name'	=>	$result->last_name
									  );
									  
					$this->session->set_userdata($dataArr);
					redirect('members/dashboards');	
										
				}else{
					//invalid user
					$data['error'] = TRUE;
					$data['error_message']	=	'Please enter valid credential.';
				}
				
			}
		}else{			
			redirect('members/dashboards');	
				
		}
				
		$this->load->view('members/login',$data);
	}
	
	// -----------------------------------------------------------------------------------------
	
	/**
	 * This function 'll do logout process and redirect to login page
	 *
	 * @access public
	 * 
	 */
	
	function logout(){
		$this->session->sess_destroy();
		redirect('members/login');
	}
	
	// -----------------------------------------------------------------------------------------
	
	/**
	 * This function 'll create password string
	 *
	 * @access private
	 * @return String password
	 * 
	 */
	
	private function create_new_password(){
		$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$str = '';
		for ($i = 0; $i < 8; $i++){
			$str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
		}
		return $str;
	}
	
	// -----------------------------------------------------------------------------------------
	
	/**
	 * This function 'll do logout process and redirect to login page
	 *
	 * @access public
	 * 
	 */
	
	function forgotPassword(){
		$rules = array(
						array(
							'field'   => 'username',
							'label'   => 'lang:email',
							'rules'   => 'trim|required|valid_email',
						),
						);
						
		$data['error'] 		=	FALSE;
		$data['error_msg'] 	=	'';
		$data['info'] 		=	FALSE;
		$data['info_msg']	=	'';
		
		$this->load->library('form_validation');
		$this->form_validation->set_rules($rules);
		$this->form_validation->set_error_delimiters('<br>');
		
		if ($this->form_validation->run() != FALSE){
			
			$query		=		$this->db->get_where('pp_user_details', 
													array(
														'email'		=> 	$this->input->post('username')
														)
												  );
			//if user exists								  
			if ($query->num_rows() === 1) {
				$result		=	$query->row();
				
				$name = $result->first_name;
				$email = $result->email;
				$new_password = $this->create_new_password();
				$subject_email = 'reset password';
				$new_password		=	$this->create_new_password();
				
				
				
				$body	='Dear '.$name.' The password to access Test pilot project was changed.<br/>
Access information:<br/>Login:'.$email.'<br/>Password:'.$new_password.'<br/>';
				
				if($this->sendmail($email,'support@dineroxlab.com',$subject_email,$body)){
					//Update new password
					$this->db->set(array("password"=>md5($new_password)));
					$this->db->where('user_id', $result->user_id);
					$this->db->update('pp_users');
					
					$data['info'] = TRUE;
					$data['info_msg'] = 'Emai Send Success fully';
				}else{
					$data['error'] = TRUE;
					$data['error_msg'] = 'Error during send mail';
				}			
				
				
			}else{
				$data['error'] = TRUE;
				$data['error_msg'] = 'user does not exists';			
			}
		}
			
		$this->load->view('members/forgot_pass',$data);
	}
	
	private function sendmail($to,$from,$subject,$body){
		$to="$to";
		$headers = "MIME-Version: 1.0\r\n";
		$headers.= "Content-type: text/html; ";
		$headers.= "charset=iso-8859-1\r\n";
		$headers.= "From: $from";
		$subject = "$subject";
		$body = "<HTML><BODY>$body</BODY></HTML>";
				
		if(mail($to,$subject,$body,$headers)){
			return true;
		}else{
			return false;
		}		
	}
	
}

?>