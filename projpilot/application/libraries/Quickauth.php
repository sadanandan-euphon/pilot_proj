<?php
/*
* @Package Quick Authentication Library
* @author David Blencowe
* @link http://www.syntaxmonster.net
* @version 1.0.0
* @since Version 1.0.0
*/
class Quickauth
{
    var $CI;
    var $_username;
	var $_language=1;// global variable for handling language
    var $_table = array(
                    'users' => 'pp_users'
                    );

    function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('url');
        $this->CI->load->helper('email');
        $this->CI->load->helper('string');
	}

	
    function Quickauth()
    {
        self::__construct();
    }
	
	function is_admin(){
		if($this->CI->session->userdata('user_role_id') == 1){
			return true;	
		}else{
			return false;
		}
	}
	
	
	function redirect_out_admin(){
		redirect(base_url().'members/login');
	}
	
	// -----------------------------------------------------------------------------------------
	
	/**
    * Check the database too see if the user email that is passed to the function exists.
    * @param String $email
	* @param Integer $user_id , by default it will be zero
    * @return TRUE/FALSE
    */
    function _useremail_exists($email,$user_id=0){
        $this->CI->db->where('email', $email);
		//if user id provided
		if($user_id > 0){
			$this->CI->db->where('user_id <>', $user_id);
		}
        $this->CI->db->limit(1);
        $query = $this->CI->db->get('pp_user_details');

        if ($query->num_rows() !== 1){
            return FALSE;
        }else{
			return TRUE;
        }
    }
	
	// -----------------------------------------------------------------------------------------

    /**
    * Check the database too see if the username that is passed to the function exists.
    * If it does then it is set to the global $_username variable for later use
    * @param String $username
    * @return TRUE/FALSE
    */
    function _username_exists($username ,$user_id=0)
    {
        $this->CI->db->where('user_name', $username);
		
		//if user id provided
		if($user_id > 0){
			$this->CI->db->where('user_id <>', $user_id);
		}
		
        $this->CI->db->limit(1);
        $query = $this->CI->db->get($this->_table['users']);

        if ($query->num_rows() !== 1)
        {
            return FALSE;
        }
        else
        {
            $this->_username = $username;
            return TRUE;
        }
    }
	
	// -----------------------------------------------------------------------------------------

    /**
    * Returns the number of characters in a string after it has been trimemd for
    * whitespace.
    * @param String $string
    * @return Int
    */
    function check_string_length( $string )
    {
        $string = trim($string);
        return strlen($string);
    }
	

	// -----------------------------------------------------------------------------------------

    /**
    * Check if a user is logged in
    *
    * @access public
    * @param string
    * @return bool
    */
    function logged_in()
    {
        return $this->CI->session->userdata('logged_in');
    }
	
	// -----------------------------------------------------------------------------------------

    /**
    * Log a user out (destroy all session variables)
    *
    * @access public
    */
    function logout()
    {
		$this->CI->session->sess_destroy();
    }	
	
}

/* End of file Quickauth.php */
/* Location: ./application/libraries/Quickauth.php */