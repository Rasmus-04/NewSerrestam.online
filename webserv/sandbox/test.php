
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  <link rel="stylesheet" href="main.css">
</head>

<body>
  <div class="row">
    <div class="col-md-1">
      <a href="index.php">
        <button type="button" class="btn m-2 mb-md-0 btn-outline-black btn-block fs-5 align-self-center">back</button>
      </a>
    </div>
  </div>
  <main>
    <div class="container">

      <h1 class="mb-3">Registration</h1>
      <form action="index.php" method="post">
        <div class="col-md-6 mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="col-md-6 mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" required />
        </div>
        <div class="col-md-6">
          <label for="confirm_password" class="form-label">Confirm Password</label>
          <input type="password" class="form-control" name="confirm_password" id="confirm_password" required />
        </div>
        <div class="col-md-4">
          <button type="button; submit" class="btn mt-2 mb-md-0 btn-outline-red btn-block fs-5 align-self-cente" name="action" value="create">Register</button>
        </div>
      </form>
    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  <script src="script.js"></script>
</body>
</html>