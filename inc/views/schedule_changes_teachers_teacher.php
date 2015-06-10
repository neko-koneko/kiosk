<?php
 include("inc/views/head.php");
 include("inc/views/header.php");
?>

<div class="nav-back" onclick="goBack();"><</div>

<div class="w100 fleft main-container">

 <?php
  include('main_left.php');
 ?>


	<div class="fleft w75 bbsz asc" style="position: absolute; top: 0px; bottom: 0px; right: 0px;">
          <div class="fleft w100" style="position: absolute; top: 0px; bottom: 0px; right: 0px; overflow-y: auto; overflow-x: hidden;">



          <?php

			echo '<h1 class="p10">Замены расписания, '.$teacherName.'</h1>';

			/*echo 'added';
			print_r ($added);

			echo '<br><br>';
			echo 'removed';
			print_r ($removed);
			//die;
            /**/

			$rm = array();
			foreach ($removed as $key => $value){
				$rm[$value['date']][$value['time_slot']][$value['group_id']] = $value;
			}

			ksort($rm);


			$ad = array();
			foreach ($added as $key => $value){
				$ad[$value['date']][$value['time_slot']][$value['group_id']] = $value;
			}

			ksort($ad);


			$rmKeys = array_keys((array)$rm);
			$adKeys = array_keys((array)$ad);

			$dates = $rmKeys + $adKeys;
			sort($dates);
			$dates = array_unique($dates);

            //print_r($dates);

			foreach ($dates as $date){				echo '<div class="fleft bbsz asc p10 w100">';
				echo '<div class="schedule-weekday-container">';

				$d = explode('-',$date);
				$dateStr = $d[2].'-'.$d[1].'-'.$d[0];

				$weekdayName = mb_strtolower(getWeekdayNameByNum(date('w',mktime(0,0,0,$d[1],$d[2],$d[0]))));
				$dateStr = $dateStr.', '.$weekdayName;

				echo '<h2 class="pb10 schedule-changes-date">'.$dateStr.'</h2>';

				echo '<table class="w100 schedule-outer-table">';

				$rmSlotKeys = array_keys((array)$rm[$date]);
				$adSlotKeys = array_keys((array)$ad[$date]);

				$slots = $rmSlotKeys + $adSlotKeys;
				sort($slots);
				$slots = array_unique($slots);


				foreach ($slots as $slot ){
						echo '<tr class="schedule-outer-table-color-'.$slot.'">';
						echo '<td style="width:40px">'.$slot.'</td>';

	                    $s = '<table class="w100">';

	                    if (!empty($ad[$date][$slot])){
	                            foreach ($ad[$date][$slot] as $groupId => $data)
	                            {
									$groupId = supertrim($groupId);
									$timeStr = $slotsTimeData[$data['time_slot']];
		    	                    $classNum = supertrim($data['class_num']);
		        	                $classLetter = supertrim($data['class_letter']);

									$s.='<tr class="schedule-teacher-add-subject">';

									$s.='<td >';
									$s .= '[+]'.$data['new_subject'];
									$s.= '</td>';

			                        $s.='<td style="width:60px">'.$classNum.$classLetter.'</td>';
			                        $s.='<td style="width:60px">';
			                        if (!empty($groupId)){
			                        	$s.='('.$groupId.')';
			                        }
			                        $s.='</td>';

									$s.='<td style="width:60px">';
									$s .= $data['room'];
									$s.='</td>';

									$s.='</tr>';
								}
						}

						if (!empty($rm[$date][$slot])){
	                            foreach ($rm[$date][$slot] as $groupId => $data)
	                            {
									$groupId = supertrim($groupId);
									$timeStr = $slotsTimeData[$data['time_slot']];
		    	                    $classNum = supertrim($data['class_num']);
		        	                $classLetter = supertrim($data['class_letter']);

									$s.='<tr class="schedule-teacher-change-subject">';

									$s.='<td >';
									//$s .= '<strike class="schedule-changes-stroke"><span class="schedule-outer-table-color-'.$slot.'">'.$data['subject'].'</span></strike>';
									$s .= '<span class="schedule-outer-table-color-'.$slot.'">'.$data['subject'].'</span>';
									$s .= '&nbsp;<span class="green">&#8658;&nbsp;</span>';
									$s .= '<div class="fright pr10 lightgray">'.$data['new_subject'];
									if(!empty($data['new_teacher_name'])){
										$s .= '<span class="smaller">('.$data['new_teacher_name'].')</span>';
									}
									$s .= '</div>';
									$s.= '</td>';

			                        $s.='<td style="width:60px">'.$classNum.$classLetter.'</td>';
			                        $s.='<td style="width:60px">';
			                        if (!empty($groupId)){
			                        	$s.='('.$groupId.')';
			                        }
			                        $s.='</td>';

									$s.='<td style="width:60px">';
									if (!empty($data['new_room']) && ($data['new_room'] != $data['room']) ){
										$s .= '<strike class="schedule-changes-stroke"><span class="schedule-outer-table-color-'.$slot.'">'.$data['room'].'</span></strike><br>';
										$s .= $change['new_room'];
									}
									else{
										$s .= $data['room'];
									}
									$s.='</td>';

									$s.='</tr>';
								}
						}


						/*foreach ($scheduleSlots as $group => $data){


							$group = supertrim($group);
							$timeStr = $data['time_slot_interval'];
	                        $classNum = supertrim($data['class_num']);
	                        $classLetter = supertrim($data['class_letter']);

							$change = $scheduleModel->getScheduleChanges($classNum,$classLetter,$slot,$group,$dow);
	                        /*$s.='<tr>';
	                        $s.='<td style="width:240px">'.$data['subject'].'</td>';
	                        $s.='<td style="width:40px">'.$data['class_num'].$data['class_letter'].'</td>';
	                        $s.='<td style="width:60px">';
	                        if (!empty($data['group_id'])){
	                        	$s.='('.$data['group_id'].')';
	                        }
	                        $s.='</td>';
	                        $s.='<td style="width:40px">'.$data['room'].'</td>';
	                        $s.='</tr>';
							if(!empty($change)){
								$s.='<tr class="schedule-teacher-change-subject">';
							}else{
	                        	$s.='<tr>';
	                        }

							$s.='<td >';

							if(!empty($change)){
								$s .= '<strike class="schedule-changes-stroke"><span class="schedule-outer-table-color-'.$slot.'">'.$data['subject'].'</span></strike><br>';
								$s .= $change['new_subject'];
							}else{
								$s .= $data['subject'];
							}
							$s.= '</td>';

	                        $s.='<td style="width:60px">'.$classNum.$classLetter.'</td>';
	                        $s.='<td style="width:60px">';
	                        if (!empty($groupId)){
	                        	$s.='('.$groupId.')';
	                        }
	                        $s.='</td>';

							$s.='<td style="width:60px">';
							if(!empty($change)){
								$change['room'] = supertrim($change['room']);
								if (!empty($change['room']) && ($change['room'] != $data['room']) ){
									$s .= '<strike class="schedule-changes-stroke"><span class="schedule-outer-table-color-'.$slot.'">'.$data['room'].'</span></strike><br>';
									$s .= $change['room'];
								}
								else{
									$s .= $data['room'];
								}
							}else{
								$s .= $data['room'];
							}
							$s.='</td>';

							$s.='</tr>';

						}/**/
	                    $s .= '</table>';
						echo '<td style="width:150px">'.str_replace(' ','',$timeStr).'</td>';

						echo '<td>'.$s.'</td>';

						echo '</tr>';
						$i++;
				   }

				   echo '</table>';
			}

			echo '</div>';
			echo '</div>';
			/**/


          ?>
          </div>
	</div>
</div>

<?php
 include("inc/views/footer.php");
?>