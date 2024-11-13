<div wire:ignore.self class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login to Vote</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if($errorMessage)
                    <div class="alert alert-danger">{{ $errorMessage }}</div>
                @endif
                <form wire:submit.prevent="authenticate">
                    <div class="mb-3">
                        <label for="registrationNumber" class="form-label">Registration Number</label>
                        <input type="text" wire:model="registrationNumber" class="form-control">
                        @error('registrationNumber') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="idNumber" class="form-label">ID Number</label>
                        <input type="text" wire:model="idNumber" class="form-control">
                        @error('idNumber') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="mobileNumber" class="form-label">Mobile Number</label>
                        <input type="text" wire:model="mobileNumber" class="form-control">
                        @error('mobileNumber') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
        </div>
    </div>
</div>
