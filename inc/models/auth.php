<?php

class AuthModel{	private $db;

	function __construct (){		global $db;		$this->db = $db;	}

	public function auth($login,$password){
  		$query = $this->db->from('admin_users')->where('login',$login)->get();
        if ($query->num_rows() > 0){

	        $row = $query->row_array();

    	    $hash = $row['password'];
    	    if (empty($hash)){    	    	return false;    	    }

    	    return password_verify($password,$hash);

        }else{        	return false;        }
	}

	public function update($login,$password){
		$options = array('cost' => 14);
		$hash = password_hash($password,PASSWORD_DEFAULT,$options );
		if (!$hash){return false;}
  		return $this->db->set('password',$hash)->where('login',$login)->update('admin_users');
	}

	public function reg($login,$password){		$query = $this->db->from('admin_users')->where('login',$login)->get();
        if ($query->num_rows() > 0){        	return false;        }

		$options = array('cost' => 14);
		$hash = password_hash($password,PASSWORD_DEFAULT,$options );
		if (!$hash){return false;}
  		return $this->db->set('password',$hash)->set('login',$login)->insert('admin_users');
	}
}


?>