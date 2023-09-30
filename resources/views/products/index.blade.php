<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="col-md-4">
                        <h3>Filters</h3>
                        <label for="category">Category:</label>
                        <select id="category" class="form-control">
                            <option value="">All Categories</option>
                            @foreach($productCategories as $category)
                                <option value="{{$category->id}}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <br>
                        <label for="tag">Tag:</label>
                        <input type="text" name="tag" id="tag" class="form-control">
                        <br>
                         <div class="form-group">
                            <label for="min-price">Min Price:</label>
                            <input type="number" id="min-price" class="form-control" placeholder="Min Price">
                        </div>
                        <div class="form-group">
                            <label for="max-price">Max Price:</label>
                            <input type="number" id="max-price" class="form-control" placeholder="Max Price">
                        </div>
                        <br>
                        <button id="apply-filters" class="btn btn-primary">Apply Filters</button>
                        <button id="reset-filters" class="btn btn-secondary">Reset Filters</button>
                    </div>
                    <table id="product-table" class="table table-bordered" style="width:-moz-available;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    <div id="load-more-container">
                        <button class="btn btn-link" id="load-more" data-page="1">Load More</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    $(document).ready(function () {
        var page = 1;
        var perPage = "{{ $perPage }}";

        // Initialize the DataTable
        var table = $('#product-table').DataTable({
            paging: false,
            searching: false,
            ordering: false,
            info: false,
        });

        // Function to load more products
        function loadMore() {
            $.ajax({
                url: "{{ url('user/products')}}" + "?page=" + page,
                method: 'GET',
                dataType: 'json',
                data: {
                    category: $('#category').val(),
                    tag: $('#tag').val(),
                    minPrice: $('#min-price').val(),
                    maxPrice: $('#max-price').val(),
                },
                success: function (data) {
                    data.data.forEach(function (product) {
                        // Append each product row to the DataTable
                        table.row.add([
                            product.id,
                            '<img src="' + " {{ url('images') }}/" +product.image + '" alt="' + product.name + '" width="50">',
                            product.name,
                            product.description,
                            product.price,
                            '<input type="number" class="form-control quantity-input" data-id="'+product.id+'" min="0" value=""><button type="button" class="btn btn-primary add-to-cart" data-id="'+product.id+'">Add to Cart</button>',

                        ]).draw(false);
                    });

                    if (data.next_page_url) {
                        page++;
                    } else {
                        $('#load-more-container').hide();
                    }
                },
            });
        }

        $('#apply-filters').click(function () {
            table.clear();
            page = 1;
            loadMore();
        });

        $('#reset-filters').click(function () {
            $('#category').val('');
            $('#tag').val('');
            $('#price-range').val('');

            table.clear();
            page = 1;
            loadMore();
        });

        $('#load-more').click(function () {
            loadMore();
        });

        // Initial load
        loadMore();


        $('.add-to-cart').click(function () {

            console.log(11111);
            var productId = $(this).data('id');
            var quantity = $('.quantity-input[data-id="' + productId + '"]').val();

            $.ajax({
                url: "{{ route('cart.add') }}",
                method: 'POST',
                data: {
                    productId: productId,
                    quantity: quantity,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    alert('Product added to cart.');
                }
            });
        });

    });

</script>
