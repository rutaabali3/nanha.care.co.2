# Bolt's Journal - Critical Learnings

This file tracks critical performance learnings and codebase insights for Bolt.

## 2026-10-12 - Optimize Eloquent relationship aggregations with withAvg / withCount
**Learning:** Eager loading full Eloquent models (`with('reviews')`) when only aggregate values (like average rating) are rendered in views causes severe memory inflation and model hydration overhead across paginated lists. Furthermore, checking `!== null` on Eloquent `withAvg` results can cause accidental fallback N+1 queries when aggregate values are `null` (e.g., 0 reviews).
**Action:** Use `withAvg('relation', 'column')` or `withCount('relation')` instead of `with('relation')`, and ensure accessors check `array_key_exists('relation_avg_column', $this->attributes)` with null-coalescing (`?? 0`) to prevent N+1 queries for unreviewed/empty records.
