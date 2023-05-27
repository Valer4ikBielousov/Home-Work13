<?php
session_start();
require __DIR__ . '/functions/functions.php';

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
            <h1>Login form</h1>
        </div>
        <form action="controllers/login_control.php" method="POST">
            <div class="row g-3">
                <div class="col" style=" margin-top: 20px ">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Write your email</label>
                </div>
                <input type="text" name="email" class="form-control"
                       value=""
                       aria-label="email" placeholder="email">
            </div>
            <div class="col" style=" margin-bottom: 20px">
                <div class="col-sm-10">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Write your Password</label>
                </div>
                <input type="password" name="password" class="form-control" placeholder="password" id="inputPassword3">
            </div>


            <button type="submit" class="btn btn-secondary">Sign in</button>
        </form>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>

</body>
</html>
