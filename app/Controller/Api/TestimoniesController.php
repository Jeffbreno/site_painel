<?php

namespace App\Controller\Api;

use App\Http\Request;
use App\Model\Entity\Testimony as EntityTestimony;
use Exception;

class TestimoniesController extends ApiController
{

    /** 
     * Método responsável por obter a renderização dos itens de depoimentos para a página
     * 
     */
    private static function getTestimonyItems(Request $request, &$obPagination): array
    {
        //DEPOIMENTOS
        $resultItems = [];

        // RESULTADO DA PÁGINA
        $queryTestmonies = EntityTestimony::orderBy('id', 'desc')->get();

        //GET DA PAGINA ATUAL 
        $queryParams = $request->getQueryParams();

        $currentPage = $queryParams['page'] ?? 1;

        //Retorna link para paginação
        $obPagination = PaginationController::getPagination($request, $queryTestmonies, 5, $currentPage);

        // $Pagination = Page::getLinkPages($request, $queryParams, $result);

        foreach ($obPagination as $testimonies) {
            $resultItems[] = [
                'id' => (int)$testimonies->id,
                'nome' => $testimonies->nome,
                'mensagem' => $testimonies->mensagem,
                'data' => $testimonies->data
            ];
        }

        //RETORNA OS DEPOIMENTOS
        return $resultItems;
    }

    /**
     * Método responsável por retornar os depoimentos
     *
     */
    public static function getTestimonies(Request $request): array
    {
        return [
            'depoimentos' => self::getTestimonyItems($request, $obPagination),
            'paginacao' => PaginationController::getPage($request, $obPagination)
        ];
    }

    /**
     * Método responsável por retornar os depoimentos
     *
     */
    public static function getTestimony(Request $request, int $id): array
    {
        /**
         * Trabalhando com váriavel tipada, esse erro seria tratado se o campo fosse mixed
         * {
         * #Valida se é um ID valido
         * if (!is_numeric($id)) {
         *    throw new Exception("O registro '" . $id . "' informado não é valido", 400);
         *   }
         * }
         */

        #Busca depoimento
        $obTestimony = EntityTestimony::getById($id);
        #Valida se o depoimento existe
        if (!$obTestimony instanceof EntityTestimony) {
            throw new Exception("O depoimento " . $id . " não foi encontrado", 404);
        }

        #Retorna os detalhes do depoimento
        return [
            'id' => (int)$obTestimony->id,
            'nome' => $obTestimony->nome,
            'mensagem' => $obTestimony->mensagem,
            'data' => $obTestimony->data
        ];
    }

    /**
     * Método responsável por retornar o formulário de cadastro de um novo depoimento
     *
     */
    public static function setNewTestimony(Request $request): array
    {
        //DADOS DO POST
        $postVars = $request->getPostVars();

        #VALIDAR CAMPOS OBRIGATÓRIOS
        if (!isset($postVars['nome']) or !isset($postVars['mensagem'])) {
            throw new Exception("Os campos 'nome' e 'mensagem' são obrigatórios", 400);
        }

        #NOVO DEPOIMENTO
        $obTestimony = new EntityTestimony;
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->data = date('Y-m-d H:i:s');

        $obTestimony->save();

        #RETORNA OS DELHES DO DEPOIMENTO CADASTRADO
        return [
            'id' => (int)$obTestimony->id,
            'nome' => $obTestimony->nome,
            'mensagem' => $obTestimony->mensagem,
            'data' => $obTestimony->data
        ];
    }

    public static function setEditTestimony(Request $request, int $id): array
    {
        //DADOS DO POST
        $postVars = $request->getPostVars();

        #VALIDAR CAMPOS OBRIGATÓRIOS
        if (!isset($postVars['nome']) or !isset($postVars['mensagem'])) {
            throw new Exception("Os campos 'nome' e 'mensagem' são obrigatórios", 400);
        }

        #BUSCA O DEPOIMENTI NO BANCO
        $obTestimony = EntityTestimony::getById($id);

        #VALIDA A INSTANCIA
        if (!$obTestimony instanceof EntityTestimony) {
            throw new Exception("O depoimento " . $id . " não doi encontrado", 404);
        }

        #ATUALIZA O DEPOIMENTO
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->update();

        #RETORNA OS DELHES DO DEPOIMENTO ATUALIZADO
        return [
            'id' => (int)$obTestimony->id,
            'nome' => $obTestimony->nome,
            'mensagem' => $obTestimony->mensagem,
            'data' => $obTestimony->data
        ];
    }
    /**
     * Método responsavel por excluir um depoimento
     *
     */
    public static function setDeleteTestimony(Request $request, int $id): array
    {
        $obTestimony = EntityTestimony::getById($id);

        if (!$obTestimony instanceof EntityTestimony) {
            throw new Exception("O depoimento " . $id . " não foi encontrado", 404);
        }

        #EXCLUI O REGISTRO
        $obTestimony->delete();

        #RETORNA O SUCESSO DA EXLUSÃO
        return [
            'success' => true
        ];
    }
}
