## 2026-10-07 - Avoid full collection eager loading when only aggregate values are needed

**Learning:** `BabysitterService::getAll()` was eager loading all `reviews` models (`with('reviews')`) across listing pagination. Hydrating all review Eloquent models into PHP memory caused high overhead and payload size without even exposing average ratings.
**Action:** Use Eloquent's `withAvg('relation', 'column')` or `withCount('relation')` to compute aggregate metrics directly in database SQL and avoid hydrating unused model collections.
