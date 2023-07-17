<?php

namespace App\Controller\Pages;

use App\Http\Request;
use App\Model\Entity\Testimony as EntityTestimony;
use App\Utils\View;

class TestimonyController extends PageController
{
    /** 
     * Método responsável por obter a renderização dos itens de depoimentos para a página
     * 
     */
    private static function getTestimonyItems(Request $request, &$obPagination): string
    {
        //DEPOIMENTOS
        $resultItems = '';

        // RESULTADO DA PÁGINA
        $queryTestmonies = EntityTestimony::orderBy('id', 'desc')->get();

        //Seta e Retorna intens por página
        $obPagination = PageController::setPaginator($request, $queryTestmonies, 1);

        foreach ($obPagination as $testimonies) {
            $resultItems .= View::render('pages/testimony/item', [
                'nome' => $testimonies->nome,
                'mensagem' => $testimonies->mensagem,
                'data' => date('d/m/Y H:i', strtotime($testimonies->data))
            ]);
        }

        //RETORNA OS DEPOIMENTOS
        return $resultItems;
    }
    /**
     * Método responsável por retorno o conteúdo (view) de depoimentos
     * 
     */
    public static function getTestimonies(Request $request): string
    {

        $content = View::render('pages/testimonies', [
            'itens' => self::getTestimonyItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination)
        ]);

        return parent::getPage('Site Igreja', $content);
    }

    /**
     * Método responsável por cadastrar um depoimento
     * 
     */
    public static function insertTestimony(Request $request): string
    {
        //DADOS DO POST
        $postVars = $request->getPostVars();
        $obTestimony = new EntityTestimony;
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->data = date('Y-m-d H:i:s');

        $obTestimony->save();

        //RETORNA A PAGINA DE DEPOIMENTOS
        return self::getTestimonies($request);
    }
}
