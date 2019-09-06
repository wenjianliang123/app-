<!DOCTYPE html>
<html lang="zh-CN" style="width: auto;">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <title>Bootstrap</title>
    <link rel="shortcut icon" href="favicon.ico">
    <script src="{{asset('bootstrap/jquery.min.js')}}"></script>
    <script src="{{asset('bootstrap/bootstrap.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('bootstrap/bootstrap.min.css')}}">
    {{--opacity:0.9;--}}
    {{--background-color: rgba(0,0,0,0.1);--}}
    {{--51,122,183--}}



</head>
<body style="margin-top: 5%;background-color: rgba(0,0,0,0.1);background-image: url('http://www.dijiuyue.com/image/111.jpg');background-size: 100%,100%;">
    <div class="container">
        <center>
            @yield('content')
        </center>
    </div>
</body>
</html>