<?php require APPROOT . '/views/layouts/partials/header.php'; ?>

<body>

<?php require APPROOT . '/views/layouts/partials/navbar.php'; ?>

<div class="container py-4">

<?php

if(isset($content))
{
    require APPROOT . "/views/" . $content . ".php";
}

?>



</div>

<?php require APPROOT . '/views/layouts/partials/footer.php'; ?>