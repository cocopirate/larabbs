<nav class="navbar navbar-expand-lg navbar-static-top navbar-light bg-light">
    <div class="container">
        <!-- Branding Image -->
        <a class="navbar-brand" href="#">
            <img src="https://v4.bootcss.com/assets/brand/bootstrap-solid.svg" width="30" height="30" alt="">
        </a>

        <!-- Collapsed Hamburger -->
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#app-navbar-collapse" aria-controls="app-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {{active_class(if_route('topics.index'))}}">
                    <a class="nav-link" href="{{ route('topics.index') }}">全部话题<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item {{ active_class(if_route('categories.show') && if_route_param('category', 1)) }}">
                    <a class="nav-link" href="{{ route('categories.show', 1) }}">分享</a>
                </li>
                <li class="nav-item {{ active_class(if_route('categories.show') && if_route_param('category', 2)) }}">
                    <a class="nav-link" href="{{ route('categories.show', 2) }}">教程</a>
                </li>
                <li class="nav-item {{ active_class(if_route('categories.show') && if_route_param('category', 3)) }}">
                    <a class="nav-link" href="{{ route('categories.show', 3) }}">问答</a>
                </li>
                <li class="nav-item {{ active_class(if_route('categories.show') && if_route_param('category', 4)) }}">
                    <a class="nav-link" href="{{ route('categories.show', 4) }}">公告</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <!-- Authentication Links -->

                @guest
                    <a class="nav-item nav-link" href="{{ route('login') }}">登录</a>
                    <a class="nav-item nav-link" href="{{ route('register') }}">注册</a>
                @else
                    <li class="nav-item dropdown">
                        <a href="#" class="dropdown-toggle nav-link" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="user-avatar float-left" style="margin-right:8px; margin-top:-5px;" >
                                <img src="{{ Auth::user()->avatar }}" class="img-responsive img-circle" width="30px" height="30px">
                            </span>
                            {{ Auth::user()->name }}<span class="caret"></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('users.show', Auth::id()) }}">
                                <span class="oi oi-person"></span>
                                个人中心
                            </a>
                            <a class="dropdown-item" href="{{ route('users.edit', Auth::id()) }}">
                                <span class="oi oi-file"></span>
                                编辑资料
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                {{ csrf_field() }}
                                <button type="submit" class="dropdown-item" href="#">
                                    <span class="oi oi-account-logout"></span>
                                    退出登录
                                </button>
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>

    </div>
</nav>