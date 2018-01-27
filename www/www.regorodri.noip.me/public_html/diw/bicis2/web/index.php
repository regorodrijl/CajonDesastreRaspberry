<?php
    require_once '../lib/i18n.php';
    
    session_start();
    
    if (isset($_SESSION['lang']))
    {
        // Comprobar se o idioma ven na URL:
        if (isset($_GET['lang']))
        {
            $_SESSION['i18n']->setLocale($_GET['lang']); 
        }
        else
        {
            // Establecer ese idioma:
            $_SESSION['i18n']->setLocale($_SESSION['lang']);   
        }
    }
    else
    {
        $i18n = new i18n();

        // Coller o idoma por defecto do navegador do usuario:
        $locale = $i18n->getClientLang();
        // Establecer ese idioma:
        $i18n->setLocale($locale);   
        
        $_SESSION['lang'] = $locale;
        $_SESSION['i18n'] = $i18n;
    }

?>

<!DOCTYPE html>

<html>
    <head>
        <title><?php echo _("Bikes for life"); ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0">
        <link rel="stylesheet" href="./css/stylesheet.css">
    </head>
    <body>
        <div id="siteContainer">
            <!-- SITE HEADER: -->
            <header id="siteHeader">
                <img id="siteLogo" src="./img/logo.jpg" alt="Site logo">
                <div id="languages">
                    <ul>
                        <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?lang=en">EN</a></li>
                        <li><a href="<?php echo $_SERVER['PHP_SELF']; ?>?lang=es">ES</a></li>
                    </ul>
                </div>
            </header>

            <!-- Text introducing who we are: -->
            <article id="whoWeAre">
                <p>
                    <?php
                        echo gettext("Main paragraph of my site");
                        echo "<br>";
                        echo _("Translate me");
                        
                    ?>
                </p>
            </article>

            <!-- Three areas where we work -->
            <section id="workingAreas">
                <!-- WEB DEVELOPMENT: -->
                <article class="workingArea">
                    <img src="./img/rwd.jpg" alt="Web Development">
                    <h3>webdevelopment</h3>
                    <p class="workingAreaDescription">
                            Suspendisse vel porttitor nisl. Lorem ipsum dolor sit 
                            amet, consectetur adipiscing elit. Praesent lacinia 
                            lacus faucibus, dignissim augue iaculis, pellentesque 
                            velit. Nunc ligula massa, consequat et lacinia in, 
                            placerat at tellus. Nunc sit amet orci nec enim lacinia 
                            facilisis ac nec massa. Donec egestas neque quis pretium 
                            tristique. Nam semper, metus vitae facilisis vehicula, 
                            libero eros accumsan velit, non cursus elit tellus ut odio. 
                    </p>
                </article>
                <!-- SLICING SERVICE: -->
                <article class="workingArea">
                    <img src="./img/rwd.jpg" alt="Web Development">
                    <h3>slicingservice</h3>
                    <p class="workingAreaDescription">
                            Suspendisse vel porttitor nisl. Lorem ipsum dolor sit 
                            amet, consectetur adipiscing elit. Praesent lacinia 
                            lacus faucibus, dignissim augue iaculis, pellentesque 
                            velit. Nunc ligula massa, consequat et lacinia in, 
                            placerat at tellus. Nunc sit amet orci nec enim lacinia 
                            facilisis ac nec massa. Donec egestas neque quis pretium 
                            tristique. Nam semper, metus vitae facilisis vehicula, 
                            libero eros accumsan velit, non cursus elit tellus ut odio. 
                    </p>
                </article>

                <!-- RESPONSIVE DESIGN -->
                <article class="workingArea">
                    <img src="./img/rwd.jpg" alt="Web Development">
                    <h3>responsivedesign</h3>
                    <p class="workingAreaDescription">
                            Suspendisse vel porttitor nisl. Lorem ipsum dolor sit 
                            amet, consectetur adipiscing elit. Praesent lacinia 
                            lacus faucibus, dignissim augue iaculis, pellentesque 
                            velit. Nunc ligula massa, consequat et lacinia in, 
                            placerat at tellus. Nunc sit amet orci nec enim lacinia 
                            facilisis ac nec massa. Donec egestas neque quis pretium 
                            tristique. Nam semper, metus vitae facilisis vehicula, 
                            libero eros accumsan velit, non cursus elit tellus ut odio. 
                    </p>
                </article>
            </section>
        </div>
    </body>
</html>
