<div>
    <div class="border p-2">
        <h1>Applicants</h1>
        <input type="file" wire:model="applicants" />
        <x-button label="Upload" icon="upload" dark sm wire:click="uploadApplicants" spinner="uploadApplicants"/>
    </div>
</div>
