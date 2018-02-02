<?php
session_start();
//session_cache_limiter('nocache');
/*---------------- Session langues --------------------*/
if (isset ($_REQUEST['LANG'])) 
{
    $_SESSION['LANG'] = $_REQUEST['LANG'];
} 
else if (isset ($_SESSION['LANG'])) 
{
    $_SESSION['LANG'] = $_SESSION['LANG'];
}
else
{
    $_SESSION['LANG'] = 'FR';
}/*-------------------fin langues----------------------*/

require('../Inc/require.inc.php');

//require('../Inc/admin.inc.php');
    
$EX = isset ($_REQUEST['ex']) ? $_REQUEST['ex'] : 'accueil';

/* La fonction de contrôle specialites() devra afficher le menu par défaut de la section 'specialites' */
/* La fonction de contrôle conseils() devra afficher le menu par défaut de la section 'conseils' */
/* La fonction de contrôle infos() devra afficher l'ancre' par défaut de la section 'infos' */

/* La fonction de contrôle login() vérifiera les infos envoyées par le formulaire, et affichera soit l'espace admin, soit l'espace membres */
/* La fonction de contrôle deconnect() a pour effet de vider $_SESSION['user] */
switch ($EX) {
    case 'spe': specialites(); break;
    case 'fco': conseils(); break;
    case 'inf': infos(); break;
    // fonction de vérification du login//si ok ouverture de l'un des deux contrôleurs d'administration    
    case 'log': login(); break;
    case 'dec': deconnect(); break;
    case 'ins': insert(); break;
    //case 'esp': membres();
        //break;  
    case 'adm': admin(); break;
    case 'tes': test(); break;
    default : accueil(); break;
}//--finswitch

/* --------------------------------------------------------------
 * FONCTIONS DE CONTROLE :  
 * home()
 * specialites()
 * conseils()
 * infos()
 ---------------------------------------------------------------*/

function accueil() {
    
    global $content;
    
    $content['title'] = 'Cat Clinic - Accueil';
    $content['description'] = 'Bienvenue dans votre clinique spécialisée dans le soin de vos félins';
    $content['keywords'] = '';
    $content['author'] = 'Lambert Nathaelle';
    
    $content['class'] = 'VHtml';
    $content['method'] = 'showHtml';
    $content['arg'] = '../Html/accueil.html';
    
    return;
    
}/*-- accueil() */


function specialites() {
    
    global $content;
    
    $id = 1; // a remplacer par $_GET['idcat'] ou array
    
    if(!isset($_GET['id']))
    {
        $method = 'showSpecialites';
        $marticle = new MArticle();
        $data = $marticle-> SelectAllResume($id);
    } else
    {
        $method = 'showDetailsSpec';
        $marticle = new MArticle($_GET['id']);
        $data = $marticle-> Select();
    }
    array_walk($data, 'strip_xss');
    
    $content['title'] = 'Cat Clinic - Nos Specialités';
    $content['description'] = ' ... ';
    $content['keywords'] = '';
    $content['author'] = 'Lambert Nathaelle';
    
    $content['class'] = 'VSpecialites';
    
    $content['method'] = $method;
    $content['arg'] = $data;
    
    return;
    
}/*-- specialites() */


function conseils() {
    
    global $content;
    
    $id = 2; // a remplacer par $_GET['idcat'] ou array
    
    $marticle = new MArticle();
    $data = $marticle-> SelectResume($id);
    array_walk($data, 'strip_xss');
    
    $content['title'] = 'Cat Clinic - Conseils pour votre animal';
    $content['description'] = ' ... ';
    $content['keywords'] = '';
    $content['author'] = 'Lambert Nathaelle';
    
    $content['class'] = 'VHtml';
    $content['method'] = 'showConseils';
    
    $content['arg'] = $data;
    
    return;
    
}/*-- conseils() */

function infos() {
    
    global $content;
    
    $content['title'] = 'Cat Clinic - Informations générales';
    $content['description'] = ' ... ';
    $content['keywords'] = '';
    $content['author'] = 'Lambert Nathaelle';
    
    $content['class'] = 'VHtml';
    $content['method'] = 'showHtml';
    
    $html = '../Html/infos.html';
    $content['arg'] = $html;
    
    return;
    
}/*-- infos() */


/* --------------------------------------------------------------
 * FONCTIONS DE CONTROLE :  
 * login()
 * membre()
 * admin()
 ---------------------------------------------------------------*/
