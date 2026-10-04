## 2026-10-04 - Eliminate multi-level correlated EXISTS subqueries in dashboard metrics

**Learning:** `whereHas('items.product', fn($q) => $q->where('shop_id', $shopId))` in Eloquent compiles into nested correlated double-`EXISTS` SQL subqueries (`EXISTS (SELECT * FROM order_items WHERE ... EXISTS (SELECT * FROM products WHERE ...))`). Executing this repeatedly across multiple metric calculations (total orders, pending orders, revenue, recent orders) creates redundant SQL overhead. Plucking shop product IDs once (`Product::where('shop_id', $shopId)->pluck('id')`) simplifies queries to single-level `whereIn` checks or avoids DB execution entirely if no products exist.

**Action:** Before writing multiple `whereHas('relation.nestedRelation')` aggregations in dashboard overview methods, pre-pluck the parent entity IDs and filter child models directly with `whereIn`.
