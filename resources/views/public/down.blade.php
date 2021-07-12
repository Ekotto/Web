<h1>Select your download:</h1>

<table class="table table-bordered">
@foreach ($downloads as $download)
    <tr>
        <td>{{ $download->name }}</td>
        <td>&pound;{{ round($download->price/100) }}</td>
        <td><a href="/buy/{{ $download->id }}" class="btn btn-primary">Buy</a></td>
    </tr>
@endforeach
</table>
