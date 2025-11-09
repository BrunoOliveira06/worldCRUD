<?php
// Este arquivo será chamado via AJAX para buscar dados de clima na API OpenWeatherMap

header('Content-Type: application/json');
$nome_cidade = $_GET['nome'] ?? '';

// ATENÇÃO: Você deve obter sua própria chave de API no site OpenWeatherMap e substituir o placeholder abaixo.
$api_key = "SUA_CHAVE_OPENWEATHERMAP_AQUI"; // <-- SUBSTITUA ESTE VALOR

if ($api_key == "SUA_CHAVE_OPENWEATHERMAP_AQUI") {
    echo json_encode(['erro' => 'Chave de API do OpenWeatherMap não configurada. Por favor, substitua "SUA_CHAVE_OPENWEATHERMAP_AQUI" no arquivo cidades/api_clima.php pela sua chave real.']);
    exit;
}

if (empty($nome_cidade)) {
    echo json_encode(['erro' => 'Nome da cidade não fornecido.']);
    exit;
}

// URL da API OpenWeatherMap para clima atual (usando 'pt_br' para idioma e 'metric' para Celsius)
$url = "http://api.openweathermap.org/data/2.5/weather?q=" . urlencode($nome_cidade) . "&appid=" . $api_key . "&units=metric&lang=pt_br";

// Inicializa a sessão cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$resposta = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code != 200) {
    $erro_msg = json_decode($resposta, true)['message'] ?? 'Erro desconhecido ao buscar clima.';
    echo json_encode(['erro' => 'Erro ao buscar clima: ' . $erro_msg . ' (Código HTTP: ' . $http_code . ')']);
    exit;
}

$dados = json_decode($resposta, true);

// Simplifica os dados para o que é relevante
$clima = [
    'temperatura' => $dados['main']['temp'] ?? 'N/A',
    'descricao' => $dados['weather'][0]['description'] ?? 'N/A',
    'minima' => $dados['main']['temp_min'] ?? 'N/A',
    'maxima' => $dados['main']['temp_max'] ?? 'N/A',
    'umidade' => $dados['main']['humidity'] ?? 'N/A',
    'vento' => $dados['wind']['speed'] ?? 'N/A',
];

echo json_encode($clima);
?>
