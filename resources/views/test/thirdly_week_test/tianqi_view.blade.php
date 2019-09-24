<!DOCTYPE HTML>
<html>
<head>
    <span ><b class="city_show" style="color: #D50000"></b></span>
    <meta charset="utf-8"><link rel="icon" href="https://jscdn.com.cn/highcharts/images/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="/jquery-3.3.1.js"></script>
    <script src="https://code.highcharts.com.cn/highcharts/highcharts.js"></script>
    <script src="https://code.highcharts.com.cn/highcharts/highcharts-more.js"></script>
    <script src="https://code.highcharts.com.cn/highcharts/modules/exporting.js"></script>
    <script src="https://img.hcharts.cn/highcharts-plugins/highcharts-zh_CN.js"></script>
    <script src="https://code.highcharts.com.cn/highcharts/themes/grid-light.js"></script>
    <script src="{{asset('/public.js')}}"></script>
</head>
<body>
<div id="container"></div>
<div class="container" style='margin-left:35%'>
    <p>
        城市：
        <input type="text"  name="city_name">
        <button id="btn">搜索今日天气</button>
    </p>

</div>
</body>
</html>

<script>
        //做个session jquery拿session的用户信息去用ajax去根据用户信息查询到token
        //思路2：拿登陆页面传过来的用户信息去查询token
        //思路3：拿登陆页面传过来的token进行操作
    $('#btn').on('click',function(){
        // alert(1);
        var city_name=$('[name="city_name"]').val();//namex属性 获取标签属性
        //让城市名称展示出来
        $('.city_show').html('城市名称：'+city_name);
//        alert(city_name);return;
        var url='http://www.dijiuyue.com/thirdly_week_test/chaxun_tianqi';
        //获取登陆页面存放的cookie
        var token=getCookie('token');
//        console.log(token);return;
        //如果token为空让她跳转去登陆页面
        if(token==null){
            window.location.href='http://www.dijiuyue.com/thirdly_week_test/login_view';
            return;
        }
        if(city_name ==""){
            alert('请填写城市，如果不填写默认展示北京天气');
//            return;
        }
        $.ajax({
            url:url,
            type:'get',
            data:{city_name:city_name,token:token},
            dataType:"json",
            success:function(res){
                //调用下面的方法
                weather(res.result)
            }
        });



    });



    function weather(res)
    {
        // alert(1);
        var categories = [];//X轴日期
        var data = [];//x轴日期对应时间轴的最高日期和最低日期
        $.each(res,function(i,v){
            categories.push(v.days);
            var arr = [parseInt(v.temp_low),parseInt(v.temp_high)];
            data.push(arr)
        });

        var chart = Highcharts.chart('container', {
            chart: {
                type: 'columnrange', // columnrange 依赖 highcharts-more.js
                inverted: true
            },
            title: {
                text: '当天天气情况'
            },
            subtitle: {
                text: res[0]['days']
            },
            xAxis: {
                categories:categories
            },
            yAxis: {
                title: {
                    text: '温度 ( °C )'
                }
            },
            tooltip: {
                valueSuffix: '°C'
            },
            plotOptions: {
                columnrange: {
                    dataLabels: {
                        enabled: true,
                        formatter: function () {
                            return this.y + '°C';
                        }
                    }
                }
            },
            legend: {
                enabled: false
            },
            series: [{
                name: '温度',
                data: data
            }]
        });
    }
        //获取url中的参数
        function getUrlParam(name) {
            var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
            var r = window.location.search.substr(1).match(reg);  //匹配目标参数
            if (r != null) return unescape(r[2]); return null; //返回参数值
        }

</script>