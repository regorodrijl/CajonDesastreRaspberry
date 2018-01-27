<?php 
//evitamos problemas con las cabeceras

$idioma = (isset($_GET["language"])) ? trim(strip_tags($_GET["language"])) : "es_ES.utf8";
putenv("LANG=$idioma");
putenv("LC_ALL={$idioma}");
setlocale(LC_ALL, $idioma);
if (false === function_exists('gettext'))
{
 echo "No tienes la libreria gettext instalada.";
 exit(1);
}else {
    echo "INSTALADO";
}
// Define la ubicación de los ficheros de traduccion
bindtextdomain("messages", "./locale");
bind_textdomain_codeset('messages', 'utf-8');
textdomain("messages");
//Mostramos el texto
//echo(gettext("Prueba de texto en castellano"));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Orestis</title>
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
                    <a class="btn btn-sm btn " href="index.php?language=es_ES.utf8" role="button">ES</a>
                    <a class="btn btn-sm btn " href="index.php?language=en_US.utf8" role="button">EN</a>
                    <li>EN</li>
                    <li>FR</li>
                </ul>
            </div>
        </header>

        <!-- Text introducing who we are: -->
        <article id="whoWeAre">
        <?php echo gettext("Bikes for life");?>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                Vestibulum venenatis eros et velit fringilla, nec mattis 
                nisi aliquam. Praesent eu augue maximus justo dapibus 
                pulvinar sagittis quis lacus. Praesent finibus mauris lacus, 
                vel viverra risus tempor non. Proin nec diam eu dui tincidunt 
                malesuada. Sed tellus lorem, mattis id euismod et, euismod 
                nec ante. Proin ut ipsum eu lorem euismod consectetur ut nec est.
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
