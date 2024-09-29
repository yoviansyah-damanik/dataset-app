<div>
    <div class="row">
        <div class="col-6">
            <div class="text-center fw-bold mb-4">
                Calon {{ $candidate_callsign }}
            </div>
            <div class="mb-4">
                @if ($candidate_1_picture)
                    <img class="img-fluid mx-auto" src="{{ $candidate_1_picture->temporaryUrl() }}">
                @else
                    <img class="img-fluid mx-auto" src="{{ GeneralHelper::get_candidate_1_picture() }}">
                @endif
            </div>

            <div class="mb-4 position-relative">
                <input type="file" class="form-control @error('candidate_1_picture') is-invalid @enderror"
                    wire:model='candidate_1_picture' accept="image/*">
                @error('candidate_1_picture')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                @enderror
                <div wire:loading wire:target="candidate_1_picture">Mengunggah...</div>
            </div>

            <div class="mb-4 position-relative">
                <input type="text" class="form-control text-center @error('candidate_1_name') is-invalid @enderror"
                    placeholder="Masukkan nama Calon {{ $candidate_callsign }}..." wire:model="candidate_1_name">
                @error('candidate_1_name')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button class="btn btn-primary d-block w-100" wire:click="update_1"
                wire:loading.attr='disabled'>Simpan</button>
        </div>
        <div class="col-6">
            <div class="text-center fw-bold mb-4">
                Calon Wakil {{ $candidate_callsign }}
            </div>
            <div class="mb-4">
                @if ($candidate_2_picture)
                    <img class="img-fluid mx-auto" src="{{ $candidate_2_picture->temporaryUrl() }}">
                @else
                    <img class="img-fluid mx-auto" src="{{ GeneralHelper::get_candidate_2_picture() }}">
                @endif
            </div>

            <div class="mb-4 position-relative">
                <input type="file" class="form-control @error('candidate_2_picture') is-invalid @enderror"
                    wire:model='candidate_2_picture' accept="image/*">
                @error('candidate_2_picture')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                @enderror
                <div wire:loading wire:target="candidate_2_picture">Mengunggah...</div>
            </div>

            <div class="mb-4 position-relative">
                <input type="text" class="form-control text-center @error('candidate_2_name') is-invalid @enderror"
                    placeholder="Masukkan nama Calon {{ $candidate_callsign }}..." wire:model="candidate_2_name">
                @error('candidate_2_name')
                    <div class="invalid-tooltip">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button class="btn btn-primary d-block w-100" wire:click="update_2"
                wire:loading.attr='disabled'>Simpan</button>
        </div>
    </div>
</div>
