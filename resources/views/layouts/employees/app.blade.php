<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>@yield('title','Employees')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {{-- your custom bootstrap template CSS here added --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
      <a class="navbar-brand" href="{{ route('employees.index') }}">Employees</a>
    </div>
  </nav>

  <div class="container">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @yield('content')
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
