<nav class="navbar navbar-default">
    <div class="container">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!--
                <a class="navbar-brand" href="http://emich.edu">
                    <img style="max-width:120%;max-height:120%;" title="EMU"
                         src="images/emu-logo.png">
                </a>
                -->
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav">
                    @if (Auth::check())
                        <li><a href="{{ url('/home') }}">Home</a></li>
                        <li><a href="{{ url('/partsrequest') }}">Request Parts</a></li>
                        <li><a href="{{ url('/checkout') }}">Checkout</a></li>

                        @if(Auth::user()->can(App\Permission\Permissions::P_Material_Request)
                        || Auth::user()->can(App\Permission\Permissions::P_Shop_Request)
                        || Auth::user()->can(App\Permission\Permissions::P_Access_All_Requests))
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Requests<span
                                            class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    @if(Auth::user()->can(App\Permission\Permissions::P_Shop_Request))
                                        <li><a href="{{ url('/requests') }}">Unapproved Requests</a></li>
                                    @endif

                                    @if(Auth::user()->can(App\Permission\Permissions::P_Material_Request))
                                        <li><a href="{{ url('/materials') }}">Approved Requests</a></li>
                                    @endif

                                    @if(Auth::user()->can(App\Permission\Permissions::P_Access_All_Requests))
                                        <li><a href="{{ url('/allrequests') }}">All Requests</a></li>
                                    @endif
                                </ul>
                            </li>
                        @endif

                        @if(Auth::user()->can(App\Permission\Permissions::P_Access_Received_Manager))
                            <li><a href="{{ url('/receivedmanager') }}">Received Manager</a></li>
                        @endif

                        @if(Auth::user()->can(App\Permission\Permissions::P_Access_User_Permissions))
                            <li><a href="{{ url('/users') }}">Manage Users</a></li>
                        @endif

                        @if(Auth::user()->can(App\Permission\Permissions::P_Access_Techs))
                            <li><a href="{{ url('/techs') }}">Manage Techs</a></li>
                        @endif
                    @endif
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::check())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                               aria-haspopup="true"
                               aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <!-- <li role="separator" class="divider"></li> -->
                                <li>
                                    <form method="get" action="{{ url('/settings') }}">
                                        <button href="" type="submit" class="btn btn-link btn-logout">
                                            <span class="glyphicon glyphicon-cog"></span> Settings
                                        </button>
                                    </form>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li>
                                    <form method="post" action="{{ url('/logout') }}">
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-link btn-logout">
                                            <span class="glyphicon glyphicon-off"></span> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li><a href="{{ url('/login') }}">Login</a></li>
                    @endif
                </ul>

            </div>


        </div>
    </div>
</nav>