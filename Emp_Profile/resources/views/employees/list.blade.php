<!DOCTYPE html>
<html>
<head>
    <title>Employee List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">

<div class="container">
    <h3 class="mb-4">All Employees</h3>
    <div id="employeeList"></div>
</div>

<script>
    window.onload = async () => {
        try {
            const res = await fetch('/employees');
            const employees = await res.json();

            let html = '';
            employees.forEach(emp => {
                html += `<div class="card mb-2">
                    <div class="card-body">
                        <h5>${emp.name}</h5>
                        <p>${emp.gender} | ${emp.marital_status} | ${emp.department}</p>
                        <p>${emp.phone} | ${emp.email}</p>
                    </div>
                </div>`;
            });

            document.getElementById('employeeList').innerHTML = html;
        } catch (error) {
            document.getElementById('employeeList').innerHTML = "<p class='text-danger'>Failed to load employees.</p>";
        }
    };
</script>
</body>
</html>
