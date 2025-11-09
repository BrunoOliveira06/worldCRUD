<?php
// Este arquivo será chamado via AJAX para buscar detalhes de um país na API REST Countries

header('Content-Type: application/json');
$nome_pais = $_GET['nome'] ?? '';

if (empty($nome_pais)) {
    echo json_encode(['erro' => 'Nome do país não fornecido.']);
    exit;
}

// URL da API REST Countries para buscar pelo nome
$url = "https://restcountries.com/v3.1/name/" . urlencode($nome_pais) . "?fullText=true";

// Inicializa a sessão cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Necessário em alguns ambientes XAMPP
$resposta = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code != 200) {
    echo json_encode(['erro' => 'País não encontrado na API ou erro de conexão. Código HTTP: ' . $http_code]);
    exit;
}

$dados = json_decode($resposta, true);

if (empty($dados)) {
    echo json_encode(['erro' => 'Nenhum dado encontrado para o país.']);
    exit;
}

// Simplifica os dados para o que é relevante (o primeiro resultado)
$pais = $dados[0];

$detalhes = [
    'capital' => $pais['capital'][0] ?? 'N/A',
    'regiao' => $pais['region'] ?? 'N/A',
    'subregiao' => $pais['subregion'] ?? 'N/A',
    'bandeira_url' => $pais['flags']['svg'] ?? '',
    'moeda' => array_keys($pais['currencies'])[0] ?? 'N/A',
    'moeda_nome' => $pais['currencies'][array_keys($pais['currencies'])[0]]['name'] ?? 'N/A',
];

echo json_encode($detalhes);
?>
