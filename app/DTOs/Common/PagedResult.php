<?php

namespace App\DTOs\Common;

use Illuminate\Pagination\LengthAwarePaginator;

readonly class PagedResult
{
    public function __construct(
        public array $data,
        public int $total,
        public int $per_page,
        public int $current_page,
        public int $last_page,
        public bool $has_more,
    ) {}

    public static function fromPaginator(LengthAwarePaginator $paginator): self
    {
        return new self(
            data: $paginator->items(),
            total: $paginator->total(),
            per_page: $paginator->perPage(),
            current_page: $paginator->currentPage(),
            last_page: $paginator->lastPage(),
            has_more: $paginator->hasMorePages(),
        );
    }

    public function toArray(): array
    {
        return [
            'data' => $this->data,
            'total' => $this->total,
            'per_page' => $this->per_page,
            'current_page' => $this->current_page,
            'last_page' => $this->last_page,
            'has_more' => $this->has_more,
        ];
    }
}
