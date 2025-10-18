<div x-data="{ open: false }">
     <img 
        src="{{ asset($getState()) }}" 
        class="w-28 h-28 object-cover rounded cursor-pointer border"
        @click="open = true"
    />

     <div 
        x-show="open"
        x-transition
        class="fixed inset-0 bg-black/70 flex items-center justify-center z-50"
        @click.self="open = false"
    >
        <img 
            src="{{ asset($getState()) }}" 
            class="max-w-[90vw] max-h-[90vh] rounded-lg shadow-lg"
        />
    </div>
</div>
