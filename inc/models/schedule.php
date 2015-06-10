<?php

class ScheduleModel{	private $db;

	function __construct (){		global $db;		$this->db = $db;	}

	public function getScheduleTypes(){
		$default = array('students'=>'Расписание для учащихся','teachers'=>'Расписание для преподавателей');
		if ($this->hasChanges()){			$default['changes/students']='Замены для учащихся';
			$default['changes/teachers']='Замены для преподавателей';		}
		return $default;
	}

	public function getScheduleClassList(){
		$result = array();
  		$query = $this->db->from('schedule')->select('class_num, class_letter')->distinct()->order_by('class_num asc, class_letter asc')->get();
        foreach ($query->result_array() as $row)
		{
		   $result[] = $row;
		}
		return $result;
	}

	public function getStudentsSchedule($classNum,$classLetter){		$result = array();
  		$query = $this->db->from('schedule')->where(array('class_num'=>$classNum, 'class_letter'=>$classLetter))->get();
  		//echo $this->db->last_query();
        foreach ($query->result_array() as $row)
		{
		   $result[] = $row;
		}
		return $result;
	}

	public function getTeacherList(){		$result = array();
  		$query = $this->db->from('schedule')->select('teacher_name')->distinct()->order_by('teacher_name asc')->get();
        foreach ($query->result_array() as $row)
		{
		   if ($row['teacher_name']==''){continue;}
		   $result[] = $row;
		}
		return $result;	}

	public function getTeacherSchedule($teacherName){		$result = array();
  		$query = $this->db->from('schedule')->where(array('teacher_name'=>$teacherName))->get();
  		//echo $this->db->last_query();
        foreach ($query->result_array() as $row)
		{
		   $result[] = $row;
		}
		return $result;	}

	public function clearSchedule($mode){		switch($mode){			case 'low':{				$this->db->query('DELETE FROM `schedule` WHERE `class_num` < 5');
				//echo "Q=".$this->db->last_query();die;
				break;			}			case 'high':{
				$this->db->query('DELETE FROM `schedule` WHERE `class_num` >= 5');
				//echo "Q=".$this->db->last_query();die;
				break;
			}
			default:{
				$this->db->empty_table('schedule');
				//echo "Q=".$this->db->last_query();die;
				break;
			}
		}	}

	public function clearScheduleChanges(){		$this->db->empty_table('schedule_changes');
	}

