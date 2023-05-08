<?php

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions/database_functions.php';
require_once __DIR__ . '/db.php';
//require_once __DIR__ . '/controllers/blog_add_control.php';

if (!chekAuth($bloger)) {
    header('location:' . SITE_REGISTRATION);
    exit;
}

$page = $_GET['page'] ?? 1;
$productPerPage = 3;
$offset = ($page - 1) * $productPerPage;

$blogs = getAllBlogs($bloger, $productPerPage, $offset);
$productsCount = countBlogs($bloger);
$maxPage = ceil($productsCount / $productPerPage);

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

    <h1>Closed content</h1>
    <div class="card-group">
        <?php if ($blogs) {
            foreach ($blogs as $blog) {
                ?>
                <div class="card" style="width: 18rem;">
                    <img src="<?= SITE_REGISTRATION . $blog['image'] ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?= $blog['tittle'] ?></h5>

                    </div>
                </div>


            <?php }
        } ?>

    </div>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
         <?php for($i=1; $i <= $maxPage; $i++){?>
            <li class="page-item"><a class="page-link" href="?page=<?= $i?>"><?= $i?></a></li>
           <?php }?>
        </ul>
    </nav>
</div>
</body>
</html>

