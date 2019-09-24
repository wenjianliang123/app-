<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">

    <title> hAdmin- 主页</title>

    <meta name="keywords" content="">
    <meta name="description" content="">

    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">



    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="{{asset('bootstrap/bootstrap.min.css')}}">
    <link href="{{asset('/hadmin/css/bootstrap.min.css?v=3.3.6')}}" rel="stylesheet">
    <link href="{{asset('/hadmin/css/font-awesome.min.css?v=4.4.0')}}" rel="stylesheet">
    <link href="{{asset('/hadmin/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('/hadmin/css/style.css?v=4.1.0')}}" rel="stylesheet">
</head>

<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
<div id="wrapper">
    <!--左侧导航开始-->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="nav-close"><i class="fa fa-times-circle"></i>
        </div>
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                                    <span class="block m-t-xs" style="font-size:20px;">
                                        <i class="fa fa-area-chart"></i>
                                        <strong class="font-bold">hAdmin</strong>
                                    </span>
                                </span>
                        </a>
                    </div>
                    <div class="logo-element">hAdmin
                    </div>
                </li>
                <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                    <span class="ng-scope">分类</span>
                </li>
                <li>
                    <a class="J_menuItem" href="{{asset('/hadmin/index_v1.html')}}">
                        <i class="fa fa-home"></i>
                        <span class="nav-label">主页</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa fa-bar-chart-o"></i>
                        <span class="nav-label">统计图表</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a class="J_menuItem" href="graph_echarts.html">百度ECharts</a>
                        </li>
                        <li>
                            <a class="J_menuItem" href="graph_flot.html">Flot</a>
                        </li>
                        <li>
                            <a class="J_menuItem" href="graph_morris.html">Morris.js</a>
                        </li>
                        <li>
                            <a class="J_menuItem" href="graph_rickshaw.html">Rickshaw</a>
                        </li>
                        <li>
                            <a class="J_menuItem" href="graph_peity.html">Peity</a>
                        </li>
                        <li>
                            <a class="J_menuItem" href="graph_sparkline.html">Sparkline</a>
                        </li>
                        <li>
                            <a class="J_menuItem" href="graph_metrics.html">图表组合</a>
                        </li>
                    </ul>
                </li>
                <li class="line dk"></li>
                <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                    <span class="ng-scope">商品管理</span>
                </li>
                {{--<li>--}}
                    {{--<a href="mailbox.html"><i class="fa fa-envelope"></i> <span class="nav-label">信箱 </span><span class="label label-warning pull-right">16</span></a>--}}
                    {{--<ul class="nav nav-second-level">--}}
                        {{--<li><a class="J_menuItem" href="mailbox.html">收件箱</a>--}}
                        {{--</li>--}}
                        {{--<li><a class="J_menuItem" href="mail_detail.html">查看邮件</a>--}}
                        {{--</li>--}}
                        {{--<li><a class="J_menuItem" href="mail_compose.html">写信</a>--}}
                        {{--</li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                <li>
                    <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">商品管理</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{asset('http://www.dijiuyue.com/admin/goods/goods_list')}}">商品列表</a>
                        </li>
                        <li><a class="J_menuItem" href="{{asset('admin/goods/goods_add')}}">商品添加</a>
                        </li>


                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">商品分类管理</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{asset('admin/goods/cate_list')}}">分类列表</a>
                        </li>
                        <li><a class="J_menuItem" href="{{asset('admin/goods/cate_add')}}">分类添加</a>
                        </li>


                    </ul>
                </li>

                <li>
                    <a href="#"><i class="fa fa-edit"></i> <span class="nav-label">商品类型管理</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="{{asset('admin/goods/type_list')}}">类型列表</a>
                        </li>
                        <li><a class="J_menuItem" href="{{asset('admin/goods/type_add')}}">类型添加</a>
                        </li>
                        <li><a class="J_menuItem" href="{{asset('admin/goods/attr_list')}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;属性列表</a>
                        </li>
                        <li><a class="J_menuItem" href="{{asset('admin/goods/attr_add')}}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;属性添加</a>
                        </li>


                    </ul>
                </li>



                <li class="line dk"></li>
                <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                    <span class="ng-scope">分类</span>
                </li>
                <li>
                    <a href="#"><i class="fa fa-flask"></i> <span class="nav-label">UI元素</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="typography.html">排版</a>
                        </li>
                        <li>
                            <a href="#">字体图标 <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li>
                                    <a class="J_menuItem" href="fontawesome.html">Font Awesome</a>
                                </li>
                                <li>
                                    <a class="J_menuItem" href="glyphicons.html">Glyphicon</a>
                                </li>
                                <li>
                                    <a class="J_menuItem" href="iconfont.html">阿里巴巴矢量图标库</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">拖动排序 <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li><a class="J_menuItem" href="draggable_panels.html">拖动面板</a>
                                </li>
                                <li><a class="J_menuItem" href="agile_board.html">任务清单</a>
                                </li>
                            </ul>
                        </li>
                        <li><a class="J_menuItem" href="buttons.html">按钮</a>
                        </li>
                        <li><a class="J_menuItem" href="tabs_panels.html">选项卡 &amp; 面板</a>
                        </li>
                        <li><a class="J_menuItem" href="notifications.html">通知 &amp; 提示</a>
                        </li>
                        <li><a class="J_menuItem" href="badges_labels.html">徽章，标签，进度条</a>
                        </li>
                        <li>
                            <a class="J_menuItem" href="grid_options.html">栅格</a>
                        </li>
                        <li><a class="J_menuItem" href="plyr.html">视频、音频</a>
                        </li>
                        <li>
                            <a href="#">弹框插件 <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li><a class="J_menuItem" href="layer.html">Web弹层组件layer</a>
                                </li>
                                <li><a class="J_menuItem" href="modal_window.html">模态窗口</a>
                                </li>
                                <li><a class="J_menuItem" href="sweetalert.html">SweetAlert</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">树形视图 <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li><a class="J_menuItem" href="jstree.html">jsTree</a>
                                </li>
                                <li><a class="J_menuItem" href="tree_view.html">Bootstrap Tree View</a>
                                </li>
                                <li><a class="J_menuItem" href="nestable_list.html">nestable</a>
                                </li>
                            </ul>
                        </li>
                        <li><a class="J_menuItem" href="toastr_notifications.html">Toastr通知</a>
                        </li>
                        <li><a class="J_menuItem" href="diff.html">文本对比</a>
                        </li>
                        <li><a class="J_menuItem" href="spinners.html">加载动画</a>
                        </li>
                        <li><a class="J_menuItem" href="widgets.html">小部件</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#"><i class="fa fa-table"></i> <span class="nav-label">表格</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="table_basic.html">基本表格</a>
                        </li>
                        <li><a class="J_menuItem" href="table_data_tables.html">DataTables</a>
                        </li>
                        <li><a class="J_menuItem" href="table_jqgrid.html">jqGrid</a>
                        </li>
                        <li><a class="J_menuItem" href="table_foo_table.html">Foo Tables</a>
                        </li>
                        <li><a class="J_menuItem" href="table_bootstrap.html">Bootstrap Table
                                <span class="label label-danger pull-right">推荐</span></a>
                        </li>
                    </ul>
                </li>
                <li class="line dk"></li>
                <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                    <span class="ng-scope">分类</span>
                </li>
                <li>
                    <a href="#"><i class="fa fa-picture-o"></i> <span class="nav-label">相册</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="basic_gallery.html">基本图库</a>
                        </li>
                        <li><a class="J_menuItem" href="carousel.html">图片切换</a>
                        </li>
                        <li><a class="J_menuItem" href="blueimp.html">Blueimp相册</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="J_menuItem" href="css_animation.html"><i class="fa fa-magic"></i> <span class="nav-label">CSS动画</span></a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-cutlery"></i> <span class="nav-label">工具 </span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a class="J_menuItem" href="form_builder.html">表单构建器</a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>
    <!--左侧导航结束-->

    <!--右侧部分开始-->
    <div id="page-wrapper" class="gray-bg dashbard-1">

        @yield('content')

    </div>
    <!--右侧部分结束-->
</div>

<!-- 全局js -->
<script src="{{asset('/hadmin/js/jquery.min.js?v=2.1.4')}}"></script>
<script src="{{asset('/hadmin/js/bootstrap.min.js?v=3.3.6')}}"></script>
<script src="{{asset('/hadmin/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
<script src="{{asset('/hadmin/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('/hadmin/js/plugins/layer/layer.min.js')}}"></script>

<!-- 自定义js -->
<script src="{{asset('/hadmin/js/hAdmin.js?v=4.1.0')}}"></script>
<script type="text/javascript" src="{{asset('/hadmin/js/index.js')}}"></script>

<!-- 第三方插件 -->
{{--<script src="{{asset('/hadmin/js/plugins/pace/pace.min.js')}}"></script>--}}
<div style="text-align:center;">
    <p>来源:<a href="http://www.mycodes.net/" target="_blank">源码之家</a></p>
</div>
</body>

</html>
<script>

</script>
