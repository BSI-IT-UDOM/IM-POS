<div id="MapMenuINGRPopup" class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center hidden z-60">
    <div class="bg-white rounded-lg shadow-lg max-w-xl w-full max-h-screen overflow-y-auto">
        <div class="bg-gradient-to-b from-blue-500 to-blue-400 rounded-t-lg px-6 py-4">
            <h2 class="text-2xl font-bold text-white mb-2">NEW BUILD OF MATERIAL</h2>
        </div>
        <form id="MapMenuForm" action="{{ route('createIngredient') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            <div class="mb-4">
                <label for="Menu_id" class="block text-sm font-medium text-gray-900 mb-1">MENU NAME</label>
                <select name="Menu_id" id="Menu_id" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('Menu_id') is-invalid @enderror" onchange="popupMenu()">
                    <option value="" disabled selected>-- MENUS LIST --</option>
                    <option value="createMenu">++ NEW MENU ++</option>
                    @foreach ($dropdownMenu as $data)
                        <option value="{{ $data->Menu_id }}" {{ old('Menu_id') == $data->Menu_id ? 'selected' : '' }}>
                            {{ $data->Menu_name_eng }}
                        </option>
                    @endforeach
                </select>
                @error('Menu_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div id="ingredientFields">
                <div class="mb-4 ingredient-field">
                    <label for="IIQ_id" class="block text-sm font-medium text-gray-900 mb-1">INGREDIENTS</label>
                    <select id="IIQ_id" name="IIQ_id[]" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 @error('IIQ_id') is-invalid @enderror">
                        <option value="" disabled selected>-- INGREDIENTS LIST --</option>
                        <option value="createINGR">++ NEW INGREDIENTS ++</option>
                        @foreach ($ingredientQty as $data)
                            <option value="{{ $data->IIQ_id }}" {{ old('IIQ_id') == $data->IIQ_id ? 'selected' : '' }}>
                                {{ $data->IIQ_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('IIQ_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <button type="button" id="addIngredientField" class="bg-green-500 text-white px-4 py-2 rounded-md focus:outline-none mb-4">+ ADD MORE INGREDIENT +</button>
            <div class="text-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">SAVE</button>
                <button type="button" id="closeMapMenuINGRPopup" class="bg-gray-300 hover:bg-gray-400 text-gray-900 px-4 py-2 rounded-md ml-2 focus:outline-none">CANCEL</button>
            </div>

        </form>
    </div>
    @include('popups.create-menu-for-pos')
    @include('popups.create-ingredient')
</div>
<script>
    function popupMenu() {
        var selectedValue = document.getElementById('Menu_id');
        // var text = selectedValue.options[selectedValue.selectedIndex].text;
        console.log(selectedValue.value);
        if (selectedValue === 'createMenu') {   
            togglePopup('popupcreate');
        } else {
            const popup = document.getElementById('popupcreate');
            popup.classList.add('hidden');
        }
    }
    function togglePopup(popupId) {
        const popup = document.getElementById(popupId);
        popup.classList.remove('hidden');
    }
    document.getElementById('ingredientFields').addEventListener('change', function(e) {
        if (e.target && e.target.matches('select[name="IIQ_id[]"]')) {
            if (e.target.value === 'createINGR') {
                togglePopup('PopupIngredientsCreate');
                document.getElementById('MapMenuINGRPopup').classList.add('hidden');
            } else {
                const popup = document.getElementById('PopupIngredientsCreate');
                popup.classList.add('hidden');
            }
        }
    });

    document.getElementById('addIngredientField').addEventListener('click', function() {
        const container = document.getElementById('ingredientFields');
        const newField = document.createElement('div');
        newField.classList.add('mb-4', 'ingredient-field');
        newField.innerHTML = `
            <label for="IIQ_id" class="block text-sm font-medium text-gray-900 mb-1">INGREDIENTS</label>
            <div class="flex items-center space-x-4">
                <select name="IIQ_id[]" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="" disabled selected>-- INGREDIENTS LIST --</option>
                    <option value="createINGR">++ NEW INGREDIENTS ++</option>
                    @foreach ($ingredientQty as $data)
                        <option value="{{ $data->IIQ_id }}">{{ $data->IIQ_name }}</option>
                    @endforeach
                </select>
                <button type="button" class="remove-field bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-md">Delete</button>
            </div>
        `;
        container.appendChild(newField);
        const removeButtons = document.querySelectorAll('.remove-field');
        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
                this.closest('.ingredient-field').remove();
            });
        });
    });

    document.getElementById('closeMapMenuINGRPopup').addEventListener('click', function() {
        document.getElementById('MapMenuINGRPopup').classList.add('hidden');   
        document.getElementById('MapMenuINGRForm').reset();    
        const invalidFields = document.querySelectorAll('.is-invalid');
        invalidFields.forEach(field => field.classList.remove('is-invalid'));
        const errorMessages = document.querySelectorAll('.invalid-feedback');
        errorMessages.forEach(message => message.textContent = '');
    });

    if ("{{ $errors->any() }}") {
        document.getElementById('popupMaterial').classList.remove('hidden');
        const firstInvalid = document.querySelector('.is-invalid');
        if (firstInvalid) {
            firstInvalid.focus({ preventScroll: true });
        }
    }

</script>
<style>
    .is-invalid {
        border-color: #dc3545;
    }
    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

</style>



