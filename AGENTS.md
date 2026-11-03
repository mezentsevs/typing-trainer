# Typing trainer

PHP (Laravel) + TypeScript (Vue) SPA that generates random touch-typing lessons
and retrieves final test texts from pluggable sources.

## Commands

- Dev environment: `./vendor/bin/sail up`
- Fresh DB with seed data: `php artisan migrate:fresh --seed`
- Backend tests: `php artisan test`
- Backend style check / fix: `composer code:lint` / `composer code:fix`
- Frontend style check / fix: `npm run code:lint` / `npm run code:fix`
- Frontend build: `npm run build`
- API docs: `composer openapi:generate`

## Boundaries

### Always

- Run the relevant tests and linters after code changes.

### Ask first

- Install, update, or remove dependencies (`composer`, `npm`).
- Edit config files other than `.env` and `.env.example` (`docker/`, `config/*`, etc.).
- Edit existing migrations.
- Run `php artisan migrate:fresh --seed`.
- Run any git command (commit, push, branch, etc.).

### Never

- Edit `.env` or `.env.example`.
- Commit or expose secrets, tokens, or credentials.
- Force-push or rewrite git history.

## Conventions

- Languages are defined twice on purpose: `app/Languages` (PHP) and
  `resources/js/languages` (TypeScript), each with its own `LanguageRegistry`.
  Update both sides in sync when adding or changing a language.
- Final test text sources are strategies tagged `testRetrieveStrategies`
  in `TestServiceProvider`; add a new source as a new strategy, not as
  branching inside the orchestrator.
- Style is enforced by `php-cs-fixer`, `eslint`, and `prettier` - follow the
  existing configs, do not reformat unrelated code.
- Prefer modern PHP and TypeScript features supported by the project setup
  over legacy patterns.
