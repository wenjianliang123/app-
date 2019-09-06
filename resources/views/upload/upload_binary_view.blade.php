@extends('bootstrap.admin')
@section('content')
<input type="file" name="file">
<input type="submit" value='提交' id="btn">


<script type="text/javascript">
    //二进制 方式上传文件
    $("#btn").on('click',function(){
        //模拟表单对象  FormData
        var file = $('[name="file"]')[0].files[0]; //获取到文件
//        console.log(file);return;
//        *******************此处有改动*******************
        var file_name=file.name;
        var file_size=file.size;
        var file_type=file.type;
//        var
//        alert(file_type);return;
        var reader = new FileReader(); //h5
        reader.readAsBinaryString(file);//读原始二进制
        //请求完成走的代码
        reader.onload = function()
        {
            //result属性
            console.log(this.result);
            //发送原生ajax
            var xhr = new XMLHttpRequest();
            xhr.open('POST',"http://www.dijiuyue.com/api/upload_binary"+'?file_name='+file_name+"&file_size="+file_size+"&file_type="+file_type,true);
            xhr.onload = function(){
                //请求完成走的代码
            }
            xhr.sendAsBinary(this.result);
        }
    })

    //给XMLHttpRequest的原型添加二进制发送功能
    XMLHttpRequest.prototype.sendAsBinary = function(datastr) {
        function byteValue(x) {
            return x.charCodeAt(0) & 0xff;
        }
        var ords = Array.prototype.map.call(datastr, byteValue);
        var ui8a = new Uint8Array(ords);
        this.send(ui8a.buffer);
    }
</script>
@endsection