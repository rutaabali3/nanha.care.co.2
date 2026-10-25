## 2026-10-25 - Eloquent Aggregate Eager Loading vs Model Collection Loading

**Learning:** Loading full Eloquent relationship collections (e.g. `with('reviews')`) when views only need aggregate metrics (like average rating) bloats PHP memory usage. Using `withAvg('reviews', 'rating')` aggregates in SQL and attaches the `reviews_avg_rating` attribute directly to parent models. Also, double-check eager loading targets: eager loading `parent` when querying by `parent_id` is redundant and causes N+1 lazy-loads on `babysitter` when rendering parent view tables.

**Action:** Always use `withAvg`/`withCount`/`withSum` instead of `with()` for aggregations, and align `with()` relations with the model properties rendered in Blade views.
