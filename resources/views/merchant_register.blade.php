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
        .form-outline input {
            width: 70%;
            margin-left: 110px;
            border-top: none;
            border-left: none;
            border-right: none;

        }

        .login_btn button {
            margin-left: 320px;
        }

        .form-outline i {
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
                <ul class="navbar-nav">
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
                        <div class="card-header">
                            <h5>Register For Merchant</h5>
                        </div>
                            <div class="card-body p-4 p-lg-5 text-black">
                            <form action="/merchant_register" method="POST">
                            @csrf
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-3">Name</div>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="name">
                                            </div>
                                            <div class="col-sm-3 mt-3">SSM No</div>
                                            <div class="col-sm-9 mt-3">
                                                <input type="text" class="form-control" name="ssm_no">
                                            </div>
                                            <div class="col-sm-3 mt-3">Contact</div>
                                            <div class="col-sm-9 mt-3">
                                                <input type="text" class="form-control" id="pri_phone" name="primary_contact" placeholder="Primary">
                                            </div>
                                            <div class="col-sm-3 mt-3"></div>
                                            <div class="col-sm-9 mt-3">
                                                <input type="text" class="form-control" id="sec_phone" name="secondary_contact" placeholder="Secondary">
                                            </div>
                                            <div class="col-sm-3 mt-3">Email Address</div>
                                            <div class="col-sm-9 mt-3">
                                                <input type="text" class="form-control" name="email">
                                            </div>
                                            <div class="col-sm-3 mt-3">Address</div>
                                            <div class="col-sm-9 mt-3">
                                                <!-- <input type="text" class="form-control" v-model="add.category"> -->
                                                <textarea class="form-control" id="" cols="30" rows="5" name="address"></textarea>
                                            </div>
                                            <div class="col-sm-3 mt-3">Zip/Postal Code</div>
                                            <div class="col-sm-9 mt-3">
                                                <input type="text" class="form-control" name="zip_code">
                                            </div>
                                            <div class="col-sm-3 mt-3">City</div>
                                            <div class="col-sm-9 mt-3">
                                                <input type="text" class="form-control" name="city">
                                            </div>
                                            <div class="col-sm-3 mt-3">State</div>
                                            <div class="col-sm-9 mt-3">
                                                <input type="text" class="form-control" name="state">
                                            </div>
                                            <div class="col-sm-3 mt-3">Country</div>
                                            <div class="col-sm-9 mt-3">
                                                <input type="text" class="form-control" name="country">
                                            </div>
                                            <div class="col-sm-3 mt-3">Bank Name</div>
                                            <div class="col-sm-9 mt-3">
                                                <input type="text" class="form-control" name="bank_name">
                                            </div>
                                            <div class="col-sm-3 mt-3">Bank Account No</div>
                                            <div class="col-sm-9 mt-3">
                                                <input type="text" class="form-control" name="bank_acc_no">
                                            </div>
                                            <div class="col-sm-3 mt-3">Belongs To</div>
                                            <div class="col-sm-9 mt-3">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="belongs_to" value="GSM">GSM Mall
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="belongs_to" Value="Other">Other Mall
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 mt-3">Password</div>
                                            <div class="col-sm-9 mt-3">
                                                <input type="password" class="form-control" name="password">
                                            </div>
                                            <div class="col-sm-3 mt-3">Confirm Password</div>
                                            <div class="col-sm-9 mt-3">
                                                <input type="password" class="form-control" name="confirm_password">
                                            </div>
                                            <div class="col-sm-3 mt-3">Activation</div>
                                            <div class="col-sm-9 mt-3">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="activation" value="1">Yes
                                                    </label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="activation" value="0">No
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success" style="float:right">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>