Planifica App - Gestão organizada de evento

### Passo a passo
-Criar arquivo .env com base no .env.exemple

~ cp .env.exemple .env 

### Defina as variáveis ambiente de acordo com seu ambiente
-----

#### IMPORTANTE: Caso já tenha subido o container e depois modificado as variáveis de ambiente que afetam outros containers, como dados do db, por exemplo será necessário recriar os volumes persistentes, com isso ele recriará o banco de dados com as variáveis corretas

~ docker-compose down -v --remove-orphans
~ docker-compose up -d --build

### Iniciar os containers Docker

~ docker-compose up -d

### Acesse o container da aplicação (serviço "app") e estando nele, rode os comandos abaixo (Essa configuração só será necessária uma vez, ao rodar o projeto pela primeira vez)

~ docker-compose exec app sh

~ docker-compose exec app php artisan key:generate #Caso não tenha gerado a key anteriormente
~ docker-compose exec app php artisan migrate #Para rodar as migrações do banco de dados

<!-- ### Configure o ambiente laravel

~ docker-compose run --rm artisan key:generate

### Rode as migrations para criação das tabelas e banco de dados
~ docker-compose run --rm artisan migrate -->

### Instalar os pacotes npm para rodar o frontend(Caso ainda não tenha sido instalados)
~ npm i

### Iniciar os servidores de desenvolvimento
~ npm run dev

### Para monitorar os logs dos serviços docker, utilize os comandos abaixo

# Logs do PHP-FPM
~ docker logs -f planifica-app

# Logs do Nginx
~ docker logs -f nginx-server

# Logs do Vite
~ docker logs -f planifica-vite

### Para ambiente de produção, rodar o build:
~ docker compose run --rm npm run build  # gera o diretório public/build/...

----------------

### Explicação de como a integração do Laravel + Vue através do vite funciona
# Porta 8000 (Laravel + Nginx)
O que roda: Aplicação Laravel (backend)

Como acessar: http://localhost:8000

Contém:

-Rotas da API (se configuradas)
-Assets compilados pelo Vite


# Porta 5173 (Vite Dev Server - HMR)
O que roda: Frontend (Vue + Quasar) com Hot Module Replacement

Como acessar: http://localhost:5173

Contém:

-Compilação em tempo real dos arquivos Vue/JS
-Injeção automática de mudanças no navegador (HMR)

# Modo Produção (npm run build):

-Os assets são compilados para /public/build
-Laravel serve tudo na porta 8000
-Não há comunicação com a porta 5173
-O comportamento não é SPA puro, o Laravel continua sendo um backend MVC tradicional e as views Blade irão carregar componentes Vue compilados e as Rotas para API REST que fazemos no "frontend" da aplicação funcionaria normalmente.

### Sugestão de melhorias futuras

-Implementação de Interfaces para a estrutura com o Pattern de Repository e Services.

-Adição de uma classe que implementa automaticamente nas migrações futuras os parâmetros do moodelo base, herdados da classe de modelo base (BaseModel)

-Separar em dois repositórios ou projetos, um para o frontend e outro para o backend. É possível separar facilmente o projeto em um repositório "frontend", mantendo a estrutura de API do Laravel => Nesse cenário teríamos um SPA puro, poderíamos separar equipes de desenvolvimento 

-Implmentação do i18n para preparar o sistema para multi linguagens- Escolhido pela não implementação inicial por conta do nível de "complexidade" adicionada no frontend sem necessidade inicial, mas facilmente podemos adicionar no futuro

-Implementação de testes mais completos e ter uma cobertura mair, implementar também testes e2e(Com Cypress ou outra ferramenta) e testes de integração
