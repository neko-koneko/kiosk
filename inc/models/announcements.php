<?php

class AnnouncementsModel{	private $db;

	function __construct (){		global $db;		$this->db = $db;	}

	public function getAnnouncement($id){
		$result = array();

  		$query = $this->db->from('announcements')->where(array('id'=>$id))->get();
  		//echo $this->db->last_query();
        return $query->row_array();
	}


	public function getAnnouncements($params){
		$result = array();

        $selectParams = $params['where'];

		$orderBy = $params['orderBy'];
		$orderType = $params['orderType'];

        $orderBy = (empty($orderBy))?'id':$orderBy;
		$orderType = ($orderType=='desc')?'desc':'asc';

		/*$limit  = empty($params['limit'])?3:$params['limit'];
		$offset = empty($params['offset'])?0:$params['offset'];/**/

  		if (!empty($selectParams)){  			 $this->db->where($selectParams);
  		}

  		if ((!empty($limit))||(!empty($offset))){  			$this->db->limit($limit,$offset);  		}
  		if (!empty($limit)){
  			$this->db->limit($limit);
  		}

  		$query = $this->db->order_by($orderBy,$orderType)->get('announcements');

  		//echo 'Q='.$this->db->last_query(); die;

        foreach ($query->result_array() as $row)
		{
		   $result[] = $row;
		}
		return $result;
	}

	public function enable($id){
  		$query = $this->db->where('id',$id)->set('available','Y')->update('announcements');
	}

	public function disable($id){
  		$query = $this->db->where('id',$id)->set('available','N')->update('announcements');
	}

	public function delete($id){
  		$query = $this->db->where('id',$id)->delete('announcements');
	}

	public function save($id,$data){  		$query = $this->db->where('id',$id)->set($data)->update('announcements');
	}
	public function insert($data){
  		$query = $this->db->insert('announcements',$data);
	}
}


?>