<!DOCTYPE html>
<html lang="zh-CN" style="background-image: url('http://www.dijiuyue.com/image/111.jpg');width: auto; background-size: 100%,100%;">
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


    {{--类似于 php代码中的  echo  str_replace("$user_info['user_name']", "<td style='color: red'>".搜索的值."</td>", $user_info);   重点是 $user_info['user_name']  js中这个东西没办法搞到  你有办法么--}}
</head>
<body style="margin-top: 5%;">
    <div class="container">
        <center>
            @yield('content')
        </center>
    </div>
</body>
</html>