<?php
class M_users extends CI_Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
	
	// -----------------------------------------------------------------------------------------
	/**
	*This function 'll get province
	*
	* @return Array $result 
	*/	
	
	function getAllProvice(){
		$this->db->select('*');	
		$query		=	$this->db->get('pp_province');
		$result		=	$query->result();		
		return $result;		
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	*This function 'll get all user roles
	*
	* @return Array $result 
	*/	
	function getAllUserRoles(){
		$this->db->select('*');	
		$query		=	$this->db->get('pp_user_role');
		$result		=	$query->result();		
		return $result;		
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	*This function 'll insert user.
	*
	* @access public
	* @param array $dataArr
	* @return $insert_id 
	*/	
	
    function insertUser($dataArr){
		$query		=	$this->db->insert('pp_users',$dataArr);
		$insert_id	=	$this->db->insert_id();
		return $insert_id;
    }
	
	// -----------------------------------------------------------------------------------------
	/**
	*This function 'll insert user details.
	*
	* @access public
	* @param array $dataArr
	* @return $insert_id 
	*/	
	
    function insertUserDetails($dataArr){
		$query		=	$this->db->insert('pp_user_details',$dataArr);
		$insert_id	=	$this->db->insert_id();
		return $insert_id;
    }
	
	// -----------------------------------------------------------------------------------------
	/**
	*This function 'll update user.
	*
	* @access public
	* @param Integer $user_id
	* @param array $dataArr
	* @return true/false
	*/	
	
    function updateUser($user_id,$dataArr){
		$this->db->where('user_id',$user_id);
		$this->db->update('pp_users',$dataArr);
		return true;
    }
	
	// -----------------------------------------------------------------------------------------
	/**
	*This function 'll update user details.
	*
	* @access public
	* @param Integer $user_id
	* @param array $dataArr
	* @return true/false
	*/	
	
    function updateUserDetails($user_id,$dataArr){
		$this->db->where('user_id',$user_id);
		$this->db->update('pp_user_details',$dataArr);
		return true;
    }
	
	
	// -----------------------------------------------------------------------------------------
	/**
	*This function 'll get selected user details by id.
	*
	* @access public
	* @param Integer $user_id
	* @return $result as array 
	*/	
	
    function getUserDetailsById($user_id){
		$recordArr		=	array();
		$this->db->select("pp_users.*,pp_user_details.*");
		$this->db->from('pp_users');
		$this->db->where('pp_users.user_id',$user_id);
		$this->db->join('pp_user_details', 'pp_user_details.user_id = pp_users.user_id');
		$this->db->limit(1);
		$query 		=	$this->db->get();
		$result 	=	$query->result();
		
		foreach($result as $user){
			$data		= array(	'user_id'					=>	$user->user_id,
									'user_name'					=>	$user->user_name,
									'password'					=>	$user->password,
									'user_role_id'				=>	$user->user_role_id,
									'status'					=>	$user->status,
									'created_date'				=>	$user->created_date,
									'last_login'				=>	$user->last_login,
									'user_details_id'			=>	$user->user_details_id,
									'first_name'				=>	$user->first_name,
									'last_name'					=>	$user->last_name,
									'email'						=>	$user->email,
									'address'					=>	$user->address,
									'city'						=>	$user->city,
									'province'					=>	$user->province,
									'post_code'					=>	$user->post_code,
									'phone'						=>	$user->phone,
									'birth_date'				=>	$user->birth_date,
									'last_modified'				=>	$user->last_modified
			);
				
			array_push($recordArr,$data);
		
		}
		
		return $result;
    }
	
	// -----------------------------------------------------------------------------------------
	
	/**
	*This function 'll get permissions by role id.
	*
	* @access public
	* @param Integer $role_id
	* @return $result array of user groups
	*/	
    
    function getUserRolePermissions($role_id){
		$this->db->select("`user_role_permissions_id`, `user_role_id`, `permission_id`");
		$this->db->where('user_role_id',$role_id);
	 	$query		=	$this->db->get('pp_user_role_permissions');
		$result 	=	$query->result();
		return $result;
    }
	
	// -----------------------------------------------------------------------------------------
	/**
	*This function 'll get all user details.
	*
	* @access public
	* @param Integer $user_id
	* @return $result as array 
	*/	
	
    function getUserDetails(){
		$recordArr		=	array();
		$this->db->select("pp_users.*,pp_user_details.*");
		$this->db->from('pp_users');
		$this->db->join('pp_user_details', 'pp_user_details.user_id = pp_users.user_id');
		$query 		=	$this->db->get();
		$result 	=	$query->result();
		
		foreach($result as $user){
			$data		= array(	'user_id'					=>	$user->user_id,
									'user_name'					=>	$user->user_name,
									'password'					=>	$user->password,
									'user_role_id'				=>	$user->user_role_id,
									'status'					=>	$user->status,
									'created_date'				=>	$user->created_date,
									'last_login'				=>	$user->last_login,
									'user_details_id'			=>	$user->user_details_id,
									'first_name'				=>	$user->first_name,
									'last_name'					=>	$user->last_name,
									'email'						=>	$user->email,
									'address'					=>	$user->address,
									'city'						=>	$user->city,
									'province'					=>	$user->province,
									'post_code'					=>	$user->post_code,
									'phone'						=>	$user->phone,
									'birth_date'				=>	$user->birth_date,
									'last_modified'				=>	$user->last_modified
			);
				
			array_push($recordArr,$data);
		
		}
		
		return $result;
    }
	
	//-------------------------------------------------------------------------------------------------------------------------------------------------
	/*
	*	This function 'll  get users list
	*
	* @param Integer $limit
	* @param Integer $offset
	* @return array	contain records
	*/
	
	function getAllUsersDetails($limit = 25, $offset = 0){
		$records	=	array();
		$this->db->select("pp_users.*,pp_user_details.*");
		$this->db->from('pp_users');
		$this->db->join('pp_user_details', 'pp_user_details.user_id = pp_users.user_id');
		
		$this->db->limit($limit,$offset);
		
		$query 		=	$this->db->get();
		$result 	=	$query->result();
		
		foreach($result as $user){
			$data		= array(	'user_id'					=>	$user->user_id,
									'user_name'					=>	$user->user_name,
									'password'					=>	$user->password,
									'user_role_id'				=>	$user->user_role_id,
									'status'					=>	$user->status,
									'created_date'				=>	$user->created_date,
									'last_login'				=>	$user->last_login,
									'user_details_id'			=>	$user->user_details_id,
									'first_name'				=>	$user->first_name,
									'last_name'					=>	$user->last_name,
									'email'						=>	$user->email,
									'address'					=>	$user->address,
									'city'						=>	$user->city,
									'province'					=>	$user->province,
									'post_code'					=>	$user->post_code,
									'phone'						=>	$user->phone,
									'birth_date'				=>	$user->birth_date,
									'last_modified'				=>	$user->last_modified
			);
				
			array_push($records,$data);
		
		}
		return $records;
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	*This function 'll get the number users of records.
	*
	* @return number of rows or zero
	*/	
	
    function getUserDetailsRecordsCount(){		
		$this->db->select("pp_users.*,pp_user_details.*");
		$this->db->from('pp_users');
		$this->db->join('pp_user_details', 'pp_user_details.user_id = pp_users.user_id');
		$query 		=	$this->db->get();
		//check and return the number of records
		if($query->num_rows() > 0){
			return (int)$query->num_rows();
		}else{
			return 0;
		}
    }
	
	//-------------------------------------------------------------------------------------------------------------------------------------------------
	/*
	*	This function 'll  get users list with search criteria
	*
	* @param Array $data
	* @param Integer $limit
	* @param Integer $offset
	* @return array	contain records
	*/
	
	function getAllUsersDetailsBySearch($data,$limit = 25, $offset = 0){
		$records	=	array();
		$this->db->select("pp_users.*,pp_user_details.*");
		$this->db->from('pp_users');
		
		if(!empty($data)){
			if($data['last_name']!=''){
				$this->db->where('pp_user_details.last_name',$data['last_name']);
			}
		}
		$this->db->join('pp_user_details', 'pp_user_details.user_id = pp_users.user_id');
		
		$this->db->limit($limit,$offset);
		
		$query 		=	$this->db->get();
		$result 	=	$query->result();
		
		foreach($result as $user){
			$data		= array(	'user_id'					=>	$user->user_id,
									'user_name'					=>	$user->user_name,
									'password'					=>	$user->password,
									'user_role_id'				=>	$user->user_role_id,
									'status'					=>	$user->status,
									'created_date'				=>	$user->created_date,
									'last_login'				=>	$user->last_login,
									'user_details_id'			=>	$user->user_details_id,
									'first_name'				=>	$user->first_name,
									'last_name'					=>	$user->last_name,
									'email'						=>	$user->email,
									'address'					=>	$user->address,
									'city'						=>	$user->city,
									'province'					=>	$user->province,
									'post_code'					=>	$user->post_code,
									'phone'						=>	$user->phone,
									'birth_date'				=>	$user->birth_date,
									'last_modified'				=>	$user->last_modified
			);
				
			array_push($records,$data);
		
		}
		return $records;
	}
	
	// -----------------------------------------------------------------------------------------
	/**
	*This function 'll get the number of users records by the search criteria.
	*
	* @param Array $data
	* @return number of rows or zero
	*/	
	
    function getRecordsCountOfUsersDetailsBySearch($data){		
		$this->db->select("pp_users.*,pp_user_details.*");
		$this->db->from('pp_users');
		
		if(!empty($data)){
			if($data['last_name']!=''){
				$this->db->where('pp_user_details.last_name',$data['last_name']);
			}
		}
		
		$this->db->join('pp_user_details', 'pp_user_details.user_id = pp_users.user_id');
		$query 		=	$this->db->get();
		//check and return the number of records
		if($query->num_rows() > 0){
			return (int)$query->num_rows();
		}else{
			return 0;
		}
    }
	
	// -----------------------------------------------------------------------------------------
	/**
	*This function 'll delete user details.
	*
	* @param Integer $user_id
	* @return number of rows or zero
	*/	
	
    function deleteUserById($user_id){		
		$this->db->where('user_id',$user_id);
		$this->db->delete('pp_user_details');
		
		$this->db->where('user_id',$user_id);
		$this->db->delete('pp_users');
		
		return true;
    }
}
?>