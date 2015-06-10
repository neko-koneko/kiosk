<?php
    require_once(__DIR__.'/../models/schedule.php');

	$scheduleModel = new ScheduleModel();

	switch($main_request_array[1]){

		case "":{            $data = $scheduleModel->getScheduleTypes();
            include("inc/views/schedule_main.php");
            break;		}

		case "students":{			$classNum = $main_request_array[2];
			$classLetter = urldecode ($main_request_array[3]);

			if (empty($classLetter)||empty($classNum)){
	            $data = $scheduleModel->getScheduleClassList();
	            include("inc/views/schedule_students_main.php");
            }else{	            $data = $scheduleModel->getStudentsSchedule($classNum,$classLetter);
	            $changesData = $scheduleModel->getStudentsScheduleChanges($classNum,$classLetter);
	            include("inc/views/schedule_students_week.php");
            }
            break;
		}

		case "teachers":{			$teacherName = urldecode($main_request_array[2]);

			if (empty($teacherName)){
	            $data = $scheduleModel->getTeacherList();
	            include("inc/views/schedule_teachers_main.php");
            }else{
	            $data = $scheduleModel->getTeacherSchedule($teacherName);
	            //$changesData = $scheduleModel->getChangesListByTeacher($teacherName);

	            $removed = $scheduleModel->getRemovedItemsByTeacher($teacherName);
   		        $added = $scheduleModel->getAddedItemsByTeacher($teacherName);

	            $slotsTimeData = $scheduleModel->getSlotsTime();
	            include("inc/views/schedule_teachers_week.php");
            }
            break;		}

		case "changes":{
			$mode = $main_request_array[2];
			switch($mode){				case 'teachers':{
	                $teacherName = urldecode($main_request_array[3]);

					if (empty($teacherName)){			            $data = $scheduleModel->getChangesTeacherList();
						include("inc/views/schedule_changes_teachers_main.php");
					}else{
			            //$data = $scheduleModel->getChangesListByTeacher($teacherName);
			            /*$data = $scheduleModel->getTeacherSchedule($teacherName);
	    		        $changesData = $scheduleModel->getChangesListByTeacher($teacherName);/**/

	    		        $removed = $scheduleModel->getRemovedItemsByTeacher($teacherName);
	    		        $added = $scheduleModel->getAddedItemsByTeacher($teacherName);

			            $slotsTimeData = $scheduleModel->getSlotsTime();
			            include("inc/views/schedule_changes_teachers_teacher.php");
		            }

		            break;
	            }

	            case 'students':
	            default:{

		            $data = $scheduleModel->getChangesList();
		            include("inc/views/schedule_changes_students.php");
		            break;
	            }
			}

            break;
		}
	}

?>