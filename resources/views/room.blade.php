@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mt-4">Kambarių Valdymas</h1>

        @if(session('success'))
            <div class="alert alert-success mt-2">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mt-2">
                {{ session('error') }}
            </div>
        @endif

        <!-- Automatinis paskirstymas grupei -->
        <div class="card mt-4">
            <div class="card-header" style="cursor: pointer;" onclick="toggleSection('allocationSection')">
                Automatinis kambarių paskirstymas grupei
            </div>
            <div id="allocationSection" class="card-body" style="display: none;">
                <form method="POST" action="{{ route('rooms.propose-allocate-group') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="total_people" class="form-label">Žmonių skaičius</label>
                        <input type="number" name="total_people" id="total_people" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="rooms_count" class="form-label">Kambarių skaičius</label>
                        <input type="number" name="rooms_count" id="rooms_count" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="desired_type" class="form-label">Pageidaujamas kambario tipas (nebūtina)</label>
                        <input type="text" name="desired_type" id="desired_type" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Paskirstyti</button>
                </form>
            </div>
        </div>

        @if(isset($proposed_rooms))
            <div class="card mt-4">
                <div class="card-header">
                    Siūlomi kambariai
                </div>
                <div class="card-body">
                    <p>Ar sutinkate su šiuo kambarių paskirstymu?</p>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Kambario Numeris</th>
                            <th>Tipas</th>
                            <th>Talpa</th>
                            <th>Kaina už Nakvynę</th>
                            <th>Vaizdas į Jūrą</th>
                            <th>Aukštas</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($proposed_rooms as $room)
                            <tr>
                                <td>{{ $room->kambario_nr }}</td>
                                <td>{{ $room->tipas }}</td>
                                <td>{{ $room->capacity }}</td>
                                <td>{{ number_format($room->kaina_nakciai, 2) }} EUR</td>
                                <td>{{ $room->vaizdas_i_jura ? 'Taip' : 'Ne' }}</td>
                                <td>{{ $room->aukstas }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <form method="POST" action="{{ route('rooms.confirm-allocate-group') }}">
                        @csrf
                        <button type="submit" class="btn btn-success">Patvirtinti ir rezervuoti</button>
                        <a href="{{ route('rooms.index') }}" class="btn btn-secondary">Atšaukti</a>
                    </form>
                </div>
            </div>
        @endif

        @if(session('allocated_rooms'))
            <div class="alert alert-info mt-3">
                Paskirti kambariai: {{ implode(', ', session('allocated_rooms')) }}
            </div>
        @endif

        <!-- Pridėti naują kambarį -->
        <div class="card mt-4">
            <div class="card-header" style="cursor: pointer;" onclick="toggleSection('addRoomSection')">
                Pridėti Naują Kambarį
            </div>
            <div id="addRoomSection" class="card-body" style="display: none;">
                <form method="POST" action="{{ route('rooms.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="kambario_nr" class="form-label">Kambario Numeris</label>
                        <input type="text" name="kambario_nr" id="kambario_nr" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="tipas" class="form-label">Tipas</label>
                        <input type="text" name="tipas" id="tipas" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="capacity" class="form-label">Talpa</label>
                        <input type="number" name="capacity" id="capacity" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="kaina_nakciai" class="form-label">Kaina už Nakvynę</label>
                        <input type="text" name="kaina_nakciai" id="kaina_nakciai" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="available" class="form-label">Pasiekiamumas</label>
                        <select name="available" id="available" class="form-select">
                            <option value="1">Laisvas</option>
                            <option value="0">Užimtas</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="aukstas" class="form-label">Aukštas</label>
                        <input type="number" name="aukstas" id="aukstas" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="vaizdas_i_jura" class="form-label">Vaizdas į Jūrą</label>
                        <select name="vaizdas_i_jura" id="vaizdas_i_jura" class="form-select">
                            <option value="0">Be Vaizdo į Jūrą</option>
                            <option value="1">Vaizdas į Jūrą</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Pridėti Kambarį</button>
                </form>
            </div>
        </div>

        <!-- Redaguoti Kambarį Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editRoomForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Redaguoti Kambarį</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="edit_tipas" class="form-label">Tipas</label>
                                <input type="text" name="tipas" id="edit_tipas" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_capacity" class="form-label">Talpa</label>
                                <input type="number" name="capacity" id="edit_capacity" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_kaina_nakciai" class="form-label">Kaina už Nakvynę</label>
                                <input type="text" name="kaina_nakciai" id="edit_kaina_nakciai" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_available" class="form-label">Pasiekiamumas</label>
                                <select name="available" id="edit_available" class="form-select">
                                    <option value="1">Laisvas</option>
                                    <option value="0">Užimtas</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="edit_aukstas" class="form-label">Aukštas</label>
                                <input type="number" name="aukstas" id="edit_aukstas" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_vaizdas_i_jura" class="form-label">Vaizdas į Jūrą</label>
                                <select name="vaizdas_i_jura" id="edit_vaizdas_i_jura" class="form-select">
                                    <option value="0">Ne</option>
                                    <option value="1">Taip</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Atšaukti</button>
                            <button type="submit" class="btn btn-primary">Išsaugoti</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Kambarių Sąrašas -->
        <div class="card mt-4">
            <div class="card-header">Kambarių Sąrašas</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Kambario Numeris</th>
                        <th>Tipas</th>
                        <th>Talpa</th>
                        <th>Kaina už Nakvynę</th>
                        <th>Laisvas</th>
                        <th>Aukštas</th>
                        <th>Vaizdas į Jūrą</th>
                        <th>Veiksmai</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($kambariai as $kambarys)
                        <tr @if(!$kambarys->available) class="table-danger" @endif>
                            <td>{{ $kambarys->kambario_nr }}</td>
                            <td>{{ $kambarys->tipas }}</td>
                            <td>{{ $kambarys->capacity }}</td>
                            <td>{{ number_format($kambarys->kaina_nakciai, 2) }} EUR</td>
                            <td>{{ $kambarys->available ? 'Taip' : 'Ne' }}</td>
                            <td>{{ $kambarys->aukstas }}</td>
                            <td>{{ $kambarys->vaizdas_i_jura ? 'Taip' : 'Ne' }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="openEditModal({{ $kambarys->kambario_id }}, '{{ addslashes($kambarys->tipas) }}', {{ $kambarys->capacity }}, {{ $kambarys->kaina_nakciai }}, {{ $kambarys->available }}, {{ $kambarys->aukstas }}, {{ $kambarys->vaizdas_i_jura }})">Redaguoti</button>
                                <form action="{{ route('rooms.destroy', $kambarys->kambario_id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Ar tikrai norite ištrinti šį kambarį?')">Ištrinti</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Nėra kambarių</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Modal Script -->
    <script>
        function toggleSection(sectionId) {
            const section = document.getElementById(sectionId);
            if (section.style.display === 'none' || section.style.display === '') {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        }

        function openEditModal(id, tipas, capacity, kaina, available, aukstas, vaizdas) {
            const form = document.getElementById('editRoomForm');
            form.action = `/rooms/${id}`;
            form.querySelector('#edit_tipas').value = tipas;
            form.querySelector('#edit_capacity').value = capacity;
            form.querySelector('#edit_kaina_nakciai').value = kaina;
            form.querySelector('#edit_available').value = available;
            form.querySelector('#edit_aukstas').value = aukstas;
            form.querySelector('#edit_vaizdas_i_jura').value = vaizdas;

            const editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        }
    </script>
@endsection
