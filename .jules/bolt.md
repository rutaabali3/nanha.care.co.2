## 2026-09-30 - Prevent N+1 Fallbacks with Eloquent `withAvg()` and `array_key_exists()`

**Learning:** When using Eloquent's `withAvg('relation', 'column')`, SQL returns `NULL` for entities with 0 related records. Checking `$this->attributes['relation_avg_column'] ?? null` causes `null` checks to fail on 0-review entities and fallback to `$this->relation()->avg()`, triggering an N+1 query for every zero-review entity.
**Action:** Always use `array_key_exists('relation_avg_column', $this->attributes)` in model accessors to verify if the aggregate attribute was selected by Eloquent before falling back to lazy queries.
