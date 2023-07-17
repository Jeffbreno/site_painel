<?php

namespace App\Controller\Admin;

use App\Http\Request;
use App\Utils\View;
use App\Model\Entity\Testimony as EntityTestimony;

class TestimoniesController extends PageController
{

    /**
     * Método reponsável por retornar mensagem de status
     *
     */
    private static function getStatus(Request $request)
    {
        #QUERY PARAMS
        $queryParams = $request->getQueryParams();

        if (!isset($queryParams['status'])) return '';

        #MENSAGEM DE STATUS
        switch ($queryParams['status']) {
            case 'created':
                return AlertController::getSuccess('Depoimento criado com sucesso!');

            case 'update':
                return AlertController::getSuccess('Depoimento atualizado com sucesso!');
            case 'deleted':
                return AlertController::getSuccess('Depoimento excluído com sucesso!');
        }
    }

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

        //GET DA PAGINA ATUAL 
        $queryParams = $request->getQueryParams();

        $currentPage = $queryParams['page'] ?? 1;

        //Retorna link para paginação
        $obPagination = PageController::getPagination($request, $queryTestmonies, 5, $currentPage);

        foreach ($obPagination as $testimonies) {
            $resultItems .= View::render('admin/modules/testimonies/item', [
                'id' => $testimonies->id,
                'nome' => $testimonies->nome,
                'mensagem' => $testimonies->mensagem,
                'data' => date('d/m/Y H:i', strtotime($testimonies->data))
            ]);
        }

        //RETORNA OS DEPOIMENTOS
        return $resultItems;
    }

    /**
     * Método responsável por renderizar a view de home do painel
     *
     */
    public static function getTestimonies(Request $request): string
    {

        #CONTEÚDO DA HOME DE DEPOIMENTOS
        $content = View::render('admin/modules/testimonies/index', [
            'itens' => self::getTestimonyItems($request, $obPagination),
            'pagination' => parent::getLinkPages($request, $obPagination),
            'status' => self::getStatus($request)
        ]);

        #RETORNA A PÁGINA COMPLETA
        return parent::getPainel('Depoimentos', $content, 'testimonies');
    }

    /**
     * Método responsável por retornar o formulário de cadastro de um novo depoimento
     *
     */
    public static function getNewTestimonies(Request $request): string
    {
        #CONTEÚDO DA HOME DE DEPOIMENTOS
        $content = View::render('admin/modules/testimonies/form', [
            'title' => 'Cadastrar depoimento',
            'nome' => null,
            'mensagem' => null,
            'status' => self::getStatus($request)
        ]);
        return parent::getPainel('Cadastro depoimento', $content, 'testimonies');
    }

    public static function setNewTestimonies($request): string
    {
        //DADOS DO POST
        $postVars = $request->getPostVars();
        $obTestimony = new EntityTestimony;
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->data = date('Y-m-d H:i:s');

        $obTestimony->save();

        return $request->getRouter()->redirect('/admin/testimonies/' . $obTestimony->id . '/edit?status=created');
    }


    /**
     * Método responsável por retornar o fomulário de edição de um depoimento
     *
     */
    public static function getEditTestimonies(Request $request, int $id): string
    {
        $obTestimony = EntityTestimony::getById($id);

        if (!$obTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        #CONTEÚDO DA HOME DE DEPOIMENTOS
        $content = View::render('admin/modules/testimonies/form', [
            'title' => 'Cadastrar depoimento',
            'nome' => $obTestimony->nome,
            'mensagem' => $obTestimony->mensagem,
            'status' => self::getStatus($request)
        ]);
        return parent::getPainel('Editar depoimento', $content, 'testimonies');
    }

    public static function setEditTestimonies(Request $request, int $id)
    {
        $obTestimony = EntityTestimony::getById($id);

        if (!$obTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        #POST VARS
        $postVars = $request->getPostVars();

        #ATUALIZA A INSTANCIA
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->update();

        return $request->getRouter()->redirect('/admin/testimonies/' . $obTestimony->id . '/edit?status=update');
    }

    /**
     * Método responsável por retornar o formulário de exclusão de um depoimento
     *
     */
    public static function getDeleteTestimonies(Request $request, int $id): string
    {
        $obTestimony = EntityTestimony::getById($id);

        if (!$obTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        #CONTEÚDO DA HOME DE DEPOIMENTOS
        $content = View::render('admin/modules/testimonies/delete', [
            'title' => 'Excluir depoimento',
            'nome' => $obTestimony->nome,
            'mensagem' => $obTestimony->mensagem,
            'status' => self::getStatus($request)
        ]);
        return parent::getPainel('Excluir registro', $content, 'testimonies');
    }

    /**
     * Método responsavel por excluir um depoimento
     *
     */
    public static function setDeleteTestimonies(Request $request, int $id)
    {
        $obTestimony = EntityTestimony::getById($id);

        if (!$obTestimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        #EXCLUI O REGISTRO
        $obTestimony->delete();

        return $request->getRouter()->redirect('/admin/testimonies?status=deleted');
    }
}
