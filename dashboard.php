<?php
    session_start();
    
    if(array_key_exists('username',$_COOKIE) && ($_COOKIE['role'] == 'admin' || $_COOKIE['role'] == 'pharmacist')){
        $_SESSION['username'] = $_COOKIE['username'];
        $_SESSION['role'] = $_COOKIE['role'];
    }
    
    if(array_key_exists('username',$_SESSION) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'pharmacist')){
        $logout_link = "index.php?logout=1";
        if($_SESSION['role'] == 'pharmacist'){
            $sidebar = "<a href='billing.php'>Billing</a>";
        }

        if($_SESSION['role'] == 'admin'){
            $sidebar = "<a href='users.php'>Users</a>";
        }
    }else{
    	include('rolecheck.php');
        header('LOCATION:index.php');
        die();
    }
    include("include.php");

        if($_POST['from']!="" && $_POST['to']!=""){
            if($_POST['from']<=$_POST['to']){
                $query = "SELECT total,date,total_qty FROM customers WHERE date BETWEEN '".$_POST['from']." 00:00:01' AND '".$_POST['to']." 23:59:59'";

                    if(!($result = mysqli_query($connection,$query))){
                        echo mysqli_error($connection);
                    }
            
                    $prev_date = date("d-m-Y",strtotime("00-00-0000"));
                    $date_arr = array();
                    $total_arr = array();
                    $customer_arr = array();
                    $timestamp_arr = array();
                    $total_qty_arr = array();
            
                    $total = 0;
                    $customer=0;
                    $total_qty = 0;
                    while($row = mysqli_fetch_array($result)){
                        $timestamp = strtotime($row['date']);
                        $ts = date("Y-m-d H:i",$timestamp);
            
                        $date = date("Y-m-d",$timestamp);
            
                        if($date!=$prev_date){
                            if(!empty($date_arr)){
                                array_push($total_arr,$total);
                            }
            
                            if(!empty($date_arr)){
                                array_push($customer_arr,$customer);
                            }
            
                            if(!empty($date_arr)){
                                array_push($total_qty_arr,$total_qty);
                            }
            
                            array_push($date_arr, $date);
                            array_push($timestamp_arr,$ts);
            
                            $total = $row['total'];
                            $total_qty = $row['total_qty'];
                            $customer =1;
                            $prev_date = $date;
                        }else{
                            $total+=$row['total'];
                            $total_qty+= $row['total_qty'];
                            $customer+=1;
                        }
                    }
            
                    array_push($total_arr,$total);
                    array_push($customer_arr,$customer);
                    array_push($total_qty_arr,$total_qty);
            
            
                    for($i=0; $i<sizeof($date_arr); $i++){
                        $bar_chart_data .= "{days: '".$date_arr[$i]."',earning:".$total_arr[$i]."}, ";
                        $line_chart_data .= "{ts: '".$timestamp_arr[$i]."',customer:".$customer_arr[$i]."}, ";
                        $area_chart_data .= "{days: '".$date_arr[$i]."',total_qty:".$total_qty_arr[$i]."}, ";
                    }
            
                    $bar_chart_data = substr($bar_chart_data, 0,-2);
                    $line_chart_data = substr($line_chart_data, 0,-2);
                    $area_chart_data = substr($area_chart_data, 0,-2);
            
                    $query = "SELECT name,units_sold FROM stocks ORDER BY units_sold DESC LIMIT 0,5";
                    $result = mysqli_query($connection,$query);
            
                    while($row = mysqli_fetch_array($result)){
                        $bar_graph_data .= "{medicine:'".mysqli_real_escape_string($connection,$row['name'])."',sold:'".$row['units_sold']."'}, ";
                    }
            
                    $bar_graph_data = substr($bar_graph_data,0,-2);
                }else{
                    $error= '<div class="alert alert-danger" role="alert">FROM date should be less than or equal to TO date</div>';
                }
            }

            if(($_POST['from']!="" && $_POST['to']=="") || ($_POST['from']=="" && $_POST['to']!="")){
                $error = '<div class="alert alert-danger" role="alert">Enter Both the dates</div>';
            }

?>
<!DOCTYPE html>
<html>
<head>
	<title>Pharmacy Manager</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<link rel="stylesheet" type="text/css" href="css/style.css">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

</head>
<body>
	<div id="main-container-pages" style="position: relative;z-index: 0;">
    	    <nav class="navbar navbar-dark bg-danger" >
    	    	<button type="button" id="menu-toggler" style="padding:0;border:none"><img src="Images/menu.jpg" width="45" style="border-radius: 5px;float: left;"></button>
    	        <a class="navbar-brand py-2" href="#" id="top-bar">
    	            Pharmacy Manager
    	            <img src="Images/logo.jpg" id="logo" width="50" height="50" class="d-inline-block align-top" alt="Logo">
    	        </a>
    	    </nav>

            <p id="dashboard-title">Dashboard</p>

            <form method="post" id="timeline">
              <?php echo $error; ?>
              <div class="row">
                <div class="col">
                  <label for="from" >From</label>
                  <input type="date" class="form-control" id="from" placeholder="First name" name="from">
                </div>
                <div class="col">
                  <label for="to" >To</label>
                  <input type="date" class="form-control" id="to" placeholder="Last name" name="to">
                </div>
              <button type="submit" class="btn btn-success" style="margin-top: 30px;">Submit</button>
              </div>
            </form>

            <div class="graph shadow p-3 mb-5 bg-white rounded" id="bar-graph">
                <p class="title">Bar graph of Daily Earnings</p>
            </div>

            <div class="graph shadow p-3 mb-5 bg-white rounded" id="line-graph">
                <p class="title">Line Chart of Number of Customers</p>
            </div>

            <div class="graph shadow p-3 mb-5 bg-white rounded" id="area-graph" style="margin-top: 5%;">
                <p class="title">Area Chart of Total Number of Medicines Sold</p>
            </div>

            <div class="graph shadow p-3 mb-5 bg-white rounded" id="med-bar-graph" style="margin-top: 5%;">
                <p class="title">Bar graph of Most sold medicines</p>
            </div>

    </div>

	<div class="off">
		<a class="closebtn">&times;</a>
		<div id="mySidenav">
		  <a href="admin.php">Home</a>
		  <?php echo $sidebar; ?>
		  <a href="stocks.php">Stocks</a>
		  <a href=<?php echo $logout_link; ?>>Log Out</a>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script type="text/javascript" src="js/script.js"></script>

	<script type="text/javascript">


        Morris.Bar({
            element :'bar-graph',
            data : [<?php echo $bar_chart_data; ?>],
            xkey : ['days'],
            barColors: ["blue"],
            ykeys : ['earning'],
            labels : ['Earnings'],
            hideHover : 'auto',
        })

        Morris.Line({
            element :'line-graph',
            data : [<?php echo $line_chart_data; ?>],
            lineColors: ["orange"],
            xkey : ['ts'],
            ykeys : ['customer'],
            labels : ['Customers'],
            hideHover : 'auto',
        })

        Morris.Area({
            element :'area-graph',
            data : [<?php echo $area_chart_data; ?>],
            lineColors: ["red"],
            xkey : ['days'],
            ykeys : ['total_qty'],
            labels : ['Total Medicines'],
            hideHover : 'auto',
        })

        Morris.Bar({
            element :'med-bar-graph',
            data : [<?php echo $bar_graph_data; ?>],
            barColors: ["#65ff00"],
            xkey : ['medicine'],
            ykeys : ['sold'],
            labels : ['Units Sold'],
            hideHover : 'auto',
        })
	</script>
</body>
</html>
