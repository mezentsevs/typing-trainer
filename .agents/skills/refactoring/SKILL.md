---
name: refactoring
description: Restructures code without changing its behavior. Use when cleaning up code, removing duplication, reducing complexity, improving readability or performance, or optimizing backend and frontend code.
---

# Refactoring

## Workflow

1. Inspect - find one small refactoring candidate and explain what is wrong (duplication, long method, unclear name, leaky abstraction, avoidable performance cost). Do not run a broad audit or produce a list of candidates.
2. Propose - describe the intended change and why it is behavior-preserving. Stop and wait for explicit approval before editing anything.
3. Implement - make the smallest change that achieves the goal. One refactoring per run, no unrelated edits.
4. Verify - run the relevant tests and linters, then show the diff.

## Essential principles

- Never change external behavior or design.
- Ensure the affected path is covered by tests. If it is not, propose a manual verification plan and wait for confirmation before proceeding.
- Prefer small, independently reviewable steps over a broad rewrite.
- Apply clean architecture, clean code, SOLID, design patterns, DRY, KISS, YAGNI.
- Keep constants in dedicated constants modules (`app/Traits/Constants`, `resources/js/consts`); do not inline magic values.
- Follow the project's existing naming style for variables, methods, classes, and other identifiers.
- Do not add new code comments unless strictly necessary, and only after an explicit request and confirmation.

## Project-specific guardrails

- Prefer `tailwindcss` utilities for styling; avoid custom CSS unless a utility-based solution is impractical.
