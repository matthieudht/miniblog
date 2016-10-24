<!doctype html>
<html>
  <head>
    <title></title>
    <meta charset="utf-8" />
  </head>
  <body>


    <h1>mon 1er blog</h1>
    <p>DErnier billet du blog: </p>

    <?php
    /* conexion to databse */
    try {
	$bdd = new PDO('mysql:host=localhost;dbname=miniblog;charset=utf8', 'dehondtmatthieu', 'mD120989');
    }
    catch(Exception $error) {
	die('erreur: '.$error->getMessage());}

    /* recover last 5 billets */
    $request = $bdd->query('SELECT id, titre, contenu, DATE_FORMAT(date_creation, \'%d%m%y at %Hh%imin%ss\') AS date_creation_fr FROM Billets ORDER BY date_creation DESC LIMIT 5 OFFSET 0');

    while ($donnes = $request->fetch()) {
    ?>

      <div class="news">
	<h3>
	  <?php echo htmlspecialchars($donnes['titre']); ?> <em> le <?php echo $donnes['date_creation_fr']; ?></em>
	</h3>

	<p><?php echo nl2br(htmlspecialchars($donnes['contenu'])); ?>
	  <br/>
	  <em><a href="commentaires.php?billet=<?php echo $donnes['id']; ?>">Commentaires</a></em></p>
      </div>
      <?php
      }
      $request->closeCursor();
      ?>
  </body>
</html>
