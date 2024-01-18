<?php
// TemaTres : aplicación para la gestión de lenguajes documentales #       #
//
// Copyright (C) 2004-2019 Diego Ferreyra tematres@r020.com.ar
// Distribuido bajo Licencia GNU Public License, versión 2 (de junio de 1.991) Free Software Foundation
//
//
//
require "config.tematres.php";
$metadata=do_meta_tag();
?>
<!DOCTYPE html>
<html lang="<?php echo LANG;?>">
  <head>
    <?php echo HTMLheader($metadata);?>        
        <?php
        echo '<link rel="stylesheet" type="text/css" href="'.T3_WEBPATH.'jq/chartist-js/chartist.min.css">';
        echo '<script type="text/javascript" src="'.T3_WEBPATH.'jq/chartist-js/chartist.min.js"></script>';
        echo '<script type="text/javascript" src="'.T3_WEBPATH.'jq/chartist-js/chartist-plugin-axistitle.min.js"></script>';
        ?>
        <style>
            #ct-deep  {
                height: 300px;
                width: 100%;
            }
            #ct-lexical {
                height: 400px;
                width: 100%;

            }
            #ct-logic {
                height: 400px;
                width: 100%;
            }
            .ct-label{
                fill: rgba(0,0,0,.8);
                color: rgba(0,0,0,.8);
                font-size: 1em;
                line-height: 2;
            }
        </style>        
  </head>
 <body>   
    <?php echo HTMLnavHeader(); ?>
<div class="container">
<div class="container sobre " id="bodyText">
    
    <?php

    echo HTMLsummary();

    if (evalUserLevel($_SESSION[$_SESSION["CFGURL"]])>0) {

        $_GET["ord"]=array2value("ord", $_GET);
        $_GET["y"]=array2value("y", $_GET);
        $_GET["user_id"]=array2value("user_id", $_GET);
        //es admin y quiere ver un usuario
        if (($_GET["user_id"])    &&    (evalUserLevel($_SESSION[$_SESSION["CFGURL"]])==1)) {
            echo doBrowseTermsFromUser(secure_data($_GET["user_id"], $_GET["ord"]));
        } elseif ($_GET["user_id"]) {//no es admin y quiere verse a si mismo
            echo doBrowseTermsFromUser(secure_data($_SESSION[$_SESSION["CFGURL"]]["ssuser_id"], "sql"), secure_data($_GET["ord"], "sql"));
        } elseif ($_GET["y"]) {//quiere ver un año
            echo doBrowseTermsFromDate(secure_data($_GET["m"], "sql"), secure_data($_GET["y"], "sql"), secure_data($_GET["ord"], "sql"));
        } else {//ver lista agregada
            echo doBrowseTermsByDate();
        }
    };
    ?>
</div>
</div><!-- /.container -->
<div class="push"></div>
<!-- ###### Footer ###### -->

<div id="footer" class="footer">
    <div class="container">
        <p class="navbar-text pull-left">
            <?php
                //are enable SPARQL
                if (CFG_ENABLE_SPARQL==1) {
                    echo '<a class="label label-info" href="'.URL_BASE.'sparql.php" title="'.LABEL_SPARQLEndpoint.'">'.LABEL_SPARQLEndpoint.'</a>';
                }

                if (CFG_SIMPLE_WEB_SERVICE==1) {
                    echo '  <a class="label label-info" href="'.URL_BASE.'services.php" title="API"><span class="glyphicon glyphicon-share"></span> API</a>';
                }

                echo '  <a class="label label-info" href="'.URL_BASE.'xml.php?rss=true" title="RSS"><span class="icon icon-rss"></span> RSS</a>';
                echo '  <a class="label label-info" href="'.URL_BASE.'index.php?s=n" title="'.ucfirst(LABEL_showNewsTerm).'"><span class="glyphicon glyphicon-fire"></span> '.ucfirst(LABEL_showNewsTerm).'</a>';
                if (evalUserLevel($_SESSION[$_SESSION["CFGURL"]])==0) {
                    echo '  <a class="label label-info" href="'.URL_BASE.'login-modal.php" title="'.MENU_MiCuenta.'" data-toggle="modal" data-target="#remoteModal">'.MENU_MiCuenta.'</a>';
                }
            ?>
        </p>
        <?php echo doMenuLang(); ?>
    </div>
    <div id="info-footer" class="text-center">
        <strong>Universidade Federal do Pará</strong><br>
        Rua Augusto Corrêa, 1 - Guamá - Belém/PA - Brasil
    </div>

</div>
<?php echo HTMLjsInclude();?>
</body>
</html>
