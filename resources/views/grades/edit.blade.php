<!DOCTYPE html>
<html>

<head>
    <title>Laravel</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header text-center font-weight-bold">
                Editar nota
            </div>
            <div class="card-body">
                <form method="post" action="/grades/update/{{$grade->id}}">
                    @csrf
                    <div class="form-group">
                        <label for="value">value</label>
                        <input type="number" id="value" name="value" class="form-control" min="0" max="20" required="" value="{{$grade->value}}">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>