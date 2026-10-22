## 2026-10-22 - Eager Loading Multi-Type Moderation Items
**Learning:** Moderation queue and published content listing queries fetched polymorphic/multi-type models without eager loading, resulting in N+1 database queries when views accessed related models (`shop.owner`, `doctor`, `user`).
**Action:** When querying moderation queue or list views across multiple entity types, conditionally apply `with('shop.owner')`, `with('doctor')`, or `with('user')` on query builders based on model class.
