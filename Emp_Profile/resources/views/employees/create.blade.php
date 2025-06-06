<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">

<div class="container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>Employee Registration</h4>
        </div>
        <div class="card-body">
            <form id="employeeForm" class="row g-3 needs-validation" novalidate>

                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select" required>
                        <option value="">Select</option>
                        <option>Male</option><option>Female</option><option>Other</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Marital Status</label>
                    <select name="marital_status" class="form-select" required>
                        <option value="">Select</option>
                        <option>Single</option><option>Married</option><option>Divorced</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="tel" name="phone" class="form-control" pattern="[0-9]{10,15}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Nationality</label>
                    <input type="text" name="nationality" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Hire Date</label>
                    <input type="date" name="hire_date" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="date_of_birth" class="form-control" required>
                </div>

                <div class="col-12">
                    <label class="form-label">Department</label>
                    <input type="text" name="department" class="form-control" required>
                </div>

                <div class="col-12">
                    <label class="form-label">Address</label>
                    <textarea name="address" class="form-control" required></textarea>
                </div>

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('employeeForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const form = this;
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            const res = await fetch('/employees', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify(data)
            });

            const result = await res.json();
            alert(result.message);
            form.reset();
            form.classList.remove('was-validated');
        } catch (err) {
            alert("Failed to save employee.");
            console.error(err);
        }
    });
</script>

</body>
</html>
