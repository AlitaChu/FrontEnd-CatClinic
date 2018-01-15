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
    
$EX = isset ($_REQUEST['ex']) ? $_REQUEST['ex'] : 'accueil';

/* La fonction de contrôle specialites() devra afficher le menu par défaut de la section 'specialites' */
/* La fonction de contrôle conseils() devra afficher le menu par défaut de la section 'conseils' */
/* La fonction de contrôle infos() devra afficher l'ancre' par défaut de la section 'infos' */
switch ($EX) {
    case 'spe': specialites();
        break;
    case 'fco': conseils();
        break;
    case 'inf': infos();
        break;
    default : accueil();
        break;
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
    
    //$marticle = new MArticle();
    //$data = $marticle-> SelectAllResume($id);
    //array_walk($data, 'strip_xss');
    
    //test du Select()
    //$marticle = new MArticle(2);
    //$data = $marticle-> Select();
    //array_walk($data, 'strip_xss');
    
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
    
    //debug($data); 
    
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


/* ---------------------------------------------------------------
 * Mise en page - Architecture 
 --------------------------------------------------------------- */
require('../View/layout.view.php');

?>