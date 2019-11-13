# Arquivei - Desafio Bolton

## Table of contents
- [Getting started](#getting-started)
    * [References](#references)
    * [Clone Repository](#clone-repository)
    * [Map SSH Key](#map-ssh-key)
    * [Up Project](#up-project)
- [Documentation](#documentation)
    * [Allowed verbs](#allowed-verbs)
    * [Required in the header of all requests](#required-in-the-header-of-all-requests)
    * [Resources](#resources)
        * [With authentication](#with-authentication)
            * [nfe](#nfe)
            * [download](#download)

## Getting startd

### References
This application was made on the criteria of the [Bolton Challenge](https://public.3.basecamp.com/p/9wuA4g7RB79CBJkjvCzdKNFS)

Application endpoints are documented in [Swagger Documentation](http://127.0.0.1:8000/swagger/index.html)

This application uses the package [Arquivei Nfe](https://github.com/MedeirosDev/arquivei-nfe) (It's private)

### Clone Repository
Required ssh key in github. It's private 
```
git clone git@github.com:MedeirosDev/arquivei.git
```

### Map SSH Key
Change `docker-compose.yml` to map your private ssh key to volume docker `/root/.ssh/id_rsa`


### Up Project
Up Containers
```
docker-compose up -d --build
```

Update project dependencies
```
docker exec -it arquivei-app export COMPOSER_MEMORY_LIMIT=-1
docker exec -it arquivei-app composer update
```

copy .env.example to .env
```
docker exec -it arquivei-app cp .env.example .env
```


Clear cache
```
docker exec -it arquivei-app php artisan cache:clear && composer dumpautoload
```

Run Migrations with seeders
```
docker exec -it arquivei-app php artisan migrate:refresh --seed
```


## Documentation
### Allowed verbs
 `GET`

### Required in the header of all requests
Media type
```
Content-Type: application/json
Accept: application/json
```

Authorization
```
x-api-id: f96ae22f7c5d74fa4d78e764563d52811570588e
x-api-key: cc79ee9464257c9e1901703e04ac9f86b0f387c2
```

# Resources
## With authentication
### NFe
[GET /nfe/{access_key}](http://127.0.0.1:8000/nfe/{access_key}) - Returns NFe

Request headers
```
Content-Type: application/json
Accept: application/json
x-api-id: f96ae22f7c5d74fa4d78e764563d52811570588e
x-api-key: cc79ee9464257c9e1901703e04ac9f86b0f387c2
```

Request body
```json
{}
```

Response body
```json
{
    "id": 1,
    "access_key": "{access_key}",
    "amount": 365.89,
    "xml": "http://127.0.0.1:8000/api/nfe/{access_key}",
    "created_at": "2019-11-12 23:11:59",
    "updated_at": "2019-11-12 23:11:59"
}
```

### Download
[GET /download/{access_key}](http://127.0.0.1:8000/download/{access_key}) - Download xml of NFe

Request headers
```
Content-Type: application/json
Accept: application/json
x-api-id: f96ae22f7c5d74fa4d78e764563d52811570588e
x-api-key: cc79ee9464257c9e1901703e04ac9f86b0f387c2
```

Request body
```json
{}
```

Response Stream file xml named `{access_key}.xml`
