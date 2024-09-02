<?php

namespace App\src\Traits;

namespace Cirel\LaravelBasicsAuxs\Http\Request;

trait GetRequestPagination
{
    private int $perPage;
    private string $orderBy;
    private string $order;
    private bool $withTrashed;
    private string|null $search;

    private function setPagination(Request $request, string $defaultOrderBy): void
    {
        $this->perPage      = $request->input('perPage', 20);
        $this->orderBy      = $request->input('orderBy', $defaultOrderBy);
        $this->order        = $request->input('order', 'asc');
        $this->withTrashed  = $request->input('withTrashed', false);
        $this->search       =  $request->input('search', null);
    }
}
