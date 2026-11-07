---
name: testing
description: Writes tests that follow the project's existing patterns. Use when adding test coverage for new or untested behavior across backend and frontend.
---

# Testing

## Workflow

1. Inspect - find the closest existing test for the area and treat it as the reference candidate. Study its structure, naming, and assertions. If none exists for this area, use the nearest existing pattern and state which one you are following. Do not run a broad audit or produce a list of candidates.
2. Propose - describe the test cases to add, what each one covers, and which existing pattern it follows. Stop and wait for explicit approval before editing anything.
3. Implement - add the smallest set of tests that covers the behavior. One area per run, no unrelated edits.
4. Verify - run the relevant tests and linters, applying automatic fixes with the project's fixers, then list the changed files and summarize the modifications.

## Essential principles

- Never change external behavior or design. If new tests fail, report the defect instead of changing application code.
- Follow the closest existing test's structure, naming, and assertions.
- Keep the same structural principles across backend and frontend tests, differing only in stack-specific details.
- Prefer small, independently reviewable steps over a broad rewrite.
- Write one scenario per test. Keep positive and negative cases separate.
- Ensure the new tests cover the behavior and pass.
- Apply clean architecture, clean code, SOLID, design patterns, DRY, KISS, YAGNI.
- Keep test constants in dedicated test constants modules (currently `tests/Traits/Constants`) and reuse shared constants (`app/Traits/Constants`, `resources/js/consts`); do not inline magic values.
- Follow the project's existing naming style for variables, methods, classes, and other identifiers.
- Do not add new code comments unless strictly necessary, and only after an explicit request and confirmation.

## Project-specific guardrails

- Tests live in `tests/Feature/Api`, `tests/Unit`, and `tests/cypress/e2e`; look there for the closest pattern.
