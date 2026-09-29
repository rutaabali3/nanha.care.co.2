## 2026-09-29 - Aggregate Aggregations with Eloquent withAvg Over Full Model Eager Loading

**Learning:** When listing models (e.g. `BabysitterProfile`) that display summary aggregates like average review rating in UI card components, eager-loading the full relationship (`with('reviews')`) instantiates every review record and hydration overhead in memory for all paginated items. Using Eloquent's `withAvg('reviews', 'rating')` delegates aggregate calculation directly to the database query (`AVG(rating)` subselect / join) and populates `$model->reviews_avg_rating` without inflating memory or fetching redundant review fields.

**Action:** Prefer `withAvg()`, `withCount()`, or `withSum()` over `with('relation')` when relation models themselves are not rendered in the view or list component.
