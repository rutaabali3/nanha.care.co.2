## 2026-10-13 - Database-Level Query Filtering vs. In-Memory Paginator Filtering

**Learning:** Calling Laravel collection methods (e.g., `$orders->where('status', $status)`) on a `LengthAwarePaginator` instance filters only the records retrieved on the current page instead of querying the database. This leads to incorrect pagination counts, incomplete filter results across pages, and unneeded database row fetching.
**Action:** Always apply filter conditions (`where`, `whereDate`) directly to the QueryBuilder in the repository/service layer before executing `paginate()`.
