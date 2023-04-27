
<nav class="mb-4 navbar navbar-expand-lg" id="">
    <img src="{{asset('images/gsm.jpg')}}" alt="GSM Logo" width="150px" height="40px">
    <div class="collapse navbar-collapse" id="navbarSuapportedContent-4">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"> 
                <h5 style="margin-top: 18px">{{Session::get('user')->name}}</h5>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{asset('images/user.png')}}" width="40px" height="40px"></a>
                <div class="dropdown-menu dropdown-menu-right dropdown-cyan" aria-labelledby="navbarDropdownMenuLink-4">
                    <!-- <a class="dropdown-item" href="#">My account</a> -->
                    <a class="dropdown-item" href="/logout">Log out</a>
                </div>
            </li>
        </ul>
    </div>
</nav>