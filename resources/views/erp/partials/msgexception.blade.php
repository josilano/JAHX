<div class="container">
    <label>Comunicar erro ao Administrador do Sistema:|</label>
    <label>Código: {{ $exception->getCode() }}|</label>
    <label>{{ $exception->getMessage() }}|</label>
    <label>{{ $exception->getFile() }}|</label>
    <label>Linha: {{ $exception->getLine() }}</label>
</div>