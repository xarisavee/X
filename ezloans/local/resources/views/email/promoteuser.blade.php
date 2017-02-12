<!DOCTYPE html>
<html lang="en">

    <head>
        <title>EZLoan</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>

    <body>
        <div class="container">
            <div class="row">
                <h1>Congratulations from EZLoans, {{ $promoteEmail['name'] }}!</h1>
                <br/>
                <p>You have been promoted as {{ $promoteEmail['position'] }} in {{ $promoteEmail['cooperative'] }}.</p>
                <br/>
                <p>You may access your account on your domain <strong><a href="{{ $promoteEmail['domain'] }}"> {{ $promoteEmail['domain'] }} </a></strong> using the email address and temporary password provided.</p>
                <p>Your email address is: <strong>{{ $promoteEmail['email'] }}</strong></p>
                <p>Your temporary password is: <strong>{{ $promoteEmail['password'] }}</strong></p>
                <p>Note: Change your password right away after logging in. Enjoy EZLoans!</p>
                <br />
                <p>EZLoans Team</p>
            </div>
        </div>

    </body>

</html>