<?php 
require_once('../config/dbconnect.php');


$value = isset($_POST['id'])? $_POST['id']: '0';

if($value=='today')

	$sql = "SELECT *, h.exercise_id AS EXE_ID FROM ".$db_suffix."history h
		Left Join ".$db_suffix."exercise e ON h.exercise_id=e.exercise_id where h.user_id='".$_REQUEST["user_id"]."' AND DATE(date_taken)=CURDATE() ORDER BY h.date_taken DESC";

else if($value=='week')

	$sql = "SELECT *, h.exercise_id AS EXE_ID FROM ".$db_suffix."history h
		Left Join ".$db_suffix."exercise e ON h.exercise_id=e.exercise_id where h.user_id='".$_REQUEST["user_id"]."' AND DATE(date_taken) > (NOW() - INTERVAL 7 DAY) ORDER BY h.date_taken DESC";
		
else if($value=='month')

	$sql = "SELECT *, h.exercise_id AS EXE_ID FROM ".$db_suffix."history h
		Left Join ".$db_suffix."exercise e ON h.exercise_id=e.exercise_id where h.user_id='".$_REQUEST["user_id"]."' ORDER BY h.date_taken DESC";
	

$news_query = mysqli_query($db,$sql);


?>
                      <table class="table table-striped table-bordered table-hover" id="sample_3">
                        <thead>
                           <tr>
                           	  <th>&Uuml;bung</th>
                              <th>Zeit</th>
                              <th >Ergebnis</th>
                              <th >Gemacht am</th>                              
                           </tr>
                        </thead>
                        
                        <tbody>
                       
                        <?php 
                            
                            while($row = mysqli_fetch_object($news_query))
                            {
                            
                            
                            $sql_inside="SELECT AVG(percentage) AS AVG_SCORE, MAX(percentage) AS BEST_SCORE, MIN(percentage) AS MIN_SCORE, AVG(time_taken) AS AVG_TIME, MIN(time_taken) AS BEST_TIME, MAX(time_taken) AS MAX_TIME FROM ".$db_suffix."history where exercise_id='$row->exercise_id'";
    
                           $query_inside = mysqli_query($db, $sql_inside);
        
                            if(mysqli_num_rows($query_inside) > 0)
                            {
                                $content     = mysqli_fetch_object($query_inside);
                                                        
                                $AVG_SCORE  = round($content->AVG_SCORE, 2);
                                $BEST_SCORE    = $content->BEST_SCORE;
                                $MIN_SCORE    = $content->MIN_SCORE;
                                $AVG_TIME    = round($content->AVG_TIME);
                                $BEST_TIME = $content->BEST_TIME;
                                $MAX_TIME = $content->MAX_TIME;
                                
                            }
                            
                            $time_span='';
                            $score_span='';
                            
                            if($row->percentage>$AVG_SCORE && $row->percentage<$BEST_SCORE)											
								$score_span='<span class="badge badge-success">&Uuml;ber Durchschnitt</span>';
							else if($row->percentage==$AVG_SCORE)											
								$score_span='<span class="badge badge-warning">Durchschnitt</span>';
							else if($row->percentage==$BEST_SCORE)											
								$score_span='<span class="badge badge-success">Bestes Ergebnis</span>';
							
							else if($row->percentage<$AVG_SCORE && $row->percentage>$MIN_SCORE)											
								$score_span='<span class="badge badge-warning">Unter Durchschnitt</span>';
							else if($row->percentage==$MIN_SCORE)											
								$score_span='<span class="badge badge-warning">Niedrigstes Ergebnis</span>';
							//else if($row->percentage<=65)											
								//$score_span='<span class="badge badge-danger">Fail</span>';
									
                                
                            $duration_EXE='';
                            $init=$row->time_taken;
                           
                            $hours = floor($init / 3600);
                            $minutes = floor(($init / 60) % 60);
                            $seconds = $init % 60;
                            
                            if($hours>0 && $hours<10)
							
								$hours='0'.$hours;
								
							if($minutes>0 && $minutes<10)
							
								$minutes='0'.$minutes;
								
							if($seconds>0 && $seconds<10)
							
								$seconds='0'.$seconds;
								
							
							if($hours!=0)
                                                                      
                                $duration_EXE.=$hours.' : ';
								
							else
							
								$duration_EXE.=' 00 : ';	
                            
                            if($minutes!=0)
                            
                                $duration_EXE.=$minutes.' : ';
								
							else
							
								$duration_EXE.=' 00 : ';	
                            
                            if($seconds!=0)
                            
                                $duration_EXE.=$seconds;
								
							else
							
								$duration_EXE.='00';	
                            
                            
                            if($row->time_taken>$AVG_TIME && $row->time_taken<$MAX_TIME)											
								$time_span='<span class="badge badge-warning">Unter Durchschnitt</span>';
							else if($row->time_taken==$AVG_TIME)											
								$time_span='<span class="badge badge-warning">Durchschnitt</span>';
							//else if($row->time_taken==$MAX_TIME)											
								//$time_span='<span class="badge badge-danger">Slowest</span>';
							
							else if($row->time_taken<$AVG_TIME && $row->time_taken>$BEST_TIME)											
								$time_span='<span class="badge badge-success">&Uuml;ber Durchschnitt</span>';
							else if($row->time_taken==$BEST_TIME)											
								$time_span='<span class="badge badge-success">Bestzeit</span>';
								
                            
                            $style='style="color:green;"';
                            if($row->percentage<65)
                            { 
                                $time_span='';
                                $score_span='';
                                $style='style="color:red;"';
                            }
                            
                            
                        
                            
                            ?> 
           
                           <tr>
                           
                           	<td <?php echo $style; ?>><?php echo $row->exercise_title;?></td>
                            
                            <td <?php echo $style; ?>><?php echo $duration_EXE. ' '.$time_span;?></td>
                            
                            <td <?php echo $style; ?>><?php echo $row->percentage.'%'. ' '.$score_span;?></td>
                            
                            <td <?php echo $style; ?>><?php 
              
                              if(date('d-m-Y')==date('d-m-Y', strtotime($row->date_taken)))
                              
                                echo date('H:i', strtotime($row->date_taken));
                                
                            else
                            
                                echo date('d-m-Y H:i', strtotime($row->date_taken));	
                              
                              ?></td>                              
                                                            
                           </tr>
                           
          <?php } ?>       
                        </tbody>
                        
                     </table>