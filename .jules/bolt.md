## 2026-10-11 - Use `withAvg` for aggregations in Eloquent queries
**Learning:** Using `with('reviews')` on paginated lists eager-loads all review models into memory, leading to unnecessary hydration overhead when only the average rating is displayed on list cards.
**Action:** Use `withAvg('reviews', 'rating')` to compute aggregated values directly in SQL for query efficiency and lower memory usage.
