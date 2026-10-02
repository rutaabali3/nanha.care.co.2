## 2026-10-02 - Combine Multiple Aggregates into Single Query

**Learning:** In Laravel/Eloquent dashboards, calling multiple aggregate methods (`count()`, `sum()`) separately on the same table causes multiple round-trips to the database. Using a single `selectRaw` with conditional SQL aggregations (`COUNT(CASE WHEN ... THEN 1 END)`) reduces query count from N to 1.
**Action:** When gathering dashboard stats from a single table, combine multiple `count()` and `sum()` queries into one `selectRaw` query.
