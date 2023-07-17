<?php

namespace App\Controller\Admin;

use App\Http\Request;
use App\Utils\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PageController
{

    /**
     * Modulos disponíveis no painel
     */
    private static array $modules = [
        'home' => [
            'label' => 'Home',
            'link' => URL . '/admin'

        ],
        'testimonies' => [
            'label' => 'Depoimentos',
            'link' => URL . '/admin/testimonies'

        ],
        'users' => [
            'label' => 'Usuários',
            'link' => URL . '/admin/users'

        ]
    ];

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
    /**
     * Método responsável de retornar conteúdo (view) da estrutura genérica de página do painel
     *
     */
    public static function getPage(string $title, string $content): string
    {
        return View::render('admin/layout/page', [
            'title' => $title,
            'content' => $content
        ]);
    }

    /**
     * Método responsável por gerar links de páginação
     */
    public static function getLinkPages(Request $request, mixed $resultadosPaginados)
    {
        $currentPage = $resultadosPaginados->currentPage();
        $lastPage = $resultadosPaginados->lastPage();
        $url = $request->getRouter()->getCurrentUrl();
        $link = '';
        $links = '';
        if ($lastPage > 1) {

            // Links de páginas numeradas
            for ($i = 1; $i <= $lastPage; $i++) {
                $queryParams['page'] = $i;

                $link = $url . '?' . http_build_query($queryParams);

                $links .= View::render('pages/pagination/link', [
                    'page' => $i,
                    'link' => $link,
                    'active' => ($i === $currentPage ? 'active' : '')
                ]);
            }

            if ($currentPage > 1) {
                $queryParams['page'] = $currentPage - 1;
                $link = $url . '?' . http_build_query($queryParams);
                $after =  '<li class="page-item"><a class="page-link" href="' . $link . '">&laquo;</a></li>';
            } else {
                $after = '<li class="page-item disabled"><span class="page-link">&laquo;</span></li>';
            }

            if ($currentPage < $lastPage) {
                $queryParams['page'] = $currentPage + 1;
                $link = $url . '?' . http_build_query($queryParams);
                $next = '<li class="page-item"><a class="page-link" href="' . $link . '">&raquo;</a></li>';
            } else {
                $next = '<li class="page-item disabled"><span class="page-link">&raquo;</span></li>';
            }

            return View::render('pages/pagination/box', [
                'links' => $links,
                'next' => $next,
                'after' => $after
            ]);
        }
    }

    /**
     * Método reponsável por renderizar a view do menu do painel
     */
    private static function getMenu($currentModule): string
    {
        #LINKS DO MENU
        $links = '';

        #ITERA OS MÓDULOS
        foreach (self::$modules as $hash => $module) {
            $links .= View::render('admin/menu/link', [
                'label' => $module['label'],
                'link' => $module['link'],
                'current' => $hash == $currentModule ? 'text-danger' : ''
            ]);
        }

        #RETORNA A RENDERIZAÇÃO DO MENU
        return View::render('admin/menu/box', [
            'links' => $links
        ]);
    }

    /**
     * Método reponsável por redenrizar a view do painel com conteúdo dinâmico
     * 
     */
    public static function getPainel(string $title, string $content, string $currentModule): string
    {
        #RENDERIZA A VIEW DO PAINEL
        $contentPainel = View::render('admin/layout/painel', [
            //'menu' => self::getMenu($currentModule),
            'content' => $content
        ]);
        #RETORNA PÁGINA RENDERIZADA
        return self::getPage($title, $contentPainel);
    }
}
