# Encurtador URL

## Iniciando

```bash
$ https://github.com/DaviFreire/encurtador_url.git
$ cd encurtador_url
$ docker-compose up -d
```

Acompanhar a instalação das dependências do composer através do comando abaixo:

```bash
$ docker-compose logs -f app
```

## Rotas:

| POST   | localhost/api/registrar  - Cria novo usuário


Ex. parâmetros:


    {
        "email": "davi.freire@email.com.br",
        "password": "123456"
    }

| POST   | localhost/api/login - Faz login e gera um token JWT


Ex. parâmetros:


    {
        "email": "davi.freire@email.com.br",
        "password": "123456"
    }

É necessário passar o token de login para as rotas abaixo:
| POST   | localhost/api/url/encurtar  


Ex. parâmetros:


    {
        "url": "https://www.uol.com.br/"
    }

| GET    | localhost/api/url/info 


Ex. parâmetros:


    {
        "url": "localhost/123"
    }

| GET    | localhost/api/url/user/{id}  



