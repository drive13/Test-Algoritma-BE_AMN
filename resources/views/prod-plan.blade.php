<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Test BE AMN</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    </head>
    <body>
        <div class="container-fluid">
            <h1>Production Planning</h1>
            <div class="row">
                <div class="col">
                    <form class="p-2 border border-3 border-dark" action="/production-planning" method="post">
                        @csrf
                        @method('POST')
                        <div class="mb-3 row">
                            <label for="product_id" class="col-sm-3 col-form-label">Product</label>
                            <div class="col-sm-9">
                                <select name="product_id" class="form-select">
                                    <option selected>Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>                                    
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="qty" class="col-sm-3 col-form-label">Qty</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="qty" name="qty">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="start_date" class="col-sm-3 col-form-label">Start Production Date</label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="start_date" name="start_date">
                            </div>
                        </div>
                        <button class="btn btn-sm btn-primary" type="submit">Save</button>
                    </form>
                </div>
            </div>
            <hr>
            <hr>
            <div class="row">
                <div class="col">
                    {{-- <p>Planning Date : {{ 'tes' }}</p>
                    <p>Production Date : {{ 'tes' }}</p> --}}
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Daily Capacity</th>
                                <th>Planned Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productionPlan as $pp)
                                <tr>
                                    <td>{{ $pp->code }}</td>
                                    <td>{{ $pp->name }}</td>
                                    <td>{{ $pp->daily_capacity }}</td>
                                    <td>{{ $pp->planned_qty }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    {{-- <p>Planning Date : {{ 'tes' }}</p>
                    <p>Production Date : {{ 'tes' }}</p> --}}
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Production Date</th>
                                <th>Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productionPlanDetails as $ppd)
                                <tr>
                                    <td>{{ $ppd->code }}</td>
                                    <td>{{ $ppd->name }}</td>
                                    <td>{{ date('j F Y', strtotime($ppd->production_date)) }}</td>
                                    <td>{{ $ppd->qty }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    </body>
</html>