function admin() {
    
    global $content;
    
    if(isset($_GET['id_art'])) {
        $marticle = new MArticle($_GET['id_art']);
        $data = $marticle-> Select();
    }
    else if(isset($_GET['id_cat'])) {
        $marticle = new MArticle();
        $data = $marticle-> SelectAllResume($_GET['id_cat']);
    } else {
        $mcategorie = new MCategorie();
        $data = $mcategorie-> SelectCat();
    }
    
    array_walk($data, 'strip_xss');
    
    $content['title'] = 'Cat Clinic - Panneau d\'administration';
    $content['description'] = ' ... ';
    $content['keywords'] = '';
    $content['author'] = 'Lambert Nathaelle';
    
    $content['class'] = 'VAdmin';
    // Par default, affichage du panel 1 d'administration des articles, qui possède aussi le message 'Bienvenue'
    $EX2 = isset ($_REQUEST['ex2']) ? $_REQUEST['ex2'] : 'pan1';
    
    // à terminer de créer 3 méthodes selon le paramètre transmis par le menu panel, devrait faciliter l'interrogation de la base, VAdmin à modifier et à scinder en 3!!!!! On oublie le VHtml
    switch ($EX2) {
        case 'pan1': $content['method'] = 'showAdmGeneral';
                     $content['arg'] = $data;
                     break;
        case 'pan2': $content['method'] = 'showAdmClients';
                     $content['arg'] = $data;
                     break;
        case 'pan3': $content['method'] = 'showAdmConsultations';
                     $content['arg'] = $data;
                     break;
        default : die(); break;
    }//--finswitch
    
    return;
    
}/*-- conseils() */











/* --------------------------------------------------------------
 * FONCTIONS DE CONTROLE :  
 * insert()
 * update()
 * delete()
 ---------------------------------------------------------------*/

function test() {
    
    global $content;
    
    $content['title'] = 'Cat Clinic - Accueil';
    $content['description'] = 'Bienvenue dans votre clinique spécialisée dans le soin de vos félins';
    $content['keywords'] = '';
    $content['author'] = 'Lambert Nathaelle';
    
    $content['class'] = 'VHtml';
    $content['method'] = 'showHtml';
    $content['arg'] = '../Html/formtest.html';
    
    return;
    
}/*-- test() */


function insert() {
    
    isset($_POST['passwd']) ? $_POST['passwd'] = password_hash($_POST['passwd'], PASSWORD_BCRYPT) : '';
    
    debug($_POST);
    debug($_FILES);
    /* $_FILES = tabarray :
     * $_FILES['image']['name'] -> nom du fichier initial
     * $_FILES['image']['type'] -> type mime
     * $_FILES['image']['tmp_name'] -> chemin du fichier temporaire
     * $_FILES['image']['error'] -> s'il y a une erreur, à gérer!
     * $_FILES['image']['size'] -> taille du fichier
    */
    
    /* Teste s'il y a téléchargement d'une image : 
     * Vérifer 1. Attribut 'name' du form, 
               2. Présence de l'attribut enctype=" / ", 
               3.Vérifier init.php (si droit de télécharger) ainsi que le max upload */
    if (isset($_FILES['image']) && $_FILES['image']['tmp_name'])
    {
        /* Récupère les nouveaux noms de fichiers après traitement par la fonction upload() : */
        $filename_new = upload($_FILES['image']);
        $filename_vignette_new = 'vignettes/' . $filename_new;
        $filename_fullsize_new = 'fullsize/' . $filename_new;

        // Redimensionne les images en fullsize
        $fullsize_new = img_resize($_FILES['image']['tmp_name'], 450, 450);
        // Génère l'image fullsize $fullsizeimage_new vers le fichier $filename_new suivant le mime :
        switch ($_FILES['image']['type'])
        {
            case 'image/png'  : imagepng($fullsize_new, UPLOAD . $filename_fullsize_new, 0);  break;// 0 == compression minimum
            case 'image/jpeg' : imagejpeg($fullsize_new, UPLOAD . $filename_fullsize_new, 100); break;// 100 == compression maximum
            case 'image/gif'  : imagegif($fullsize_new, UPLOAD . $filename_fullsize_new);  break;
        }

        // Redimensionne l'image de la vignette :
        $vignette_new = img_resize($_FILES['image']['tmp_name'], 150, 150);
        // Génère l'image $image_new vers le fichier $file_new suivant le mime
        switch ($_FILES['image']['type'])
        {
            case 'image/png'  : imagepng($vignette_new, UPLOAD . $filename_vignette_new, 0);  break;// 0 == compression minimum
            case 'image/jpeg' : imagejpeg($vignette_new, UPLOAD . $filename_vignette_new, 100); break;// 100 == compression maximum
            case 'image/gif'  : imagegif($vignette_new, UPLOAD . $filename_vignette_new);  break;
        }

        // Ajoute au tableau $_POST (et donc $_value pour l'insertion) la clef IMG avec le nom du fichier pour insertion dans la base
        $_POST['img'] = $filename_fullsize_new;
        $_POST['img_vig'] = $filename_vignette_new;
    }
    
    switch($_POST['arg']){
    case 'user': $mtable = new MClient(); break;
    case 'anim': $mtable = new MAnimal(); break;
    case 'cons': $mtable = new MConsultation(); break;
    case 'arti': $_POST['contenu'] = text_format();
                 $mtable = new MArticle(); break;
    default : die(); break;
    }//--finswitch
    
    $mtable-> SetValue($_POST);
    $mtable-> Insert();
    
    test(); // == fonction précédente ou redirection
    
}/*-- insert() */

/* ---------------------------------------------------------------
 * Mise en page - Architecture 
 --------------------------------------------------------------- */
require('../View/layout.view.php');

?>