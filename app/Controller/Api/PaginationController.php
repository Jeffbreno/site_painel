<?php

namespace App\Controller\Api;

use App\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PaginationController
{
    /**
     * Método generico para páginação
     * 
     */
    public static function getPagination(Request $request, Collection $items, int $perPage = 10, int $currentPage = null)
    {
        $options = [];
        $options['path'] = $options['path'] ?? $request->getRouter()->getCurrentUrl();

        $items = $items instanceof Collection ? $items : Collection::make($items);

        $paginator = new LengthAwarePaginator(
            $items->forPage($currentPage, $perPage),
            $items->count(),
            $perPage,
            $currentPage,
            $options
        );

        return $paginator->withPath($options['path']);
    }

    public static function getPage(Request $request, mixed $resultadosPaginados): array
    {
        $currentPage = $resultadosPaginados->currentPage();
        $lastPage = $resultadosPaginados->lastPage();
        return [
            'paginaAtual' => $currentPage,
            'quantidadePaginas' => $lastPage
        ];
    }
}
