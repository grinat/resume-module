Модуль резюме на базе Yii 2 Basic Project Template. PHP 7, PostgreSQL 10.0

### Установка

По идее достаточно просто скопировать папку modules/resume в любой сайт под yii2, затем подключить его, прописав в config/web.php и config/console.php
```
$config = [
    'bootstrap' => [
        ...
        'resume',
		...
    ],
    'modules' => [
	    ...
        'resume' => [
            'basePath' => '@app/modules/resume',
            'class' => 'app\modules\resume\Module'
        ],
        ....
    ],
];
```

Затем запустить миграцию:
~~~
php /var/www/html/yii migrate --migrationPath=@app/modules/resume/migrations
~~~

Модуль будет доступен по url: site/resume/resume/index либо site/index.php?r=resume%2Fresume%2Findex

### Запуск через докер

1. Перейти в /docker

2. Выполнить:
~~~
docker volume create --name=postgres-data-resume-web-service
~~~

3. Запустить
~~~
docker-compose up
~~~

4. Приложение будет на 3001 порту

5. Установить зависимости через composer и выполнить миграции:
~~~
docker exec -ti resume-web-service-php sh -c "cd /var/www/html && php /usr/bin/composer install"
docker exec -ti resume-web-service-php sh -c "php /var/www/html/yii migrate --interactive=0 --migrationPath=@app/modules/resume/migrations"
~~~
