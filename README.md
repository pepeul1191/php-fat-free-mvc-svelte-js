# Fat Free PHP Framework MVC + SvelteJS

Instalar dependencias:

    $ composer install
    $ npm install

Scripts

    $ php -S localhost:8080
    $ npm run dev

### Migraciones

Migraciones con DBMATE - accesos/sqlite3:

    $ dbmate -d "db/migrations/sqlite3" -e "DB" new <<nombre_de_migracion>>
    $ dbmate -d "db/migrations/sqlite3" -e "DB" up
    $ dbmate -d "db/migrations/sqlite3" -e "DB" rollback

### Github

    $ git push origin access:access

---

Fuentes:

+ https://fatfreeframework.com/3.7/getting-started
+ https://github.com/f3-factory/f3-cms/blob/main/app/routes.ini
+ https://fatfreeframework.com/3.7/quick-reference
+ https://stackoverflow.com/questions/40510806/php-return-data-from-anonymous-in-file
