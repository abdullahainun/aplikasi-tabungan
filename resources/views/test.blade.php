<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Users Data</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

    <div class="container">
      <h2>All Users Data</h2>
      <div class="btn-group">
        <button class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Export All Data <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
          <li><a href="{{ route('htmltopdf',['downloadpdf'=>'pdf']) }}">Export to PDF</a></li>
          <li><a href="{{ route('htmltopdf',['downloadexcel'=>'excel']) }}">Export to Excel</a></li>
        </ul>
      </div>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>Created At</th>
            <th><button class="btn btn-success btn-xs">Add New Supplier</button></th>
          </tr>
        </thead>
        <tbody>
          @foreach($blogs as $blog)
            <tr>
              <td>{{ $blog->id }}</td>
              <td>{{ $blog->name }}</td>
              <td>{{ $blog->email }}</td>
              <td>{{ $blog->password }}</td>
              <td>{{ $blog->created_at }}</td>
              <td>
                <button class="btn btn-warning btn-xs btn-detail">
                  <span class="glyphicon glyphicon-edit"></span>
                </button>
                <button class="btn btn-danger btn-xs btn-delete">
                  <span class="glyphicon glyphicon-trash"></span>
                </button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </body>
</html>