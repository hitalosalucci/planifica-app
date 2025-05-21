<?php
// Salve este arquivo em seu projeto e execute-o com: docker-compose exec app php db-connection-test.php

// Lê as variáveis de ambiente definidas no docker-compose
$host = getenv('DB_HOST') ?: 'db';
$port = getenv('DB_PORT') ?: 3306;
$database = getenv('DB_DATABASE') ?: 'planifica_app';
$username = getenv('DB_USERNAME') ?: 'planifica_user';
$password = getenv('DB_PASSWORD') ?: 'planifica_pass@$123';

echo "Testando conexão com o banco de dados...\n";
echo "Host: $host\n";
echo "Port: $port\n";
echo "Database: $database\n";
echo "Username: $username\n";

// Tenta resolver o hostname do DB para verificar conectividade de rede
echo "\nResolvendo hostname do banco de dados...\n";
$hostIp = gethostbyname($host);
echo "Hostname '$host' resolve para: $hostIp\n";

// Teste de rede básico
echo "\nVerificando se podemos alcançar o servidor de banco de dados...\n";
$socket = @fsockopen($host, $port, $errno, $errstr, 5);
if (!$socket) {
    echo "ERRO: Não foi possível conectar ao banco de dados: $errstr ($errno)\n";
} else {
    echo "Conexão de rede bem-sucedida!\n";
    fclose($socket);
}

// Tenta estabelecer conexão PDO com o banco
echo "\nTentando estabelecer conexão PDO...\n";
try {
    $dsn = "mysql:host=$host;port=$port;dbname=$database";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT => 5,
    ];
    
    $pdo = new PDO($dsn, $username, $password, $options);
    echo "Conexão PDO estabelecida com sucesso!\n";
    
    // Testar consulta simples
    $stmt = $pdo->query("SELECT version() as version");
    $result = $stmt->fetch();
    echo "Versão do banco de dados: " . $result['version'] . "\n";
    
    // Testar se a tabela migrations existe
    $stmt = $pdo->query("SELECT EXISTS (
        SELECT 1 FROM information_schema.tables 
        WHERE table_schema = DATABASE() 
        AND table_name = 'migrations'
    ) as table_exists");
    $result = $stmt->fetch();
    echo "Tabela migrations existe? " . ($result['table_exists'] ? "Sim" : "Não") . "\n";
    
} catch (PDOException $e) {
    echo "ERRO na conexão PDO: " . $e->getMessage() . "\n";
}

echo "\nTeste concluído!\n";