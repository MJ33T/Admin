<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>GSM | Merchant Login Portal</title>

    <style>
        .form-outline input{
            width: 70%;
            margin-left: 110px;
            border-top: none;
            border-left: none;
            border-right: none;
            
        }
        .login_btn button{
            margin-left: 320px;
        }
        .form-outline i{
            position: absolute;
            left: 135px;
            top: 18px 
        }
    </style>
</head>
<body>
<header>
<nav class="navbar navbar-expand-lg navbar-light g-light" style="background-color:white">
<img src="{{asset('images/gsm.jpg')}}" alt="GSM Logo" width="150px" height="80px">

  <div class="navbar" id="navbarSupportedContent" style="margin-left: 1100px">
    <ul class="navbar-nav" >
      <li class="nav-item">
        <a class="nav-link" href="/merchant_login" style="color:#000000;font-weight: bold;">Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/merchant_register" style="color:#000000;font-weight: bold;">Register</a>
      </li>
    </ul>
  </div>
</nav>
</header>
<section class="vh-200" style="background-color: lightgrey;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-9">
                <div class="card" style="border-radius: 1rem;">
                    <div class="card-body p-4 p-lg-5 text-black">
                        <form action="/merchant_login" method="POST">
                            @csrf
                            <div class="row">
                                <div class="d-flex align-items-center mb-3 pb-1">
                                    <img src="{{asset('images/gsm.jpg')}}" alt="" width="200px" height="140px">
                                </div>
                            </div>
                            <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px; text-align:center; color: #073650">Merchant Login Portal</h5>
                            <div class="row">
                                <div class="form-outline col-md-12 mb-4">
                                    <i class="fa-solid fa-user"></i>
                                    <input type="email" id="email_input" name="email" class="form-control form-control-lg" placeholder="Username" style="text-align:center"/>
                                </div>
                            </div>
                            <div class="row">    
                                <div class="form-outline col-md-12 mb-4">
                                    <i class="fa-solid fa-lock"></i>
                                    <input type="password" id="password_input" name="password" class="form-control form-control-lg" placeholder="Password" style="text-align:center"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="login_btn pt-1 col-md-12 mb-4">
                                    <button class="btn btn-primary btn-lg" type="submit">Login</button>
                                </div>
                            </div>
                        </form>      
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>