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

  $showFavoritos = false;

  $error = '';

  $message = '';

  if (isset($_POST['buscar_web'])) {
    $movieName = $_POST['movie_name_web'];

    $data = $client->getMovieData($movieName);

    if ($data['Response'] == 'False') {
      $error = "ERROR: {$data['Error']}";
    } else {
      $movies = $data['Search'];
    }
  }

  if (isset($_POST['add_favorito'])) {
    $movieData = [
      'Title' => $_POST['title_m'],
      'Year' => $_POST['year_m'],
      'Type' => $_POST['type_m'],
      'Poster' => $_POST['poster_m']
    ];

    $db->insertFavorito($movieData);

    $message = 'Favorito agregado correctamente';
  }

  if (isset($_POST['show_favoritos'])) {
    $showFavoritos = true;
  }

  $favoritos = $db->getFavoritos();
  ?>

  <form method="POST">
    <input type="text" name="movie_name_web" id="movie_name_web" placeholder="Nombre de la película">
    <button type="submit" name="buscar_web" id="buscar_web">Buscar</button>
    <button type="submit" name="show_favoritos">Mostrar favoritos</button>
  </form>

  <?php if (!empty($message)) : ?>
    <p>
      <?php
      echo $message;
      return;
      ?>
    </p>
  <?php endif; ?>

  <?php if (!empty($error)) : ?>
    <p><?php echo $error; ?></p>
  <?php elseif ($showFavoritos) : ?>
    <h2>Favoritos</h2>
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
            <td><?php echo $favorito['title_m']; ?></td>
            <td><?php echo $favorito['year_m']; ?></td>
            <td><?php echo $favorito['type_m']; ?></td>
            <td><img src="<?php echo $favorito['poster_m']; ?>" alt="<?php echo $favorito['title_m']; ?>"></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else : ?>
    <table>
      <thead>
        <tr>
          <th>Título</th>
          <th>Año</th>
          <th>Tipo</th>
          <th>Poster</th>
          <th>Favoritos</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($movies as $movie) : ?>
          <tr>
            <td><?php echo $movie['Title']; ?></td>
            <td><?php echo $movie['Year']; ?></td>
            <td><?php echo $movie['Type']; ?></td>
            <td><img src="<?php echo $movie['Poster']; ?>" alt="<?php echo $movie['Title']; ?>"></td>
            <td>
              <form method="POST">
                <input type="hidden" name="title_m" value="<?php echo $movie['Title']; ?>">
                <input type="hidden" name="year_m" value="<?php echo $movie['Year']; ?>">
                <input type="hidden" name="type_m" value="<?php echo $movie['Type']; ?>">
                <input type="hidden" name="poster_m" value="<?php echo $movie['Poster']; ?>">
                <button type="submit" name="add_favorito">Agregar a favoritos</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <script src="js/functions.js"></script>
</body>

</html>