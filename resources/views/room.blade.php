@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-blue-500 flex items-center justify-center py-8">
        <div class="w-full max-w-4xl px-4">
            <h1 class="text-3xl font-bold mb-6 text-gray-700 text-center">Kambarių Valdymas</h1>

            @if(session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 p-3 rounded mb-4 text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-300 text-red-800 p-3 rounded mb-4 text-center">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Automatic Allocation for Group -->
            <div class="mb-8 p-4 bg-white rounded shadow text-center border border-gray-300">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Automatinis kambarių paskirstymas grupei</h2>
                <form method="POST" action="{{ route('rooms.allocate-group') }}" class="grid grid-cols-1 gap-4 justify-items-center">
                    @csrf
                    <input type="number" name="total_people" class="p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-300 w-1/2 text-center" placeholder="Žmonių skaičius" required>
                    <input type="number" name="rooms_count" class="p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-300 w-1/2 text-center" placeholder="Kambarių skaičius" required>
                    <input type="text" name="desired_type" class="p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-300 w-1/2 text-center" placeholder="Pageidaujamas kambario tipas (nebūtina)">
                    <button type="submit" class="bg-blue-200 hover:bg-blue-300 text-gray-700 px-4 py-2 rounded transition duration-200 w-1/2 border border-gray-300">Paskirstyti</button>
                </form>
            </div>

            @if(session('allocated_rooms'))
                <div class="bg-green-100 border border-green-300 text-green-800 p-3 rounded mb-8 text-center">
                    Paskirti kambariai: {{ implode(', ', session('allocated_rooms')) }}
                </div>
            @endif

            <!-- Add New Room Form -->
            <div class="mb-8 p-4 bg-white rounded shadow text-center border border-gray-300">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Pridėti Naują Kambarį</h2>
                <form method="POST" action="{{ route('rooms.store') }}" class="grid grid-cols-1 gap-4 justify-items-center">
                    @csrf
                    <input type="text" name="room_number" placeholder="Kambario Numeris" class="p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-300 w-1/2 text-center" required>
                    <input type="text" name="type" placeholder="Tipas" class="p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-300 w-1/2 text-center" required>
                    <input type="number" name="capacity" placeholder="Kapacitetas" class="p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-300 w-1/2 text-center" required>
                    <input type="text" name="price_per_night" placeholder="Kaina už Nakvynę" class="p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-300 w-1/2 text-center" required>
                    <select name="is_available" class="p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-300 w-1/2 text-center">
                        <option value="1">Pasiekiamas</option>
                        <option value="0">Užimtas</option>
                    </select>
                    <input type="number" name="floor" placeholder="Aukštas" class="p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-300 w-1/2 text-center" required>
                    <select name="sea_view" class="p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-300 w-1/2 text-center">
                        <option value="0">Be Vaizdo į Jūrą</option>
                        <option value="1">Vaizdas į Jūrą</option>
                    </select>
                    <button type="submit" class="bg-green-200 hover:bg-green-300 text-gray-700 px-4 py-2 rounded transition duration-200 w-1/2 border border-gray-300">Pridėti Kambarį</button>
                </form>
            </div>

            <!-- Edit Room Modal (Hidden by default) -->
            <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden" style="display:none;">
                <div class="bg-white p-6 rounded shadow-lg w-full max-w-md text-center border border-gray-300">
                    <h2 class="text-xl font-bold mb-4 text-gray-700">Redaguoti Kambarį</h2>
                    <form id="editRoomForm" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block mb-1 font-semibold text-gray-700">Tipas:</label>
                            <input type="text" name="type" id="editType" class="p-1 border border-gray-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-300 text-center" required>
                        </div>
                        <div>
                            <label class="block mb-1 font-semibold text-gray-700">Kapacitetas:</label>
                            <input type="number" name="capacity" id="editCapacity" class="p-1 border border-gray-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-300 text-center" required>
                        </div>
                        <div>
                            <label class="block mb-1 font-semibold text-gray-700">Kaina už Nakvynę:</label>
                            <input type="text" name="price_per_night" id="editPrice" class="p-1 border border-gray-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-300 text-center" required>
                        </div>
                        <div>
                            <label class="block mb-1 font-semibold text-gray-700">Pasiekiamumas:</label>
                            <select name="is_available" id="editAvailable" class="p-1 border border-gray-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-300 text-center">
                                <option value="1">Pasiekiamas</option>
                                <option value="0">Užimtas</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-1 font-semibold text-gray-700">Aukštas:</label>
                            <input type="number" name="floor" id="editFloor" class="p-1 border border-gray-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-300 text-center" required>
                        </div>
                        <div>
                            <label class="block mb-1 font-semibold text-gray-700">Vaizdas į Jūrą:</label>
                            <select name="sea_view" id="editSeaView" class="p-1 border border-gray-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-300 text-center">
                                <option value="0">Ne</option>
                                <option value="1">Taip</option>
                            </select>
                        </div>
                        <div class="flex justify-center space-x-2">
                            <button type="button" onclick="closeEditModal()" class="bg-gray-200 text-gray-700 px-3 py-1 rounded hover:bg-gray-300 transition duration-200 text-sm border border-gray-300">Atšaukti</button>
                            <button type="submit" class="bg-orange-300 hover:bg-orange-400 text-gray-700 px-3 py-1 rounded transition duration-200 text-sm border border-gray-300">Išsaugoti</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Room Table -->
            <div class="mb-4 p-4 bg-white rounded shadow text-center border border-gray-300">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Kambarių Sąrašas</h2>
                <table class="table-auto border border-gray-300 mx-auto" style="border-collapse: collapse;">
                    <thead>
                    <tr class="bg-gray-50">
                        <th class="py-1 px-2 border border-gray-300 text-gray-600 text-sm">Kambario Numeris</th>
                        <th class="py-1 px-2 border border-gray-300 text-gray-600 text-sm">Tipas</th>
                        <th class="py-1 px-2 border border-gray-300 text-gray-600 text-sm">Kapacitetas</th>
                        <th class="py-1 px-2 border border-gray-300 text-gray-600 text-sm">Kaina už Nakvynę</th>
                        <th class="py-1 px-2 border border-gray-300 text-gray-600 text-sm">Pasiekiamumas</th>
                        <th class="py-1 px-2 border border-gray-300 text-gray-600 text-sm">Aukštas</th>
                        <th class="py-1 px-2 border border-gray-300 text-gray-600 text-sm">Vaizdas į Jūrą</th>
                        <th class="py-1 px-2 border border-gray-300 text-gray-600 text-sm">Veiksmai</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($rooms as $room)
                        <tr class="hover:bg-gray-100
                        @if(!$room->is_available) bg-red-50 @endif">
                            <td class="p-1 border border-gray-300 text-gray-700 text-sm">{{ $room->room_number }}</td>
                            <td class="p-1 border border-gray-300 text-gray-700 text-sm">{{ $room->type }}</td>
                            <td class="p-1 border border-gray-300 text-gray-700 text-sm">{{ $room->capacity }}</td>
                            <td class="p-1 border border-gray-300 text-gray-700 text-sm">{{ $room->price_per_night }}</td>
                            <td class="p-1 border border-gray-300 text-gray-700 text-sm">
                                {{ $room->is_available ? 'Taip' : 'Ne' }}
                            </td>
                            <td class="p-1 border border-gray-300 text-gray-700 text-sm">{{ $room->floor }}</td>
                            <td class="p-1 border border-gray-300 text-gray-700 text-sm">{{ $room->sea_view ? 'Taip' : 'Ne' }}</td>
                            <td class="p-1 border border-gray-300 text-gray-700 text-sm">
                                <div class="flex items-center justify-center space-x-1">
                                    <button class="bg-orange-300 text-gray-700 px-2 py-1 rounded hover:bg-orange-400 transition duration-200 text-xs border border-gray-300"
                                            onclick="openEditModal({{ $room->id }}, '{{ $room->type }}', {{ $room->capacity }}, {{ $room->price_per_night }}, {{ $room->is_available }}, {{ $room->floor }}, {{ $room->sea_view }})">
                                        Redaguoti
                                    </button>

                                    <form method="POST" action="{{ route('rooms.destroy', $room->id) }}" class="flex items-center">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-300 text-gray-700 px-2 py-1 rounded hover:bg-red-400 transition duration-200 text-xs border border-gray-300">
                                            Ištrinti
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="p-1 border border-gray-300 text-gray-600 text-sm" colspan="8">Nėra kambarių</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function openEditModal(id, type, capacity, price, available, floor, sea_view) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editRoomForm');

            form.action = `/rooms/${id}`;
            document.getElementById('editType').value = type;
            document.getElementById('editCapacity').value = capacity;
            document.getElementById('editPrice').value = price;
            document.getElementById('editAvailable').value = available;
            document.getElementById('editFloor').value = floor;
            document.getElementById('editSeaView').value = sea_view;

            modal.classList.remove('hidden');
            modal.style.display = 'flex';
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.add('hidden');
            modal.style.display = 'none';
        }
    </script>
@endsection
