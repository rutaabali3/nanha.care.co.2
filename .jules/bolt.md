## 2026-10-19 - Eloquent `hasManyThrough` Aggregations for Shop Ratings
**Learning:** Using `whereHas` for aggregating ratings across nested relationships creates subquery overhead (`WHERE EXISTS`). Utilizing direct `hasManyThrough` relationships allows Eloquent to generate a direct `JOIN` with `AVG()` aggregation.
**Action:** Always define `hasManyThrough` relationships on models when performing aggregates over secondary models.
