<?php 

$mandate_exe_id=array();
$sql = "select exercise_id from ".$db_suffix."mandat_exe where lang_level = '".$_SESSION["user_level"] ."' AND org_name='".$_SESSION["user_org_name"]."' AND me_status='1'";				
$query = mysqli_query($db, $sql);

while($content=mysqli_fetch_object($query))
	
	array_push($mandate_exe_id, $content->exercise_id);

		


$id=$_REQUEST["id"];

$sql = "select user_first_name, user_last_name from ".$db_suffix."user where user_id = '$id' limit 1";				
$query = mysqli_query($db, $sql);

if(mysqli_num_rows($query) > 0)
{
	$usr = mysqli_fetch_object($query);
	
	$user_perform_name= $usr->user_first_name.' '.$usr->user_last_name;
}
	
$sql = "SELECT *, h.exercise_id AS EXE_ID FROM ".$db_suffix."history h
		Left Join ".$db_suffix."exercise e ON h.exercise_id=e.exercise_id where h.user_id='$id' GROUP BY h.exercise_id ORDER BY h.date_taken DESC";
		
$news_query = mysqli_query($db,$sql);

?>

<!-----PAGE LEVEL CSS BEGIN--->

<link rel="stylesheet" type="text/css" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.css" />

<link rel="stylesheet" href="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.css" />


