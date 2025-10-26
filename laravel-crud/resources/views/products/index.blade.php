<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, inital-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Ürün Listesi</title>

</head>
<body>
<h1>Ürün Listesi</h1>

    @foreach($products as $product)
<h2>{{$product->name}} ({{$product->qty}})</h2>

<p>
    {{$product->description}}
</p>

<a href="/urunler/sil/{{$product->id}}">Sil</a>
    @endforeach
</body>
</html>
