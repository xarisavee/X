<!DOCTYPE html>
<html lang="en">

    <head>
        <title>EZLoan | Log In</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>
        <div class="container">
            <div class="row">
                <h1>Welcome to EZLoans, {{ $welcomeuser['name'] }}!</h1>
                <br/>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam auctor, enim ac euismod congue, ipsum justo luctus purus, dictum sodales turpis orci a massa. Etiam in odio vitae orci commodo ultrices. Proin fermentum lorem sit amet elit gravida, nec elementum urna commodo. Nulla facilisi. Ut justo neque, tristique nec fermentum sit amet, vehicula sed leo. Sed ullamcorper nibh mauris, in laoreet tellus volutpat et. Suspendisse gravida euismod turpis, eget vulputate ex accumsan ut. Ut vel dictum turpis.</p>
                <br/>
                <p>You may access your account on your domain <strong><a href="{{ $welcomeuser['domain'] }}"> {{ $welcomeuser['domain'] }} </a></strong> using the email address and password you provided.</p>
                <p>Your email address is: <strong>{{ $welcomeuser['email'] }}</strong></p>
                <p>Enjoy EZLoans!</p>
                <br />
                <p>EZLoans Team</p>
            </div>
        </div>

    </body>

</html>