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

2. Сменить путь в .env

3. Если windows, то выполнить:
~~~
docker volume create --name postgres-data-resume-web-service -d local
~~~
Если linux, то закомментировать/удалить все где указано # Для windows и расскоментировать Для linux

4. 
~~~
docker-compose up
~~~

5. Приложение будет на 3001 порту

6. Установить зависимости через composer


CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

**NOTES:**
- Yii won't create the database for you, this has to be done manually before you can access it.
- Check and edit the other files in the `config/` directory to customize your application as required.
- Refer to the README in the `tests` directory for information specific to basic application tests.