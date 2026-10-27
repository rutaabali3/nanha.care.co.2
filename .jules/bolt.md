## 2026-10-27 - Optimize Shop Owner Dashboard Queries
**Learning:** In Laravel Eloquent, using `whereHas` across nested 3-table relationships (`items.product.shop`) generates subqueries per metric query (`COUNT(*)`, `SUM()`, etc.). Pre-fetching primary keys (`$productIds`) for the owner's shop allows querying `order_items` directly with `whereIn('product_id', $productIds)` and combining review aggregations (`AVG` + `COUNT`) into a single query.
**Action:** Always check if a parent model's child IDs can be plucked once to simplify subsequent subqueries and aggregations on related models.
