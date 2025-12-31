# Typing trainer

## Note on Future Development

Please be aware that this application is in active development. The project is continuously evolving with planned fixes, improvements, and additional capabilities. Thank you for your understanding and support.

## About 'Typing trainer'

This is a typing trainer, written in and for educational and demonstrational purposes.

A full-stack SPA typing trainer for mastering touch-typing. It generates random lessons based on language and count. The final test sources text through multiple strategies: genre-based AI generation using cloud or local models, a seeded database, or user-uploaded files. Features include a virtual keyboard, real-time error highlighting, progress tracking, and detailed statistics.

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
- [Scribe](https://github.com/knuckleswtf/scribe).

## Key Features

### Adaptive Lesson Generation with Progressive Difficulty
Dynamically creates typing lessons tailored to each supported language, intelligently sequencing characters, alternating vowels and consonants, and using special characters in context. The system automatically adjusts lesson length and complexity based on user progress, ensuring an optimal learning curve from beginner to advanced levels.

### Intelligent Keyboard Visualization with Multi-Layout Support
Displays an on-screen keyboard with smart highlighting for the next key press, including necessary modifier keys. Supports multiple language layouts and visually distinguishes hand zones to build proper muscle memory and technique.

### Real-Time Interactive Typing Feedback & Performance Analytics
Provides live character-level validation with visual distinction between correct, incorrect, and upcoming text. Tracks real-time statistics including typing speed (WPM), error count, elapsed time, and completion percentage, with a dynamic progress bar.

### AI-Powered Content & Extensible Text Generation Strategies
Generates practice content using multiple strategies: AI models (local/cloud), database samples, or user-uploaded text. Built on a modular strategy pattern for seamless switching between sources based on availability and user preference.

### Comprehensive Multi-Language Support
Native support for multiple languages with dedicated character sets, frequency tables, and intelligent text normalization. The system's architecture ensures authentic typing experiences through proper encoding conversion and language-specific formatting rules.

### Structured Progress Tracking & Lesson Progression
Tracks detailed statistics for lessons and tests (WPM, errors, time). The built-in lesson system gradually introduces new characters while reinforcing learned keys, with a final test option for genre-based or custom text practice.

### Intuitive User Interface with Interactive Elements
Clean, responsive design with light/dark theme support, character-level error highlighting, word focus indication, smooth auto-scrolling, and a collapsible keyboard.

### Extensible & Maintainable Architecture
Features a clean separation of concerns using service providers, orchestrators, and strategy patterns. Modular design allows easy integration of new text sources, languages, or features while maintaining system stability.

### Secure User Authentication & Data Management
Full user authentication with registration/login and token-based API authorization. User progress is securely saved and managed via protected routes.

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

- Configure your AI model in .env (tested with LM Studio + qwen/qwen3-1.7b)

- Configure your custom AI text generation prompt template or delete it from .env for using default

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
<img width="1920" height="1200" alt="2025-07-31_18-46-38" src="https://github.com/user-attachments/assets/e9e09be3-a9bd-4820-aae5-f974341ef1b5" />
<img width="1920" height="1200" alt="2025-07-31_18-47-18" src="https://github.com/user-attachments/assets/65e49d0b-225a-41c0-900f-1d7d017a0f41" />
<img width="1920" height="1200" alt="2025-11-05_17-45-59" src="https://github.com/user-attachments/assets/f1fa992d-a7c8-4bfe-89b5-39910921dfb2" />
<img width="1920" height="1200" alt="2025-11-05_18-13-54" src="https://github.com/user-attachments/assets/2dfd411b-529a-4b0e-ba85-f2c911a6c3d4" />
<img width="1920" height="1200" alt="2025-07-31_18-50-33" src="https://github.com/user-attachments/assets/fba55df3-ade7-422f-bc4b-b18447e8aec6" />
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
<img width="1920" height="1200" alt="2025-07-31_19-26-42" src="https://github.com/user-attachments/assets/1576cf32-9352-4725-9f75-11de55088c8f" />
<img width="1920" height="1200" alt="2025-07-31_19-27-36" src="https://github.com/user-attachments/assets/2ffca5bd-2ff5-459d-890d-87f4331c60d8" />

## License

The 'Typing trainer' is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Third-Party Licenses
This project uses third-party software components. Their respective licenses can be found in the LICENSE-3rd-party.md file.
