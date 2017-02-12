<html>
	<head>
		<title>EZLoan | Log In</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<link href="{{asset('css/bootstrap.css')}}" rel="stylesheet"/>
		<!-- <link href="{{asset('css/Admin.css')}}" rel="stylesheet"/> -->
		<link rel="shortcut icon" href="{{asset('images/logo2.png')}}"/>

		<link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
		<link href='https://fonts.googleapis.com/css?family=Exo+2' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Convergence' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Alegreya' rel='stylesheet' type='text/css'>
		<link href="{{asset('css/Login.css')}}" rel="stylesheet"/>
	</head>
	<body>
		<header>
			<div class="container">
				<div class="intro-text">
					<div class="intro-lead-in">
						{{ strtoupper($domain) }} <!--IMAGE HERE-->
					</div>
					<div class="intro-heading">{{ strtoupper($coop_name) }}</div> <!--COMPANY NAME HERE-->
					<!-- <div class="intro-subheading">Powered by EZLoans</div> -->
				</div>
			</div>
		</header>
		
		<div id="loginpanel" class="container">
			<div class="row">
				<div id="logindiv">
					<div class="panel">
						<h3 class="panel-title">Login to start your session</h3>
						<div class="panel-body">
							<form role="form" action="{{ route('companysignincheck', $domain) }}" method="post">
								<fieldset>
									@if ($error = $errors->first('password'))
										<div class="alert alert-danger">
											{{ $error }}
										</div>
									@endif
									<div class="form-group input-group">
                                        <span style="background: #231204; border: none;" class="input-group-addon"><i class="fa fa-user fa-lg fa-inverse"></i></span>
										<input class="form-control" id="logemail" name="logemail" placeholder="Email Address" type="text" required autofocus>
									</div>
									<div class="input-group">
										<span class="input-group-addon text-center" style="background: #231204; border: none; padding-left: 14px; padding-right: 13px;"><i class="fa fa-lock fa-lg fa-inverse"></i></span>
										<input class="form-control" id="logpassword" name="logpassword" placeholder="Password" name="password" type="password" value="" required>
									</div>
									<div class="checkbox">
										<label> <input name="remember" type="checkbox" value="Remember Me">Remember Me </label>
									</div>
									<input type="hidden" name="_token" value="{{{ csrf_token() }}}">
									<div class="text-center">
										<input class="btn" type="submit" id="submit" name="submit" value="Submit"/> 
									</div>
									<!-- Change this to a button or input when using this as a form -->
								</fieldset>
							</form>
							<br />
							<div class="text-center">
								<a id="locatelink" name="locatelink" href="">Oops, I forgot my password. Help!</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- jQuery -->
		<script src="js/jquery.js"></script>

		<!-- Bootstrap Core JavaScript -->
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>