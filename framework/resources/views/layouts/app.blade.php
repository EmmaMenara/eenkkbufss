<!DOCTYPE html>
<html lang="en">
@include('partials._head')

<body class="nav-md">
<div class="container body">

    <div class="main_container">

    {{--top nav--}}
    @include('partials._sidenav')
    {{--/topnav--}}

    <!-- top navigation -->
    @include('partials._topnav')
    <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="page-title">
                <div class="title_left">
                    <h5>@yield('title')</h5>
                </div>
                @yield('search')
            </div>
            <div class="clearfix"></div>
            <div class="data-pjax">
                @yield('content')

            </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
    @include('partials._footer')
    <!-- /footer content -->
    </div>
</div>


<script src="{{asset('js/app.js')}}"></script>
<script>
    setTimeout(function() {
        $('#successMessage').fadeOut('fast');
    }, 2000);
</script>
@stack('scripts')


</body>
</html>