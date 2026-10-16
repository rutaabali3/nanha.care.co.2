## 2026-10-16 - Optimize Babysitter Listing with SQL Average Aggregation
**Learning:** Eager loading full Eloquent models (e.g. `reviews`) across list views simply to display aggregate properties (like average rating) causes significant unnecessary memory allocation and model hydration overhead.
**Action:** Use Eloquent's `withAvg('relation', 'column')` or similar aggregate methods (`withCount`, `withSum`) to perform calculations directly in database queries instead of eager loading collections into memory.
