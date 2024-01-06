<table class="highlight striped">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Telefone 1</th>
            <th>Telefone 2</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($clientes as $cliente)
        <tr>
            <td>{{ $cliente->nome_rsocial }}</td>
            <td><a href="tel:{{ str_replace('-', '', $cliente->tel_principal) }}">{{ $cliente->tel_principal }}</a></td>
            <td><a href="tel:{{ str_replace('-', '', $cliente->tel_secundario) }}">{{ $cliente->tel_secundario }}</a></td>
        </tr>
    @endforeach
    </tbody>
</table>