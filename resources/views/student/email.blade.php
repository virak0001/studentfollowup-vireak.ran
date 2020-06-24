<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>
<body style="background: rgba(241, 241, 243, 0.966); padding: 40px">
    <div style="background: white; padding: 20px;margin-top: 100px; text-align:center; width: 70%; margin: 0 auto">
        <h3>Manage Student Follow Up Student</h3>
        <hr style="background: black">
    </div>
    <div style="background:white; padding: 20px; width: 70%; margin: 0 auto">
        {{$datas['body']}}
    </div>
</body>
</html>