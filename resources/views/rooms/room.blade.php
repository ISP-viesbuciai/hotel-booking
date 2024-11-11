@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">Kambarių Valdymas</h1>

        <!-- Room Table -->
        <div class="mb-4">
            <h2 class="text-xl font-semibold mb-2">Kambarių Sąrašas</h2>
            <table class="min-w-full bg-white border">
                <thead>
                <tr>
                    <th class="py-2 border-b">Kambario Numeris</th>
                    <th class="py-2 border-b">Tipas</th>
                    <th class="py-2 border-b">Kapacitetas</th>
                    <th class="py-2 border-b">Kaina už Nakvynę</th>
                    <th class="py-2 border-b">Pasiekiamumas</th>
                    <th class="py-2 border-b">Aukštas</th>
                    <th class="py-2 border-b">Vaizdas į Jūrą</th>
                    <th class="py-2 border-b">Veiksmai</th>
                </tr>
                </thead>
                <tbody>
                <!-- Example Rooms (Hardcoded) -->
                <tr>
                    <td class="p-2 border-b">101</td>
                    <td class="p-2 border-b">Vienvietis</td>
                    <td class="p-2 border-b">1</td>
                    <td class="p-2 border-b">50.00</td>
                    <td class="p-2 border-b">Taip</td>
                    <td class="p-2 border-b">1</td>
                    <td class="p-2 border-b">Ne</td>
                    <td class="p-2 border-b">
                        <button class="bg-blue-500 text-white px-2 py-1 rounded" onclick="editRoom(this)">Redaguoti</button>
                        <button class="bg-red-500 text-white px-2 py-1 rounded" onclick="deleteRoom(this)">Ištrinti</button>
                    </td>
                </tr>
                <!-- Add more hardcoded rooms as needed -->
                </tbody>
            </table>
        </div>

        <!-- Add New Room Form -->
        <div class="mb-4">
            <h2 class="text-xl font-semibold mb-2">Pridėti Naują Kambari</h2>
            <form id="addRoomForm" class="grid grid-cols-2 gap-4">
                <input type="text" placeholder="Kambario Numeris" class="p-2 border rounded" id="newRoomNumber">
                <input type="text" placeholder="Tipas" class="p-2 border rounded" id="newRoomType">
                <input type="number" placeholder="Kapacitetas" class="p-2 border rounded" id="newRoomCapacity">
                <input type="text" placeholder="Kaina už Nakvynę" class="p-2 border rounded" id="newRoomPrice">
                <select class="p-2 border rounded" id="newRoomAvailable">
                    <option value="Yes">Pasiekiamas</option>
                    <option value="No">Užimtas</option>
                </select>
                <input type="number" placeholder="Aukštas" class="p-2 border rounded" id="newRoomFloor">
                <select class="p-2 border rounded" id="newRoomSeaView">
                    <option value="No">Be Vaizdo į Jūrą</option>
                    <option value="Yes">Vaizdas į Jūrą</option>
                </select>
                <button type="button" onclick="addRoom()" class="col-span-2 bg-green-500 text-white px-4 py-2 rounded">Pridėti Kambari</button>
            </form>
        </div>
    </div>

    <script>
        function addRoom() {
            const tbody = document.querySelector('table tbody');
            const newRoomNumber = document.getElementById('newRoomNumber').value;
            const newRoomType = document.getElementById('newRoomType').value;
            const newRoomCapacity = document.getElementById('newRoomCapacity').value;
            const newRoomPrice = document.getElementById('newRoomPrice').value;
            const newRoomAvailable = document.getElementById('newRoomAvailable').value;
            const newRoomFloor = document.getElementById('newRoomFloor').value;
            const newRoomSeaView = document.getElementById('newRoomSeaView').value;

            const row = `<tr>
                <td class="p-2 border-b">${newRoomNumber}</td>
                <td class="p-2 border-b">${newRoomType}</td>
                <td class="p-2 border-b">${newRoomCapacity}</td>
                <td class="p-2 border-b">${newRoomPrice}</td>
                <td class="p-2 border-b">${newRoomAvailable}</td>
                <td class="p-2 border-b">${newRoomFloor}</td>
                <td class="p-2 border-b">${newRoomSeaView}</td>
                <td class="p-2 border-b">
                    <button class="bg-blue-500 text-white px-2 py-1 rounded" onclick="editRoom(this)">Redaguoti</button>
                    <button class="bg-red-500 text-white px-2 py-1 rounded" onclick="deleteRoom(this)">Ištrinti</button>
                </td>
            </tr>`;
            tbody.insertAdjacentHTML('beforeend', row);
            document.getElementById('addRoomForm').reset();
        }

        function deleteRoom(button) {
            button.closest('tr').remove();
        }

        function editRoom(button) {
            const row = button.closest('tr').children;
            const roomNumber = row[0].textContent;
            const type = prompt('Kambario Tipas:', row[1].textContent);
            const capacity = prompt('Kapacitetas:', row[2].textContent);
            const price = prompt('Kaina už Nakvynę:', row[3].textContent);
            const available = confirm('Ar šis kambarys pasiekiamas?') ? 'Taip' : 'Ne';
            const floor = prompt('Aukštas:', row[5].textContent);
            const seaView = confirm('Ar kambarys turi vaizdą į jūrą?') ? 'Taip' : 'Ne';

            row[1].textContent = type;
            row[2].textContent = capacity;
            row[3].textContent = price;
            row[4].textContent = available;
            row[5].textContent = floor;
            row[6].textContent = seaView;
        }
    </script>
@endsection
