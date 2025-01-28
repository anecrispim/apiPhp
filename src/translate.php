<?php
// Tradução usando WebView ou integração com Google Translate
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text = $_POST['text'];
    $source = $_POST['source'] ?? 'en';
    $target = $_POST['target'] ?? 'pt';

    // URL do Google Translate (usando scraping ou WebView)
    $url = "https://translate.google.com/m?hl=$target&sl=$source&q=" . urlencode($text);

    // Faz a requisição HTTP para o Google Translate
    $response = file_get_contents($url);

    // Extração do texto traduzido usando regex ou DOMDocument
    if (preg_match('/<div[^>]*class="result-container"[^>]*>(.*?)<\/div>/', $response, $matches)) {
        $translatedText = $matches[1];
        echo json_encode([
            'success' => true,
            'translatedText' => $translatedText,
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Erro ao traduzir o texto.',
        ]);
    }
}
