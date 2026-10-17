## 2026-10-17 - Optimize rating aggregations in list queries with withAvg
**Learning:** Eager loading full Eloquent relations (e.g. `reviews`) on paginated listing pages when only summary data (like average rating) is needed incurs significant memory and hydration overhead.
**Action:** Use Eloquent's `withAvg('relation', 'column')` to delegate calculations directly to SQL and access via a model accessor, avoiding model instantiation for nested collections in list queries.
