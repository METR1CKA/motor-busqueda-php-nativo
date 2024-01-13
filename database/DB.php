<?php
class DB
{
  private $host = 'localhost';
  private $db   = 'db_evidence_technology';
  private $user = 'root';
  private $pass = '';
  private $pdo;

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

      throw new \PDOException("Error connecting to the database. Please check the logs.", (int)$e->getCode());
    }
  }

  public function insertFavorito($movieData)
  {
    $sql = "INSERT INTO favoritos (Title, Year, Type, Poster) VALUES (?, ?, ?, ?)";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute([$movieData["Title"], $movieData["Year"], $movieData["Type"], $movieData["Poster"]]);

    return $this->pdo->lastInsertId();
  }

  public function getFavoritos()
  {
    $sql = "SELECT * FROM favoritos";

    $stmt = $this->pdo->prepare($sql);

    $stmt->execute();

    $favoritos = $stmt->fetchAll();

    return $favoritos;
  }

  public function __destruct()
  {
    // Cerrar la conexión a la base de datos
    $this->pdo = null;
  }
}
