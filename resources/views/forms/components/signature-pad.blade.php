<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div 
        class="signature-pad-wrapper" 
        x-data="signaturePadComponent()"
        x-init="init()"
        wire:ignore
    >
        
        <div class="border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden bg-white inline-block">
            <canvas 
                x-ref="canvas" 
                class="signature-canvas" 
                width="400" 
                height="200"
                style="display: block;"
            ></canvas>
        </div>
        
        <div class="mt-3 flex gap-2">
            <button 
                type="button" 
                @click="clearSignature()"
                class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 text-sm font-medium rounded-lg transition"
            >
                Clear Signature
            </button>
        </div>
        
        <!-- Hidden input untuk menyimpan signature base64 -->
        <input 
            type="hidden" 
            x-ref="hiddenInput"
            {{ $applyStateBindingModifiers('wire:model') }}="{{ $getStatePath() }}"
        />
        
        @error($getStatePath())
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                {{ $message }}
            </p>
        @enderror
    </div>
</x-dynamic-component>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('signaturePadComponent', () => ({
            signaturePad: null,
            
            init() {
                this.initSignaturePad();
                
                // Load existing value jika ada
                const existingValue = this.$refs.hiddenInput.value;
                if (existingValue) {
                    this.loadSignature(existingValue);
                }
            },
            
            initSignaturePad() {
                const canvas = this.$refs.canvas;
                
                this.signaturePad = new SignaturePad(canvas, {
                    backgroundColor: 'rgba(255, 255, 255, 1)',
                    penColor: 'rgb(0, 0, 0)',
                    minWidth: 0.5,
                    maxWidth: 2.5,
                });
                
                // Update hidden input saat user menggambar
                this.signaturePad.addEventListener('endStroke', () => {
                    this.saveSignature();
                });
            },
            
            saveSignature() {
                if (!this.signaturePad.isEmpty()) {
                    const dataURL = this.signaturePad.toDataURL('image/png');
                    this.$refs.hiddenInput.value = dataURL;
                    this.$refs.hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
                } else {
                    this.$refs.hiddenInput.value = '';
                    this.$refs.hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
                }
            },
            
            clearSignature() {
                this.signaturePad.clear();
                this.$refs.hiddenInput.value = '';
                this.$refs.hiddenInput.dispatchEvent(new Event('input', { bubbles: true }));
            },
            
            loadSignature(dataURL) {
                if (dataURL && dataURL.length > 0) {
                    const img = new Image();
                    img.onload = () => {
                        const ctx = this.$refs.canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, this.$refs.canvas.width, this.$refs.canvas.height);
                    };
                    img.src = dataURL;
                }
            }
        }));
    });
</script>
@endpush

<style>
    .signature-canvas {
        display: block;
        cursor: crosshair;
    }
</style>  