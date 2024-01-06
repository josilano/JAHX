<?php

namespace App\Http\Controllers;

use App\Facades\FornecedorFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FornecedorController extends Controller
{
    const SEM_MSG_TELA = 9;

    public function __construct()
	{
		$this->middleware('auth');
	}

	private function dashboardFornecedores($cadfornecedor, $cadfornecedorexception)
	{
        $fornecedores = FornecedorFacade::paginate(10);//listarFornecedorPaginado(10);
        
        if ($fornecedores instanceof \Exception) $fornecedoresexception = $fornecedores;
        
        return view ('erp.fornecedor.fornecedores', compact('fornecedores', 'fornecedoresexception', 'cadfornecedor', 'cadfornecedorexception'));
	}

	private function edicaoFornecedor($fornecedor, $fornecedorexception, $upfornecedor, $upfornecedorexception)
    {

        return view ('erp.fornecedor.editafornecedor', compact('fornecedor', 'fornecedorexception', 'upfornecedor', 'upfornecedorexception'));
    }

    public function listFornecedores()
	{
		return $this->dashboardFornecedores(self::SEM_MSG_TELA, null);
	}

	public function createFornecedor(Request $request)
    {
        	$fornecedor = FornecedorFacade::novoFornecedor();
        	$fornecedor->fill($request->all());
            $fornecedor->pessoa_tipo = $request->get('pessoa-tipo');
            $fornecedor->nome_rsocial = $request->get('nome-rsocial');
            $fornecedor->cpf_cnpj = $request->get('cpf-cnpj');
            $fornecedor->nome_fantasia = $request->get('nome-fantasia');
            $fornecedor->tel_principal = $request->get('tel-principal');
            $fornecedor->tel_secundario = $request->get('tel-secundario');
            
            $fornecedor->save();

        	$fornecedoresexception = ($fornecedor instanceof \Exception) ? $fornecedor : null;

        return $this->dashboardFornecedores($fornecedor, $fornecedoresexception);
    }

	public function showNomeFornecedor($slug)
    {
        $fornecedor = FornecedorFacade::getFornecedorPorNome($slug);

        $fornecedorexception = ($fornecedor instanceof \Exception) ? $fornecedor : null;
        
        return $this->edicaoFornecedor($fornecedor, $fornecedorexception, self::SEM_MSG_TELA, null);
    }

    public function showFornecedor($id)
    {
        $fornecedor = FornecedorFacade::find($id);

        $fornecedorexception = ($fornecedor instanceof \Exception) ? $fornecedor : null;
        
        return $this->edicaoFornecedor($fornecedor, $fornecedorexception, self::SEM_MSG_TELA, null);
    }

    public function updateFornecedor(Request $request, $id)
    {
        $fornecedor = FornecedorFacade::find($id);
        
        if (!is_null($fornecedor) & !($fornecedor instanceof \Exception))
        {
            $fornecedor->fill($request->all());
            $fornecedor->pessoa_tipo = $request->get('pessoa-tipo');
            $fornecedor->nome_rsocial = $request->get('nome-rsocial');
            $fornecedor->cpf_cnpj = $request->get('cpf-cnpj');
            $fornecedor->nome_fantasia = $request->get('nome-fantasia');
            $fornecedor->tel_principal = $request->get('tel-principal');
            $fornecedor->tel_secundario = $request->get('tel-secundario');
            
            $fornecedor->save();
            
            if ($fornecedor instanceof \Exception)
            {
                $upfornecedorexception = $fornecedor;
                $upfornecedor = self::SEM_MSG_TELA;
            }
            else
            {
                $upfornecedorexception = null;
                $upfornecedor = $fornecedor;
            }

            return $this->edicaoFornecedor($fornecedor, null, $upfornecedor, $upfornecedorexception);
        }
        $fornecedorexception = ($fornecedor instanceof \Exception) ? $fornecedor : null;

        return $this->edicaoFornecedor($fornecedor, $fornecedorexception, null, null);
    }

    public function getFornecedor($slug)
    {
        $fornecedor = FornecedorFacade::getFornecedorPorNome($slug);
        $fornecedorexception = ($fornecedor instanceof \Exception) ? $fornecedor : null;
        return $fornecedor;
    }
}
