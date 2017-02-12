<!doctype html>
<html lang="en">

<head>
	<title>EZLoan | Welcome! </title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="description" content="Online loan management system for credit cooperatives. Manage loans and savings accounts of your borrowers online. Remind members on due dates via SMS and E-mail.">
	<meta name="keywords" content="Loan management system, loan management software, lending servicing software, microfinance, lending, loan crm, lending crm, lending software, loan software, cloud based, mobile based, android based lending system">
	<meta name="author" content="EZLoan"> 

	<link rel="shortcut icon" href="{{asset('images/logo2.png')}}"/>

	<link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.min.css')}}">
	<link href='https://fonts.googleapis.com/css?family=Exo+2' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Convergence' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

	<link href="{{asset('css/bootstrap.css')}}" rel="stylesheet"/>
	<link href="{{asset('css/Homepage.css')}}" rel="stylesheet"/>

</head>

<body>
	<div id="page-top" class="index">

		<header>
			<div class="container">
				<nav class="navbar navbar-default">
					<div class="container">
		            <!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
								<span class="fa fa-bars fa-2x fa-inverse"></span>
							</button>
							<a class="navbar-brand" href="#page-top">EZLOAN</a>
						</div>

						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav navbar-right">
								<li class="hidden">
									<a href="#page-top"></a>
								</li>
								<li>
									<a href="#about">About</a>
								</li>
								<li>
									<a href="#features">How It Works</a>
								</li>
								<!-- <li>
									<a href="" data-toggle="modal" data-target="#LoginModal">Log In</a>
								</li> -->
								<li>
									<a href="#trial">Free Trial</a>
								</li>
							</ul>
						</div>
						<!-- /.navbar-collapse -->
					</div>
				</nav>
				<div class="intro-text">
					<div class="intro-lead-in">
						<!-- <img class="logo" src="{{URL::asset('local/images/logo2.png')}}" alt=""/><br /> -->
						EZLoan
					</div>
					<div class="intro-heading">Made especially for Filipino credit cooperatives.</div>
				</div>
				<div class="col-lg-12" class="signform">
					<form class="form-inline" id="signupform" method="post" action="{{ route('companyregister') }}">
						<div class="row">
							<input type="text" id="comp_name" name="comp_name" placeholder="Company Name" required="" class="form-control">
							<input type="text" id="user_email" name="user_email" placeholder="Email address" required="" class="form-control">
							<input type="hidden" name="_token" value="{{{ csrf_token() }}}">
							<input type="submit" id="submit" name="submit" class="btn btn-lg form-control" value="Try for 30 Days">
						</div>
					</form>
				</div>
			</div>
		</header>

		<section id="about">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-center">
						<h2 class="section-heading">ABOUT US</h2>
						<h3 class="section-subheading">Loaning made easy.</h3>
					</div>
				</div>
				<div class="row text-center">
					<div class="col-sm-12 col-md-4 col-lg-4">>
						<h4 class="heading">Credit Cooperative System</h4>
						<p class="text-muted">
							&emsp;&emsp;&emsp;EZLoan is a web-based generic credit cooperative system that will aid in data management processes of a credit cooperative.
							<br />
							&emsp;&emsp;&emsp;Manage member accounts, check the loan status online, renew or apply for a new loan online, remind members when due dates are coming.
							<br />
							&emsp;&emsp;&emsp;Morbi scelerisque congue arcu a congue. Etiam sagittis, lectus vitae tincidunt ornare, ipsum arcu tristique tellus, sed vehicula turpis massa et mi. Duis vel placerat augue, nec cursus tortor. Morbi vitae dui vel massa iaculis tincidunt. Sed ac ante posuere, consequat lectus nec, tincidunt sapien. Sed et ultrices erat, non ornare arcu.
						</p>
					</div>
					<div class="col-sm-12 col-md-8 col-lg-8">
						<img class="staticphoto" src="{{asset('images/dash.png')}}">
					</div>
				</div>
			</div>
		</section>

		<section id="features">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-center">
						<h2 class="section-heading">FEATURES</h2>
						<h3 class="section-subheading">Product Features</h3>
					</div>
					<div class="row text-center">
						<div class="col-sm-12 col-md-8 col-lg-8">
							<img class="staticphoto2" src="{{asset('images/dash.png')}}">
						</div>
						<div class="col-sm-12 col-md-4 col-lg-4">
							<div class="statictext2">
								<p class="text-muted">
									&emsp;&emsp;&emsp;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras at felis sed elit dapibus consequat eu gravida sapien. Phasellus tempus, dolor ut tempor malesuada, neque urna vehicula nisl, faucibus viverra massa elit vel justo. In ut metus est. Quisque dignissim porttitor consectetur. Integer molestie in nibh eget dictum. Proin sem arcu, mollis ut ante vel, cursus dictum mi. 
									<br />
									&emsp;&emsp;&emsp;Manage member accounts, check the loan status online, renew or apply for a new loan online, remind members when due dates are coming.
								</p>
							</div>
						</div>
					</div>
				</div>
				<div class="row text-center">
					
				</div>
			</div>
		</section>

		<section id="how">
			<div class="row">
				<div class="container">
					<div class="col-lg-12 text-center">
						<h2 class="section-heading">How EZLoan Works</h2>
						<h3 class="section-subheading">Product Features</h3>
					</div>
				</div>
				<div class="container">
					<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
						<img class="staticphoto img-responsive" src="{{asset('images/dash.png')}}">
					</div>
					<div id="howtext" class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<div class="statictext2">
							<p class="text-muted">
								&emsp;&emsp;&emsp;Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras at felis sed elit dapibus consequat eu gravida sapien. Phasellus tempus, dolor ut tempor malesuada, neque urna vehicula nisl, faucibus viverra massa elit vel justo. In ut metus est. Quisque dignissim porttitor consectetur. Integer molestie in nibh eget dictum. Proin sem arcu, mollis ut ante vel, cursus dictum mi. 
								<br />
								&emsp;&emsp;&emsp;Manage member accounts, check the loan status online, renew or apply for a new loan online, remind members when due dates are coming.
							</p>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section id="trial">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-center">
						<h2 class="section-heading">30-days Free Trial</h2>
						<h3 class="section-subheading">Try EZLoan for 30 days for FREE and see if our product is what you are looking for.</h3>
					</div>
					<!-- <div class="container">
						<div class="col-lg-12" class="signform">
							<form class="form-inline" id="signupform" method="post" action="">
								<div class="row">
									<input type="text" id="comp_name" name="comp_name" placeholder="Company Name" required="" class="form-control">
									<input type="text" id="user_email" name="user_email" placeholder="Email address" onkeyup="return validateEmail(user_email);" required="" class="form-control">
									<input type="hidden" name="_token" value="{{{ csrf_token() }}}">
									<input type="submit" class="btn btn-lg form-control" value="Try for 30 Days">
								</div>
							</form>
						</div>
					</div> -->
				</div>
			</div>
		</section>

		<footer>
			<div class="container">
				<div class="row copyright">
					<div class="col-md-6 footer-span1">
						<span>&copy; Powered by Team Oink Oink.</span>
					</div>
					<div class="col-md-6 footer-span2">
						<ul class="list-inline social-buttons">
							<li><a href="https://www.facebook.com/itsmeclaudz" target="_blank"><i class="fa fa-facebook"></i></a></li>
							<li><a href="https://twitter.com/itsmeclaudz" target="_blank" ><i class="fa fa-twitter"></i></a></li>
							<li><a href="mailto:web@tup.edu.ph"><i class="fa fa-envelope"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</footer>

	</div>
