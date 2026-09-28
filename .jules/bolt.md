## 2026-07-09 - Aggregate Relationship Calculation using withAvg

**Learning:** Loading full Eloquent relationship collections (e.g. `with('reviews')`) on paginated or list endpoints just to compute scalar values like `avg('rating')` introduces heavy model hydration overhead and high memory usage. Using Eloquent's `withAvg('relation', 'column')` calculates the aggregate at database query time, producing `reviews_avg_rating` directly on the model.

**Action:** Whenever displaying aggregate metrics (average rating, count, sum) on list views, use `withAvg`, `withCount`, or `withSum` instead of eager-loading full relationship models.
