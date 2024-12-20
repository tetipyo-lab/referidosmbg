<h1>Página Dinámica</h1>

<p><strong>Parámetros:</strong></p>
<ul>
    @foreach($queryParams as $key => $value)
        <li>{{ $key }}: {{ $value }}</li>
    @endforeach
</ul>

<p><strong>Param1:</strong> {{ $param1 }}</p>
<p><strong>Param2:</strong> {{ $param2 }}</p>