<?php
    $vmenu = new VMenu();
    $vheader = new VHeader();

    /* Instanciation du contenu <div> servContent de la section 'services' (section du cv texte) en fonction de la classe à appeller (définie par le switch principal) */
    $vcontent = new $content['class']();
    //$vadmContent = new $admContent['class']();
?>

<!DOCTYPE html>
<html lang="<?=$_SESSION['LANG']?>">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">-->
    <meta name="description" content="<?=$content['description']?>">
    <meta name="keywords" content="<?=$content['keywords']?>">
    <meta name="author" content="<?=$content['author']?>">

    <title><?=$content['title']?></title>
      
    <!-- <link rel="icon" href="favicon.ico" /> -->
    <link rel="icon" type="image/png" href="../img/profil.png" />

    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/app.css">

    <link href="https://fonts.googleapis.com/css?family=Oxygen" rel="stylesheet">
 </head>

  <body>
      
    <?php  
    /* Header (affichage uniquement si le mode formulaire de contact n'est pas activé par request ou session ON) */
    //!isset ($_REQUEST['ex']) ? $vheader->showHeader() : '';
    /* Pour test : */
    $vheader->showHeader();
    ?>
      
    <div id="page">
    <?php
    /* Navigation */
    $vmenu->showMenu();
      
    /* Bande grise pour le menu si sortie du flux principal (catégories et formulaire de contact) */
    //isset ($_REQUEST['exec'])? print('<div style="height: 56px; background-color: #333;"></div>') : '';
    
    /* Affichage de la section 'présentation' (about) sur la page principale */
    //!isset ($_REQUEST['ex']) ? include('../Html/about.html') : ''; 
      
    /* Affichage du formulaire de contact */
    //if(isset ($_REQUEST['exec']) || ($_SESSION['form'] == 'ON'))
        //{
            //if ((isset ($_REQUEST['exec'])) && ($_REQUEST['exec'] == 'contactform'))
            //{
                //include('../Html/contactform.php');
                //$vcontactform = new VContactform();
                //$vcontactform->showContactform();
            //}else if ($_SESSION['form'] == 'ON')
            //{
                //include('../Html/contactform.php');
                //$vcontactform = new VContactform();
                //$vcontactform->showContactform();
            //}
        //}
    ?>
          
    <section id="content" class="grid-x grid-padding-x">
      <div class="large-12">
        <?php
      
        /* Affichage de la vue sélectionnée dans la section "services" */
        $vcontent-> {$content['method']}($content['arg']);
      
        ?>
      </div>
    </section>
   
    <?php 
    //if( isset ($_REQUEST['ex']))
    //{
        //if ($_REQUEST['ex'] != 'contactform') 
        //{
            //include('../Html/video.html');
        //}
    //}
    ?>

    </div>
        
    <script src="../bower_components/jquery/dist/jquery.js"></script>
    <script src="../bower_components/what-input/dist/what-input.js"></script>
    <script src="../bower_components/foundation-sites/dist/js/foundation.js"></script>
    <script src="../js/app.js"></script>

  </body>

</html>
