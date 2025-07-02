<table>
    <thead>
    <tr>
        <th>Title</th>
        <th>Category</th>
        <th>Price</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr>
        
            <td>{{ $product->title }}</td>
            <td>{{ $product->category }}</td>
            <td>{{ $product->price }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
