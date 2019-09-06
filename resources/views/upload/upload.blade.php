@extends('bootstrap.admin')
@section('content')
    <input type="file" name="images" id="file">
    <button class="btn btn-danger upload">上传</button>
    <script>
        $(function(){
           $(".upload").on('click',function () {
//               alert(1);
               var name='问建梁';
               var fd= new FormData();
               var file=$("#file")[0].files[0];
//               console.log(file);return false;
                   fd.append('name',name);
                   fd.append('file',file);
//                   alert(jjj);
               $.ajax({
                   url:"http://www.dijiuyue.com/api/upload",
                   type:"POST",
                   data:fd,
                   contentType:false,
                   processData:false,
                   success:function (res) {
                       console.log(res);
                   }
               })
           })
        });
    </script>
@endsection