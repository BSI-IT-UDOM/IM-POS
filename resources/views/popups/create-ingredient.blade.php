
<div id="PopupIngredientsCreate" class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center hidden z-60">
    <div class="bg-white rounded-lg shadow-lg max-w-xl w-full max-h-screen overflow-y-auto">
        <div class="bg-gradient-to-b from-blue-500 to-blue-400 rounded-t-lg px-6 py-4">
            <h2 class="text-2xl font-bold text-white mb-2">NEW INGREDIENT</h2>
        </div>
        <form id="createMenuGrForm" action="{{ route('create-menu-ingredient') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            <div class="mb-4">
                <label for="IIQ_name" class="block text-sm font-medium text-gray-900 mb-1">NAME IN ENGLISH</label>
                <input type="text" id="IIQ_name" name="IIQ_name" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('IIQ_name')
                    <span class="invalid-feedback">{{ $message }}</span>
                 @enderror
            </div>
            <div class="mb-4">
                <label for="IIQ_name_kh" class="block text-sm font-medium text-gray-900 mb-1">NAME IN KHMER</label>
                <input type="text" id="IIQ_name_kh" name="IIQ_name_kh" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('IIQ_name_kh')
                    <span class="invalid-feedback">{{ $message }}</span>
                 @enderror
            </div>
            <div class="mb-4">

                <label for="Material_id" class="block text-sm font-medium text-gray-900 mb-1">MATERIAL</label>

                <select id="Material_id" name="Material_id" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('Material_id') is-invalid @enderror">

                    <option value="" disabled selected>-- MATERIAL LIST --</option>

                    <option value="createMenu">++ NEW MATERIAL ++</option>

                    @foreach ($material as $data)

                        <option value="{{ $data->Material_id }}" {{ old('Material_id') == $data->Material_id ? 'selected' : '' }}>

                            {{ $data->Material_Engname }}

                        </option>

                    @endforeach

                </select>

                @error('Material_id')

                    <span class="invalid-feedback">{{ $message }}</span>

                @enderror

            </div>
            <div class="mb-4">

                <label for="UOM_id" class="block text-sm font-medium text-gray-900 mb-1">UOM</label>

                <select id="UOM_id" name="UOM_id" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('Menu_id') is-invalid @enderror">

                    <option value="" disabled selected>-- UOM LIST --</option>

                    @foreach ($uom as $data)

                        <option value="{{ $data->UOM_id }}" {{ old('UOM_id') == $data->UOM_id ? 'selected' : '' }}>

                            {{ $data->UOM_name }}

                        </option>

                    @endforeach

                </select>

                @error('UOM_id')

                    <span class="invalid-feedback">{{ $message }}</span>

                @enderror

            </div>
            <div class="mb-4">
                <label for="Qty" class="block text-sm font-medium text-gray-900 mb-1">QTY</label>
                <input type="number" id="Qty" name="Qty" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                @error('Qty')
                    <span class="invalid-feedback">{{ $message }}</span>
                 @enderror
            </div>
            <div class="text-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">SAVE</button>
                <button type="button" id="closeMenuGrPopup" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-4 py-2 rounded-md ml-2 focus:outline-none">CANCEL</button>
            </div>
        </form>
    </div>
</div>
<script>
    document.getElementById('closeMenuGrPopup').addEventListener('click', function() {
        document.getElementById('PopupIngredientsCreate').classList.add('hidden');
        document.getElementById('createMenuGrForm').reset();    
        const invalidFields = document.querySelectorAll('.is-invalid');
        invalidFields.forEach(field => field.classList.remove('is-invalid'));
        const errorMessages = document.querySelectorAll('.invalid-feedback');
        errorMessages.forEach(message => message.textContent = '');
    });

    // Display the popup if validation errors are present
    if ("{{ $errors->any() }}") {
        document.getElementById('PopupIngredientsCreate').classList.remove('hidden');
        const firstInvalid = document.querySelector('.is-invalid');
        if (firstInvalid) {
            firstInvalid.focus({ preventScroll: true });
        }
    }
</script>