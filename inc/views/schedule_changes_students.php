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

           echo '<h1 class="p10">Замены расписания для учащихся</h1>';

           if (empty($data)){               echo '<h1 class="pl10 pt40 schedule-changes-none tacentr">Нет замен</h1>';           }else{

	           $r = array();
	           foreach ($data as $key => $value){
	           		$r[$value['date']][$value['class_num']][$value['class_letter']][$value['time_slot']][$value['group_id']] = $value;
	           }

	           ksort($r);

	           foreach ($r as $date => $scheduleDate){				   echo '<div class="fleft bbsz asc p10 w100">';
	               echo '<div class="schedule-weekday-container">';

	               $d = explode('-',$date);
	               $dateStr = $d[2].'-'.$d[1].'-'.$d[0];

	               $weekdayName = mb_strtolower(getWeekdayNameByNum(date('w',mktime(0,0,0,$d[1],$d[2],$d[0]))));
	               $dateStr = $dateStr.', '.$weekdayName;

				   echo '<h2 class="pb10 schedule-changes-date">'.$dateStr.'</h2>';

				   ksort ($scheduleDate);
	               $i=1;

				   foreach ($scheduleDate as $classNum => $scheduleClasses){
	                    foreach($scheduleClasses as $classLetter => $scheduleClassesLetters){
							echo '<div class="pt10 pb10 schedule-changes-class">'.$classNum.$classLetter.' <span>('.$dateStr.')</span></div>';
						   	echo '<table class="w100 schedule-changes-table">';
						   	echo '<thead>';
						   	echo '<tr>';
						   	echo '<td style="width:100px">№ урока</td>';
						   	echo '<td style="width:80px">Группа</td>';
						   	echo '<td style="width:180px">Заменяемый предмет</td>';
						   	echo '<td style="width:180px">Новый предмет</td>';
						   	echo '<td>Заменяющий преподаватель</td>';
						   	echo '<td style="width:60px">Каб.</td>';
						   	echo '</tr>';
						   	echo '</thead>';
						   	echo '<tbody>';
	                        foreach($scheduleClassesLetters as $slot => $scheduleClassesLettersSlots){
								ksort($scheduleClassesLettersSlots);
								foreach ($scheduleClassesLettersSlots as $group => $data){									echo '<tr class="schedule-outer-table-color-'.$slot.'">';

										echo '<td >'.$data['time_slot'].'</td>';
				                        echo '<td >'.$data['group_id'].'</td>';
				                        echo '<td >'.'<strike class="schedule-changes-stroke">';
				                        echo '<span class="schedule-outer-table-color-'.$slot.'">'.$data['subject'].'</span>';
				                        echo '</strike>'.'</td>';

				                        if (preg_match('@Занятие не проводится@ui',$data['new_subject'])){					                        echo '<td colspan=3 class="tacentr">'.$data['new_subject'].'</td>';
				                        } else{
					                        echo '<td >'.$data['new_subject'].'</td>';
					                        echo '<td >'.$data['teacher_name'].'</td>';
					                        echo '<td >'.$data['room'].'</td>';
				                        }
									echo '</tr>';
								}

							}
						   	echo '</tbody>';
						    echo '</table>';

						}
				   }

				   echo '</div>';
				   echo '</div>';
	           }
           }

          ?>
          </div>
	</div>
</div>

<?php
 include("inc/views/footer.php");
?>