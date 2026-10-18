## 2026-10-18 - Consolidate Multiple Aggregate Queries in Dashboard Overview
**Learning:** Dashboard metrics frequently perform individual Eloquent aggregate queries (`count()`, `sum()`, `avg()`) filtered across relationships (`whereHas`). Each call constructs and executes a separate `EXISTS (SELECT ...)` subquery against the database.
**Action:** Consolidate multiple aggregate queries on the same target table into a single SQL query using `selectRaw()` with conditional aggregates like `COUNT(*)`, `SUM(CASE WHEN ... THEN ... ELSE 0 END)`, and `COALESCE(AVG(...), 0)`.
