<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width; initial-scale=1.0"/>
        <meta name="description" content="Online loan management system for credit cooperatives. Manage loans and savings accounts of your borrowers online. Remind members on due dates via SMS and E-mail.">
        <meta name="keywords" content="Loan management system, loan management software, lending servicing software, microfinance, lending, loan crm, lending crm, lending software, loan software, cloud based, mobile based, android based lending system">
        <meta name="author" content="EZLoan">

        <link href="{{ asset('css/Admin.css') }}" rel="stylesheet"/>
        <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
        <link href="{{ asset('font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
        <link rel="shortcut icon" href="{{ asset('images/logo-icon.png') }}"/>

        <link href='https://fonts.googleapis.com/css?family=Exo+2' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Convergence' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>

        <!--[if lt IE 9]>
        <script src="{{asset('js/html5shiv.js')}}"></script>
        <script src="{{asset('js/respond.min.js')}}"></script>
        <![endif]-->       
    </head><!--/head-->

    <body>
        @yield('content')

        <script src="{{asset('js/jquery.js')}}"></script>
        <script src="{{asset('js/bootstrap.min.js')}}"></script>>
    </body>
</html>