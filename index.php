<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Prueba Tecnica Evidence Technology</title>
  <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body>
  <?php
  include 'client/ClientHttp.php';
  include 'database/DB.php';

  $client = new ClientHttp();
  $db = new DB();

  $movies = [];

  $error = '';

  if (isset($_POST['buscar_web'])) {
    $movieName = $_POST['movie_name_web'];

    $data = $client->getMovieData($movieName);

    if ($data['Response'] == 'False') {
      $error = "ERROR: {$data['Error']}";
    } else {
      $movies = $data['Search'];
    }
  }
  ?>

  <form method="POST">
    <input type="text" name="movie_name_web" id="movie_name_web" placeholder="Nombre de la película">
    <button type="submit" name="buscar_web" id="buscar_web">Buscar</button>
  </form>

  <?php if (!empty($error)) : ?>
    <p><?php echo $error; ?></p>
  <?php else : ?>
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
        <?php foreach ($movies as $movie) : ?>
          <tr>
            <td><?php echo $movie['Title']; ?></td>
            <td><?php echo $movie['Year']; ?></td>
            <td><?php echo $movie['Type']; ?></td>
            <td><img src="<?php echo $movie['Poster']; ?>" alt="<?php echo $movie['Title']; ?>"></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <script src="js/functions.js"></script>
</body>

</html>