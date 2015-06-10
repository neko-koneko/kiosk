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

			echo '<h1 class="p10">Расписание '.$classNum.' '.$classLetter.'</h1>';

			$changes =array();
			foreach ($changesData as $value){				$d = explode('-',$value['date']);
				$dateStr = $d[2].'-'.$d[1].'-'.$d[0];
				$dow = date('w',mktime(0,0,0,$d[1],$d[2],$d[0]));
				$value['group_id'] = supertrim($value['group_id']);
				$changes[$dow][$value['time_slot']][$value['group_id']] = $value;			}

			$r = array();
			foreach ($data as $key => $value){					$r[$value['day_of_week']][$value['time_slot']][$value['group_id']] = $value;			}

			ksort($r);
			foreach ($r as $dow => $scheduleDow){				echo '<div class="fleft bbsz asc p10 w100">';
				echo '<div class="p10 schedule-weekday-container">';
				echo '<span class="weekday">'.getWeekdayNameByNum($dow).'</span>';


				ksort ($scheduleDow);
				         $i=1;

				echo '<table class="w100 schedule-outer-table">';
				foreach ($scheduleDow as $slot => $scheduleSlots){					echo '<tr class="schedule-outer-table-color-'.$slot.'">';

					echo '<td style="width:40px">'.$slot.'</td>';

					ksort($scheduleSlots);

					$s = '<table class="w100">';
					foreach ($scheduleSlots as $group => $data){						$group = supertrim($group);						$timeStr = $data['time_slot_interval'];
						$s.='<tr>';
						$s.='<td style="width:40px">'.$data['group_id'].'</td>';

						$s.='<td style="width:240px">';
						$change = $changes[$dow][$slot][$group];
						if(!empty($change)){							$s .= '<strike class="schedule-changes-stroke"><span class="schedule-outer-table-color-'.$slot.'">'.$data['subject'].'</span></strike><br>';
							$s .= $change['new_subject'];
						}else{							$s .= $data['subject'];
						}
						$s.= '</td>';

						$s.='<td style="padding-left:10px">';
						if(!empty($change)){
							$s .= '<strike class="schedule-changes-stroke"><span class="schedule-outer-table-color-'.$slot.'">'.$data['teacher_name'].'</span></strike><br>';
							$s .= $change['teacher_name'];
						}else{
							$s .= $data['teacher_name'];
						}
						$s.='</td>';

						$s.='<td style="width:40px">';
						if(!empty($change)){
							$change['room'] = supertrim($change['room']);
							if (!empty($change['room']) && ($change['room'] != $data['room']) ){
								$s .= '<strike class="schedule-changes-stroke"><span class="schedule-outer-table-color-'.$slot.'">'.$data['room'].'</span></strike><br>';
								$s .= $change['room'];
							}
							else{								$s .= $data['room'];
							}
						}else{
							$s .= $data['room'];
						}
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