<?php

class MenuModel{	private $db;

	function __construct (){		global $db;		$this->db = $db;	}

	public function getMenuList(){
		$result = array();
  		$query = $this->db->from('menu')->order_by('ord asc')->get();
        foreach ($query->result_array() as $row)
		{
		   $result[] = $row;
		}
		return $result;
	}

	public function getTopMenuItem(){
		$result = array();
  		$query = $this->db->from('menu')->order_by('ord asc')->limit(1)->get();
        return $query->row_array();
	}

	public function getMenu($id){		$result = array();

  		$query = $this->db->from('menu')->where(array('id'=>$id))->get();
  		//echo $this->db->last_query();
        return $query->row_array();
	}

	public function getMenuLastOrd(){		$result = array();

  		$query = $this->db->from('menu')->select('ord')->order_by('ord desc')->limit(1)->get();
  		//echo $this->db->last_query();
        $result = $query->row_array();
        return $result['ord'];
	}

	public function enable($id){
  		$query = $this->db->where('id',$id)->set('available','Y')->update('menu');
	}

	public function disable($id){
		if ($id==1){return;}
  		$query = $this->db->where('id',$id)->set('available','N')->update('menu');
	}

	public function delete($id){
		if ($id==1){return;}
  		$query = $this->db->where('id',$id)->delete('menu');
	}

	public function save($id,$data){
  		$query = $this->db->where('id',$id)->set($data)->update('menu');
	}

	public function insert($data){
		$ord = $this->getMenuLastOrd();
		$data['ord']=$ord+1;
  		$query = $this->db->insert('menu',$data);
	}

	public function updateStructure($data){		$ord = 1;		foreach ($data as $id){           $query = $this->db->where('id',$id)->set('ord',$ord)->update('menu');
           $ord++;		}	}
}


?>