## 2026-10-29 - Optimize Eloquent Subqueries on Shop Owner Dashboard
**Learning:** Calling multiple `whereHas('items.product', ...)` queries across different stats causes repeated `EXISTS` subquery evaluations across `orders`, `order_items`, and `products`. Pre-fetching product IDs with `Product::where('shop_id', $shopId)->pluck('id')` allows reusing `$productIds` in direct `whereIn` queries on `product_reviews` and `order_items`.
**Action:** Replace `whereHas` on nested relations with direct `whereIn` using pre-plucked target IDs when calculating aggregate dashboard metrics.