</body>

	<!-- jQuery -->
	<script src="{{asset('js/jquery.js')}}"></script>

	<!-- Bootstrap Core JavaScript -->
	<script src="{{asset('js/bootstrap.min.js')}}"></script>

	<!-- Plugin JavaScript -->
	<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

	<!-- <script src="{{asset('js/classie.js')}}"></script> -->
	<!-- <script src="{{asset('js/cbpAnimatedHeader.js')}}"></script> -->

	<!-- Contact Form JavaScript -->
	<script src="{{asset('js/jqBootstrapValidation.js')}}"></script>
	<script src="{{asset('js/contact_me.js')}}"></script>

	<!-- Custom Theme JavaScript -->
	<script src="{{asset('js/agency.js')}}"></script>

	<script>
	$(document).ready(function () {
		 $('#submit').click(function() {
			var goodColor = "#66cc66";
			var badColor = "#a94442";

		    var sEmail = $('#user_email').val();

        	if (validateEmail(sEmail)) {
		        return true;	
		    }else{
		    	// document.getElementById(user_email).style.borderColor = badColor;
				e.preventDefault();
		    }

		});
		
	});

	function validateEmail(sEmail) {
	    var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	    if (filter.test(sEmail)) {
	        return true;
	    }
	    else {
	        return false;
	    }
	}


	</script>
</html>