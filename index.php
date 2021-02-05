<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <!-- Meta Description, Keywords et Title pour le référencement -->
    <meta name="description" content="VAPEUR DOUCE - Plats gourmands, Vapeur Douce">
    <meta name="keywords" content="vapeur, cuisson, recette, vapeur douce, Stéphane Gabrielly, Gabrielly">
    <meta name="robots" content="index, follow">
    <title>Vapeur Douce</title>
    <!-- Twitter Card-->
    <meta name=”twitter:card” content="summary">
    <meta name=”twitter:site” content="@Vapeur-Douce">
    <meta name=”twitter:title” content="Vapeur Douce">
    <meta name=”twitter:description” content="Plats gourmands, Vapeur Douce">
    <meta name=”twitter:creator” content="@StéphaneGabrielly">
    <meta name=”twitter:image:src” content="https://dev5.projects.go.yo.fr/Vapeur-Douce/src/vapeurdouce.jpg">
    <!-- Open Graph -->
    <meta property="og:url" content="https://dev5.projects.go.yo.fr/Vapeur-Douce/">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Vapeur Douce">
    <meta property="og:description" content="Plats gourmands, Vapeur Douce">
    <meta property="og:image" content="https://dev5.projects.go.yo.fr/Vapeur-Douce/src/vapeurdouce.jpg">
</head>

<body>
    <main>

        <div id="mainBlock">
            <h1>VAPEUR <span>DOUCE</span></h1>
            <!-- Ici le form renvoi à la même page et la méthode utilisée est le POST -->
            <form action="index.php" method="POST">
                <input type="text" id="inputFormRecherche" name="inputFormRecherche" autocomplete="off" list='cuissonList' required>
                <datalist id="">
                    <?php
                    //Initialisation de la session
                    $curl = curl_init();
                    //Configuration des options
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://api.hmz.tf/?id=all",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_TIMEOUT => 30
                    ));
                    //éxécution de la session
                    $response = curl_exec($curl);
                    //fermeture de la session
                    curl_close($curl);
                    //On décode le json reçu afin de pouvoir afficher les résultats
                    $response = json_decode($response, true);
                    foreach($response['message'] as $key => $value){
                        $trucPasCuit = htmlentities($key, ENT_QUOTES);
                        echo ('<option>' . $trucPasCuit . '</option>');
                    }
                    ?>
                </datalist>
                <button type="submit"><img src="src/loupe.svg" alt="loupe de recherche"></button>
            </form>
            <p>Plats gourmands, Vapeur Douce</p>
        </div>

        <div id="divResultat">
            <?php
            //On vérifie qu'une recherche est en cours
            if (isset($_POST['inputFormRecherche'])) {
                //On encode l'input de l'utilisateur pour s'en servir ensuite dans l'url. On utilise ici la fonction urlencode() native de php
                $search = urlencode($_POST['inputFormRecherche']);
                //Initialisation de la session
                $curl = curl_init();
                //Configuration des options
                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://api.hmz.tf/?id=$search",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 30
                ));
                //éxécution de la session
                $response = curl_exec($curl);
                //fermeture de la session
                curl_close($curl);
                //On décode le json reçu afin de pouvoir afficher les résultats
                $response = json_decode($response, true);

                if ($search == 'all') {
                    //On échappe l'affichage de résultat pour all parce que ça fait tout planter
                    echo ('<p>Aucun résultat ne correspond à votre recherche...</p>');
                } else if ($search == 'xss') {
                    //Début de la vengeance
            ?>
                    <script>
                        setTimeout(function() {
                            let e = document.createElement(`div`);
                            e.style.cssText = `position:fixed;top:0;left:0;right:0;bottom:0;display:flex;align-items:center;justify-content:center;background-color:rgba(255,0,0,.8);color:#fff;font-size:10vh;font-weight:600;z-index:2147483646;`;
                            e.innerHTML = `Vilain formateur ! Vilain !`;
                            document.body.appendChild(e);
                        }, 200);
                        alert('Je suis un vilain formateur !');
                    </script>
            <?php
                    echo ('<img src="src/hackerman.gif" alt="parce que tu le vaux bien" style="width:40rem;heigth:auto;">');
                    //Fin de la vengeance
                } else if ($response['status'] == 'success') {
                    //Ici, toutes les données qui proviennent de l'API sont encodée à des fins de sécurité
                    //On affiche le nom de l'aliment recherché si il existe dans l'API
                    echo ('<h2>' . htmlentities($response["message"]["nom"], ENT_QUOTES) . '</h2>');
                    echo ('<div id="lalignedudesigner"></div>');
                    //On affiche le trempage si il est indiqué
                    if (isset($response["message"]["vapeur"]["trempage"])) {
                        echo ('<p>Trempage : ' . htmlentities($response["message"]["vapeur"]["trempage"], ENT_QUOTES) . '</p>');
                    }
                    //On affiche le niveau d'eau si il est indiqué
                    if (isset($response["message"]["vapeur"]["niveau d'eau"])) {
                        echo ("<p>Niveau d'eau : " . htmlentities($response["message"]["vapeur"]["niveau d'eau"], ENT_QUOTES) . "</p>");
                    }
                    //On affiche le tremps de cuisson si il est indiqué
                    if (isset($response["message"]["vapeur"]["cuisson"])) {
                        echo ('<p>Temps de cuisson : ' . htmlentities($response["message"]["vapeur"]["cuisson"], ENT_QUOTES) . '</p>');
                    }
                } else {
                    //Si aucun résultat ne correspond à la recherche (si status ne renvoi pas success), on affiche un message d'erreur
                    echo ('<p>Aucun résultat ne correspond à votre recherche...</p>');
                }
            }
            ?>
        </div>

    </main>
<script src="app.js"></script>
</body>

</html>