@extends('layouts.app')

@section('content')
    <div class="tw-min-h-screen tw-bg-blue-200 tw-flex tw-items-center tw-justify-center tw-py-8">
        <div class="tw-w-full tw-max-w-4xl tw-px-4">
            <h1 class="tw-text-3xl tw-font-bold tw-mb-6 tw-text-gray-700 tw-text-center">Kambarių Valdymas</h1>

            @if(session('success'))
                <div class="tw-bg-green-100 tw-border tw-border-green-300 tw-text-green-800 tw-p-3 tw-rounded tw-mb-4 tw-text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="tw-bg-red-100 tw-border tw-border-red-300 tw-text-red-800 tw-p-3 tw-rounded tw-mb-4 tw-text-center">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Automatic Allocation for Group (Collapsible) -->
            <div class="tw-mb-8 tw-bg-white tw-rounded tw-shadow tw-text-center tw-border tw-border-gray-300">
                <h2
                    class="tw-text-xl tw-font-semibold tw-mb-0 tw-text-gray-700 tw-p-4 tw-cursor-pointer hover:tw-bg-gray-100"
                    onclick="toggleSection('allocationSection')"
                >
                    Automatinis kambarių paskirstymas grupei
                </h2>
                <div id="allocationSection" class="tw-hidden tw-p-4 tw-border-t tw-border-gray-300">
                    <form method="POST" action="{{ route('rooms.allocate-group') }}" class="tw-grid tw-grid-cols-1 tw-gap-4 tw-justify-items-center">
                        @csrf
                        <input type="number" name="total_people" class="tw-p-2 tw-border tw-border-gray-300 tw-rounded focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-300 tw-w-1/2 tw-text-center" placeholder="Žmonių skaičius" required>
                        <input type="number" name="rooms_count" class="tw-p-2 tw-border tw-border-gray-300 tw-rounded focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-300 tw-w-1/2 tw-text-center" placeholder="Kambarių skaičius" required>
                        <input type="text" name="desired_type" class="tw-p-2 tw-border tw-border-gray-300 tw-rounded focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-300 tw-w-1/2 tw-text-center" placeholder="Pageidaujamas kambario tipas (nebūtina)">
                        <button type="submit" class="tw-bg-blue-200 hover:tw-bg-blue-300 tw-text-gray-700 tw-px-4 tw-py-2 tw-rounded tw-transition tw-duration-200 tw-w-1/2 tw-border tw-border-gray-300">Paskirstyti</button>
                    </form>
                </div>
            </div>

            @if(session('allocated_rooms'))
                <div class="tw-bg-green-100 tw-border tw-border-green-300 tw-text-green-800 tw-p-3 tw-rounded tw-mb-8 tw-text-center">
                    Paskirti kambariai: {{ implode(', ', session('allocated_rooms')) }}
                </div>
            @endif

            <!-- Add New Room Form (Collapsible) -->
            <div class="tw-mb-8 tw-bg-white tw-rounded tw-shadow tw-text-center tw-border tw-border-gray-300">
                <h2
                    class="tw-text-xl tw-font-semibold tw-mb-0 tw-text-gray-700 tw-p-4 tw-cursor-pointer hover:tw-bg-gray-100"
                    onclick="toggleSection('addRoomSection')"
                >
                    Pridėti Naują Kambarį
                </h2>
                <div id="addRoomSection" class="tw-hidden tw-p-4 tw-border-t tw-border-gray-300">
                    <form method="POST" action="{{ route('rooms.store') }}" class="tw-grid tw-grid-cols-1 tw-gap-4 tw-justify-items-center">
                        @csrf
                        <input type="text" name="room_number" placeholder="Kambario Numeris" class="tw-p-2 tw-border tw-border-gray-300 tw-rounded focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-300 tw-w-1/2 tw-text-center" required>
                        <input type="text" name="type" placeholder="Tipas" class="tw-p-2 tw-border tw-border-gray-300 tw-rounded focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-300 tw-w-1/2 tw-text-center" required>
                        <input type="number" name="capacity" placeholder="Kapacitetas" class="tw-p-2 tw-border tw-border-gray-300 tw-rounded focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-300 tw-w-1/2 tw-text-center" required>
                        <input type="text" name="price_per_night" placeholder="Kaina už Nakvynę" class="tw-p-2 tw-border tw-border-gray-300 tw-rounded focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-300 tw-w-1/2 tw-text-center" required>
                        <select name="is_available" class="tw-p-2 tw-border tw-border-gray-300 tw-rounded focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-300 tw-w-1/2 tw-text-center">
                            <option value="1">Pasiekiamas</option>
                            <option value="0">Užimtas</option>
                        </select>
                        <input type="number" name="floor" placeholder="Aukštas" class="tw-p-2 tw-border tw-border-gray-300 tw-rounded focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-300 tw-w-1/2 tw-text-center" required>
                        <select name="sea_view" class="tw-p-2 tw-border tw-border-gray-300 tw-rounded focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-300 tw-w-1/2 tw-text-center">
                            <option value="0">Be Vaizdo į Jūrą</option>
                            <option value="1">Vaizdas į Jūrą</option>
                        </select>
                        <button type="submit" class="tw-bg-green-200 hover:tw-bg-green-300 tw-text-gray-700 tw-px-4 tw-py-2 tw-rounded tw-transition tw-duration-200 tw-w-1/2 tw-border tw-border-gray-300">Pridėti Kambarį</button>
                    </form>
                </div>
            </div>

            <!-- Edit Room Modal (Hidden by default) -->
            <div id="editModal" class="tw-fixed tw-inset-0 tw-bg-black tw-bg-opacity-50 tw-flex tw-items-center tw-justify-center tw-hidden" style="display:none;">
                <div class="tw-bg-white tw-p-6 tw-rounded tw-shadow-lg tw-w-full tw-max-w-md tw-text-center tw-border tw-border-gray-300">
                    <h2 class="tw-text-xl tw-font-bold tw-mb-4 tw-text-gray-700">Redaguoti Kambarį</h2>
                    <form id="editRoomForm" method="POST" class="tw-space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="tw-block tw-mb-1 tw-font-semibold tw-text-gray-700">Tipas:</label>
                            <input type="text" name="type" id="editType" class="tw-p-1 tw-border tw-border-gray-300 tw-rounded tw-w-full focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-300 tw-text-center" required>
                        </div>
                        <div>
                            <label class="tw-block tw-mb-1 tw-font-semibold tw-text-gray-700">Kapacitetas:</label>
                            <input type="number" name="capacity" id="editCapacity" class="tw-p-1 tw-border tw-border-gray-300 tw-rounded tw-w-full focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-300 tw-text-center" required>
                        </div>
                        <div>
                            <label class="tw-block tw-mb-1 tw-font-semibold tw-text-gray-700">Kaina už Nakvynę:</label>
                            <input type="text" name="price_per_night" id="editPrice" class="tw-p-1 tw-border tw-border-gray-300 tw-rounded tw-w-full focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-300 tw-text-center" required>
                        </div>
                        <div>
                            <label class="tw-block tw-mb-1 tw-font-semibold tw-text-gray-700">Pasiekiamumas:</label>
                            <select name="is_available" id="editAvailable" class="tw-p-1 tw-border tw-border-gray-300 tw-rounded tw-w-full focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-300 tw-text-center">
                                <option value="1">Pasiekiamas</option>
                                <option value="0">Užimtas</option>
                            </select>
                        </div>
                        <div>
                            <label class="tw-block tw-mb-1 tw-font-semibold tw-text-gray-700">Aukštas:</label>
                            <input type="number" name="floor" id="editFloor" class="tw-p-1 tw-border tw-border-gray-300 tw-rounded tw-w-full focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-300 tw-text-center" required>
                        </div>
                        <div>
                            <label class="tw-block tw-mb-1 tw-font-semibold tw-text-gray-700">Vaizdas į Jūrą:</label>
                            <select name="sea_view" id="editSeaView" class="tw-p-1 tw-border tw-border-gray-300 tw-rounded tw-w-full focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-blue-300 tw-text-center">
                                <option value="0">Ne</option>
                                <option value="1">Taip</option>
                            </select>
                        </div>
                        <div class="tw-flex tw-justify-center tw-space-x-2">
                            <button type="button" onclick="closeEditModal()" class="tw-bg-gray-200 tw-text-gray-700 tw-px-3 tw-py-1 tw-rounded hover:tw-bg-gray-300 tw-transition tw-duration-200 tw-text-sm tw-border tw-border-gray-300">Atšaukti</button>
                            <button type="submit" class="tw-bg-orange-300 hover:tw-bg-orange-400 tw-text-gray-700 tw-px-3 tw-py-1 tw-rounded tw-transition tw-duration-200 tw-text-sm tw-border tw-border-gray-300">Išsaugoti</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Room Table -->
            <div class="tw-mb-4 tw-p-4 tw-bg-white tw-rounded tw-shadow tw-text-center tw-border tw-border-gray-300">
                <h2 class="tw-text-xl tw-font-semibold tw-mb-4 tw-text-gray-700">Kambarių Sąrašas</h2>
                <table class="tw-table-auto tw-border tw-border-gray-300 tw-mx-auto" style="border-collapse: collapse;">
                    <thead>
                    <tr class="tw-bg-gray-50">
                        <th class="tw-py-1 tw-px-2 tw-border tw-border-gray-300 tw-text-gray-600 tw-text-sm">Kambario Numeris</th>
                        <th class="tw-py-1 tw-px-2 tw-border tw-border-gray-300 tw-text-gray-600 tw-text-sm">Tipas</th>
                        <th class="tw-py-1 tw-px-2 tw-border tw-border-gray-300 tw-text-gray-600 tw-text-sm">Kapacitetas</th>
                        <th class="tw-py-1 tw-px-2 tw-border tw-border-gray-300 tw-text-gray-600 tw-text-sm">Kaina už Nakvynę</th>
                        <th class="tw-py-1 tw-px-2 tw-border tw-border-gray-300 tw-text-gray-600 tw-text-sm">Pasiekiamumas</th>
                        <th class="tw-py-1 tw-px-2 tw-border tw-border-gray-300 tw-text-gray-600 tw-text-sm">Aukštas</th>
                        <th class="tw-py-1 tw-px-2 tw-border tw-border-gray-300 tw-text-gray-600 tw-text-sm">Vaizdas į Jūrą</th>
                        <th class="tw-py-1 tw-px-2 tw-border tw-border-gray-300 tw-text-gray-600 tw-text-sm">Veiksmai</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($rooms as $room)
                        <tr class="hover:tw-bg-gray-100 @if(!$room->is_available) tw-bg-red-50 @endif">
                            <td class="tw-p-1 tw-border tw-border-gray-300 tw-text-gray-700 tw-text-sm">{{ $room->room_number }}</td>
                            <td class="tw-p-1 tw-border tw-border-gray-300 tw-text-gray-700 tw-text-sm">{{ $room->type }}</td>
                            <td class="tw-p-1 tw-border tw-border-gray-300 tw-text-gray-700 tw-text-sm">{{ $room->capacity }}</td>
                            <td class="tw-p-1 tw-border tw-border-gray-300 tw-text-gray-700 tw-text-sm">{{ $room->price_per_night }}</td>
                            <td class="tw-p-1 tw-border tw-border-gray-300 tw-text-gray-700 tw-text-sm">
                                {{ $room->is_available ? 'Taip' : 'Ne' }}
                            </td>
                            <td class="tw-p-1 tw-border tw-border-gray-300 tw-text-gray-700 tw-text-sm">{{ $room->floor }}</td>
                            <td class="tw-p-1 tw-border tw-border-gray-300 tw-text-gray-700 tw-text-sm">{{ $room->sea_view ? 'Taip' : 'Ne' }}</td>
                            <td class="tw-p-1 tw-border tw-border-gray-300 tw-text-gray-700 tw-text-sm">
                                <div class="tw-flex tw-items-center tw-justify-center tw-space-x-1">
                                    <button class="tw-bg-orange-300 tw-text-gray-700 tw-px-2 tw-py-1 tw-rounded hover:tw-bg-orange-400 tw-transition tw-duration-200 tw-text-xs tw-border tw-border-gray-300"
                                            onclick="openEditModal({{ $room->id }}, '{{ $room->type }}', {{ $room->capacity }}, {{ $room->price_per_night }}, {{ $room->is_available }}, {{ $room->floor }}, {{ $room->sea_view }})">
                                        Redaguoti
                                    </button>

                                    <form method="POST" action="{{ route('rooms.destroy', $room->id) }}" class="tw-flex tw-items-center">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="tw-bg-red-300 tw-text-gray-700 tw-px-2 tw-py-1 tw-rounded hover:tw-bg-red-400 tw-transition tw-duration-200 tw-text-xs tw-border tw-border-gray-300">
                                            Ištrinti
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="tw-p-1 tw-border tw-border-gray-300 tw-text-gray-600 tw-text-sm" colspan="8">Nėra kambarių</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function toggleSection(sectionId) {
            const section = document.getElementById(sectionId);
            if (section.classList.contains('tw-hidden')) {
                section.classList.remove('tw-hidden');
            } else {
                section.classList.add('tw-hidden');
            }
        }

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

            modal.classList.remove('tw-hidden');
            modal.style.display = 'flex';
        }

        function closeEditModal() {
            const modal = document.getElementById('editModal');
            modal.classList.add('tw-hidden');
            modal.style.display = 'none';
        }
    </script>
@endsection
