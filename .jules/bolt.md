## 2026-10-14 - Batch Cache Invalidation for Broadcast Notifications
**Learning:** Calling `Cache::forget()` in a loop for $N$ users issues $2 \times N$ separate cache driver store operations. Using `Cache::deleteMultiple()` allows invalidating all user notification caches in a single operation while evaluating timestamps once outside the loop.
**Action:** When broadcasting messages or performing bulk state changes across multiple users, collect cache keys and invalidate them using `Cache::deleteMultiple($keys)`.
