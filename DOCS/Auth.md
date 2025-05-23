# Autenticação

### Formato
Personal token utilizando o Laravel Samctum

- O usuário solicita um token fornecendo credenciais válidas

- O servidor gera um token único associado ao usuário

- O cliente armazena este token e o envia em requisições subsequentes

- O servidor valida o token a cada requisição protegida

### Sobre o Laravel Snmctum
Sanctum é o pacote de autenticação leve do Laravel para APIs e SPAs (Single Page Applications). O sistema de Personal Access Tokens é uma das principais características do Sanctum, permitindo que usuários gerem tokens de acesso para autenticação em APIs.

### Como autenticar
-Acesso a documentação no Insomnia e vá em "auth", com o método POST, colocando suas credenciasi, ele retornará um "access_token" do tipo Bearer, adicione no Environment do Insominia e pronto, você já tem um token pronto para realizar as requisições na API 