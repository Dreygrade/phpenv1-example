<?php

use Medoo\Medoo;
use Particle\Validator\Validator;

require_once '../vendor/autoload.php';
//$array = [1, "apple", 2, "foo", "bar"];

/*$database = new medoo([
    'database_type' => 'sqlite',
    'database_file' => '../storage/database.db'
]);

$comment = new SitePoint\Comment($database);
$comment->setEmail('bruno@skvorc.me')
  ->setName('Bruno Skvorc')
  ->setComment('It works!It works!It works!It works!It works!Hooray! Saving comments works!Hooray! Saving comments works!Hooray! Saving comments works!Hooray! Saving comments works!')
  ->setComment('Hooray! Saving comments works!Hooray! Saving comments works!Hooray! Saving comments works!Hooray! Saving comments works!Hooray! Saving comments works!Hooray! Saving comments works!Hooray! Saving comments works!')
  ->save();*/

// Medoo initialisation
$file = '../storage/database.db';
/*if (is_writable('../storage/database.local.db')) {
$file = '../storage/database.local.db';
}*/

$database = new medoo([
    'database_type' => 'sqlite',
    'database_file' => $file
]);

$comment = new SitePoint\Comment($database);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $v = new Validator();
    $v->required('name')->lengthBetween(1, 100)->alnum(true);
    $v->required('email')->email()->lengthBetween(5, 255);
    $v->required('comment')->lengthBetween(10, null);

    $result = $v->validate($_POST);

    if ($result->isValid()) {
        try {
       $comment
            ->setName($_POST['name'])
            ->setEmail($_POST['email'])
            ->setComment($_POST['comment'])
            ->save();

        header('Location: /');
        return;

        } catch (\Exception $e) {
            die($e->getMessage());
}
    } else {
        dump($result->getMessages());
    }
}

?>


<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="manifest" href="site.webmanifest">
        <link rel="apple-touch-icon" href="icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <!--[if lte IE 9]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->

        <!-- Add your site or application content here -->
        <p>Hello world! This is HTML5 Boilerplate.</p>
        
    
        
        <?php foreach ($comment->findAll() as $comment) : ?>
        
        

    <div class="comment">
        <h3>On <?php echo $comment->getSubmissionDate() ?>, 
               <?php echo $comment->getName() ?> wrote:</h3>

        <p><?php echo $comment->getComment(); ?></p>
    </div>

<?php endforeach; ?>
        
        
        <form method="post">
            
        <label>Name: <input type="text" name="name" placeholder="Your name"></label>
        <label>Email: <input type="text" name="email" placeholder="your@email.com"></label>
        <label>Comment: <textarea name="comment" cols="30" rows="10"></textarea></label>


        <input type="submit" value="Save">
        </form>        
        
        <script src="js/vendor/modernizr-3.5.0.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.2.1.min.js"><\/script>')</script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>

        <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
        <script>
            window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
            ga('create','UA-XXXXX-Y','auto');ga('send','pageview')
        </script>
        <script src="https://www.google-analytics.com/analytics.js" async defer></script>
        
        <?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); ?>
        
    </body>
</html>
