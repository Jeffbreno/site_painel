<?php

namespace App\Controller\Pages;

use App\Http\Request;
use App\Utils\View;

/**Bibliotecas para paginação no ILLUMINATE */

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PageController
{

    /**
     * Método responsável por retornar um link da paginação
     */
    private static function getLinks(mixed $page, mixed $url, $ultimaPagina = null): string
    {
        if ($ultimaPagina) {
            $queryParams['page'] = $ultimaPagina;
        } else {
            $queryParams['page'] = $page['page'];
        }
        #LINK
        if ($page['page'] == 0) {
            $link = $url . '?page=1';
        } else {
            $link = $url . '?' . http_build_query($queryParams);
        }


        #VIEW
        return View::render('pages/pagination/link', [
            'page' => $ultimaPagina ? 'Última' : ($page['page'] == 0 ? 'Primeira' : $page['page']),
            'link' => $link,
            'active' => ($page['current'] ? 'active' : '')
        ]);
    }
    /**
     * Método generico para páginação
     * 
     */
    public static function setPaginator(Request $request, Collection $items, int $perPage = 10)
    {
        $options = [];
        $options['path'] = $options['path'] ?? $request->getRouter()->getCurrentUrl();

        //GET DA PAGINA ATUAL 
        $queryParams = $request->getQueryParams();
        $currentPage = $queryParams['page'] ?? 1;

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
     * Método responsavél por gerar links de paginação
     */
    public static function getPagination($request, $resultadosPaginados)
    {
        $currentPage = $resultadosPaginados->currentPage();
        $lastPage = $resultadosPaginados->lastPage();
        $url = $request->getRouter()->getCurrentUrl();
        $links = '';

        //LIMITE DA PAGINAÇÃO
        $limit = $_ENV['PAG_LIMIT'];

        //MEIO DA PAGINAÇÃO
        $middle = ceil($limit / 2);

        //INICIO DA PAGINAÇÃO
        $start = $middle > $currentPage ? 0 : $currentPage - $middle;

        //AJUTA O FINAL DA PAGINAÇÃO
        $limit = $limit + $start;

        if ($lastPage > 1) {

            //AJUSTA O LIMITE DA PAGINAÇÃO
            if ($limit > $lastPage) {
                $diff = $limit - $lastPage;
                $start -= $diff;
            }

            //LINK INICIAL
            if ($start > 0) {
                $page['page'] = 0;
                $page['current'] = 0;
                $links .= self::getLinks($page, $url);
            }

            // Links de páginas numeradas
            for ($i = 1; $i <= $lastPage; $i++) {
                $page['page'] = $i;
                $page['current'] = ($i === $currentPage ? 1 : 0);

                //VERIFICA O START DA PAGINAÇÃO
                if ($page['page'] <= $start) continue;

                //VERIFICA O LIMITE DA PAGINAÇÃO
                if ($page['page'] > $limit) {
                    $links .= self::getLinks($page, $url, $lastPage);
                    break;
                }

                $links .= self::getLinks($page, $url);
            }

            #REDERIZA BOX DOS LINKS
            return View::render('pages/pagination/box', [
                'links' => $links,
            ]);
        }
    }
    /**
     * Método responsável por redenrizar o topo da página
     * @return string
     */
    private static function getHeader()
    {
        return View::render('pages/header');
    }

    /**
     * Método responsável por redenrizar o rodapé da página
     * @return string
     */
    private static function getFooter()
    {
        return View::render('pages/footer');
    }
    /**
     * Método responsável por retornar o conteúdo (view) da página genérica
     * @return string
     */
    public static function getPage($title, $content)
    {
        return View::render('pages/page', [
            'title' => $title,
            'header' => self::getHeader(),
            'content' => $content,
            'footer' => self::getFooter(),
        ]);
    }
}
