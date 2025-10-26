<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, inital-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Ürün Düzenle</title>
</head>
<body>
<h1>Ürün Düzenle</h1>
<form action="/urunler/duzenle/{{$product->id}}" method="POST">
    @csrf
    <input type="text" name="name" value="{{$product->name}}" placeholder="Ürün Adı"> <br>
    <textarea name="description" id="" cols="30" rows="10" placeholder="Açıklama"><{{$product->description}}/textarea> <br>
    <input type="number" name="qty" value="{{$product->qty}}" placeholder="Stok Adedi"> <br>
    <input type="number" name="price" value="{{$product->price}}" placeholder="Fiyat"><br>
    <input type="checkbox" name="is_published" {{$product->is_published ? 'checked' : ''}}> Yayınla
    <br>
    <button>Güncelle</button>
</form>

</body>
</html>
