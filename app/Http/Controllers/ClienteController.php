<?php

namespace App\Http\Controllers;

use App\Facades\ClienteFacade;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    
	const SEM_MSG_TELA = 9;

    public function __construct()
	{
		$this->middleware('auth');
	}

	private function dashboardClientes($cadcliente, $cadclienteexception)
	{
        $clientes = ClienteFacade::paginate(10);
        $clientesall = ClienteFacade::all();
        
        if ($clientes instanceof \Exception) $clientesexception = $clientes;
        
        return view ('erp.cliente.clientes', compact('clientes', 'clientesexception', 'cadcliente', 'cadclienteexception', 'clientesall'));
	}

	private function edicaoCliente($cliente, $clienteexception, $upcliente, $upclienteexception)
    {
        return view ('erp.cliente.editacliente', compact('cliente', 'clienteexception', 'upcliente', 'upclienteexception'));
    }

    public function listClientes()
	{
		return $this->dashboardClientes(self::SEM_MSG_TELA, null);
	}

	public function createCliente(Request $request)
    {
        //if (Auth::user()->cargo != 'admin') return back()->with('msg', 'Usuário sem permissão');
        	$cliente = ClienteFacade::novoCliente();
        	$cliente->fill($request->all());
            $cliente->pessoa_tipo = $request->get('pessoa-tipo');
            $cliente->nome_rsocial = $request->get('nome-rsocial');
            $cliente->cpf_cnpj = $request->get('cpf-cnpj');
            $cliente->nome_fantasia = $request->get('nome-fantasia');
            $cliente->tel_principal = $request->get('tel-principal');
            $cliente->tel_secundario = $request->get('tel-secundario');
            $cliente->status = 'ativo';
            
            $cliente->save();

        	$clientesexception = ($cliente instanceof \Exception) ? $cliente : null;

        return $this->dashboardClientes($cliente, $clientesexception);
    }

	public function showNomeCliente($slug)
    {
        $cliente = ClienteFacade::getClientePorNome($slug);
        if (is_null($cliente))
            $cliente = ClienteFacade::where('nome_fantasia', $slug)->first();

        $clienteexception = ($cliente instanceof \Exception) ? $cliente : null;
        
        return $this->edicaoCliente($cliente, $clienteexception, self::SEM_MSG_TELA, null);
    }

    public function showCliente($id)
    {
        $cliente = ClienteFacade::find($id);

        $clienteexception = ($cliente instanceof \Exception) ? $cliente : null;
        
        return $this->edicaoCliente($cliente, $clienteexception, self::SEM_MSG_TELA, null);
    }

    public function updateCliente(Request $request, $id)
    {
        $cliente = ClienteFacade::find($id);
        
        if (!is_null($cliente) & !($cliente instanceof \Exception))
        {
            $cliente->fill($request->all());
            $cliente->pessoa_tipo = $request->get('pessoa-tipo');
            $cliente->nome_rsocial = $request->get('nome-rsocial');
            $cliente->cpf_cnpj = $request->get('cpf-cnpj');
            $cliente->nome_fantasia = $request->get('nome-fantasia');
            $cliente->tel_principal = $request->get('tel-principal');
            $cliente->tel_secundario = $request->get('tel-secundario');
            $cliente->status = $request->get('status');
            
            $cliente->save();
            
            if ($cliente instanceof \Exception)
            {
                $upclienteexception = $cliente;
                $upcliente = self::SEM_MSG_TELA;
            }
            else
            {
                $upclienteexception = null;
                $upcliente = $cliente;
            }

            return $this->edicaoCliente($cliente, null, $upcliente, $upclienteexception);
        }
        $clienteexception = ($cliente instanceof \Exception) ? $cliente : null;

        return $this->edicaoCliente($cliente, $clienteexception, null, null);
    }

    public function getCliente($slug)
    {
        $cliente = ClienteFacade::getClientePorNome($slug);
        if (is_null($cliente))
            $cliente = ClienteFacade::where('nome_fantasia', $slug)->first();
            
        $clienteexception = ($cliente instanceof \Exception) ? $cliente : null;
        return $cliente;
    }

    public function listaClientesTelefones()
	{
        //$clientes = ClienteFacade::paginate(10);
        $clientes = ClienteFacade::orderBy('nome_rsocial')->get();
        
        //if ($clientes instanceof \Exception) $clientesexception = $clientes;
        
        return view ('erp.cliente.clienteslistatelefone', compact('clientes'));
    }
}
