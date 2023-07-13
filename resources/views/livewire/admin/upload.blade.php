<div>
    <div class="border p-2">
        <h1>Applicants</h1>
        <input type="file" wire:model="applicants" />
        <x-button label="Upload" icon="upload" dark sm wire:click="uploadApplicants" spinner="uploadApplicants"/>
    </div>
    <div class="border p-2">
        <h1>Applicants ISULAN</h1>
        <input type="file" wire:model="applicants_isulan" />
        <x-button label="Upload" icon="upload" dark sm wire:click="uploadApplicantsIsulan" spinner="uploadApplicantsIsulan"/>
    </div>
    <div class="border p-2">
        <h1>Applicants ACCESS</h1>
        <input type="file" wire:model="applicants_access" />
        <x-button label="Upload" icon="upload" dark sm wire:click="uploadApplicantsAccess" spinner="uploadApplicantsAccess"/>
    </div>
</div>
