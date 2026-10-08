## 2026-10-08 - Batching Monthly Analytics Queries Over Ranges

**Learning:** Loop-based monthly reporting queries using `whereYear` / `whereMonth` in Eloquent execute multiple redundant SQL queries with repeated subqueries (`whereHas`). Batching the date range with `whereBetween` and eager-loading relation dates allows grouping in memory, reducing N database roundtrips to 1 without heavy database-specific `GROUP BY` SQL expressions.

**Action:** When calculating monthly metrics for charts, fetch the date window in a single query using `whereBetween` and group by formatted date string in collection memory.
