<!DOCTYPE html>
<!-- Coding by CodingLab | www.codinglabweb.com -->
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!--<title>Dashboard Sidebar Menu</title>-->


    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
<nav class="sidebar close">
    <header>
        <div class="image-text">
                <span class="image">
                    <img src="{{ asset('img/logo.jpg')  }}" alt="">
                </span>

            <div class="text logo-text">
                <span class="name">ИС "Fox"</span>
                <span class="profession">удобная CRM</span>
            </div>
        </div>

        <i class='bx bx-chevron-right toggle'></i>
    </header>

    <div class="menu-bar">
        <div class="menu">

            <!-- <li class="search-box">
                <i class='bx bx-search icon'></i>
                <input type="text" placeholder="Search...">
            </li> -->

            <ul class="menu-links">
                <li class="nav-link">
                    <a href="{{ route('home')  }}">
                        <i class='bx bx-home-alt icon' ></i>
                        <span class="text nav-text">Рабочий стол</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="{{ route('organization.index')  }}">
                        <i class='bx bx-bar-chart-alt-2 icon' ></i>
                        <span class="text nav-text">Организации</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="{{ route('userbase.index')  }}">
                        <i class='bx bx-bar-chart-alt-2 icon' ></i>
                        <span class="text nav-text">База пользователей</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="#">
                        <i class='bx bx-bell icon'></i>
                        <span class="text nav-text">Замечания</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="#">
                        <i class='bx bx-pie-chart-alt icon' ></i>
                        <span class="text nav-text">Приказы</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="#">
                        <i class='bx bx-heart icon' ></i>
                        <span class="text nav-text">Отчёты</span>
                    </a>
                </li>

                <li class="nav-link">
                    <a href="#">
                        <i class='bx bx-wallet icon' ></i>
                        <span class="text nav-text">Зарплата</span>
                    </a>
                </li>

            </ul>
        </div>

        <div class="bottom-content">
            <li class="">

                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class='bx bx-log-out icon' ></i>
                    <span class="text nav-text">Выход</span>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>



        </div>
    </div>

</nav>

<section class="home" id="app">
    <div class="text">{{ $title ?? 'Не указано'  }}</div>
    <div class="content">
        @yield('content')

    </div>

</section>



</body>
</html>
