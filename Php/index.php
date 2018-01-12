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
    
    $content['title'] = 'Cat Clinic - Nos Specialités';
    $content['description'] = ' ... ';
    $content['keywords'] = '';
    $content['author'] = 'Lambert Nathaelle';
    
    $content['class'] = 'VSpecialites';
    $content['method'] = 'showSpecialites';
    
    $content['arg'] = $data;
    
    return;
    
}/*-- specialites() */

function conseils() {
    
    global $content;
    
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
    
    $servContent['title'] = 'Cat Clinic - Informations générales';
    $servContent['description'] = ' ... ';
    $servContent['keywords'] = '';
    $servContent['author'] = 'Lambert Nathaelle';
    
    $servContent['class'] = 'VHtml';
    $servContent['method'] = 'showHtml';
    
    $html = '../Html/infos.html';
    $servContent['arg'] = $html;
    
    return;
    
}/*-- infos() */


/* ---------------------------------------------------------------
 * Mise en page - Architecture 
 --------------------------------------------------------------- */
require('../View/layout.view.php');

?>