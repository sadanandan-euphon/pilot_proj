<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Members extends MX_Controller {

	/**
	 * constructor
	 *
	 */
	function __construct() {
        parent::__construct();
		
		// setting current controller to the template class
		$this->template->set('controller', $this);
		
		$this->load->model('m_users');
		
		if(!($this->quickauth->logged_in())){
			$this->quickauth->redirect_out_admin();
		}	
    }
	
	// -----------------------------------------------------------------------------------------
	
	/**
	 * This function 'll shows the user list page
	 *
	 * @access public
	 * @param Integer $user_id
	 * @return view of users
	 */
	
	public function index($offset=0){
		$this->load->library('pagination');
		$per_page	=	$this->config->item('admin_per_page');
		$total_rows					=	$this->m_users->getUserDetailsRecordsCount();
		$config['base_url']			=	base_url().'members/dashboards';		
		$config['total_rows'] 		=	$total_rows;
		$config['per_page'] 		=	$per_page;	
		$this->pagination->initialize($config);		
		$data['pagination_links'] 	=	$this->pagination->create_links();
		
		$userDetailsArr		=	$this->m_users->getAllUsersDetails($per_page,$offset);
		$data['userDetailsArr']=	$userDetailsArr;
		
		$this->template->load_partial('members/member_template','dashboards/index',$data);	
	}
	
	// -----------------------------------------------------------------------------------------
	
	/**
	 * This function 'll manage users add edit operations
	 *
	 * @access public
	 * @param String  $operation [add or edit]
	 * @param Integer $user_id
	 * @return view of users add-edit page
	 */
	
	public function userManagement($operation='',$user_id=0){
		
		$data['error']				=	false;	
		$data['message']			=	'';
		
		$logged_user_role_id	=	$this->session->userdata('user_role_id');
		$userPermsArr	=	$this->getUserRolePermissions($logged_user_role_id);
		$data['userPermsArr']		=	$userPermsArr;
		
		$provinceOptions			=	$this->getProviceList();
		$data['provinceOptions']	=	$provinceOptions;
			
		$roleOptions				=	$this->getUserRoleList();
		$data['roleOptions']		=	$roleOptions;
		
		

		$data['userDetailsArr']		=	array();
		
		$data['operation']		=	'none';
		
		if($operation=='add'){
			$data['operation']		=	'add';
			
		}else if($operation=='edit' && $user_id > 0){
			$data['operation']		=	'edit';
			
			$userDetailsArr	=	$this->m_users->getUserDetailsById($user_id);
			
			if(count($userDetailsArr) > 0){
				foreach($userDetailsArr as $usd){
					$user_role		= 	$usd->user_role_id;
					$province_code	=	$usd->province;
					
					$provinceOptions		=	$this->getProviceList($province_code);
					$data['provinceOptions']	=	$provinceOptions;
						
					$roleOptions		=	$this->getUserRoleList($user_role);
					$data['roleOptions']	=	$roleOptions;					
				}
				
				
			}else{
				$data['error']				=	true;	
				$data['message']			=	'No such user. Please enter valid user id.';
			}
			
			$data['userDetailsArr']	=	$userDetailsArr;
		}else{
			$data['error']				=	true;	
			$data['message']			=	'No such user. Please enter valid user id.';
		}
		
		if($this->input->post()){
			$post_operation		=	trim($this->input->post('hidOperation'));
			$post_user_id		=	trim($this->input->post('hidUserId'));
			
			$first_name		=	trim($this->input->post('txtFirstName'));
			$last_name		=	trim($this->input->post('txtLastName'));			
			$email			=	trim($this->input->post('txtEmail'));			
			$address		=	trim($this->input->post('txtAddress'));			
			$city			=	trim($this->input->post('txtCity'));
			$province		=	trim($this->input->post('sltProvince'));			
			$postCode		=	trim($this->input->post('txtPostCode'));
			$phone			=	trim($this->input->post('txtPhone'));
			$user_name		=	trim($this->input->post('txtUserId'));
			$password		=	trim($this->input->post('txtPassword'));
			$user_role_id		=trim($this->input->post('sltUserRole'));
			$birth_date		=	trim($this->input->post('txtBirthDate'));
			
			$birthDateArr	=	explode('/',$birth_date);
			$birth_date		=	$birthDateArr[2].'-'.$birthDateArr[0].'-'.$birthDateArr[1];
			
			$password		=	$password!=''?md5($password):'';
			
			$exists_email		=	$this->quickauth->_useremail_exists($email,$post_user_id);
			$exists_user_name	=	$this->quickauth->_username_exists($user_name,$post_user_id);
			
			if($exists_email){
				$data['error']				=	true;	
				$data['message']			=	'This email already taken. Choose another one.';
				
			}else if($exists_user_name){
				$data['error']				=	true;	
				$data['message']			=	'This user name already taken. Choose another one.';
			}else{
			
			if($post_operation	==	'add'){						
				$insertUserArr	=array(
					'user_name'=>$user_name,
					'password'	=>$password,
					'user_role_id'=>$user_role_id,
					'status'		=>1,
					'created_date'	=>	date("Y-m-d")
				);
				$user_id	=	$this->m_users->insertUser($insertUserArr);
				
				if($user_id > 0){							
					$insertUserDetailsArr	=array(
						'user_id'=>$user_id,
						'first_name'	=>$first_name,
						'last_name'=>$last_name,
						'email'		=>$email,
						'address'=>$address,
						'city'	=>$city,
						'province'=>$province,
						'post_code'		=>$postCode,
						'phone'	=>$phone,
						'birth_date'=>$birth_date,
						'last_modified'	=>	date("Y-m-d G:i:s Z")
					);
					
					$user_details_id	=	$this->m_users->insertUserDetails($insertUserDetailsArr);
					
					if($user_details_id > 0){
						redirect('members/dashboards');	
					}
				}
			
			}else if(($post_operation	==	'edit') && ($post_user_id > 0)){
				$updateUserArr	=array(
					'user_name'=>$user_name,
					'user_role_id'=>$user_role_id,
					'status'		=>1
				);
				
				if($password!=''){
					$updateUserArr['password']	=	$password;
				}
				
				$update_status	=	$this->m_users->updateUser($user_id,$updateUserArr);
				
				$updateUserDetailsArr	=array(
					'first_name'	=>$first_name,
					'last_name'=>$last_name,
					'email'		=>$email,
					'address'=>$address,
					'city'	=>$city,
					'province'=>$province,
					'post_code'		=>$postCode,
					'phone'	=>$phone,
					'birth_date'=>$birth_date,
					'last_modified'	=>	date("Y-m-d G:i:s Z")
				);
					
				$update_status_1	=	$this->m_users->updateUserDetails($user_id,$updateUserDetailsArr);
					
				if($update_status_1){
					redirect('members/dashboards');	
				}
			}
			}
			
		}
		
		$this->template->load_partial('members/member_template','dashboards/add-edit-user',$data);	
		
	}
	
	// -----------------------------------------------------------------------------------------
	
	/**
	 * This function 'll show the selected user details
	 *
	 * @access public
	 * @param Integer $user_id
	 * @return view of users details page
	 */
	
	public function viewUserDetails($user_id=0){
		
		$data['error']				=	false;	
		$data['message']			=	'';
		
		$data['userDetailsArr']		=	array();
		
		$data['operation']		=	'none';
		
		if($user_id > 0){
			
			$userDetailsArr	=	$this->m_users->getUserDetailsById($user_id);
			
			if(count($userDetailsArr) > 0){
				foreach($userDetailsArr as $usd){
					$user_role		= 	$usd->user_role_id;
					$province_code	=	$usd->province;
					
					$provinceOptions		=	$this->getProviceList($province_code);
					$data['provinceOptions']	=	$provinceOptions;
						
					$roleOptions		=	$this->getUserRoleList($user_role);
					$data['roleOptions']	=	$roleOptions;					
				}
				
				
			}else{
				$data['error']				=	true;	
				$data['message']			=	'No such user. Please enter valid user id.';
			}
			
			$data['userDetailsArr']	=	$userDetailsArr;
		}else{
			$data['error']				=	true;	
			$data['message']			=	'No such user. Please enter valid user id.';
		}
		
		$this->template->load_partial('members/member_template','dashboards/view-user',$data);	
		
	}
	
	// -----------------------------------------------------------------------------------------
	
	/**
	 * This function 'll show the selected user details for delete 
	 *
	 * @access public
	 * @param Integer $user_id
	 * @return view of users details delete page
	 */
	
	public function viewUserDetailsDeleteView($user_id=0){
		
		$data['error']				=	false;	
		$data['message']			=	'';
		
		$data['userDetailsArr']		=	array();
		
		$data['operation']		=	'none';
		
		if($user_id > 0){
			
			$userDetailsArr	=	$this->m_users->getUserDetailsById($user_id);
			
			if(count($userDetailsArr) > 0){
				foreach($userDetailsArr as $usd){
					$user_role		= 	$usd->user_role_id;
					$province_code	=	$usd->province;
					
					$provinceOptions		=	$this->getProviceList($province_code);
					$data['provinceOptions']	=	$provinceOptions;
						
					$roleOptions		=	$this->getUserRoleList($user_role);
					$data['roleOptions']	=	$roleOptions;					
				}
				
				
			}else{
				$data['error']				=	true;	
				$data['message']			=	'No such user. Please enter valid user id.';
			}
			
			$data['userDetailsArr']	=	$userDetailsArr;
		}else{
			$data['error']				=	true;	
			$data['message']			=	'No such user. Please enter valid user id.';
		}
		
		$this->template->load_partial('members/member_template','dashboards/view-user-delete',$data);	
		
	}
	
	// -----------------------------------------------------------------------------------------
	
	/**
	 * This function 'll get users province options list html
	 *
	 * @access public
	 * @param Integer $selected
	 * @return String $result
	 */
	
	function getProviceList($selected	=	''){
		$result		=	'';
		$optSelect		=	'';
		$provinceListArr	=	$this->m_users->getAllProvice();
		 foreach($provinceListArr as $dt){
			$optSelect	=	$selected==$dt->province_code?$optSelect='selected="selected"':'';
			$result.=	'<option value="'.$dt->province_code.'" '.$optSelect.'>'.$dt->province_name.'</option>';			
		}
		
		return $result;		 
		
	}
	
	// -----------------------------------------------------------------------------------------
	
	/**
	 * This function 'll get users role options list html
	 *
	 * @access public
	 * @param Integer $selected
	 * @return String $result
	 */
	
	function getUserRoleList($selected	=	''){
		$result		=	'';
		$optSelect		=	'';
		$userRoleListArr	=	$this->m_users->getAllUserRoles();
		 foreach($userRoleListArr as $dt){
			$optSelect	=	$selected==$dt->user_role_id?$optSelect='selected="selected"':'';
			$result.=	'<option value="'.$dt->user_role_id.'" '.$optSelect.'>'.$dt->user_role_name.'</option>';			
		}
		
		return $result;		 
		
	}
	
	// -----------------------------------------------------------------------------------------
	
	/**
	 * This function 'll get userss roles based on role id
	 *
	 * @access public
	 * @param Integer $user_role_id
	 * @return Array $rolesArr
	 */
	
	function getUserRolePermissions($user_role_id){
		$rolesArr	=	array();
		$userRoleArr	=	$this->m_users->getUserRolePermissions($user_role_id)	;
		foreach($userRoleArr as $ur){
			$rolesArr[]	=	$ur->permission_id;
		}
		
		return $rolesArr;
	}
	
	// -----------------------------------------------------------------------------------------
	
	/**
	 * This function 'll display users details of matched search criteria
	 *
	 * @access public
	 * @param Integer $offset
	 * @return view search users page
	 */
	
	public function search($offset=0){
		$this->load->library('pagination');
		$per_page				=	$this->config->item('admin_per_page');// get global pagination limit
		$offset = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
		
		$resultArr =array();
		//To check value is submitted from form otherwise set the session and get the values in session
		if($this->input->post()){
			$search_str			= trim($this->input->post('txtSearch'));
						
			$resultArr = array('last_name'=> $search_str);
			$this->session->set_userdata('searchData',$resultArr);
		}
		
		if(!$this->input->post()){
			$resultArr = $this->session->userdata('searchData');
			
		}	
		
		$total_rows = $this->m_users->getRecordsCountOfUsersDetailsBySearch($resultArr,$per_page,$offset);
		$config['base_url'] 		= 	base_url().'members/dashboards/search';
		$config['total_rows'] 		= 	$total_rows;
		$config['per_page'] 		= 	$per_page;
		$config['uri_segment']      =   4;// current url segment used for pagination. 
		$this->pagination->initialize($config); 		
		$data['pagination_links'] 	=	$this->pagination->create_links();
		$userDetailsArr			=	$this->m_users->getAllUsersDetailsBySearch($resultArr,$per_page,$offset);
		$data['userDetailsArr']	=	$userDetailsArr;
		
		$data['searchStr']		= $resultArr['last_name'];
		
		$this->template->load_partial('members/member_template','dashboards/index',$data);	
		
	}
	
	// -----------------------------------------------------------------------------------------
	
	/**
	 * This function 'll delete user
	 *
	 * @access public
	 * @return array $resultArr
	 */
	public function deleteUser(){
		
		$resultArr	=	array();
			
		$resultArr['status']	=	false;
		$resultArr['error_message']	=	'';
		
		if($this->input->post()){
			$user_id			= trim($this->input->post('user_id'));
			$logged_user_id	=	$this->session->userdata('user_id');
			
						
			if($user_id > 0){			

				if($user_id != $logged_user_id){
					
					if($this->checkPermission('delete')){
						$this->m_users->deleteUserById($user_id);
					}else{
						$resultArr['status']	=	true;
						$resultArr['error_message']	=	'You do not have enough permission to delete records.';
					}				
				}else{
					$resultArr['status']	=	true;
					$resultArr['error_message']	=	'This is your profile.';
				}
			}
			
		}
		echo json_encode($resultArr);		
		
	}
	
	// -----------------------------------------------------------------------------------------
	
	/**
	 * This function 'll check the user permissions
	 *
	 * @access public<br />
	 * @param String $operation
	 * @param Integer $call_typ [0 -call withing controller, 1-client side request]
	 * @return array $resultArr
	 */
	public function checkPermission($operation,$call_type=0){
		$resultArr['status']	=	false;
		
		$logged_user_role_id	=	$this->session->userdata('user_role_id');
		$userPermsArr			=	$this->getUserRolePermissions($logged_user_role_id);
		
		if($operation=='delete'){
			if(in_array('3',$userPermsArr)){
				$resultArr['status']	=	true;
			}
		}else if($operation=='edit'){
			if(in_array('2',$userPermsArr)){
				$resultArr['status']	=	true;
			}
		}else if($operation=='add'){
			if(in_array('1',$userPermsArr)){
				$resultArr['status']	=	true;
			}
		}		
		
		if($call_type==1){
			echo json_encode($resultArr);		
		}else{
			return $resultArr['status'];
		}
		
	}
	
}
