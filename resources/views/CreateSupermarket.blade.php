<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل سوبرماركت</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <div class="row w-100">
            <div class="col-md-6 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">تسجيل سوبرماركت جديد</h3>
                        <!-- نموذج التسجيل -->
                        <form action="{{ route('supermarket.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="User_id" class="form-label">رقم المستخدم</label>
                                <input type="text" class="form-control" id="User_id" name="User_id" required>
                            </div>
                            <div class="mb-3">
                                <label for="SupermarketName" class="form-label">اسم السوبرماركت</label>
                                <input type="text" class="form-control" id="SupermarketName" name="SupermarketName" required>
                            </div>
                            <div class="mb-3">
                                <label for="Location" class="form-label">الموقع</label>
                                <input type="text" class="form-control" id="Location" name="Location" required>
                            </div>
                            <div class="mb-3">
                                <label for="ContactNumber" class="form-label">رقم الاتصال</label>
                                <input type="text" class="form-control" id="ContactNumber" name="ContactNumber" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">تسجيل</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