<!-----PAGE LEVEL CSS END--->


                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                        
                        <h3 class="page-title">
                                                Leistungsübersicht <small> <?php echo $user_perform_name;  ?></small>
                                        </h3>
                                        
                                        
                        <div class="page-bar">         
                                        <ul class="page-breadcrumb">
                                                <li>
                                                        <i class="fa fa-home"></i>
                                                        <a href="<?php echo SITE_URL_ADMIN; ?>">Home</a>
                                                        <i class="fa fa-angle-right"></i>
                                                </li>
                                                
                                                <li>
                                                       <?php echo '<strong>'.$_SESSION["user_level"].' </strong> <small>'.$_SESSION["user_org_name"].'</small>'; ?>  
                                                </li>
                                        </ul>
                                        <!-- END PAGE TITLE & BREADCRUMB-->
                                </div>                
                               
                        <!-- END PAGE HEADER-->
                        <!-- BEGIN PAGE CONTENT-->
                                              
                        <div class="row">
            <div class="col-md-12">
            
               <!-- BEGIN EXAMPLE TABLE PORTLET-->
               
               <div class="portlet box grey-cascade">
                  <div class="portlet-title">
                     <div class="caption"><i class="fa fa-table"></i>&Uuml;bersicht</div>
                     <div class="actions" style="padding-right: 21%;">
                        <a href="<?php echo SITE_URL_ADMIN.'?mKey=sendmessage&parent='.$id; ?>" class="btn green"><i class="fa fa-envelope-o"></i> Diesem Schuler eine Nachricht schicken</a>
                     </div>
                  </div>
                  <div class="portlet-body">
                  <!--<div class="tools">
                     </div>-->
                     <table class="table table-striped table-bordered table-hover" id="performance_page_table_up_sample_10">
                        <thead>
                           <tr>
                           	  <th>&Uuml;bung</th>
                              <th>Dauer</th>
                              <th>Fragen</th>
                              <th >Im Paket</th>
                              <th >Ø - Ergebnis</th>
                              <!--<th >AVG Time</th>
                              <th >Best Time</th>-->
                              <th >Versuche</th>
                              <th >Letzter Versuch</th>                              
                           </tr>
                        </thead>
                        <tbody>
                        
                        <?php 
		   		 while($row = mysqli_fetch_object($news_query))
			    {
				   
				   $sql_inside="SELECT AVG(percentage) AS AVG_SCORE, MIN(percentage) AS WORST_SCORE, AVG(time_taken) AS AVG_TIME, MIN(time_taken) AS BEST_TIME, date_taken AS LAST_TIME FROM ".$db_suffix."history where user_id='$id' AND exercise_id='$row->EXE_ID' ORDER BY date_taken DESC";
				   
				   $query_inside = mysqli_query($db, $sql_inside);

					if(mysqli_num_rows($query_inside) > 0)
					{
						$content     = mysqli_fetch_object($query_inside);
												
						$AVG_SCORE       = round($content->AVG_SCORE, 2).'%';
						$WORST_SCORE    = round($content->WORST_SCORE,2).'%';
						$AVG_TIME    = round($content->AVG_TIME);
						$BEST_TIME = round($content->BEST_TIME);
						$LAST_TIME  = date('d-m-Y',strtotime($content->LAST_TIME));
					}
					
					if($LAST_TIME==date('d-m-Y'))
					
						$LAST_TIME='Heute';
		   
		   			$duration_AVG='';
					$init=$AVG_TIME;
				   
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
															  
						$duration_AVG.=$hours.' : ';
						
					else
							
						$duration_AVG.=' 00 : ';	
					
					if($minutes!=0)
					
						$duration_AVG.=$minutes.' : ';
						
					else
							
						$duration_AVG.=' 00 : ';	
					
					if($seconds!=0)
					
						$duration_AVG.=$seconds;
						
					else
							
						$duration_AVG.='00';	
						
						
					$duration_BEST='';
					$init=$BEST_TIME;
				   
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
															  
						$duration_BEST.=$hours.' : ';
						
					else
							
						$duration_BEST.=' 00 : ';	
					
					if($minutes!=0)
					
						$duration_BEST.=$minutes.' : ';
						
					else
							
						$duration_BEST.=' 00 : ';	
					
					if($seconds!=0)
					
						$duration_BEST.=$seconds;
						
					else
							
						$duration_BEST.='00';
												
					$span_for_exe_package=' <span class="badge badge-danger">Nein</span>';					
					
					if(in_array($row->exercise_id, $mandate_exe_id))
					
						$span_for_exe_package=' <span class="badge badge-success">Ja</span>';			
		   ?>
           
                           <tr>
                           
                           	  <td><?php echo '<a href="'.SITE_URL_ADMIN.'?mKey=teachers&pKey=questions&id='.$row->EXE_ID.'&title='.$row->exercise_title; ?>"><?php echo $row->exercise_title.'</a>'; ?></td>
                              
                              <td><?php 
							  
							  	sscanf($row->exercise_duration, "%d:%d:%d", $hours, $minutes, $seconds);
								  $exercise_duration= $hours * 3600 + $minutes * 60 + $seconds;
								  
								  $duration='';

									if($hours>0 && $hours<10)
							
										$hours='0'.$hours;
										
									if($minutes>0 && $minutes<10)
									
										$minutes='0'.$minutes;
										
									if($seconds>0 && $seconds<10)
									
										$seconds='0'.$seconds;										
									
									
									if($hours!=0)
																			  
										$duration.=$hours.' : ';
										
									else
							
										$duration.=' 00 : ';	
									
									if($minutes!=0)
									
										$duration.=$minutes.' : ';
										
									else
							
										$duration.=' 00 : ';	
									
									if($seconds!=0)
									
										$duration.=$seconds;
										
									else
							
										$duration.='00';	
								  
								  echo $duration;
								  
								  
							$sql_inside="SELECT date_taken AS LAST_TIME FROM ".$db_suffix."history where user_id='$id' AND exercise_id='$row->EXE_ID' ORDER BY date_taken DESC LIMIT 1";;
				   
						   $query_inside = mysqli_query($db, $sql_inside);
		
							if(mysqli_num_rows($query_inside) > 0)
							{
								$content     = mysqli_fetch_object($query_inside);														
								$LAST_TIME  = date('d-m-Y',strtotime($content->LAST_TIME));
							}  
							  
							  
							  ?></td>
                              
                              <td><?php 
							  
								  $has_done=mysqli_num_rows(mysqli_query($db,"SELECT question_id FROM ".$db_suffix."question where exercise_id='$row->exercise_id'"));
								  
								  echo $row->exercise_pull.' / '.$has_done;
							  
							  ?></td>
                              
                              <td><?php echo $span_for_exe_package;?></td>
                              
                              <td><?php echo $AVG_SCORE;?></td>
                              
                             <!-- <td><?php echo $WORST_SCORE;?></td>-->
                              
                              <!--<td><?php echo $duration_AVG;?></td>
                              
                              <td><?php echo $duration_BEST;?></td>-->
                              
                               <td><?php 

							   $has_done=mysqli_num_rows(mysqli_query($db,"SELECT exercise_id FROM ".$db_suffix."history where exercise_id='$row->EXE_ID' AND user_id='$id'"));

							   if($has_done>=0 && $has_done<10)
							   
									$game_over='0'.$has_done;
									
								else

									$game_over=$has_done;
							   
							   echo '<span class="badge badge-info">'.$game_over.'</span>';
							   
							   if($has_done>1)
							   
									echo ' <a href="'.SITE_URL_ADMIN.'?mKey=teachers&pKey=charts&exercise_id='.$row->exercise_id.'&user_id='.$id.'" class="btn default btn-xs yellow-gold">Diagramm</a>';
							   
							   ?></td>
                              
                              <td><?php echo ($LAST_TIME==date('d-m-Y'))? 'Heute' : $LAST_TIME;?></td>                              
                                                            
                           </tr>
                           
          <?php } ?>       
                        </tbody>
                     </table>
                  
                  </div>
               </div>
               <!-- END EXAMPLE TABLE PORTLET-->
            </div>
         </div>
         
         				
                        
           <div class="row">
             <div class="col-md-12">
             	<div class="portlet box blue-hoki">
                    <div class="portlet-title">
                        <div class="caption caption-md">
                            <i class="icon-bar-chart theme-font hide"></i>
                            <span class="caption-subject bold uppercase">History</span>
                            
                        </div>
                        <div class="actions" style="padding-right: 21%;">
                            <div class="btn-group btn-group-devided" data-toggle="buttons">
                                <label class="btn red btn-circle btn-sm active">
                                <input type="radio" value="today" name="today" class="toggle" id="today">Heute</label>
                                <label class="btn red btn-circle btn-sm">
                                <input type="radio" value="week" name="today" class="toggle" id="today">Diese Woche</label>
                                <label class="btn red btn-circle btn-sm">
                                <input type="radio" value="month" name="today" class="toggle" id="today">Von Beginn an</label>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="hide" id="site_activities_loading">
                            <img src="<?php echo SITE_URL_ADMIN; ?>assets/admin/layout/img/loading.gif" alt="loading"/>
                        </div>
                        <div class="table_exchange"> 
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
                            
                           $sql = "SELECT *, h.exercise_id AS EXE_ID FROM ".$db_suffix."history h
		Left Join ".$db_suffix."exercise e ON h.exercise_id=e.exercise_id where h.user_id='$id' AND DATE(date_taken)=CURDATE() ORDER BY h.date_taken DESC";
                            $news_query = mysqli_query($db,$sql);
                            
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
                      </div>  
                        </div>
                    </div>
                </div>
             </div>
         </div>
                        
         
