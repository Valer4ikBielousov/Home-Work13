<?php
session_start();
require_once __DIR__ . '/../functions/functions.php';
require_once __DIR__ . '/../functions/validation.php';
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../functions/database_functions.php';

// require from database "bloger" with PHP (PDO) on mySQL
require_once __DIR__ . "/../db.php";


// set REQUEST_METHOD errors into Session
//if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
//    setAlerts('Method not allowed!', 'warnings');
//    header('location:' . SITE_BLOGS);
//}

// parametr for function filterPostArray with type of filter to fields
$filters = [
    'tittle' => FILTER_SANITIZE_SPECIAL_CHARS,
    'content' => FILTER_SANITIZE_SPECIAL_CHARS,
    'author_id' => FILTER_SANITIZE_SPECIAL_CHARS,
];
//function to filter POST array
$filteredPost = filterPostArray($filters);

//Set value of Field Name into session
setF($filteredPost, 'blog_add_form');

//declare a type of errors on validation form
$bugName = [
    'tittle' => 'required|min_lenghth[5]|max_lenghth[300]',
    'content' => 'required|min_lenghth[5]|max_lenghth[20000]',
    'author_id' => 'required',
];

// set validation errors messages into Session

$bugArray = validation($filteredPost, $bugName, $bloger);
foreach ($bugArray as $bugField => $bugindex) {
    if (isset($bugindex)) {
        foreach ($bugindex as $bugMassages) {
            setAlerts($bugMassages, $bugField);
        }
        header('location:' . SITE_BLOGS);
        exit;
    }
}


if (fileMoveTo($_FILES['image'], '../storage/blogs')) {
    $data = [
        'tittle' => post('tittle'),
        'content' => post('content'),
        'author_id' => post('author_id', 'int'),
        'image' => 'storage/blogs' . $_FILES['image']['name']
    ];


    if ($blogid = blog_add($bloger, $data)) {

        logger($bloger,"blog #$blogid added");
        header('location:' . SITE_CLOSED);
    }

} else {
    setAlerts('File errors', 'warnings');
    header('location:' . SITE_BLOGS);

}
