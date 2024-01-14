<?php
class DB
{
  private $host = 'localhost';
  private $db   = 'db_evidence_technology';
  private $user = 'root';
  private $pass = '';
  private $pdo;

  // Constructor: establece la conexión a la base de datos
  public function __construct()
  {
    $dsn = "mysql:host=$this->host;dbname=$this->db";

    $options = [
      PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
      $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
    } catch (\PDOException $e) {
      error_log($e->getMessage());

      throw new \PDOException("Error al conectar la BD", (int)$e->getCode());
    }
  }

  // Inserta una película en la tabla de favoritos
  public function insertFavorito($movieData)
  {
    try {
      // Verificar si el favorito ya existe

      $sql = "SELECT * FROM favoritos WHERE title_m = ? AND year_m = ? AND type_m = ? AND poster_m = ?";

      $stmt = $this->pdo->prepare($sql);

      $stmt->execute([$movieData["Title"], $movieData["Year"], $movieData["Type"], $movieData["Poster"]]);

      $existingFavorito = $stmt->fetch();

      if ($existingFavorito) {
        return 'El favorito ya existe';
      }

      // Insertar el favorito
      $sql = "INSERT INTO favoritos (id, title_m, year_m, type_m, poster_m) VALUES (NULL, ?, ?, ?, ?)";

      $stmt = $this->pdo->prepare($sql);

      $stmt->execute([$movieData["Title"], $movieData["Year"], $movieData["Type"], $movieData["Poster"]]);

      return 'Favorito insertado correctamente';
    } catch (\PDOException $e) {
      error_log($e->getMessage());
      throw new \PDOException("Error insertando los favoritos.", (int)$e->getCode());
    }
  }

  // Obtiene todas las películas de la tabla de favoritos
  public function getFavoritos()
  {
    try {
      $sql = "SELECT * FROM favoritos";

      $stmt = $this->pdo->prepare($sql);

      $stmt->execute();

      return $stmt->fetchAll();
    } catch (\PDOException $e) {
      error_log($e->getMessage());

      throw new \PDOException("Error obteniendo los favoritos", (int)$e->getCode());
    }
  }

  // Destructor: cierra la conexión a la base de datos
  public function __destruct()
  {
    // Cerrar la conexión a la base de datos
    $this->pdo = null;
  }
}