	public function getChangesTeacherList(){		$result = array();

		$nowStr = date('Y-m-d');
  		$maxForwardStr = date('Y-m-d', strtotime("+6 days"));

  		$query = $this->db->from('schedule_changes')->select('teacher_name')
				->where('date >=',$nowStr)->where('date <=',$maxForwardStr)
  				->distinct()->order_by('teacher_name asc')->get();

        foreach ($query->result_array() as $row)
		{
		   if ($row['teacher_name']==''){continue;}
		   $result[$row['teacher_name']] = $row;
		}

       //$result = array();

		$query = $this->db->query("SELECT DISTINCT `schedule`.`teacher_name` as teacher_name FROM `schedule_changes`,`schedule`
									WHERE `schedule_changes`.`class_num` = `schedule`.`class_num`
									AND  `schedule_changes`.`class_letter` = `schedule`.`class_letter`
									AND   WEEKDAY(`schedule_changes`.`date`) = (`schedule`.`day_of_week` - 1)
									AND  `schedule_changes`.`time_slot` = `schedule`.`time_slot`
                                    AND `schedule_changes`.`date` >= '".$nowStr."'
                                    AND `schedule_changes`.`date` <= '".$maxForwardStr."'
									");

		//echo $this->db->last_query(); die;
        foreach ($query->result_array() as $row)
		{
		   if ($row['teacher_name']==''){continue;}
		   $result[$row['teacher_name']] = $row;
		}
		ksort($result);

		return $result;	}


	public function getRemovedItemsByTeacher($teacherName){
		$result = array();

		$nowStr = date('Y-m-d');
  		$maxForwardStr = date('Y-m-d', strtotime("+6 days"));

        $result = array();

		$query = $this->db->query("SELECT DISTINCT `schedule`.*, `schedule_changes`.`new_subject` as new_subject,
									`schedule_changes`.`date` as date, `schedule_changes`.`room` as new_room, `schedule_changes`.`teacher_name` as new_teacher_name
									FROM `schedule_changes`,`schedule`
									WHERE `schedule_changes`.`class_num` = `schedule`.`class_num`
									AND  `schedule_changes`.`class_letter` = `schedule`.`class_letter`
									AND   WEEKDAY(`schedule_changes`.`date`) = (`schedule`.`day_of_week` - 1)
									AND  `schedule_changes`.`time_slot` = `schedule`.`time_slot`
                                    AND `schedule_changes`.`date` >= '".$nowStr."'
                                    AND `schedule_changes`.`date` <= '".$maxForwardStr."'
                                    AND `schedule`.`teacher_name` = ".$this->db->escape($teacherName)."
									");

		//echo $this->db->last_query(); die;
        foreach ($query->result_array() as $row)
		{
		   $result[] = $row;
		}

		return $result;
	}


	public function getAddedItemsByTeacher($teacherName){
		$result = array();

		$nowStr = date('Y-m-d');
  		$maxForwardStr = date('Y-m-d', strtotime("+6 days"));

        $result = array();

		$query = $this->db->query("SELECT DISTINCT `schedule`.*, `schedule_changes`.`new_subject` as new_subject,
									`schedule_changes`.`date` as date, `schedule_changes`.`room` as new_room, `schedule_changes`.`teacher_name` as new_teacher_name
									FROM `schedule_changes`,`schedule`
									WHERE `schedule_changes`.`class_num` = `schedule`.`class_num`
									AND  `schedule_changes`.`class_letter` = `schedule`.`class_letter`
									AND   WEEKDAY(`schedule_changes`.`date`) = (`schedule`.`day_of_week` - 1)
									AND  `schedule_changes`.`time_slot` = `schedule`.`time_slot`
                                    AND `schedule_changes`.`date` >= '".$nowStr."'
                                    AND `schedule_changes`.`date` <= '".$maxForwardStr."'
                                    AND `schedule_changes`.`teacher_name` = ".$this->db->escape($teacherName)."
									");

		//echo $this->db->last_query(); die;
        foreach ($query->result_array() as $row)
		{
		   $result[] = $row;
		}

		return $result;
	}


	public function getChangesListByTeacher($teacherName){		$result = array();

		$nowStr = date('Y-m-d');
  		$maxForwardStr = date('Y-m-d', strtotime("+6 days"));

  		$query = $this->db->from('schedule_changes')
				->where('date >=',$nowStr)->where('date <=',$maxForwardStr)
  				->where(array('teacher_name'=>$teacherName))->get();
  		//echo $this->db->last_query();
        foreach ($query->result_array() as $row)
		{
		   $result[] = $row;
		}
		return $result;	}

	public function getSlotsTime(){
		$result = array();
  		$query = $this->db->select('time_slot, time_slot_interval')->from('schedule')->distinct()->get();
  		//echo $this->db->last_query();
        foreach ($query->result_array() as $row)
		{
		   $result[$row['time_slot']] = $row['time_slot_interval'];
		}
		return $result;
	}

	public function hasChanges(){		$nowStr = date('Y-m-d');  		$query = $this->db->from('schedule_changes')->where('date >=',$nowStr)->get();
		return ($query->num_rows() > 0);	}

	public function getScheduleChange($classNum,$classLetter,$timeSlot,$groupId,$dayOfWeek){		$dayOfWeek = intval($dayOfWeek);
		$dayOfWeek = $dayOfWeek-1;
		if ($dayOfWeek < 0){			$dayOfWeek = 6;
		}

		$result = array();
		$nowStr = date('Y-m-d');
  		$maxForwardStr = date('Y-m-d', strtotime("+6 days"));

		$query = $this->db->from('schedule_changes')
				->where('date >=',$nowStr)->where('date <=',$maxForwardStr)
				->where('WEEKDAY(date)='.$dayOfWeek)
				->where(array('class_num'=>$classNum, 'class_letter'=>$classLetter, 'time_slot'=>$timeSlot, 'group_id'=>$groupId))->get();
  		//echo $this->db->last_query();
        if ($query->num_rows() > 0)
		{
		   $result = $query->row_array();
		}
		return $result;
	}

	public function getChangesList(){		$result = array();
		$nowStr = date('Y-m-d');
  		$query = $this->db->from('schedule_changes')->where('date >=',$nowStr)->order_by('date desc, class_num asc, class_letter asc, group_id asc, time_slot asc')->get();
  		//echo $this->db->last_query();
        foreach ($query->result_array() as $row)
		{
		   $result[] = $row;
		}
		return $result;	}

	public function getStudentsScheduleChanges($classNum,$classLetter){
		$result = array();
		$nowStr = date('Y-m-d');
  		$maxForwardStr = date('Y-m-d', strtotime("+6 days"));
		$query = $this->db->from('schedule_changes')->where('date >=',$nowStr)->where('date <=',$maxForwardStr)->where(array('class_num'=>$classNum, 'class_letter'=>$classLetter))->get();
  		//echo $this->db->last_query();
        foreach ($query->result_array() as $row)
		{
		   $result[] = $row;
		}
		return $result;
	}

	public function processUploadedFile($file,$type,$debug = false){        switch ($type){
		case 'high':			return $this->processHigh($file,$debug);
			break;
		case 'low':
			return $this->processLow($file,$debug);
			break;

		case 'changes':
			return $this->processChanges($file,$debug);
			break;
		}
	}

	public function processChanges($file,$debug = false){
		require_once(__DIR__."/../libraries/phpQuery.php");
		$result = array('error'=>true,'message'=>'Неизвестная ошибка');
        $scheduleData = array();

	 	$s = file_get_contents($file);
		$s = mb_convert_encoding($s, "utf-8","windows-1251");
		//echo $s;
		phpQuery::newDocumentHTML($s);

		$classTables = pq('body>table');

		//echo "a1 ".(microtime(true)-$T0)."<br>";

		foreach ($classTables as $classTable){
			$infoString = pq($classTable)->find('h2')->text();

			$isParts = explode(',',$infoString);

			$className = $isParts[0];
			$classDateStr = $isParts[2];

			$classDateStrParts = explode('.',$classDateStr);
			$classDateSqlStr = $classDateStrParts[2].'-'.$classDateStrParts[1].'-'.$classDateStrParts[0];

			$m = array();
			$className = removeBlankCharacters($className);
			preg_match_all('@([0-9]+)([а-я]+)@ui',$className,$m);
			$classNum = $m[1][0];
			$classLetter = $m[2][0];
			//echo "a2 ".(microtime(true)-$T0)."<br>";

			//echo $classNum.' '.$classLetter;

			$trs = pq($classTable)->children('tr');
			$isFirstTr = true;
			foreach ($trs as $tr){
		    	if ($isFirstTr) {
		        	$isFirstTr = false;
		        	continue;
		        }
				//echo "a3 ".(microtime(true)-$T0)."<br>";

		        $tds = pq($tr)->children('td');

		        $tdsValues = array();
		        foreach($tds as $td){		        	$tdsValues[] = pq($td)->text();		        }

				$timeSlot = $tdsValues[0];
				$subject = $tdsValues[1];
                $groupId = $tdsValues[2];
                $teacherName = $tdsValues[3];
                $newSubject = $tdsValues[4];
                $room = $tdsValues[5];

                if (preg_match('@Занятие не проводится@ui',$teacherName)){                	$teacherName = '';
                    $newSubject = 'Занятие не проводится';
                }

		        $data['class_num']=supertrim($classNum);
                $data['class_letter']=supertrim($classLetter);
                $data['date']=supertrim($classDateSqlStr);
                $data['time_slot']=supertrim($timeSlot);
                //$data['time_slot_interval']=supertrim($timeInterval);
                $data['subject']=supertrim($subject);
                $data['new_subject']=supertrim($newSubject);
                $data['group_id']=supertrim($groupId);
                $data['teacher_name']=supertrim($teacherName);
                $data['room']=supertrim($room);

		        $scheduleData[] = $data;

				//echo pq($tr)->text();
				//echo '<br>';
			}


			//echo '+++++++++++++++++++++++++++++++++++++++++++++++++++++++++end of class-<br>';
		}

		//print_r($scheduleData); die;

        $result['message']='ПАРСЕР завершил работу по разбору файла замен расписания, потрачено времени на обработку: '.$this->usec2sec(microtime(true)-$T0,2).'<br>';

		if (empty($scheduleData)){
	        $result['message']= "ПАРСЕР: ОШИБКА: Некорректный формат замены расписания: пустой результат";
            $result['error']=true;
			return $result;
		}

		$sanityCheckResult = $this->scheduleChangesDataSanityCheck($scheduleData);

		if ($sanityCheckResult['error']==true){
			$result['message']= 'Парсер: ОШИБКА ПРОВЕРКИ ДАННЫХ.<br><div class="error-small">'.$sanityCheckResult['message'].'</div>';
            $result['error']=true;
            return $result;
		}


		$sqlErrorStr = '';
		$this->db->trans_start();

			foreach ($scheduleData as $data){

		       $q = $this->db->insert('schedule_changes',$data);
			   $sqlErrorStr .= "Q=".$this->db->last_query().'<br>';

		       if (!$q){
		       		$sqlErrorStr.= '<span class="error-text">result: DB ERROR:'.$this->db->_error_message().'</span><br>';
		       }else{
		       	    $sqlErrorStr.= '<span class="green">result: *** OK ***</span><br>';
		       }
			}

		$this->db->trans_complete();

		if ($this->db->trans_status() === false)
		{
	        $result['message']= 'БД: ОШИБКА ЗАПИСИ, не удалось провести транзакцию.<br><div class="error-small">'.$sqlErrorStr.'</div>';
            $result['error']=true;
            return $result;
		}else{
	        $result['message'].= "БД: ДАННЫЕ ЗАПИСАНЫ, общее время выполнения:".$this->usec2sec(microtime(true)-$T0,2)."<br>";
            $result['error']=false;
            return $result;
		}
	}

	public function processLow($file,$debug = false){
		require_once(__DIR__."/../libraries/phpQuery.php");
		$result = array('error'=>true,'message'=>'Неизвестная ошибка');
        $scheduleData = array();

	 	$s = file_get_contents($file);
		$s = mb_convert_encoding($s, "utf-8","windows-1251");
		//echo $s;
		phpQuery::newDocumentHTML($s);

		$classTable = pq('body>table');

		//echo "a1 ".(microtime(true)-$T0)."<br>";

		$trs = pq($classTable)->children('tr');
		$isFirstTr = true;
		$rowspan = 0;

        $dayOfWeek = 0;

		$classes = array();

		foreach ($trs as $tr){
	    	if ($isFirstTr) {
	        	$isFirstTr = false;

	        	$tds = pq($tr)->children('td');
	        	$i=0;
				foreach ($tds as $td){                    $i++;
                    if($i<=3){continue;}

                    $className = pq($td)->text();
					$m = array();
					preg_match_all('@([0-9]+)([а-я]+)@ui',$className,$m);
					$classNum = $m[1][0];
					$classLetter = $m[2][0];
					$classes[] = array('classNum' => $classNum, 'classLetter' => $classLetter);				}

				//print_r($classes); die;

	        	continue;
	        }
			//echo "a3 ".(microtime(true)-$T0)."<br>";

			$rowspan = pq($tr)->find('td:first')->attr('rowspan');
			$rowspan = intval($rowspan);

            if($rowspan>0){
				$counter = -1;
				$dayOfWeek++;
			}else{				$counter = 0;
			}

	        $tds = pq($tr)->children('td');

	        foreach ($tds as $td){
	        	if($counter == 0){
	        		$timeSlot = intval(pq($td)->text());
	        	}elseif($counter == 1){
	        		$timeInterval = pq($td)->text();
	        	}else{
					$trs2 = pq($td)->find('tr');
					if (empty($trs2)){continue;}

					$classNum = $classes[$counter-2]['classNum'];
					$classLetter = $classes[$counter-2]['classLetter'];
					if($classNum>=5){continue;}

					/*if($counter == 9 ){						echo 'node text=';
						echo pq($trs2)->text();
						echo '<br>';
					} /**/

					$i=0;
					$itrs = array();
					foreach($trs2 as $tr2){
						$itrs[$i] = $tr2;
						$i++;
					}

					$itds1 = pq($itrs[0])->children('td');
					if (empty($itds1)){continue;}
					$itds2 = pq($itrs[1])->children('td');

					$teacherNames = array();
					$groupIds = array();
					$subjects = array();

					$ldebug = false;

					$isFirtstTd1 = true;
					$defaultSubject = null;

					foreach ($itds1 as $itd1){
						if ($isFirtstTd1){
							$isFirtstTd1 = false;
							$defaultSubject = pq($itd1)->text();
							continue;
						}

						$teacherNameGroup = pq($itd1)->text();
	                    if($teacherNameGroup == '/'){continue;}

	                    // not really a teacher name but different subject on the same timeslot
	                    if (strpos($teacherNameGroup,'/')===0){
	                    	$ldebug = true;
	                    	$defaultSubject = substr($teacherNameGroup,1);
	                    	continue;
	                    }

	                    $teacherNameGroupParts = explode (':',supertrim($teacherNameGroup));

		                $teacherNames[] = supertrim($teacherNameGroupParts[0]);
		                $groupIds[] = supertrim($teacherNameGroupParts[1]);
		                $subjects[] = supertrim($defaultSubject);
					}

					if (empty($subjects)&&!empty($defaultSubject)){						$subjects[] = $defaultSubject;					}

					$rooms = array();
	                foreach ($itds2 as $itd2){
	                	$rooms[] = pq($itd2)->text();
	                }

					if ($ldebug && $debug){ print_r($subjects); print_r($groupIds);print_r($teacherNames);}

	                $data = array();

                    /*if($classNum == 3 ){
	                	$debug = true;
	                	$ldebug = true;
                        echo '$subjects=';
	                	print_r($subjects);
	                	echo '<br>';

	                }else{
	                	$debug = false;
	                	$ldebug = false;
	                } /**/

	                for ($i=0;$i<count($subjects);$i++){
	                	if ($ldebug && $debug){
	                   	echo "YEAR:".$classNum."<br>";
	                	echo "LETTER:".$classLetter."<br>";
	                	echo "DOW:".$dayOfWeek."<br>";
	                	echo "TIMESLOT:".$timeSlot."(".$timeInterval.")"."<br>";
	                	echo "SUBJECT:".$subjects[$i]."<br>";
	                	echo "GROUP:".$groupIds[$i]."<br>";
	                	echo "TEACHER:".$teacherNames[$i]."<br>";
	                	echo "ROOM:".$rooms[$i]."<br>";
	                	echo "<br>"; }

	                    $data['class_num']=supertrim($classNum);
	                    $data['class_letter']=supertrim($classLetter);
	                    $data['day_of_week']=supertrim($dayOfWeek);
	                    $data['time_slot']=supertrim($timeSlot);
	                    $data['time_slot_interval']=supertrim($timeInterval);
	                    $data['subject']=supertrim($subjects[$i]);
	                    $data['group_id']=supertrim($groupIds[$i]);
	                    $data['teacher_name']=supertrim($teacherNames[$i]);
	                    $data['room']=supertrim($rooms[$i]);

	                    $scheduleData[] = $data;

	                }
	        	}
				//echo '------------------------------------------------------------------end of REC-<br>';

		    	$counter++;
	        }

			//echo pq($tr)->text();
			//echo '<br>';

			//echo '+++++++++++++++++++++++++++++++++++++++++++++++++++++++++end of class-<br>';
		}

        //print_r($scheduleData); die;


        $result['message']='ПАРСЕР завершил работу по разбору файла расписания, потрачено времени на обработку: '.$this->usec2sec(microtime(true)-$T0,2).'<br>';

		if (empty($scheduleData)){
	        $result['message']= "ПАРСЕР: ОШИБКА: Некорректный формат расписания: пустой результат";
            $result['error']=true;
			return $result;
		}

		$sanityCheckResult = $this->scheduleDataSanityCheck($scheduleData);

		if ($sanityCheckResult['error']==true){
			$result['message']= 'Парсер: ОШИБКА ПРОВЕРКИ ДАННЫХ.<br><div class="error-small">'.$sanityCheckResult['message'].'</div>';
            $result['error']=true;
            return $result;
		}

		$sqlErrorStr = '';
		$this->db->trans_start();

			foreach ($scheduleData as $data){

		       $q = $this->db->insert('schedule',$data);
			   $sqlErrorStr .= "Q=".$this->db->last_query().'<br>';

		       if (!$q){
		       		$sqlErrorStr.= '<span class="error-text">result: DB ERROR:'.$this->db->_error_message().'</span><br>';
		       }else{
		       	    $sqlErrorStr.= '<span class="green">result: *** OK ***</span><br>';
		       }
			}

		$this->db->trans_complete();

		if ($this->db->trans_status() === false)
		{
	        $result['message']= 'БД: ОШИБКА ЗАПИСИ, не удалось провести транзакцию.<br><div class="error-small">'.$sqlErrorStr.'</div>';
            $result['error']=true;
            return $result;
		}else{
	        $result['message'].= "БД: ДАННЫЕ ЗАПИСАНЫ, общее время выполнения:".$this->usec2sec(microtime(true)-$T0,2)."<br>";
            $result['error']=false;
            return $result;
		}
	}

	public function processHigh($file,$debug = false){
		require_once(__DIR__."/../libraries/phpQuery.php");
		$result = array('error'=>true,'message'=>'Неизвестная ошибка');
        $scheduleData = array();

	 	$s = file_get_contents($file);		$s = mb_convert_encoding($s, "utf-8","windows-1251");
		//echo $s;
		phpQuery::newDocumentHTML($s);

		$classTables = pq('body>table');

		//echo "a1 ".(microtime(true)-$T0)."<br>";

		foreach ($classTables as $classTable){
			$className = pq($classTable)->find('h2')->text();
			$a = explode (' ',$className);
			$classNum = $a[0];
			//if($classNum<5){continue;}
			$classLetter = $a[1];
			//echo "a2 ".(microtime(true)-$T0)."<br>";

			//echo 'CNAME:'.$className.' '.$classNum.' '.$classLetter.'<br>';

			$trs = pq($classTable)->children('tr');
			$isFirstTr = true;
			foreach ($trs as $tr){
		    	if ($isFirstTr) {
		        	$isFirstTr = false;
		        	continue;
		        }
				//echo "a3 ".(microtime(true)-$T0)."<br>";

		        $tds = pq($tr)->children('td');

		        $counter = 0;
		        $dayOfWeek = 0;
		        foreach ($tds as $td){
		        	if($counter == 0){
		        		$timeSlot = intval(pq($td)->text());
		        	}elseif($counter == 1){
		        		$timeInterval = pq($td)->text();
		        	}else{
		        		$dayOfWeek++;
						$trs2 = pq($td)->find('tr');

						$i=0;
						$itrs = array();
						foreach($trs2 as $tr2){
							$itrs[$i] = $tr2;
							$i++;
						}

						$itds1 = pq($itrs[0])->children('td');
						$itds2 = pq($itrs[1])->children('td');

						$teacherNames = array();
						$groupIds = array();
						$subjects = array();

						$ldebug = false;

						$isFirtstTd1 = true;
						foreach ($itds1 as $itd1){
							if ($isFirtstTd1){
								$isFirtstTd1 = false;
								$defaultSubject = pq($itd1)->text();
								continue;
							}

							$teacherNameGroup = pq($itd1)->text();
		                    if($teacherNameGroup == '/'){continue;}

		                    // not really a teacher name but different subject on the same timeslot
		                    if (strpos($teacherNameGroup,'/')===0){
		                    	$ldebug = true;
		                    	$defaultSubject = substr($teacherNameGroup,1);
		                    	continue;
		                    }

		                    $teacherNameGroupParts = explode (':',supertrim($teacherNameGroup));

			                $teacherNames[] = supertrim($teacherNameGroupParts[0]);
			                $groupIds[] = supertrim($teacherNameGroupParts[1]);
			                $subjects[] = supertrim($defaultSubject);
						}
						$rooms = array();
		                foreach ($itds2 as $itd2){
		                	$rooms[] = pq($itd2)->text();
		                }

						if ($ldebug && $debug){ print_r($subjects); print_r($groupIds);print_r($teacherNames);}

		                $data = array();
		                for ($i=0;$i<count($rooms);$i++){
		                	if ($ldebug && $debug){
		                   	echo "YEAR:".$classNum."<br>";
		                	echo "LETTER:".$classLetter."<br>";
		                	echo "DOW:".$dayOfWeek."<br>";
		                	echo "TIMESLOT:".$timeSlot."(".$timeInterval.")"."<br>";
		                	echo "SUBJECT:".$subjects[$i]."<br>";
		                	echo "GROUP:".$groupIds[$i]."<br>";
		                	echo "TEACHER:".$teacherNames[$i]."<br>";
		                	echo "ROOM:".$rooms[$i]."<br>";
		                	echo "<br>"; }

		                    $data['class_num']=supertrim($classNum);
		                    $data['class_letter']=supertrim($classLetter);
		                    $data['day_of_week']=supertrim($dayOfWeek);
		                    $data['time_slot']=supertrim($timeSlot);
		                    $data['time_slot_interval']=supertrim($timeInterval);
		                    $data['subject']=supertrim($subjects[$i]);
		                    $data['group_id']=supertrim($groupIds[$i]);
		                    $data['teacher_name']=supertrim($teacherNames[$i]);
		                    $data['room']=supertrim($rooms[$i]);

		                    $scheduleData[] = $data;

		                }
		        	}
					//echo '------------------------------------------------------------------end of REC-<br>';

			    	$counter++;
		        }

				//echo pq($tr)->text();
				//echo '<br>';
			}


			//echo '+++++++++++++++++++++++++++++++++++++++++++++++++++++++++end of class-<br>';
		}

        $result['message']='ПАРСЕР завершил работу по разбору файла расписания, потрачено времени на обработку: '.$this->usec2sec(microtime(true)-$T0,2).'<br>';

		if (empty($scheduleData)){
	        $result['message']= "ПАРСЕР: ОШИБКА: Некорректный формат расписания: пустой результат";
            $result['error']=true;
			return $result;
		}

		$sanityCheckResult = $this->scheduleDataSanityCheck($scheduleData);

		if ($sanityCheckResult['error']==true){			$result['message']= 'Парсер: ОШИБКА ПРОВЕРКИ ДАННЫХ.<br><div class="error-small">'.$sanityCheckResult['message'].'</div>';
            $result['error']=true;
            return $result;		}

    	$sqlErrorStr = '';
		$this->db->trans_start();

			foreach ($scheduleData as $data){

		       $q = $this->db->insert('schedule',$data);
			   $sqlErrorStr .= "Q=".$this->db->last_query().'<br>';

		       if (!$q){
		       		$sqlErrorStr.= '<span class="error-text">result: DB ERROR:'.$this->db->_error_message().'</span><br>';
		       }else{		       	    $sqlErrorStr.= '<span class="green">result: *** OK ***</span><br>';		       }
			}

		$this->db->trans_complete();

		if ($this->db->trans_status() === false)
		{
	        $result['message']= 'БД: ОШИБКА ЗАПИСИ, не удалось провести транзакцию.<br><div class="error-small">'.$sqlErrorStr.'</div>';
            $result['error']=true;
            return $result;
		}else{
	        $result['message'].= "БД: ДАННЫЕ ЗАПИСАНЫ, общее время выполнения:".$this->usec2sec(microtime(true)-$T0,2)."<br>";
            $result['error']=false;
            return $result;
		}	}

	private function usec2sec($usec,$precision = 2){	   return round($usec/1000000000,$precision);	}

	private function scheduleDataSanityCheck($data){		$test = array();
		$result['message'] = '';
        $result['error'] = false;		foreach($data as $value){			if (!empty($test[$value['class_num'].$value['class_letter'].$value['day_of_week'].$value['time_slot'].$value['group_id']]))
			{    	        $old = $test[$value['class_num'].$value['class_letter'].$value['day_of_week'].$value['time_slot'].$value['group_id']];

    	        $result['message'].= 'Конфликт: совпадают значения 4х-мерных координат ячейки таблицы расписания, исправьте файл:<br>';
                $result['message'].= '<span class="error-text">';
    	        $result['message'] .= '('.$value['class_num'].$value['class_letter'].', '.getWeekdayNameByNum($value['day_of_week']).', урок№ '.$value['time_slot'].', группа '.$value['group_id'].')';
                $result['message'].= '</span>';
                $result['message'].= ' &#8594; '.$value['subject'].' ('.$value['teacher_name'].')';
                $result['message'] .= '<br>';

                $result['message'].= '<span class="error-text">';
    	        $result['message'] .= '('.$old['class_num'].$old['class_letter'].', '.getWeekdayNameByNum($old['day_of_week']).', урок№ '.$old['time_slot'].', группа '.$old['group_id'].')';
                $result['message'].= '</span>';
                $result['message'].= ' &#8594; '.$old['subject'].' ('.$old['teacher_name'].')';
       	        $result['message'] .= '<br><br>';
       	        $result['error'] = true;
			}
			$test[$value['class_num'].$value['class_letter'].$value['day_of_week'].$value['time_slot'].$value['group_id']] = $value;
		}
		return $result;	}

	private function scheduleChangesDataSanityCheck($data){
		$test = array();
		$result['message'] = '';
        $result['error'] = false;
		foreach($data as $value){
			if (!empty($test[$value['class_num'].$value['class_letter'].$value['date'].$value['time_slot'].$value['group_id']]))
			{
    	        $old = $test[$value['class_num'].$value['class_letter'].$value['date'].$value['time_slot'].$value['group_id']];

    	        $result['message'].= 'Конфликт: совпадают значения 4х-мерных координат ячейки таблицы замен расписания, исправьте файл:<br>';
                $result['message'].= '<span class="error-text">';
    	        $result['message'] .= '('.$value['date'].', '.$value['class_num'].$value['class_letter'].', урок№ '.$value['time_slot'].', группа '.$value['group_id'].')';
                $result['message'].= '</span>';
                $result['message'].= ' &#8594; '.$value['new_subject'].' &#8658; '.$value['subject'].' ('.$value['teacher_name'].')';
                $result['message'] .= '<br>';

                $result['message'].= '<span class="error-text">';
    	        $result['message'] .= '('.$old['date'].', '.$old['class_num'].$old['class_letter'].', урок№ '.$old['time_slot'].', группа '.$old['group_id'].')';
                $result['message'].= '</span>';
                $result['message'].= ' &#8594; '.$old['new_subject'].' &#8658; '.$old['subject'].' ('.$old['teacher_name'].')';
       	        $result['message'] .= '<br><br>';
       	        $result['error'] = true;

			}
			$test[$value['class_num'].$value['class_letter'].$value['date'].$value['time_slot'].$value['group_id']] = $value;
		}
		return $result;
	}


}


?>