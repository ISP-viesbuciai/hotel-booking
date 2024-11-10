<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .filter-container {
            margin: 20px 0;
        }
        .reservations-table {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center my-4">Hotel Reservations</h1>

    <!-- Filter Section -->
    <div class="filter-container">
        <form>
            <div class="row">
                <div class="col-md-4">
                    <label for="room-type" class="form-label">Room Type</label>
                    <select id="room-type" class="form-select">
                        <option value="">All</option>
                        <option value="single">Single</option>
                        <option value="double">Double</option>
                        <option value="suite">Suite</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="check-in" class="form-label">Check-In Date</label>
                    <input type="date" id="check-in" class="form-control">
                </div>

                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary mt-4">Filter</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Reservations Table -->
    <div class="reservations-table">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Reservation ID</th>
                    <th>Guest Name</th>
                    <th>Room Type</th>
                    <th>Check-In Date</th>
                    <th>Check-Out Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <!-- Sample Data -->
                <tr>
                    <td>1</td>
                    <td>#R1234</td>
                    <td>John Doe</td>
                    <td>Single</td>
                    <td>2024-12-01</td>
                    <td>2024-12-07</td>
                    <td>Confirmed</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>#R5678</td>
                    <td>Jane Smith</td>
                    <td>Double</td>
                    <td>2024-12-03</td>
                    <td>2024-12-10</td>
                    <td>Pending</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>#R9101</td>
                    <td>Sam Lee</td>
                    <td>Suite</td>
                    <td>2024-12-05</td>
                    <td>2024-12-12</td>
                    <td>Confirmed</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>#R1123</td>
                    <td>Mike Brown</td>
                    <td>Single</td>
                    <td>2024-12-10</td>
                    <td>2024-12-15</td>
                    <td>Cancelled</td>
                </tr>
                <tr>
                    <td>5</td>
                    <td>#R1415</td>
                    <td>Emily Davis</td>
                    <td>Double</td>
                    <td>2024-12-07</td>
                    <td>2024-12-14</td>
                    <td>Confirmed</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Basic Filter Logic (this can be expanded for dynamic filtering)
    const filterForm = document.querySelector('form');
    filterForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const roomType = document.getElementById('room-type').value;
        const checkInDate = document.getElementById('check-in').value;
        const tableRows = document.querySelectorAll('tbody tr');

        tableRows.forEach(row => {
            const rowRoomType = row.cells[3].textContent.toLowerCase();
            const rowCheckInDate = row.cells[4].textContent;

            let match = true;

            if (roomType && rowRoomType !== roomType.toLowerCase()) {
                match = false;
            }

            if (checkInDate && rowCheckInDate !== checkInDate) {
                match = false;
            }

            if (match) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
</body>
</html>
