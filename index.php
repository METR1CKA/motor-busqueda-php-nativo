<?php
include 'client/ClientHttp.php';
include 'database/DB.php';

$client = new ClientHttp();
$db = new DB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $movieName = $_POST['movieName'];
  $data = $client->getMovieData($movieName);
  $movies = $data['Search'];
  foreach ($movies as $movie) {
    $db->insertFavorito($movie);
  }
}

$favoritos = $db->getFavoritos();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prueba Tecnica Evidence Technology</title>
  <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body>
  <form method="POST">
    <input type="text" name="movieName" placeholder="Nombre de la película">
    <button type="submit">Buscar</button>
  </form>

  <table>
    <thead>
      <tr>
        <th>Título</th>
        <th>Año</th>
        <th>Tipo</th>
        <th>Poster</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($favoritos as $favorito) : ?>
        <tr>
          <td><?php echo $favorito['Title']; ?></td>
          <td><?php echo $favorito['Year']; ?></td>
          <td><?php echo $favorito['Type']; ?></td>
          <td><img src="<?php echo $favorito['Poster']; ?>" alt="<?php echo $favorito['Title']; ?>"></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <script src="js/functions.js"></script>
</body>

</html>