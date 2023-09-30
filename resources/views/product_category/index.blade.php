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
                        <select id="tag" class="form-control">
                            <option value="">All Tags</option>
                            <!-- Include tag options here -->
                        </select>
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
                    priceRange: $('#price-range').val(),
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
    });

</script>

<!-- <script>
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

        function loadMore() {
            $.ajax({
                url: "{{ url('user/products')}}"+"?page=" + page,
                method: 'GET',
                data: {
                        category: category,
                        tag: tag,
                        priceRange: priceRange,
                    },
                dataType: 'json',
                success: function (data) {
                    data.data.forEach(function (product) {
                        // Append each product row to the DataTable
                        table.row.add([
                            product.id,
                            '<img src="' + " {{ url('images') }}/" +product.image + '" alt="' + product.name + '" width="50">',
                            product.name,
                            product.description,
                            product.price,
                        ]).draw(false);
                    });

                    // Check if there are more pages to load
                    if (data.next_page_url) {
                        page++;
                        $('#load-more').attr('data-page', page);
                    } else {
                        $('#load-more-container').hide();
                    }
                },
            });
        }

        $('#load-more').click(function () {
            loadMore();
        });

        // Initial load
        loadMore();
    });
</script> -->
