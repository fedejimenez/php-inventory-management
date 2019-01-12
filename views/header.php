<?php  
  require_once("../config/connection.php");

  if (isset($_SESSION["id_user"])) {

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Purchase - Sales System | PHP </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../public/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../public/bower_components/Ionicons/css/ionicons.min.css">

  <!-- DataTables -->
  <!-- <link rel="stylesheet" href="../public/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"> -->
  <link rel="stylesheet" href="../public/datatables/jquery.dataTables.min.css">
  <link rel="stylesheet" href="../public/datatables/buttons.dataTables.min.css">
  <link rel="stylesheet" href="../public/datatables/responsive.dataTables.min.css">
  

  <!-- Theme style -->
  <link rel="stylesheet" href="../public/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../public/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="../public/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="../public/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="../public/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../public/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="../public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <!-- cutstomized styles -->
  <link rel="stylesheet" href="../public/css/styles.css">

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Purchase - Sales</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
             
             <!-- <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
              <i class="fa fa-user" aria-hidden="true"></i>
              <span class="hidden-xs"><?php echo $_SESSION["user"]?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <!--<img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">-->

                 <i class="fa fa-user" aria-hidden="true"></i>

                <p>
                  <?php echo $_SESSION["name"]?>
                  <?php echo $_SESSION["lastname"]?>
                  <small> Fullstack Web Developer</small>
                </p>
              </li>
              <!-- Menu Body -->
              <!--<li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>-->
                <!-- /.row -->
              <!--</li>-->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat" onclick="show_profile('<?php echo $_SESSION["id_user"]?>')" data-toggle="modal" data-target="#profileModal">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="logout.php" class="btn btn-default btn-flat">Logout</a>
                </div>
              </li>
            </ul>
          </li>
       
        </ul>
      </div>
    </nav>
  </header>

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
     
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU</li>
        <li class="">
          <a href="home.php">
            <i class="fa fa-home" aria-hidden="true"></i> <span>Home</span>
          </a>
        </li>

         <li class="">
          <a href="categories.php">
            <i class="fa fa-list" aria-hidden="true"></i> <span>Category</span>
            <span class="pull-right-container badge bg-blue">
              <i class="fa fa-bell pull-right">20</i>
            </span>
          </a>
        </li>

         <li class="">
          <a href="products.php">
            <i class="fa fa-tasks" aria-hidden="true"></i> <span>Products</span>
            <span class="pull-right-container badge bg-blue">
              <i class="fa fa-bell pull-right">20</i>
            </span>
          </a>
        </li>

         <li class="">
            <a href="proveedores.php">
              <i class="fa fa-users"></i> <span>Suppliers</span>
              <span class="pull-right-container badge bg-blue">
                <i class="fa fa-bell pull-right">5</i>
              </span>
            </a>
          </li>

           <li class="treeview">
          <a href="purchases.php">
            <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span>Purchases</span>
            <span class="pull-right-container badge bg-blue">
              <i class="fa fa-bell pull-right">10</i>
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="purchases.php"><i class="fa fa-circle-o"></i>Purchases</a></li>
            <li><a href="purchases_view.php"><i class="fa fa-circle-o"></i>View Purchases</a></li>
            <li><a href="purchases_view_dates.php"><i class="fa fa-circle-o"></i>View Purchases - Dates</a></li>
            <li><a href="purchases_view_month.php"><i class="fa fa-circle-o"></i>View Purchases - Monthy</a></li>
          </ul> 
        </li>

           <li class="">
          <a href="clientes.php">
            <i class="fa fa-users"></i> <span>Clients</span>
            <span class="pull-right-container badge bg-blue">
              <i class="fa fa-bell pull-right">3</i>
            </span>
          </a>
        </li>

         <li class="treeview">
          <a href="ventas.php">
            <i class="fa fa-suitcase" aria-hidden="true"></i> <span>Sales</span>
            <span class="pull-right-container badge bg-blue">
              <i class="fa fa-bell pull-right">8</i>
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="sales.php"><i class="fa fa-circle-o"></i>Sales</a></li>
            <li><a href="sales_view.php"><i class="fa fa-circle-o"></i>View Sales</a></li>
            <li><a href="sales_view_dates.php"><i class="fa fa-circle-o"></i>View Sales - Dates</a></li>
            <li><a href="sales_view_month.php"><i class="fa fa-circle-o"></i>View Sales - Monthy</a></li>
          </ul> 
        </li>

        <li class="treeview">
          <a href="purchases_report.php">
            <i class="fa fa-bar-chart" aria-hidden="true"></i> <span> Reports - Purchases</span>
            <span class="pull-right-container badge bg-blue">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="report_general_purchases.php"><i class="fa fa-circle-o"></i>Report - General Purchases</a></li>
            <li><a href="report_monthly_purchases.php"><i class="fa fa-circle-o"></i>Report - Monthy Purchases</a></li>
            <li><a href="report_supplier_purchases.php"><i class="fa fa-circle-o"></i>Report - Purchaces by Supplier</a></li>
          </ul> 
        </li>

        <li class="treeview">
          <a href="sales_report.php">
            <i class="fa fa-pie-chart" aria-hidden="true"></i> <span> Reports - Sales</span>
            <span class="pull-right-container badge bg-blue">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="report_general_sales.php"><i class="fa fa-circle-o"></i>Report - General Sales</a></li>
            <li><a href="report_monthly_sales.php"><i class="fa fa-circle-o"></i>Report - Monthy Sales</a></li>
            <li><a href="report_supplier_sales.php"><i class="fa fa-circle-o"></i>Report - Sales by Client</a></li>
          </ul> 
        </li>


        <li class="">
          <a href="users.php">
            <i class="fa fa-user" aria-hidden="true"></i> <span>Users</span>
            <span class="pull-right-container badge bg-blue">
              <i class="fa fa-bell pull-right">3</i>
            </span>
          </a>
        </li>

<!--          <li class="">
          <a href="backup.php">
            <i class="fa fa-database" aria-hidden="true"></i> <span>BackUp</span>
            <span class="pull-right-container badge bg-blue">
              <i class="fa fa-bell pull-right">3</i>
            </span>
          </a>
        </li> -->

         <li class="">
          <a href="">
            <i class="fa fa-building" aria-hidden="true"></i> <span>Company</span>
          </a>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <div id="results_ajax" class="text-center"></div>

  <!-- FORM USER PROFILE - MODAL -->
  <div id="profileModal" class="modal fade">
    <div class="modal-dialog">
      <form action="" class="form-horizontal" method="post" id="profile_form">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Edit Profile</h4> 
          </div>
          <div class="modal-body">

            <div class="form-group">
              <label for="inputText3" class="col-lg-1 control-label">Id Number</label>
              <div class="col-lg-9 col-lg-offset-1" >
                <input type="text" name="idnumber_profile" id="idnumber_profile" class="form-control" placeholder="Id Number" required pattern="[0-9]{0,12}">
              </div>
            </div>

            <div class="form-group">
              <label for="inputText1" class="col-lg-1 control-label">Name</label>
              <div class="col-lg-9 col-lg-offset-1" >
                <input type="text" name="name_profile" id="name_profile" class="form-control" placeholder="Name" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$">
              </div>
            </div>

            <div class="form-group">
              <label for="inputText1" class="col-lg-1 control-label">Last Name</label>
              <div class="col-lg-9 col-lg-offset-1" >
                <input type="text" name="lastname_profile" id="lastname_profile" class="form-control" placeholder="Last Name" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$">
              </div>
            </div>

            <div class="form-group">
              <label for="inputText1" class="col-lg-1 control-label">User</label>
              <div class="col-lg-9 col-lg-offset-1" >
                <input type="text" name="user_profile" id="user_profile" class="form-control" placeholder="User" required pattern="^[a-zA-Z_áéíóúñ\s]{0,30}$">
              </div>
            </div>

            <div class="form-group">
              <label for="inputText3" class="col-lg-1 control-label">Password</label>
              <div class="col-lg-9 col-lg-offset-1" >
                <input type="password" name="password_profile" id="password_profile" class="form-control" placeholder="Password" required ">
              </div>
            </div>
            
            <div class="form-group">
              <label for="inputText3" class="col-lg-1 control-label">Password Confirmation</label>
              <div class="col-lg-9 col-lg-offset-1" >
                <input type="password" name="password2_profile" id="password2_profile" class="form-control" placeholder="Password" required ">
              </div>
            </div>
            

            <div class="form-group">
              <label for="inputText4" class="col-lg-1 control-label">Phone</label>
              <div class="col-lg-9 col-lg-offset-1" >
                <input type="text" name="phone_profile" id="phone_profile" class="form-control" placeholder="Phone" required pattern="^[0-9]{0,15}$">
              </div>
            </div>

            <div class="form-group">
              <label for="inputText4" class="col-lg-1 control-label">Email</label>
              <div class="col-lg-9 col-lg-offset-1" >
                <input type="email" name="email_profile" id="email_profile" class="form-control" placeholder="Email" required ">
              </div>
            </div>

            <div class="form-group">
              <label for="inputText4" class="col-lg-1 control-label">Address</label>
              <div class="col-lg-9 col-lg-offset-1" >
                <textarea cols="90" rows="3" name="address_profile" id="address_profile" class="form-control" placeholder="Address" required pattern="^[a-zA-Z0-9_áéíóúñ\s]{0,200}$">
                </textarea>
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <input type="hidden" name="id_user_profile" id="id_user_profile">

            <button type="submit" name="action" id="" class="btn btn-success pull-left" value="Add"><i class="fa fa-floppy-o" aria-hidden="true"></i>Save</button>

            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>Close</button>
          
          </div>
        </div>
      </form>
    </div>
  </div>

  <script src="../public/bower_components/jquery/dist/jquery.min.js"></script>

  <script type="text/javascript" src="js/profile.js"></script>

<?php  
  } else {
    header("Location:".Connect::route()."views/index.php");
    exit();
  }
  
?>