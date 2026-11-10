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

<img width="1920" height="1200" alt="2026-11-10_11-34-26" src="https://github.com/user-attachments/assets/4a8587e1-370f-432b-a433-03c1f581ac9e" />
<img width="1920" height="1200" alt="2026-11-10_11-35-57" src="https://github.com/user-attachments/assets/5a3ef3df-da21-47e0-9e9b-ded172116bcf" />
<img width="1920" height="1200" alt="2026-11-10_11-37-51" src="https://github.com/user-attachments/assets/6a15ac59-6e5a-425d-b087-5920b4b5a5cd" />
<img width="1920" height="1200" alt="2026-11-10_11-39-57" src="https://github.com/user-attachments/assets/3fc0ee45-0595-48e7-810f-cfa43bc332bb" />
<img width="1920" height="1200" alt="2026-11-10_11-44-52" src="https://github.com/user-attachments/assets/1f377ca5-4e50-4461-a4da-c6c57003810b" />
<img width="1920" height="1200" alt="2026-11-10_11-47-11" src="https://github.com/user-attachments/assets/2aeaab11-f839-4792-912c-959b929a21af" />
<img width="1920" height="1200" alt="2026-11-10_11-51-32" src="https://github.com/user-attachments/assets/6b1feda7-564d-412b-a3cc-0db15eb08e09" />
<img width="1920" height="1200" alt="2026-11-10_11-52-57" src="https://github.com/user-attachments/assets/bf51ba94-a89d-4d23-9f73-d78ca940723d" />
<img width="1920" height="1200" alt="2026-11-10_11-55-03" src="https://github.com/user-attachments/assets/fbb8d5be-0d06-41ce-9e95-37ccbd26bde2" />
<img width="1920" height="1200" alt="2026-11-10_11-56-02" src="https://github.com/user-attachments/assets/44fce6d6-321d-46ea-ae37-5cd2431d0015" />
<img width="1920" height="1200" alt="2026-11-10_12-19-06" src="https://github.com/user-attachments/assets/6c94c681-d2ee-44b1-9884-d9e607ba7f94" />
<img width="1920" height="1200" alt="2026-11-10_12-19-58" src="https://github.com/user-attachments/assets/fa6d8396-ea8d-4d5f-baee-6d5d918874cc" />
<img width="1920" height="1200" alt="2026-11-10_12-21-53" src="https://github.com/user-attachments/assets/4c03f4a9-b9fd-443d-b610-652fe5c7d6ea" />
<img width="1920" height="1200" alt="2026-11-10_12-22-25" src="https://github.com/user-attachments/assets/54ecba02-228e-4d4d-b60e-4ae7657d0525" />
<img width="1920" height="1200" alt="2026-11-10_12-29-08" src="https://github.com/user-attachments/assets/3fce6c1c-9384-4f98-8937-1638f0ebfe41" />
<img width="1920" height="1200" alt="2026-11-10_12-29-47" src="https://github.com/user-attachments/assets/63afa0c1-f388-4e9f-95d7-634dbb7ed99e" />
<img width="1920" height="1200" alt="2026-11-10_12-34-27" src="https://github.com/user-attachments/assets/d87b43e7-d5f4-4365-a220-3315f68d20b8" />
<img width="1920" height="1200" alt="2026-11-10_12-35-19" src="https://github.com/user-attachments/assets/501530e6-8387-4bca-84c8-5c806cc0f668" />
<img width="1920" height="1200" alt="2026-11-10_12-44-03" src="https://github.com/user-attachments/assets/35c15005-fe69-409d-82d1-7d038b39093e" />
<img width="1920" height="1200" alt="2026-11-10_12-44-41" src="https://github.com/user-attachments/assets/05ee86b8-5ccc-42b4-a322-020d18dc0d5a" />
<img width="1920" height="1200" alt="2026-11-10_12-47-05" src="https://github.com/user-attachments/assets/49423e5d-690b-440a-a7cf-5a3473d7d181" />
<img width="1920" height="1200" alt="2026-11-10_12-47-45" src="https://github.com/user-attachments/assets/fd964729-fb76-42a6-a3eb-a6ebc594bf25" />
<img width="1920" height="1200" alt="2026-11-10_12-50-54" src="https://github.com/user-attachments/assets/08a99da5-83af-4346-a68a-b3aafcf9a83a" />
<img width="1920" height="1200" alt="2026-11-10_12-51-29" src="https://github.com/user-attachments/assets/574b9f6e-bd55-44f1-bd2d-525cd02f93f9" />
<img width="1920" height="1200" alt="2026-11-10_13-16-57" src="https://github.com/user-attachments/assets/1a0f94f1-a1a2-4d52-af76-b312d3667edc" />
<img width="1920" height="1200" alt="2026-11-10_13-20-03" src="https://github.com/user-attachments/assets/765a4a0c-7086-43a1-9957-4bde25ad092b" />

## ⭐ If You Found This Useful

If this project helped you - whether it saved you time, taught you something, or gave you an idea - please consider leaving a star or a like.
A ⭐, 👍, ❤️, or 💎 tells me that the work matters. It's a small gesture that genuinely fuels my motivation to keep improving the project and building new tools.

Thanks for your interest in this project!

## License

The 'Typing trainer' is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Third-Party Licenses
This project uses third-party software components. Their respective licenses can be found in the LICENSE-3rd-party.md file.
