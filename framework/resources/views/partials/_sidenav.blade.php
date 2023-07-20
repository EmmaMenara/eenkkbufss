<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{URL::asset('/')}}" class="site_title">{{--<i class="fa fa-calendar"></i>--}}
                <img src="{{URL::asset('789_logo_pack/789_logo_r1.png')}}" style="height: 80%!important;"/>
                <span>{{config('app.name')}}</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile">
            <div class="profile_pic">
                <img src="/images/img.jpg" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Bienvenido,</span>
                <h2>{{auth()->user()->name}}</h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br/>

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Dashboard</a></li>
                    <li><a><i class="fa fa-cogs"></i>Configuraci&oacute;n <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="#">Usuarios</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-folder"></i>Cat&aacute;logos<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('branch.index')}}"><i class="fa fa-building-o"></i>Sucursales</a></li>
                            <li><a href="{{route('brand.index')}}"><i class="fa fa-tag"></i>Marcas</a></li>
                            @if((\Entrust::can('add-product'))||(\Entrust::can('edit-product'))
                            ||(\Entrust::can('delete-product'))||(\Entrust::can('list-product')))
                                <li><a href="{{route('product.index')}}"><i class="fa fa-barcode"></i>Productos</a></li>
                            @endif

                            @if((\Entrust::can('add-provider'))||(\Entrust::can('edit-provider'))
                                ||(\Entrust::can('delete-provider'))||(\Entrust::can('list-provider')))
                                <li><a href="{{route('provider.index')}}"><i class="fa fa-bus"></i>Proveedores</a></li>
                            @endif
                                <li><a href="{{route('customer.index')}}"><i class="fa fa-users"></i>Fiados</a></li>

                        </ul>
                    </li>

                    <li><a><i class="fa fa-newspaper-o"></i>Inventario<span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{route('buy.index')}}"><i class="fa fa-edit"></i>Compras</a></li>
                            <li><a href="{{route('transfer.index')}}"><i class="fa fa-exchange"></i>Traslados</a></li>
                            <li><a href="{{route('product.inventory')}}"><i class="fa fa-list-alt"></i>Consultar</a></li>
                        </ul>
                    </li>
                    <li><a href="{{route('sales.index')}}"><i class="fa fa-credit-card"></i>Ventas</a></li>
                    <li><a href="{{route('reports.index')}}"><i class="fa fa-th-list"></i>Reportes</a></li>
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->

    </div>
</div>