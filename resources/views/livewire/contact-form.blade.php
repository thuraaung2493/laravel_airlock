<div>
    <form wire:submit.prevent="submit">
        <input type="text" wire:model="name">
        @error('name')
            <span>{{ $message }}</span>
        @enderror

        <input type="text" wire:model="email">
        @error('email')
            <span>{{ $message }}</span>
        @enderror

        <button type="submit">Save Contact</button>
    </form>
</div>