<!-----MODALS FOR THIS PAGE START ---->



<!-----MODALS FOR THIS PAGE END ---->
  




<!-----------------------Here goes the rest of the page --------------------------------------------->

<!-- END PAGE CONTENT-->
                </div>
                <!-- END PAGE -->    
        </div>


        <!-- END CONTAINER -->
        
        <!-- BEGIN FOOTER -->
        
        <?php require_once('footer.php'); ?>
        
        <!-- END FOOTER -->
      
        <!-- BEGIN CORE PLUGINS --> 
          
        
		<?php require_once('scripts.php'); ?>
        
        
        <!-- END CORE PLUGINS -->
        
       <!-----PAGE LEVEL SCRIPTS BEGIN--->
       
       <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/select2/select2.min.js"></script>
        
   <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
   
   <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>

   
   <script type="text/javascript" src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js"></script>
   
   <!--<script src="<?php echo SITE_URL_ADMIN; ?>assets/admin/pages/scripts/table-managed.js"></script>-->
   
    <script>
                /*jQuery(document).ready(function() {    
                    TableManaged.init();				   	   
                });*/	
				
				$('input:radio[name=today]').change(function() {
					
					$('.table_exchange').empty();
					$('#site_activities_loading').toggleClass("hide show");
					
					$.ajax({
					   type: "POST",
					   url:  '<?php echo SITE_URL_ADMIN.'teacher_things/'; ?>AJAX_stat_user.php?user_id=<?php echo $id; ?>',
					   data: {id: $(this).val()},
					   success: function(data){		
							$('.table_exchange').html(data);
							$('#site_activities_loading').toggleClass("hide show");
							
							var initTable3 = function () {

							var table12 = $('#sample_3');
					
							/* Table tools samples: https://www.datatables.net/release-datatables/extras/TableTools/ */
					
							/* Set tabletools buttons and button container */
					
							$.extend(true, $.fn.DataTable.TableTools.classes, {
								"container": "btn-group tabletools-dropdown-on-portlet",
								"buttons": {
									"normal": "btn btn-sm default",
									"disabled": "btn btn-sm default disabled"
								},
								"collection": {
									"container": "DTTT_dropdown dropdown-menu tabletools-dropdown-menu"
								}
							});
					
							var oTable = table12.dataTable({
					
								// Internationalisation. For more info refer to http://datatables.net/manual/i18n
								"language": {
					
								"sEmptyTable":      "Keine Daten in der Tabelle vorhanden",
								"sInfo":            "_START_ bis _END_ von _TOTAL_ Einträgen",
								"sInfoEmpty":       "0 bis 0 von 0 Einträgen",
								"sInfoFiltered":    "(gefiltert von _MAX_ Einträgen)",
								"sInfoPostFix":     "",
								"sInfoThousands":   ".",
								"sLengthMenu":      "_MENU_ Einträge anzeigen",
								"sLoadingRecords":  "Wird geladen...",
								"sProcessing":      "Bitte warten...",
								"sSearch":          "Suchen",
								"sZeroRecords":     "Keine Einträge vorhanden.",
								"oPaginate": {
									"sFirst":       "Erste",
									"sPrevious":    "Zurück",
									"sNext":        "Nächste",
									"sLast":        "Letzte"
								},
								"oAria": {
									"sSortAscending":  ": aktivieren, um Spalte aufsteigend zu sortieren",
									"sSortDescending": ": aktivieren, um Spalte absteigend zu sortieren"
									}
								},
					
								// Or you can use remote translation file
								//"language": {
								//   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
								//},
								
								"bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.
					
								"order": [
									[3, 'desc']
								],
								
								"lengthMenu": [
									[5, 10, 15, 20, -1],
									[5, 10, 15, 20, "Alle"] // change per page values here
								],
								// set the initial value
								"pageLength": -1,
					
								"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
					
								// Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
								// setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
								// So when dropdowns used the scrollable div should be removed. 
								//"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
					
								"tableTools": {
									"sSwfPath": "<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
									"aButtons": [{
										"sExtends": "pdf",
										"sButtonText": "PDF"
									}, {
										"sExtends": "csv",
										"sButtonText": "CSV"
									}, {
										"sExtends": "xls",
										"sButtonText": "Excel"
									}, {
										"sExtends": "print",
										"sButtonText": "Print",
										"sInfo": 'Please press "CTRL+P" to print or "ESC" to quit',
										"sMessage": "Generated by DataTables"
									}, {
										"sExtends": "copy",
										"sButtonText": "Copy"
									}]
								}
							});
					
							var tableWrapper = $('#sample_3_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper
					
							tableWrapper.find('.dataTables_length select').select2();// initialize select2 dropdown
						}
							initTable3();
					   }								   		   		
					});
				});	
				
		
		
		
		var table12 = $('#sample_3');

        /* Table tools samples: https://www.datatables.net/release-datatables/extras/TableTools/ */

        /* Set tabletools buttons and button container */

        $.extend(true, $.fn.DataTable.TableTools.classes, {
            "container": "btn-group tabletools-dropdown-on-portlet",
            "buttons": {
                "normal": "btn btn-sm default",
                "disabled": "btn btn-sm default disabled"
            },
            "collection": {
                "container": "DTTT_dropdown dropdown-menu tabletools-dropdown-menu"
            }
        });

        var oTable = table12.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
					
			"sEmptyTable":      "Keine Daten in der Tabelle vorhanden",
			"sInfo":            "_START_ bis _END_ von _TOTAL_ Einträgen",
			"sInfoEmpty":       "0 bis 0 von 0 Einträgen",
			"sInfoFiltered":    "(gefiltert von _MAX_ Einträgen)",
			"sInfoPostFix":     "",
			"sInfoThousands":   ".",
			"sLengthMenu":      "_MENU_ Einträge anzeigen",
			"sLoadingRecords":  "Wird geladen...",
			"sProcessing":      "Bitte warten...",
			"sSearch":          "Suchen",
			"sZeroRecords":     "Keine Einträge vorhanden.",
			"oPaginate": {
				"sFirst":       "Erste",
				"sPrevious":    "Zurück",
				"sNext":        "Nächste",
				"sLast":        "Letzte"
			},
			"oAria": {
				"sSortAscending":  ": aktivieren, um Spalte aufsteigend zu sortieren",
				"sSortDescending": ": aktivieren, um Spalte absteigend zu sortieren"
				}
			},

            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},
			
			"bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

            "order": [
                [3, 'desc']
            ],
            
            "lengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "Alle"] // change per page values here
            ],
            // set the initial value
            "pageLength": -1,

            "dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

            "tableTools": {
				"sSwfPath": "<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
				"aButtons": [{
					"sExtends": "pdf",
					"sButtonText": "PDF"
				}, {
					"sExtends": "csv",
					"sButtonText": "CSV"
				}, {
					"sExtends": "xls",
					"sButtonText": "Excel"
				}, {
					"sExtends": "print",
					"sButtonText": "Print",
					"sInfo": 'Please press "CTRL+P" to print or "ESC" to quit',
					"sMessage": "Generated by DataTables"
				}, {
					"sExtends": "copy",
					"sButtonText": "Copy"
				}]
			}
        });

        var tableWrapper = $('#sample_3_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper

        tableWrapper.find('.dataTables_length select').select2();
				
				
				
		
		
		var table1 = $('#performance_page_table_up_sample_10');

        /* Table tools samples: https://www.datatables.net/release-datatables/extras/TableTools/ */

        /* Set tabletools buttons and button container */

        $.extend(true, $.fn.DataTable.TableTools.classes, {
            "container": "btn-group tabletools-dropdown-on-portlet",
            "buttons": {
                "normal": "btn btn-sm default",
                "disabled": "btn btn-sm default disabled"
            },
            "collection": {
                "container": "DTTT_dropdown dropdown-menu tabletools-dropdown-menu"
            }
        });

        var oTable = table1.dataTable({

            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
					
			"sEmptyTable":      "Keine Daten in der Tabelle vorhanden",
			"sInfo":            "_START_ bis _END_ von _TOTAL_ Einträgen",
			"sInfoEmpty":       "0 bis 0 von 0 Einträgen",
			"sInfoFiltered":    "(gefiltert von _MAX_ Einträgen)",
			"sInfoPostFix":     "",
			"sInfoThousands":   ".",
			"sLengthMenu":      "_MENU_ Einträge anzeigen",
			"sLoadingRecords":  "Wird geladen...",
			"sProcessing":      "Bitte warten...",
			"sSearch":          "Suchen",
			"sZeroRecords":     "Keine Einträge vorhanden.",
			"oPaginate": {
				"sFirst":       "Erste",
				"sPrevious":    "Zurück",
				"sNext":        "Nächste",
				"sLast":        "Letzte"
			},
			"oAria": {
				"sSortAscending":  ": aktivieren, um Spalte aufsteigend zu sortieren",
				"sSortDescending": ": aktivieren, um Spalte absteigend zu sortieren"
				}
			},

            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},
			
			"bStateSave": true, // save datatable state(pagination, sort, etc) in cookie.

            "order": [
                [0, 'asc']
            ],
            
            "lengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "Alle"] // change per page values here
            ],
            // set the initial value
            "pageLength": -1,

            "dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",

            "tableTools": {
				"sSwfPath": "<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
				"aButtons": [{
					"sExtends": "pdf",
					"sButtonText": "PDF"
				}, {
					"sExtends": "csv",
					"sButtonText": "CSV"
				}, {
					"sExtends": "xls",
					"sButtonText": "Excel"
				}, {
					"sExtends": "print",
					"sButtonText": "Print",
					"sInfo": 'Please press "CTRL+P" to print or "ESC" to quit',
					"sMessage": "Generated by DataTables"
				}, {
					"sExtends": "copy",
					"sButtonText": "Copy"
				}]
			}
        });

        var tableWrapper = $('#performance_page_table_up_sample_10_wrapper'); // datatable creates the table wrapper by adding with id {your_table_jd}_wrapper

        tableWrapper.find('.dataTables_length select').select2();						
				
	</script>	
    
    <!-----PAGE LEVEL SCRIPTS END--->    
        
        <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>