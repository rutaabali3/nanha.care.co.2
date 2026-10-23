## 2026-10-23 - Database-level rating aggregation with withAvg()
**Learning:** Loading full relationship collections (like `reviews`) into memory in list queries just to compute an average rating causes unnecessary model hydration and memory bloat. Eloquent's `withAvg('reviews', 'rating')` performs the calculation directly in SQL and sets `reviews_avg_rating` on the model.
**Action:** Always prefer `withAvg()` or `withCount()` over `with('relation')` on listing/card views when relation model details are not directly rendered in the view.
