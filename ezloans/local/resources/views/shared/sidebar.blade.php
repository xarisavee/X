<?php
	$url = $_SERVER['REQUEST_URI'];
?>
	
<nav class="navbar navbar-default navbar-static-top" style="margin-bottom: 0;">
	<div class="container-fluid">
		 <div class="navbar-header">
	        <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
	        <a href="javascript:void(0);" class="bars"></a>
	        <a class="navbar-brand" href="">{{ strtoupper($domain) }} Admin</a>
	    </div>
	    <div class="collapse navbar-collapse" id="navbar-collapse">
	        <ul class="nav navbar-nav navbar-right">
	            <!-- Call Search -->
	            <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
	            <!-- #END# Call Search -->
	            <!-- Notifications -->
	            <li class="dropdown">
	                <a href="{{ route('loanrequests', array('domain' => $domain, 'user_id' => $userinfo['user_id'])) }}" role="button">
	                    <i class="material-icons">notifications</i>
	                    <span class="label-count">@if($userinfo['pendings'] != "0") {{ $userinfo['pendings'] }} @endif</span>
	                </a>
	                <!-- <ul class="dropdown-menu">
	                    <li class="header">NOTIFICATIONS</li>
	                    <li class="body">
	                        <ul class="menu">
	                            <li>
	                                <a href="javascript:void(0);">
	                                    <div class="icon-circle bg-light-green">
	                                        <i class="material-icons">person_add</i>
	                                    </div>
	                                    <div class="menu-info">
	                                        <h4>12 new members joined</h4>
	                                        <p>
	                                            <i class="material-icons">access_time</i> 14 mins ago
	                                        </p>
	                                    </div>
	                                </a>
	                            </li>
	                            <li>
	                                <a href="javascript:void(0);">
	                                    <div class="icon-circle bg-cyan">
	                                        <i class="material-icons">add_shopping_cart</i>
	                                    </div>
	                                    <div class="menu-info">
	                                        <h4>4 sales made</h4>
	                                        <p>
	                                            <i class="material-icons">access_time</i> 22 mins ago
	                                        </p>
	                                    </div>
	                                </a>
	                            </li>
	                            <li>
	                                <a href="javascript:void(0);">
	                                    <div class="icon-circle bg-red">
	                                        <i class="material-icons">delete_forever</i>
	                                    </div>
	                                    <div class="menu-info">
	                                        <h4><b>Nancy Doe</b> deleted account</h4>
	                                        <p>
	                                            <i class="material-icons">access_time</i> 3 hours ago
	                                        </p>
	                                    </div>
	                                </a>
	                            </li>
	                            <li>
	                                <a href="javascript:void(0);">
	                                    <div class="icon-circle bg-orange">
	                                        <i class="material-icons">mode_edit</i>
	                                    </div>
	                                    <div class="menu-info">
	                                        <h4><b>Nancy</b> changed name</h4>
	                                        <p>
	                                            <i class="material-icons">access_time</i> 2 hours ago
	                                        </p>
	                                    </div>
	                                </a>
	                            </li>
	                            <li>
	                                <a href="javascript:void(0);">
	                                    <div class="icon-circle bg-blue-grey">
	                                        <i class="material-icons">comment</i>
	                                    </div>
	                                    <div class="menu-info">
	                                        <h4><b>John</b> commented your post</h4>
	                                        <p>
	                                            <i class="material-icons">access_time</i> 4 hours ago
	                                        </p>
	                                    </div>
	                                </a>
	                            </li>
	                            <li>
	                                <a href="javascript:void(0);">
	                                    <div class="icon-circle bg-light-green">
	                                        <i class="material-icons">cached</i>
	                                    </div>
	                                    <div class="menu-info">
	                                        <h4><b>John</b> updated status</h4>
	                                        <p>
	                                            <i class="material-icons">access_time</i> 3 hours ago
	                                        </p>
	                                    </div>
	                                </a>
	                            </li>
	                            <li>
	                                <a href="javascript:void(0);">
	                                    <div class="icon-circle bg-purple">
	                                        <i class="material-icons">settings</i>
	                                    </div>
	                                    <div class="menu-info">
	                                        <h4>Settings updated</h4>
	                                        <p>
	                                            <i class="material-icons">access_time</i> Yesterday
	                                        </p>
	                                    </div>
	                                </a>
	                            </li>
	                        </ul>
	                    </li>
	                    <li class="footer">
	                        <a href="javascript:void(0);">View All Notifications</a>
	                    </li>
	                </ul> -->
	            </li>
	            <!-- #END# Notifications -->
	            <!-- Tasks -->
	            <!-- <li class="dropdown">
	                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
	                    <i class="material-icons">flag</i>
	                    <span class="label-count">9</span>
	                </a>
	                <ul class="dropdown-menu">
	                    <li class="header">TASKS</li>
	                    <li class="body">
	                        <ul class="menu tasks">
	                            <li>
	                                <a href="javascript:void(0);">
	                                    <h4>
	                                        Footer display issue
	                                        <small>32%</small>
	                                    </h4>
	                                    <div class="progress">
	                                        <div class="progress-bar bg-pink" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 32%">
	                                        </div>
	                                    </div>
	                                </a>
	                            </li>
	                            <li>
	                                <a href="javascript:void(0);">
	                                    <h4>
	                                        Make new buttons
	                                        <small>45%</small>
	                                    </h4>
	                                    <div class="progress">
	                                        <div class="progress-bar bg-cyan" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 45%">
	                                        </div>
	                                    </div>
	                                </a>
	                            </li>
	                            <li>
	                                <a href="javascript:void(0);">
	                                    <h4>
	                                        Create new dashboard
	                                        <small>54%</small>
	                                    </h4>
	                                    <div class="progress">
	                                        <div class="progress-bar bg-teal" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 54%">
	                                        </div>
	                                    </div>
	                                </a>
	                            </li>
	                            <li>
	                                <a href="javascript:void(0);">
	                                    <h4>
	                                        Solve transition issue
	                                        <small>65%</small>
	                                    </h4>
	                                    <div class="progress">
	                                        <div class="progress-bar bg-orange" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 65%">
	                                        </div>
	                                    </div>
	                                </a>
	                            </li>
	                            <li>
	                                <a href="javascript:void(0);">
	                                    <h4>
	                                        Answer GitHub questions
	                                        <small>92%</small>
	                                    </h4>
	                                    <div class="progress">
	                                        <div class="progress-bar bg-purple" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 92%">
	                                        </div>
	                                    </div>
	                                </a>
	                            </li>
	                        </ul>
	                    </li>
	                    <li class="footer">
	                        <a href="javascript:void(0);">View All Tasks</a>
	                    </li>
	                </ul>
	            </li> -->
	            <!-- #END# Tasks -->
	            <!-- <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li> -->
	        </ul>
	    </div>
	</div>

	<div class="navbar-default sidebar" role="navigation">
		<div class="user-info">
            <div class="image">
                <img src="{{ asset('images/user.png') }}" width="50" height="50" alt="User" />
            </div>
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ ucwords($userinfo['user_fname']." ".$userinfo['user_lname']) }}</div>
                <div class="email"> {{ $userinfo['user_email'] }}</div>
            </div>
            <br />
        </div>
        <br />
		<div class="sidebar-nav collapse navbar-collapse" id="asd">
			<ul class="nav" id="side-menu">
				<li class="panel">
					<a href="#" data-toggle="collapse" data-parent="#side-menu" data-target="#Members"><i class="fa fa-user fa-fw"></i>&nbsp;&nbsp;Members<span class="fa fa-caret-down fa-1x arrow"></span></a>
					<ul class="sub-menu collapse" id="Members">
						<li class="{{ route('addmember', array('domain' => $domain, 'user_id' => $userinfo['user_id'])) }}"><a href="{{ route('addmember', array('domain' => $domain, 'user_id' => $userinfo['user_id'])) }}">Add Member</a></li>
						<li class="{{ route('viewallmembers', array('domain' => $domain, 'user_id' => $userinfo['user_id'])) }}"><a href="{{ route('viewallmembers', array('domain' => $domain, 'user_id' => $userinfo['user_id'])) }}">Loan Books</a></li>
					</ul>
				</li>
				<li class="panel">
					<a href="#" data-toggle="collapse" data-parent="#side-menu" data-target="#Loans"><i class="fa fa-list fa-fw"></i>&nbsp;&nbsp;Loans<span class="fa fa-caret-down fa-1x arrow"></span></a>
					<ul class="sub-menu collapse" id="Loans">
						<li class="{{ route('addnewloan', array('domain' => $domain, 'user_id' => $userinfo['user_id'])) }}"><a href="{{ route('addnewloan', array('domain' => $domain, 'user_id' => $userinfo['user_id'])) }}">Add New Loan Type</a></li>
						<li class="{{ route('viewallloans', array('domain' => $domain, 'user_id' => $userinfo['user_id'])) }}"><a href="{{ route('viewallloans', array('domain' => $domain, 'user_id' => $userinfo['user_id'])) }}">Loan Overview</a></li>
						<!-- <li class=""><a href="">Rates </a></li>
						<li class=""><a href="">Penalty</a></li> -->
						<!-- <li class=""><a href="">Loan Requests <span class="badge badge-important">10</span></a></li> -->
					</ul>
				</li>
				<!-- <li class="panel">
					<a href="#" data-toggle="collapse" data-parent="#side-menu" data-target="#Payments"><i class="fa fa-money fa-fw"></i>&nbsp;&nbsp;Payments<span class="fa fa-caret-down fa-1x arrow"></span></a>
					<ul class="sub-menu collapse" id="Payments">
						<li class=""><a href=""><i class="fa fa-money fa-fw"></i>&nbsp;&nbsp;Payments</a></li>
						<li class=""><a href=""></a></li>
						<li class=""><a href="">Buy Share Capital</a></li>
					</ul>
				</li> -->
				

				<li class="panel">
					<a href="#" data-toggle="collapse" data-parent="#side-menu" data-target="#Finances"><i class="fa fa-balance-scale fa-fw"></i>&nbsp;&nbsp;Finances<span class="fa fa-caret-down fa-1x arrow"></span></a>
					<ul class="sub-menu collapse" id="Finances">
						<!-- <li class=""><a href="">Users</a></li> -->
						<li class="{{ route('paymentform', array('domain' => $domain, 'user_id' => $userinfo['user_id'])) }}"><a href="{{ route('paymentform', array('domain' => $domain, 'user_id' => $userinfo['user_id'])) }}"><i class="fa fa-cart-plus fa-fw"></i>&nbsp;&nbsp;Product Payments</a></li>
						<li class="{{ route('loanpaymentform', array('domain' => $domain, 'user_id' => $userinfo['user_id'])) }}"><a href="{{ route('loanpaymentform', array('domain' => $domain, 'user_id' => $userinfo['user_id'])) }}"><i class="fa fa-money fa-fw"></i>&nbsp;&nbsp;Loan Payments</a></li>
					</ul>
				</li>

				<li class="panel">
					<a href="#" data-toggle="collapse" data-parent="#side-menu" data-target="#Roles"><i class="fa fa-user-plus fa-fw"></i>&nbsp;&nbsp;User Management<span class="fa fa-caret-down fa-1x arrow"></span></a>
					<ul class="sub-menu collapse" id="Roles">
						<!-- <li class=""><a href="">Users</a></li> -->
						<li class="{{ route('roleoverview', array('domain' => $domain, 'user_id' => $userinfo['user_id'])) }}"><a href="{{ route('roleoverview', array('domain' => $domain, 'user_id' => $userinfo['user_id'])) }}">Users</a></li>
					</ul>
				</li>
				<li class="panel">
					<a href="{{ route('companysettings', array('domain' => $domain, 'user_id' => $userinfo['user_id'])) }}" data-toggle="collapse" data-parent="#side-menu" data-target="#Company Settings"><i class="fa fa-building-o fa-fw"></i>&nbsp;&nbsp;Company Settings</a>
				</li>
				<li class="panel">
					<a href="#" data-toggle="collapse" data-parent="#side-menu" data-target="#Reports"><i class="fa fa-files-o fa-fw"></i>&nbsp;&nbsp;Reports<span class="fa fa-caret-down fa-1x arrow"></a>
					<ul class="sub-menu collapse" id="Reports">
						<li class=""><a href="">Audit Trail</a></li>
						<li class=""><a href="">Generate Report</a></li>
					</ul>
				</li>
				<li>
					<a href="{{ route('logout', $domain) }}" id="logoutbtn" name="logoutbtn"><i class="fa fa-sign-out fa-fw"></i>&nbsp;&nbsp;Logout</a>
				</li>
			</ul>
		</div>
		<!-- /.sidebar-collapse -->
	</div>
</nav>
	
<script src="{{asset('js/jquery.js')}}"></script>

<script type="text/javascript">
	$(document).ready(function(){
		 $('a#logoutbtn').click(function(){
			if(confirm('Are you sure you want to logout?')) {
				return true;
				// header("Location: logout.php");
			}else{
				return false;
			}
		 });
	});
</script>