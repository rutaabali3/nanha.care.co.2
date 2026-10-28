## 2026-10-28 - Batch query aggregation for time series chart endpoints
**Learning:** Sequential queries in a loop over date ranges (e.g. 12 months) incur multiple database round-trips. Fetching the entire date range in a single query and grouping by month in memory reduces query count from 12 to 1 without vendor-specific SQL functions.
**Action:** When calculating monthly chart data or aggregates over fixed intervals, fetch all records with `created_at >= start_date` in one query and group in memory.
