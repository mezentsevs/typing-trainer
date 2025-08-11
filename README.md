# Typing trainer

## About 'Typing trainer'

This is a typing trainer, written in and for educational and demonstrational purposes.

Based on tech stack:
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
- [Sail](https://github.com/laravel/sail),
- [Swagger](https://swagger.io),
- [Scribe](https://github.com/knuckleswtf/scribe).

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

- Or you can seed database with user (name: Test User, email: test@example.com, password: password) and default texts for final tests:
``` bash
php artisan migrate:fresh --seed
```

- Login on http://localhost/login

That's it! Thank you!

## Screenshots

<img width="1920" height="1200" alt="2025-07-31_23-19-20" src="https://github.com/user-attachments/assets/19435f93-a587-4b3d-b31b-fff4f4451dc0" />
<img width="1920" height="1200" alt="2025-07-31_23-19-42" src="https://github.com/user-attachments/assets/32846788-81f2-4ec4-8b22-7d2ab4b356fc" />
<img width="1916" height="1200" alt="2025-07-31_18-46-38" src="https://github.com/user-attachments/assets/e9e09be3-a9bd-4820-aae5-f974341ef1b5" />
<img width="1920" height="1200" alt="2025-07-31_18-47-18" src="https://github.com/user-attachments/assets/65e49d0b-225a-41c0-900f-1d7d017a0f41" />
<img width="1916" height="1200" alt="2025-07-31_18-48-36" src="https://github.com/user-attachments/assets/df468edc-b97a-4c7f-ada6-23ea690c462e" />
<img width="1920" height="1200" alt="2025-07-31_18-49-15" src="https://github.com/user-attachments/assets/c366f0d7-9f8f-4618-9dfb-4d5e527ef079" />
<img width="1916" height="1200" alt="2025-07-31_18-50-33" src="https://github.com/user-attachments/assets/fba55df3-ade7-422f-bc4b-b18447e8aec6" />
<img width="1920" height="1200" alt="2025-07-31_18-51-37" src="https://github.com/user-attachments/assets/aeaf9dcf-7ae2-431f-999b-99695a24cb1f" />
<img width="1920" height="1200" alt="2025-07-31_23-47-00" src="https://github.com/user-attachments/assets/a5005c84-01b0-4d30-970c-9f07c7775265" />
<img width="1920" height="1200" alt="2025-07-31_23-47-16" src="https://github.com/user-attachments/assets/ca65be62-0358-45f8-907b-54ceabeaac39" />
<img width="1920" height="1200" alt="2025-07-31_23-49-14" src="https://github.com/user-attachments/assets/0f66630f-c602-4423-9e88-5fd9f61ab46a" />
<img width="1920" height="1200" alt="2025-07-31_23-49-44" src="https://github.com/user-attachments/assets/dcd20e80-30d1-498d-a945-2187db9a493e" />
<img width="1920" height="1200" alt="2025-07-31_19-06-21" src="https://github.com/user-attachments/assets/47c60fcb-7ffa-46c4-a0a3-fa51832094df" />
<img width="1920" height="1200" alt="2025-07-31_19-06-53" src="https://github.com/user-attachments/assets/b0f60857-2ecc-4fcb-933e-de267c7686c8" />
<img width="1920" height="1200" alt="2025-07-31_19-08-42" src="https://github.com/user-attachments/assets/a55574b2-4ed2-4b70-a224-229ee48f0e47" />
<img width="1920" height="1200" alt="2025-07-31_19-09-09" src="https://github.com/user-attachments/assets/8e265fb5-0ba8-4af1-ad36-21410510cdd9" />
<img width="1920" height="1200" alt="2025-07-31_19-09-31" src="https://github.com/user-attachments/assets/6b354838-29fc-4304-b6b6-4ad334f57452" />
<img width="1920" height="1200" alt="2025-07-31_19-09-53" src="https://github.com/user-attachments/assets/128d16fb-a473-41d1-ab7c-aeb0fced5206" />
<img width="1920" height="1200" alt="2025-07-31_23-55-56" src="https://github.com/user-attachments/assets/6820f531-8ab9-451e-b3ad-4800bf8aa1fc" />
<img width="1920" height="1200" alt="2025-07-31_23-56-21" src="https://github.com/user-attachments/assets/7f91c035-e18a-4aeb-ae55-7d06dcf2f0d0" />
<img width="1916" height="1200" alt="2025-07-31_19-26-42" src="https://github.com/user-attachments/assets/1576cf32-9352-4725-9f75-11de55088c8f" />
<img width="1920" height="1200" alt="2025-07-31_19-27-36" src="https://github.com/user-attachments/assets/2ffca5bd-2ff5-459d-890d-87f4331c60d8" />

## License

The 'Typing trainer' is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
