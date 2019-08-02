<?php 

$exercise_id = $_REQUEST["exercise_id"];

$user_id = $_REQUEST["user_id"];

$sql = "select exercise_title from ".$db_suffix."exercise where exercise_id = '$exercise_id' limit 1";				
$query = mysqli_query($db, $sql);

if(mysqli_num_rows($query) > 0)
{
	$content     = mysqli_fetch_object($query);	
	$exercise_title       = $content->exercise_title;
}


$sql = "select user_first_name, user_last_name from ".$db_suffix."user where user_id = '$user_id' limit 1";				
$query = mysqli_query($db, $sql);

if(mysqli_num_rows($query) > 0)
{
	$usr = mysqli_fetch_object($query);
	$user_name=$usr->user_first_name.' '.$usr->user_last_name;
}

$sql = "SELECT percentage FROM ".$db_suffix."history where user_id='$user_id' AND exercise_id='$exercise_id' ORDER BY date_taken ASC";
$news_query = mysqli_query($db,$sql);

$chart_info='';
$perv_val='';
$i=1;
while($row = mysqli_fetch_object($news_query)){

	$chart_info.="['Versuch-".$i."', ".$row->percentage."], "; 
	
	$i++;		
}
	
$chart_info=substr($chart_info,0,-2);


?>

<!-----PAGE LEVEL CSS BEGIN--->


<!-----PAGE LEVEL CSS END--->

							<h3 class="page-title">
                                                Leistungsdiagramm [<strong><?php echo $exercise_title; ?></strong>] <small><strong><?php echo $user_name; ?></strong></small>
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


                        <div class="portlet light">
                <div class="portlet-body form">
                    <div class="row">
                    	<div class="col-md-12">
                        	<div class="portlet solid grey-cararra bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa-bar-chart-o"></i>Leistungsdiagramm
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div id="site_activities_loading">
                                        <img src="<?php echo SITE_URL_ADMIN; ?>assets/admin/layout/img/loading.gif" alt="loading"/>
                                    </div>
                                    <div id="site_activities_content" class="display-none">
                                        <div id="site_activities" style="height: 250px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
					
                        
                        </div>
                    </div>
                    </div>
                </div>
         


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
       
       <script src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<script src="<?php echo SITE_URL_ADMIN; ?>assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>


<script>
		jQuery(document).ready(function() { 
		
			function showChartTooltip(x, y, xValue, yValue) {
                $('<div id="tooltip" class="chart-tooltip">' + yValue + '<\/div>').css({
                    position: 'absolute',
                    display: 'none',
                    top: y - 40,
                    left: x - 40,
                    border: '0px solid #ccc',
                    padding: '2px 6px',
                    'background-color': '#fff'
                }).appendTo("body").fadeIn(200);
            }
			
			if ($('#site_activities').size() != 0) {
                //site activities
                var previousPoint2 = null;
                $('#site_activities_loading').hide();
                $('#site_activities_content').show();

                var data1 = [<?php echo $chart_info; ?>];


                var plot_statistics = $.plot($("#site_activities"),

                    [{
                        data: data1,
                        lines: {
                            fill: 0.2,
                            lineWidth: 0,
                        },
                        color: ['#BAD9F5']
                    }, {
                        data: data1,
                        points: {
                            show: true,
                            fill: true,
                            radius: 4,
                            fillColor: "#9ACAE6",
                            lineWidth: 2
                        },
                        color: '#9ACAE6',
                        shadowSize: 1
                    }, {
                        data: data1,
                        lines: {
                            show: true,
                            fill: false,
                            lineWidth: 3
                        },
                        color: '#9ACAE6',
                        shadowSize: 0
                    }],

                    {
						xaxis: {
                            tickLength: 0,
                            tickDecimals: 0,
                            mode: "categories",
                            min: 0,
                            font: {
                                lineHeight: 18,
                                style: "normal",
                                variant: "small-caps",
                                color: "#6F7B8A"
                            }
                        },
                        yaxis: {
                            ticks: 5,
                            tickDecimals: 0,
                            tickColor: "#eee",
                            font: {
                                lineHeight: 14,
                                style: "normal",
                                variant: "small-caps",
                                color: "#6F7B8A"
                            }
                        },
                        grid: {
                            hoverable: true,
                            clickable: true,
                            tickColor: "#eee",
                            borderColor: "#eee",
                            borderWidth: 1
                        }
                    });

                $("#site_activities").bind("plothover", function (event, pos, item) {
                    $("#x").text(pos.x.toFixed(2));
                    $("#y").text(pos.y.toFixed(2));
                    if (item) {
                        if (previousPoint2 != item.dataIndex) {
                            previousPoint2 = item.dataIndex;
                            $("#tooltip").remove();
                            var x = item.datapoint[0].toFixed(2),
                                y = item.datapoint[1].toFixed(2);
                            showChartTooltip(item.pageX, item.pageY, item.datapoint[0], item.datapoint[1] + '%');
                        }
                    }
                });

                $('#site_activities').bind("mouseleave", function () {
                    $("#tooltip").remove();
                });
            }
			
						   	   
		});				
		
</script>	
    
    <!-----PAGE LEVEL SCRIPTS END--->    
        
        <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>