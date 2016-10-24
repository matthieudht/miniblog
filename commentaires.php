<!doctype html>
<html>
  <head>
    <title></title>
    <meta charset="utf-8" />
  </head>
  <body>


    <h1>Mon super blog !</h1>

    <p><a href="index.php">return to Billet list</a></p>

    

    <?php

    // Connexion à la base de données

    try

    {

	$bdd = new PDO('mysql:host=localhost;dbname=miniblog;charset=utf8', 'dehondtmatthieu', 'mD120989');

    }

    catch(Exception $error)

    {

        die('Erreur : '.$error->getMessage());

    }


    // Récupération du billet

    $request = $bdd->prepare('SELECT id, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y à %Hh%imin%ss\') AS date_creation_fr FROM Billets WHERE id = ?');

    $request->execute(array($_GET['billet']));

    $donnees = $request->fetch();

    ?>


    <div class="news">

      <h3>

        <?php echo htmlspecialchars($donnees['titre']); ?>

        <em>le <?php echo $donnees['date_creation_fr']; ?></em>

      </h3>

      

      <p>

	<?php

	echo nl2br(htmlspecialchars($donnees['contenu']));

	?>

      </p>

    </div>


    <h2>Commentaires</h2>


    <?php

    $request->closeCursor(); // Important : on libère le curseur pour la prochaine requête


    // Recover comments

    $request = $bdd->prepare('SELECT auteur, commentaire, DATE_FORMAT(date_commentaire, \'%d/%m/%Y à %Hh%imin%ss\') AS date_commentaire_fr FROM Commentaires WHERE id_billet = ? ORDER BY date_commentaire');

    $request->execute(array($_GET['billet']));


    while ($donnees = $request->fetch())

    {

    ?>

      <p><strong><?php echo htmlspecialchars($donnees['auteur']); ?></strong> le <?php echo $donnees['date_commentaire_fr']; ?></p>

      <p><?php echo nl2br(htmlspecialchars($donnees['commentaire'])); ?></p>

    <?php

    } 

    $request->closeCursor();

    ?>
  </body>
</html>
