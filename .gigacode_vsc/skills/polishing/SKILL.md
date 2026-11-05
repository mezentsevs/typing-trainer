---
name: polishing
description: Makes small, intentional improvements to behavior or design with explicit approval. Use when making small logic improvements across backend and frontend, refining design, or adjusting wording.
---

# Polishing

## Workflow

1. Inspect - find one small improvement candidate and explain what is wrong (minor logic weakness, inconsistent design, awkward wording). Do not run a broad audit or produce a list of candidates.
2. Propose - describe the intended change, what will look or behave differently, and the risk. Stop and wait for explicit approval before editing anything.
3. Implement - make the smallest change that achieves the goal. One improvement per run, no unrelated edits.
4. Verify - run the relevant tests and linters, applying automatic fixes with the project's fixers, then list the changed files and summarize the modifications.

## Essential principles

- Change external behavior or design only with explicit approval.
- Ensure the affected path is covered by tests. If behavior changes, update the tests accordingly and state how the change was verified. If the path is not covered, propose a manual verification plan and wait for confirmation before proceeding.
- Prefer small, independently reviewable steps over a broad rewrite.
- Apply clean architecture, clean code, SOLID, design patterns, DRY, KISS, YAGNI.
- Keep constants in dedicated constants modules (`app/Traits/Constants`, `resources/js/consts`); do not inline magic values.
- Follow the project's existing naming style for variables, methods, classes, and other identifiers.
- Do not add new code comments unless strictly necessary, and only after an explicit request and confirmation.

## Project-specific guardrails

- Prefer `tailwindcss` utilities for styling; avoid custom CSS unless a utility-based solution is impractical.
