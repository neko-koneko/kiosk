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

           echo '<h1 class="p10">'.$teacherName.'</h1>';

        /*    $additionals = array();
			foreach ($changesData as $value){
				$d = explode('-',$value['date']);
				$dateStr = $d[2].'-'.$d[1].'-'.$d[0];
				$dow = date('w',mktime(0,0,0,$d[1],$d[2],$d[0]));
				$value['group_id'] = supertrim($value['group_id']);
				$additionals[$dow][$value['time_slot']][$value['group_id']] = $value;
			}

			//print_r($changesData); /**/


			$rm = array();
			foreach ($removed as $key => $value){
				$rm[$value['day_of_week']][$value['time_slot']][$value['group_id']] = $value;
			}

			ksort($rm);


			$ad = array();
			foreach ($added as $key => $value){
				$ad[$value['day_of_week']][$value['time_slot']][$value['group_id']] = $value;
			}

			ksort($ad);

           $r = array();
           foreach ($data as $key => $value){           		$r[$value['day_of_week']][supertrim($value['time_slot'])][$value['group_id']] = $value;
           }

           ksort($r);


           //foreach ($r as $dow => $scheduleDow){           for($dow = 1; $dow <= 7; $dow++){
               $scheduleDow = $r[$dow];
			   $normalKeys = array_keys((array)$scheduleDow);
			   $additionalKeys = array_keys((array)$ad[$dow]);

               $keys = $normalKeys + $additionalKeys;
               sort($keys);
               $keys = array_unique($keys);
			   echo '<div class="fleft bbsz asc p10 w100">';
               echo '<div class="p10 schedule-weekday-container">';
			   echo '<span class="weekday">'.$weekday[$dow].'</span>';

			   if (empty($keys)){			   	echo '<h3>- нет занятий -</h3>';
			   }else{

				   ksort ($scheduleDow);
				   echo '<table class="w100 schedule-outer-table">';

					$rmSlotKeys = array_keys((array)$rm[$dow]);
					$adSlotKeys = array_keys((array)$ad[$dow]);
					$rSlotKeys = array_keys((array)$r[$dow]);

					$slots = $rmSlotKeys + $adSlotKeys + $rSlotKeys;
					sort($slots);
					$slots = array_unique($slots);

					//print_r($slots); die;


				   foreach ($slots as $slot ){				   		$scheduleSlots = $scheduleDow[$slot];
				   		ksort($scheduleSlots);
						echo '<tr class="schedule-outer-table-color-'.$slot.'">';
						echo '<td style="width:40px">'.$slot.'</td>';

	                    $s = '<table class="w100">';
                        $flags = array();

						if (!empty($rm[$dow][$slot])){
	                            foreach ($rm[$dow][$slot] as $groupId => $data)
	                            {
	                                $flags[$dow][$slot][$groupId] = true;
									$groupId = supertrim($groupId);
									$timeStr = $slotsTimeData[$data['time_slot']];
		    	                    $classNum = supertrim($data['class_num']);
		        	                $classLetter = supertrim($data['class_letter']);

									$s.='<tr class="schedule-teacher-change-subject">';

									$s.='<td >';
									$s .= '<strike class="schedule-changes-stroke"><span class="schedule-outer-table-color-'.$slot.'">'.$data['subject'].'</span></strike>';
									//$s .= '<span class="schedule-outer-table-color-'.$slot.'">'.$data['subject'].'</span>';
									$s .= '&nbsp;<span class="green">&#8658;&nbsp;</span>';
									$s .= '<span class="schedule-outer-table-color-'.$slot.'">'.$data['new_subject'];
									$s .= '</span>';
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


						if (!empty($ad[$dow][$slot])){
	                            foreach ($ad[$dow][$slot] as $groupId => $data)
	                            {
	                                if (!empty($flags[$dow][$slot][$groupId])){continue;}

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
									$s .= $data['new_room'];
									$s.='</td>';

									$s.='</tr>';
								}
						}


						foreach ($r[$dow][$slot] as $groupId => $data){
                            if (!empty($flags[$dow][$slot][$groupId])){continue;}
							$timeStr = $data['time_slot_interval'];
	                        $classNum = supertrim($data['class_num']);
	                        $classLetter = supertrim($data['class_letter']);

                        	$s.='<tr>';
							$s.='<td >';
							$s .= $data['subject'];
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

           }


          ?>
          </div>
	</div>
</div>

<?php
 include("inc/views/footer.php");
?>