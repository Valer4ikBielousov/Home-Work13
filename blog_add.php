<?php
session_start();
require __DIR__ . '/functions/functions.php';
require_once __DIR__ . '/functions/database_functions.php';
require_once __DIR__ . '/db.php';
$connect = connect();
$users = getAllUser($connect);

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
<div class="shadow-lg p-3 mb-5 bg-body rounded">
    <div class="p-3 mb-2 bg-secondary text-white">
        <header>MENU</header>
        <div style="display: flex; justify-content: center; ">
            <nav>

                <a style="font-size: 36px" type="button"
                   onclick="window.location.href = '/controllers/exitControler.php';"
                   class="btn btn-secondary">Exit</a>

            </nav>
        </div>
    </div>
</div>

<div class="container text-center" style=" margin-top: 200px;">
    <?php if (existMesseges('warnings')) { ?>
        <div class="alert alert-danger" role="alert">
            <?php
            foreach (getMesseges('warnings') as $warning) {
                echo "$warning<br>";
            } ?>
        </div>
    <?php } ?>
    <div class="shadow-lg p-3 mb-5 bg-body rounded">
        <div class="p-3 mb-2 bg-secondary text-white">
            <h1>Blog add</h1>
        </div>
        <form action="controllers/blog_add_control.php" method="POST" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col" style=" margin-top: 20px; margin-bottom: 20px ">
                    <?php if (existMesseges('tittle')) { ?>
                        <div class="alert alert-danger" role="alert">
                            <?php
                            foreach ((getMesseges('tittle')) as $bugMassage) {
                                echo "$bugMassage<br>";
                            } ?>
                        </div>
                    <?php } ?>
                    <input type="text" name="tittle" class="form-control"
                           value="<?= getF('blog_add_form', 'tittle') ?>"
                           aria-label="title" placeholder="tittle">
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="file" name="image" class="form-control" id="inputGroupFile02">
                <label class="input-group-text" for="inputGroupFile02">Upload</label>
            </div>
            <div class="col-sm-10">
                <?php if (existMesseges('content')) { ?>

                    <div class="alert alert-danger" role="alert">
                        <?php
                        foreach ((getMesseges('content')) as $bugMassage) {
                            echo "$bugMassage<br>";
                        } ?>
                    </div>
                <?php }
                ?>
                <div class="form-floating">
                    <textarea class="form-control" name="content" placeholder="Leave a comment here"
                              id="floatingTextarea2" style="height: 100px"></textarea>
                    <label for="floatingTextarea2">Comments</label>
                </div>
            </div>
            <div class="form-group">
                <?php if ($users) { ?>
                    <select class="form-select" name="author_id" aria-label="Default select example">

                        <option selected>Select user</option>
                        <?php foreach ($users as $user) { ?>
                            <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
                        <?php }
                        ?>
                    </select>
                <?php }
                ?>
            </div>
            <?php
            unsetMesseges('tittle');
            unsetMesseges('content');
            unsetMesseges('warnings');
            ?>
            <button type="submit" class="btn btn-secondary">ADD</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
            crossorigin="anonymous"></script>
</div>
</body>
</html>
