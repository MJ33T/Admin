<div class="nav-side-menu">
    <div class="menu-list">
        <ul id="menu-content" class="menu-content collapse out">
            <br>
            @if(Session::get('user')->dashboard == 1)
            <li class="nav-item">
                <a href="/dashboard">
                    <i class="fa-solid fa-house"></i> Dashboard
                </a>
            </li>
            @endif
            @if(Session::get('user')->floor == 1)
            <li class="nav-item">
                <a href="/floor">
                    <i class="fa-solid fa-layer-group"></i> Floor
                </a>
            </li>
            @endif
            @if(Session::get('user')->product == 1)
            <li  data-toggle="collapse" data-target="#products" class="collapsed">
                <a href="#"><i class="fa-solid fa-list-ul"></i> Product<span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse" id="products">
                <li class="sub-nav-item"><a href="/category">Category</a></li>
                <li class="sub-nav-item"><a href="/product">Product</a></li>
                <li class="sub-nav-item"><a href="/brand">Brand</a></li>
                <li class="sub-nav-item"><a href="/sub_brand">Sub Brand</a></li>
                <li class="sub-nav-item"><a href="/sub_brand_detail">Sub Brand (Details)</a></li>
            </ul>
            @endif
            @if(Session::get('user')->mall == 1)
            <li class="nav-item">
                <a href="/mall">
                    <i class="fa-solid fa-building-columns"></i> Mall
                </a>
            </li>
            @endif
            @if(Session::get('user')->merchant == 1)
            <li class="nav-item">
                <a href="/merchant">
                    <i class="fa-solid fa-school"></i> Merchant
                </a>
            </li>
            @endif
            
            <li  data-toggle="collapse" data-target="#shop" class="collapsed">
                <a href="#"><i class="fa-solid fa-shop"></i> Shop <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse" id="shop">
                <li class="sub-nav-item"><a href="/selling_identity">Selling Identity</a></li>
                <li  data-toggle="collapse" data-target="#gsm" class="collapsed">
                    <a href="#"></i> GSM <span class="arrow"></span></a>
                </li>
                <ul class="sub-menu collapse" id="gsm">
                    <li class="sub-nav-item"><a href="/new_shop">New</a></li>
                    <li class="sub-nav-item"><a href="/used_shop">Used</a></li>
                </ul>
                <li class="sub-nav-item"><a href="/other_mall">OtherMall</a></li>
            </ul>
            @if(Session::get('user')->stock == 1)
            <li data-toggle="collapse" data-target="#stock" class="collapsed">
                <a href="#"><i class="fa-solid fa-cubes"></i> Stock <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse" id="stock">
                <li class="sub-nav-item"><a href="/new_shop">New</a></li>
                <li class="sub-nav-item"><a href="/used_shop">Used</a></li>
            </ul>
            @endif
            @if(Session::get('user')->voucher == 1)
            <li class="nav-item">
                <a href="/voucher">
                    <i class="fa-solid fa-gift"></i> Voucher
                </a>
            </li>
            @endif
            @if(Session::get('user')->promotion == 1)
            <li class="nav-item">
                <a href="/promotion">
                    <i class="fa-solid fa-arrows-rotate"></i> Promotion/Updates 
                </a>
            </li>
            @endif
            @if(Session::get('user')->promotion == 1)
            <li  data-toggle="collapse" data-target="#ads" class="collapsed">
                <a href="#"><i class="fa-solid fa-rectangle-ad"></i> Advertisement<span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse" id="ads">
                <li class="sub-nav-item"><a href="/ads_client">Create AD Client</a></li>
                <li class="sub-nav-item"><a href="/create_ads">Create AD</a></li>
                <li class="sub-nav-item"><a href="/ads_schedule">AD Schedule</a></li>
            </ul>
            @endif
            @if(Session::get('user')->customer == 1)
            <li class="nav-item">
                <a href="#">
                    <i class="fa fa-user fa-lg"></i>User Profile
                </a>
            </li>
            @endif
            @if(Session::get('user')->sales == 1) 
            <li class="nav-item">
                <a href="/sales">
                <i class="fa-solid fa-chart-column"></i>Sales
                </a>
            </li>
            @endif
            @if(Session::get('user')->transaction == 1) 
            <li class="nav-item">
                <a href="/transaction">
                <i class="fa-solid fa-money-bill-trend-up"></i>Transaction
                </a>
            </li>
            @endif
            @if(Session::get('user')->reports == 1) 
            <li class="nav-item">
                <a href="/reports">
                <i class="fa-solid fa-file-invoice"></i>Reports
                </a>
            </li>
            @endif
            @if(Session::get('user')->manage_admin == 1) 
            <li class="nav-item">
                <a href="/manage_admin">
                <i class="fa-solid fa-user-gear"></i>Manage Admin
                </a>
            </li>
            @endif
            <!-- <li class="nav-item">
                <a href="/logout">
                <i class="fa-solid fa-sign-out"></i>Logout
                </a>
            </li> -->
        </ul>
    </div>
</div>


<script>
    

    
</script>