## 2026-10-24 - Optimize Correlated Eloquent whereHas in Dashboard Aggregations

**Learning:** Replacing nested Eloquent `whereHas` subqueries across multiple relations (`orders` -> `order_items` -> `products`) with non-correlated subqueries via `whereIn` (`Order::whereIn('id', OrderItem::whereIn('product_id', Product::where('shop_id', $shopId)->select('id'))->select('order_id'))`) dramatically speeds up database aggregations and eliminates correlated `EXISTS` subqueries without loading large ID arrays into PHP memory.

**Action:** Prefer non-correlated subquery builders (`select('id')` with `whereIn`) over nested `whereHas` when aggregating relational metrics in dashboard counters.
