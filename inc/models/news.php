<?php

class NewsModel{	private $db;

	function __construct (){		global $db;		$this->db = $db;	}

	public function getNewsList(){
		$result = array();
  		$query = $this->db->from('news')->order_by('ord asc')->get();
        foreach ($query->result_array() as $row)
		{
		   $result[] = $row;
		}
		return $result;
	}

	public function getNews($id){		$result = array();

  		$query = $this->db->from('news')->where(array('id'=>$id))->get();
  		//echo $this->db->last_query();
        return $query->row_array();
	}

}


?>