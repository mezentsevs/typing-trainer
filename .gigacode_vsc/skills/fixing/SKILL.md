---
name: fixing
description: Fixes confirmed defects in behavior, design, or security. Use when something is clearly broken, harmful, or risky.
---

# Fixing

## Workflow

1. Inspect - find one defect candidate and explain what is clearly wrong (broken or blocked user actions, visual overlap, broken layout, crashes, unhandled errors, data exposure, security vulnerabilities, or anything else clearly harmful or risky). Only report defects that are obvious and indisputable. Do not run a broad audit or produce a list of candidates.
2. Propose - describe the current behavior, the expected behavior, how to verify the defect, the intended change, and the risk that the fix might affect other areas. Stop and wait for explicit approval before editing anything.
3. Implement - make the smallest change that achieves the goal. One fix per run, no unrelated edits.
4. Verify - run the relevant tests and linters, applying automatic fixes with the project's fixers, then list the changed files and summarize the modifications.

## Essential principles

- Change external behavior or design only with explicit approval.
- Ensure the affected path is covered by tests. Update or extend existing ones to match the fix. If the path is not covered, propose a manual verification plan and wait for confirmation before proceeding.
- Prefer small, independently reviewable steps over a broad rewrite.
- Apply clean architecture, clean code, SOLID, design patterns, DRY, KISS, YAGNI.
- Keep constants in dedicated constants modules (`app/Traits/Constants`, `resources/js/consts`); do not inline magic values.
- Follow the project's existing naming style for variables, methods, classes, and other identifiers.
- Do not add new code comments unless strictly necessary, and only after an explicit request and confirmation.

## Project-specific guardrails

- Prefer `tailwindcss` utilities for styling; avoid custom CSS unless a utility-based solution is impractical.
