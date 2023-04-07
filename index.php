<?php
require __DIR__.'./functions/functions.php';

session_start();
print_r (getMesseges('Warning'));
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body>
<div class="container text-center" style=" margin-top: 200px;">
    <div class="shadow-lg p-3 mb-5 bg-body rounded">
        <div class="p-3 mb-2 bg-secondary text-white">
            <h1>Registration form</h1>
        </div>
        <form  action="controllers/registration.php" method="POST">
            <div class="row g-3">

                <div class="col" style=" margin-top: 20px; margin-bottom: 20px ">
                    <input type="text" name="name" class="form-control" placeholder="First name"
                           aria-label="First name">
                </div>
                <div class="col" style=" margin-bottom: 20px">
                    <input type="text" name="lastname" class="form-control" placeholder="Last name"
                           aria-label="Last name">
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" name = "email" class="form-control" id="inputEmail3">
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" name = "password" class="form-control" id="inputPassword3">
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputPassword4"  class="col-sm-2 col-form-label">Confirm password</label>
                <div class="col-sm-10">
                    <input type="password" name = "confirmPassword" class="form-control" id="inputPassword4">
                </div>
            </div>
            <button type="submit" class="btn btn-secondary">Sign in</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
            crossorigin="anonymous"></script>
</div>
</body>
</html>

