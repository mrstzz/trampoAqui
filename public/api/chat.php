<?php
// public/api/chat.php
header('Content-Type: application/json');

// --- 1. Configuração e Carregamento do Ambiente ---
$diretorio = __DIR__ . '/../../';

// Carrega o autoload (o @ suprime warnings caso o arquivo não exista)
if (!@include_once $diretorio . 'vendor/autoload.php') {
    http_response_code(500); // Internal Server Error
    echo json_encode(['reply' => 'Erro interno do servidor.']);
    exit;
}

// Carrega as variáveis de ambiente (.env)
try {
    $dotenv = Dotenv\Dotenv::createUnsafeMutable($diretorio);
    $dotenv->load();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['reply' => 'Erro interno do servidor.']);
    exit;
}

// Pega a API Key
$apiKey = $_ENV['GEMINI_API_KEY'] ?? $_SERVER['GEMINI_API_KEY'] ?? null;

if (empty($apiKey)) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['reply' => 'Erro de configuração do servidor.']);
    exit;
}

// --- 2. Processamento da Requisição do Usuário ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Método não permitido']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$userMessage = $input['message'] ?? '';

if (empty($userMessage)) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Mensagem vazia']);
    exit;
}

// --- 3. Prompt (Persona do BOT) ---
$systemInstruction = "Você é o assistente virtual do site 'TrampoAqui'.
Sua função é ajudar usuários a encontrar profissionais (limpeza, reformas, aulas, TI, saúde),
entender como funciona a plataforma, a gamificação, recompensas e como entrar em contato.
O site conecta clientes a prestadores de serviços.
Para um usuario achar qualquer categoria, ele tem a aba de pesquisa do próprio site, 
aba de categorias onde ele pode filtrar e também um feed que atualiza os anuncios recentes.
Para um usuario se cadastrar/virar prestador tem uma aba no topo.
Para entrar em contato com algum prestador/comerciante o cliente precisa contratar o serviço,
com isso aparecerá alguns campos como o whatsapp do cliente e/ou abrir um chat entre os dois (essa função está em desenvolvimente,
explique pro usuario que talvez no momento dessa mensagem ainda não esteja complementamente funcionando).
* ** não precisa colocar isso sobre um topico de resposta.  
REGRAS RÍGIDAS:
1. Você NÃO responde sobre assuntos gerais (notícias, receitas, política, esportes, código de programação que não seja relacionado à API do site, etc).
2. Se o usuário perguntar algo fora do escopo, responda educadamente: 'Desculpe, sou apenas o assistente do TrampoAqui e só posso responder sobre nossos serviços e funcionamento.'
3. Seja conciso e prestativo, mas pode ser descontraido.
4. Não dê informações confidencias ou algo que possa comprometer a integridade";

// --- 4. Montagem e Envio para a API Gemini ---
$data = [
    "contents" => [
        [
            "role" => "user",
            "parts" => [
                ["text" => $systemInstruction . "\n\nPergunta do usuário: " . $userMessage]
            ]
        ]
    ],
    "generationConfig" => [
        "temperature" => 0.2,
        "maxOutputTokens" => 500
    ]
];

// url
$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $apiKey;


// setando curl 
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Manter para ambiente local (XAMPP/WAMP)

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    curl_close($ch);
    http_response_code(503); // Service Unavailable
    echo json_encode(['reply' => 'Desculpe, o serviço de IA está indisponível no momento. Tente mais tarde.']);
    exit;
}
curl_close($ch);

// --- 5. Tratamento da Resposta ---
$geminiData = json_decode($response, true);

if ($httpCode !== 200) {
    http_response_code($httpCode);
    echo json_encode(['reply' => 'Ocorreu um erro ao processar sua solicitação pela IA.']);
    exit;
}

$botReply = $geminiData['candidates'][0]['content']['parts'][0]['text'] ?? null;

if ($botReply) {
    echo json_encode(['reply' => $botReply]);
} else {
    // A requisição foi OK (200), mas não gerou conteúdo, pode ser block ou url errada
    echo json_encode(['reply' => 'Desculpe, não consegui gerar uma resposta para isso. Tente reformular.']);
}
?>