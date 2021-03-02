<!DOCTYPE html>
<html lang="fr" class="h-100">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title><?= isset($title) ? e($title) : 'Mon Site' ?></title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
     <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous"> -->
</head>

<body class="d-flex flex-column h-100">
     <nav class="navbar navbar-dark bg-primary">
          <a href="#" class="navbar-brand">Mon site</a>
     </nav>

     <div class="conatainer m-5">
          <?= $content ?>
     </div>

     <footer class="bg-light py-3 footer mt-auto">
          <div class="container">
               <?php if (defined('DEBUG_TIME')) : ?>
                    Page généréé en <?= round(1000 * (microtime(true) - DEBUG_TIME)) ?>ms
               <?php endif ?>
          </div>
          <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
     </footer>
</body>

</html>