<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="description" content="Online loan management system for credit cooperatives. Manage loans and savings accounts of your borrowers online. Remind members on due dates via SMS and E-mail.">
        <meta name="keywords" content="Loan management system, loan management software, lending servicing software, microfinance, lending, loan crm, lending crm, lending software, loan software, cloud based, mobile based, android based lending system">
        <meta name="author" content="EZLoan">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
        <link href="{{asset('css/Admin.css')}}" rel="stylesheet"/>
        <link href="{{asset('css/DashSetup.css')}}" rel="stylesheet"/>
        <link href="{{asset('css/stylematerial.css')}}" rel="stylesheet"/>
        <link href="{{asset('css/livesearch.css')}}" rel="stylesheet"/>
        <link href="{{asset('css/loader.css')}}" rel="stylesheet">
        <link href="{{asset('font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
        <link rel="shortcut icon" href="{{asset('images/logo2.png')}}"/>

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
        
        <link href='https://fonts.googleapis.com/css?family=Exo+2' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Convergence' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
        
        
        <!-- Include Required Prerequisites -->
        <!-- <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script> -->
         
        <!-- Include Date Range Picker -->
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

        <!--[if lt IE 9]>
        <script src="{{asset('js/html5shiv.js')}}"></script>
        <script src="{{asset('js/respond.min.js')}}"></script>
        <![endif]-->       
    </head><!--/head-->

    <body>
        <div class="se-pre-con"></div>
        @yield('content')


        @include('shared.query');
        @yield('scripts')

        <script>
        $(window).load(function() {
            $(".se-pre-con").fadeOut("slow");
        });
        </script>
    </body>
</html>