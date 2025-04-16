# Warning! This project written only for practice in vibe coding with AI. In progress now.

# Typing trainer

## About 'Typing trainer'

This is a typing trainer, written in and for educational and demonstrational purposes.

Based on tech stack:
- [Grok](https://grok.com/),
- [HTML](https://developer.mozilla.org/en-US/docs/Web/HTML),
- [PHP](https://www.php.net),
- [Laravel](https://laravel.com),
- [Sanctum](https://github.com/laravel/sanctum),
- [MySQL](https://www.mysql.com),
- [TypeScript](https://www.typescriptlang.org),
- [Vue](https://vuejs.org),
- [Vue Router](https://router.vuejs.org/),
- [Pinia](https://pinia.vuejs.org),
- [Axios](https://axios-http.com),
- [CSS](https://developer.mozilla.org/en-US/docs/Web/CSS),
- [TailwindCss](https://tailwindcss.com),
- [Docker](https://www.docker.com),
- [Sail](https://github.com/laravel/sail).

## Getting Started

- Clone the repository:
``` bash
git clone [repository-url]
```

- Change directory to project:
``` bash
cd /path/to/typing-trainer/
```

- Install php dependencies:
``` bash
composer install
```

- Create .env file:
``` bash
cp .env.example .env
```

- Generate application key:
``` bash
php artisan key:generate
```

- Run Docker Desktop (with wsl - for Windows only)

- Run wsl (for Windows only):
``` bash
wsl
```

- Run Sail:
``` bash
./vendor/bin/sail up
```

- Add new tab in terminal and connect to container:
``` bash
docker exec -it typing-trainer-laravel.test-1 bash
```

- Install php dependencies (optional, if missing some required php extension in base system):
``` bash
git config --global --add safe.directory /var/www/html
composer install
```

- Run migrations:
``` bash
php artisan migrate
```

- Install node dependencies:
``` bash
npm install
```

- Build project:
``` bash
npm run build
```

- In browser go to http://localhost/

- Register new user on http://localhost/register (enter your name, email, password)

- Or you can seed database with user (name: Test User, email: test@example.com, password: password):
``` bash
php artisan migrate:fresh --seed
```

- Login on http://localhost/login

That's it! Thank you!

## License

The 'Typing trainer' is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
