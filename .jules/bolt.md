## 2026-10-20 - Aggregate monthly chart data queries into single SQL query
**Learning:** `chartData` controller methods that iterated through 12 months running individual DB aggregate queries were causing 12 SQL roundtrips per endpoint request. Grouping by month string (`strftime('%Y-%m', date)` in SQLite or `DATE_FORMAT(date, '%Y-%m')` in MySQL) reduces database query count from 12 to 1 per request.
**Action:** Always prefer `selectRaw` with SQL month date formatting and `groupBy('month_key')` for multi-month time-series chart endpoints.
