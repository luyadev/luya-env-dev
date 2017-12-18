# Dev Environment

1. Create project into your workspace `composer create-project luya/luya-env-dev`
2. Run init command `./envdev env/init`
2. Rename `env.php.dist` to `env.php` and modify your *Database connection component* to match your local env settings.
3. Execute commands `./luya migrate`, `./luya import`, `./luya admin/setup`.
4. Access `public_html` on your webserver.

## Find more infos

+ [Installation instructions](https://luya.io/guide/install)
+ [API Documentation](https://luya.io/api)
+ [Collaboration Guide](https://luya.io/guide/luya-collaboration)
+ [Questions & Issues](https://github.com/zephir/luya/issues)