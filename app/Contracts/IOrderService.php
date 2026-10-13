<?php

namespace App\Contracts;

use App\Models\Marketplace\Order;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IOrderService
{
    public function getByParent(string $userId): LengthAwarePaginator;

    public function getByShopOwner(string $userId, array $filters = []): LengthAwarePaginator;

    public function create(array $data, string $userId): Order;

    public function updateStatus(int $id, string $status, string $userId): void;

    public function requestReturn(int $id, string $reason, string $userId): void;
}
