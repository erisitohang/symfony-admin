# Web App

### Clone this repo

```shell
$ git clone git@github.com:erisitohang/symfony-admin.git
$ cd symfony-admin
```

### Environment Configuration
```
$ cp .env.example .env
```

### Docker

```shell
$ docker-compose up -d --build
```

### Install Dependencies
```shell
$ docker exec -it po_php sh -c "composer install"
```

### Run Seeder
```shell
$ docker exec -it po_php sh -c "./bin/console doctrine:mongodb:fixtures:load"
```

### Run Seeder
```shell
$ docker exec -it po_php sh -c "./bin/console doctrine:mongodb:fixtures:load"
```

### Run Application
open http://0.0.0.0 from browser  
username: user@example.com  
password: password123


### Run Test
```shell
$ docker exec -it po_php sh -c "./bin/phpunit"
```
