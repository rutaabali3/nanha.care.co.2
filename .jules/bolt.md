## 2026-10-03 - Optimize Babysitter Listing with SQL Average Aggregation
**Learning:** Eager loading full Eloquent models for aggregate values (`with('reviews')` on list/search pages) wastes significant PHP memory and CPU cycles when instantiating model collections.
**Action:** Use `withAvg('reviews', 'rating')` to compute averages via single SQL subqueries and implement attribute accessors on Eloquent models to read from `$this->attributes['reviews_avg_rating']`.
