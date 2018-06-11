
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">IST Leave System</a>
            </div>
            <!-- /.navbar-header -->
			
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                         
                            <!--CHANGED CODE-->
                        <li><a href="changepass.php"><i class="fa fa-gear fa-fw"></i> CHANGE PASSWORD</a>
                         <!--CHANGED CODE-->

                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li class='nav nav-first-level'>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li class='nav nav-second-level'>
                            <a href="#"><i class="fa fa-edit fa-fw"></i> Leave<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level ">
                                <li>
                                    <a href="#">Casual Leave (CL)</a>
									<ul class="nav nav-third-level ">
										<li>
											<a href="cl.php">Multiple Days</a><!--p id="md">Multiple Days</p-->
										</li>
										<li>
											<a href="hcl.php">Half Day</a>
										</li>
									</ul>
                                </li>
                                <li>
                                    <a href="rh.php">Restricted Holiday (RH)</a>
                                </li>
                                <li>
                                    <a href="#">Special Casual Leave (SCL)</a>
									<ul class="nav nav-third-level ">
										<li>
											<a href="scl.php">Multiple Days</a>
										</li>
										<li>
											<a href="hscl.php">Half Day</a>
										</li>
									</ul>
                                </li>
								<li>
                                    <a href="#">On Duty (OD) </a>
									<ul class="nav nav-third-level ">
										<li>
											<a href="od.php">Multiple Days</a>
										</li>
										<li>
											<a href="hod.php">Half Day</a>
										</li>
									</ul>
                                </li>
								<li>
                                    <a href="ml.php">Medical Leave (ML)</a>
                                </li>
								<li>
                                    <a href="el.php">Earn Leave(EL)</a>
                                </li>
                                <li>
                                    <a href="#">Compensation Leave (CPL)</a>
									<ul class="nav nav-third-level ">
										<li>
											<a href="cplcredits.php">Add CPL Credits</a>
										</li>
										<li>
											<a href="compensation.php">Compensation Leave</a>
										</li>
									</ul>
                                </li>
							</ul>
                            <!-- /.nav-second-level -->
                        </li>
						<li class='nav nav-first-level'>
                            <a href="#"><i class="fa fa-edit fa-fw"></i>View Holidays<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level ">
								<li>
                                    <a href="view-ph.php">View Public Holidays</a>
                                </li>
								<li>
                                    <a href="view-rh.php">View Restricted Holidays</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
						<li class='nav nav-first-level'>
							<a href="staff-report.php"><i class="fa fa-book fa-fw"></i> Reports</a>
                        </li>
                        <li class='nav nav-first-level'>
							<a href="javascript:history.back(1)"><i class="fa fa-backward"></i> Back</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
<script src="../bower_components/jquery/dist/jquery.min.js"></script>

<script src="headerHelper.js"></script>
	
