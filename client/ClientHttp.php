<?php
class ClientHttp
{
  private $endpoint = "http://www.omdbapi.com/";

  public function getMovieData($movieName)
  {
    $movieName = urlencode($movieName);
    $full_url = "$this->endpoint?apikey=4a3b711b&s=$movieName";

    // Inicializar cURL
    $ch = curl_init();

    // Configurar opciones de cURL
    curl_setopt($ch, CURLOPT_URL, $full_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Ejecutar la petición
    $result = curl_exec($ch);

    // Verificar si hubo un error
    if (curl_errno($ch)) {
      $error_msg = curl_error($ch);
      error_log($error_msg);
      throw new Exception("Error making the request. Please check the logs.");
    }

    // Cerrar cURL
    curl_close($ch);
    $ch = null;

    // Decodificar la respuesta JSON
    $data = json_decode($result, true);

    return $data;
  }
}
