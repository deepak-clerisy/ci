<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth{

  private $ci;
  
 function __construct()
 {
     $this->ci =& get_instance();
     $this->ci->load->database();
     $this->ci->load->library("session");
 }

 function get_userdata()
 {
     
     if( ! $this->logged_in())
     {
         return false;
     }
     else
     {
          $query = $this->ci->db->get_where("users", array("id" => $this->ci->session->userdata("user_id")));
          return $query->row_array();
     }
 }
 
  function get_userrole()
 {
     
     if( ! $this->logged_in())
     {
         return false;
     }
     else
     {
		  $this->ci->db->select('level');
          $query = $this->ci->db->get_where("users", array("id" => $this->ci->session->userdata("user_id")));
          return $query->row()->level;
     }
 }
 

 function logged_in()
 {
     
     return ($this->ci->session->userdata("user_id")) ? true : false;
 }




 function login($email, $password)
 {
     $data = array(
         "email" => $email,
         "password" => md5($password)
     );

     $query = $this->ci->db->get_where("users", $data);
	
     if($query->num_rows() !== 1)
     {
        
         return false;
     }
     else
     {
         //update the last login time
         $last_login = date("Y-m-d H-i-s");

         $data = array(
             "last_login" => $last_login
         );
		 $this->ci->db->where('id',$query->row()->id);
         $this->ci->db->update("users", $data);
			
         //store user id in the session
         $this->ci->session->set_userdata("user_id", $query->row()->id);

         return true;
     }
 }
 
 
 function change_password($old_pass,$new_pass)
 {
	 $user_id=$this->ci->session->userdata("user_id"); 
	 $data=array("id"=>$user_id,"password"=>md5($old_pass));
	 $this->ci->db->where($data);
	 $query=$this->ci->db->get('users');
	 $this->ci->db->last_query();   
	 if($query->num_rows())
	 {
		 $new_data=array("password"=>md5($new_pass),"modify_date"=>date('Y-m-d H:i:s'));
		 $this->ci->db->where('id',$user_id);		 
		 $this->ci->db->update("users", $new_data);
		 
		 return true;
	 } 
	 else
	 { 
		 return FALSE;
	 }	 
 }
 
 
 function add_user($data)
 {	 
	return  $this->ci->db->insert('users',$data);
 }

 function logout()
 {
     $this->ci->session->unset_userdata("user_id");
     return true;
 }

}
