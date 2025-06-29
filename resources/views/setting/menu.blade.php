@extends('layouts.setting')

@section('content')
<div class="bg-gray-100">
    <div class="container mx-auto p-6">
        <h1 class="text-center text-3xl font-bold mb-4">DETAIL BUILD OF MATERIAL</h1>
        <div class="relative flex w-full md:w-auto space-x-4">
            <form id="searchForm" method="GET" class="flex w-full md:w-auto relative">
                <input id="searchInput" type="text" placeholder="Search..." 
                    class="border border-gray-300 rounded-full py-2 px-4 pl-10 w-full md:w-64 focus:outline-none focus:ring-2 focus:ring-primary" 
                    required />
                <button type="submit" class="bg-gray-200 rounded-full py-2 px-4 absolute right-0 top-0 mt-1 mr-2 flex items-center justify-center" 
                    aria-label="Search">
                    <i class="fas fa-search text-gray-500"></i>
                </button>
            </form>
            <a href="#" id="createPopup" class="bg-primary text-white py-2 px-6 rounded-lg">SET UP</a>
        </div>   
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-4 mt-2">
            @foreach ($menuIngredients as $menuId => $ingredients)
            <div class="bg-white p-2 rounded-lg shadow-md flex flex-col">
                <img src="images/shop.jpg" alt="menu Image" class="w-full h-20 object-cover rounded-t-lg">
                <div class="p-2 flex-grow">
                    <h2 class="text-sm text-gray-800 mb-1 font-semibold">{{ $ingredients->first()->Menu_ENGName }}</h2>
                    <h3 class="text-sm text-gray-900 mb-2 font-semibold"><u>Ingredients</u></h3>
                    @foreach ($ingredients as $data)
                        <div class="mb-2">
                            <h3 class="text-sm text-gray-700">{{ $data->Material_ENGName . '    ' . $data->Qty . '    ' . $data->UOM}}</h3>
                        </div>
                    @endforeach
                </div>
                <div class="mt-auto flex justify-between p-2">
                    <!--<div class="relative group">-->
                    <!--    <button class="edit-ingredient-btn bg-blue-500 text-white px-3 py-1 rounded cursor-pointer transition duration-300 hover:bg-blue-600"-->
                    <!--        data-menu-id="{{ $menuId }}"-->
                    <!--        data-menu-name="{{ $ingredients->first()->Menu_ENGName }}"-->
                    <!--        data-ingredients='@json($ingredients)'>-->
                    <!--        <i class="fas fa-edit fa-sm"></i>-->
                    <!--        <span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-2 text-xs text-white bg-gray-600 px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">Edit</span>-->
                    <!--    </button>-->
                    <!--</div>-->
                    <div class="relative group">
                        <button class="add-ingredient-btn bg-green-500 text-white px-3 py-1 rounded cursor-pointer transition duration-300 hover:bg-green-600"
                            data-menu-id="{{ $menuId }}">
                            <i class="fas fa-plus-circle fa-sm"></i> 
                            <span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-2 text-xs text-white bg-gray-600 px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">Add</span>
                        </button>
                    </div>
                    <div class="relative group">
                        <button class="relative bg-blue-500 hover:bg-blue-600 active:bg-blue-500 text-white px-3 py-1 px-4 rounded-md focus:outline-none transition duration-150 ease-in-out group"
                        onclick="toggleActive(this, {{ $data->Menu_id }})"
                        onmouseover="setHover(this, true)"
                        onmouseout="setHover(this, false)"
                        style="background-color: {{ $data->status === 'Active' ? '#008000' : '#f00' }}; color: white;">
                        <i class="fas {{ $data->status === 'Active' ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                        <span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-2 text-xs text-white bg-gray-600 px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                            {{ $data->status === 'Active' ? 'Active' : 'Inactive' }}
                        </span>
                    </button>
                    </div>
                </div>                
            </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $invMenu->links() }}
        </div>
        @include('popups.add-ingredient-menu-popup')
    </div>
    @include('popups.create-ingredient-setting-popup')
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>


document.getElementById('searchForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission
    let searchQuery = document.getElementById('searchInput').value;

    fetch('/ingredient/search?search=' + encodeURIComponent(searchQuery), {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        const ingredientsContainer = document.querySelector('.grid');
        ingredientsContainer.innerHTML = '';

        // Loop through the returned ingredients and construct the HTML
        for (const [menuId, ingredients] of Object.entries(data.ingredients)) {
            ingredientsContainer.insertAdjacentHTML('beforeend', `
                <div class="bg-white p-2 rounded-lg shadow-md flex flex-col">
                    <img src="images/shop.jpg" alt="menu Image" class="w-full h-20 object-cover rounded-t-lg">
                    <div class="p-2 flex-grow">
                        <h2 class="text-sm text-gray-800 mb-1 font-semibold">${ingredients[0].Menu_ENGName}</h2>
                        <h3 class="text-sm text-gray-900 mb-2 font-semibold"><u>Ingredients</u></h3>
                        ${ingredients.map(data => `
                            <div class="mb-2">
                                <h3 class="text-sm text-gray-700">${data.Material_ENGName} ${data.Qty} ${data.UOM}</h3>
                            </div>
                        `).join('')}
                    </div>
                    <div class="mt-auto flex justify-between p-2">
                    <div class="relative group">
                        <button class="edit-ingredient-btn bg-blue-500 text-white px-3 py-1 rounded cursor-pointer transition duration-300 hover:bg-blue-600"
                            data-menu-id="{{ $menuId }}"
                            data-menu-name="{{ $ingredients->first()->Menu_ENGName }}"
                            data-ingredients='@json($ingredients)'>
                            <i class="fas fa-edit fa-sm"></i>
                            <span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-2 text-xs text-white bg-gray-600 px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">Edit</span>
                        </button>
                    </div>                    
                    <div class="relative group">
                        <button class="add-ingredient-btn bg-green-500 text-white px-3 py-1 rounded cursor-pointer transition duration-300 hover:bg-green-600"
                            data-menu-id="{{ $menuId }}">
                            <i class="fas fa-plus-circle fa-sm"></i> 
                            <span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-2 text-xs text-white bg-gray-600 px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">Add</span>
                        </button>
                    </div>
                        <button class="toggle-button px-3 py-1 rounded cursor-pointer transition duration-300" 
                            onclick="toggleActive(this)"
                            onmouseover="setHover(this, true)"
                            onmouseout="setHover(this, false)"
                            style="background-color: #008000; color: white;">
                            <i class="fas fa-toggle-on fa-sm"></i>
                            <span class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-2 text-xs text-white bg-gray-600 px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">Active</span>
                        </button>
                    </div>
                    </div>
                </div>
            `);
        }
    })
    .catch(error => console.error('Error:', error));
});


// document.addEventListener('DOMContentLoaded', () => {
//     const editIngredientPopup = document.getElementById('EditIngredientPopup');
//     const closeEditIngredientPopup = document.getElementById('closeEditIngredientPopup');

//     document.querySelectorAll('.edit-ingredient-btn').forEach(button => {
//         button.addEventListener('click', () => {
//             const menuName = button.getAttribute('data-menu-name');
//             const ingredients = JSON.parse(button.getAttribute('data-ingredients'));
//             const menuId = button.getAttribute('data-menu-id');

//             // Update the popup
//             const popupLabel = editIngredientPopup.querySelector('h2');
//             if (popupLabel) {
//                 popupLabel.textContent = ` ${menuName}`;
//             }

//             const form = editIngredientPopup.querySelector('form');
//             if (form) {
//                 form.action = `/ingredient/edit/${menuId}`;
//                 form.querySelector('input[name="Menu_id"]').value = menuId;
//             }

//             const ingredientsContainer = document.getElementById('ingredientsContainer');
//             ingredientsContainer.innerHTML = '';

//             ingredients.forEach(ingredient => {
//                 const formHTML = `
//                 <div class="mb-4">
//                     <label class="block text-md font-semibold text-gray-900 mb-1">INGREDIENT</label>
//                     <select id="IIQ_name" name="IIQ_id[]" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 mb-1" onchange="handleSelect(event)">
//                         <option value="" disabled selected>-- INGREDIENT NAME --</option>
//                         <option value="createINGR">++ CREATE NEW ++</option>
//                         ${ingredientOptions(ingredient.IIQ_id)}
//                     </select>
//                 </div>
//                 `;
                
//                 ingredientsContainer.insertAdjacentHTML('beforeend', formHTML);
//             });

//             editIngredientPopup.classList.remove('hidden');
//         });
//     });

//     closeEditIngredientPopup.addEventListener('click', () => {
//         editIngredientPopup.classList.add('hidden');
//     });
// });

// Helper function to generate options
function ingredientOptions(selectedId) {
    let options = '';
    @foreach ($ingredientQty as $data)
        options += `<option value="{{ $data->IIQ_id }}" ${selectedId === '{{ $data->IIQ_id }}' ? 'selected' : ''}>
                        {{ $data->IIQ_name }}
                    </option>`;
    @endforeach
    return options;
}

document.addEventListener('DOMContentLoaded', () => {
    const addIngredientPopup = document.getElementById('popupAddMenuIngr');
    const closeAddIngredientPopup = document.getElementById('closePopup');

    document.querySelectorAll('.add-ingredient-btn').forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            const menuId = button.getAttribute('data-menu-id');
            const menuIdInput = addIngredientPopup.querySelector('input[name="Menu_id"]');
            if (menuIdInput) {
                menuIdInput.value = menuId;
            }
            addIngredientPopup.classList.remove('hidden');
        });
    });

    closeAddIngredientPopup.addEventListener('click', () => {
        addIngredientPopup.classList.add('hidden');
    });
});
function handleSelect(event) {

var selectedValue = event.target.value;

if (selectedValue === 'createINGR') {

    togglePopup('PopupIngredientsCreate');

}

}
const createButton = document.getElementById('createPopup');
    const popupForm = document.getElementById('MapMenuINGRPopup');

    createButton.addEventListener('click', () => {
        popupForm.classList.remove('hidden');
    });
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            popupForm.classList.remove('hidden');
        });
    @endif

    function toggleActive(button, materialId) {
    const icon = button.querySelector('i');
    const currentStatus = icon.classList.contains('fa-toggle-on') ? 'Active' : 'Inactive';
    const newStatus = currentStatus === 'Active' ? 'Inactive' : 'Active';

    fetch(`/ingredient/${materialId}/toggle-status`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (newStatus === 'Active') {
                icon.classList.replace('fa-toggle-off', 'fa-toggle-on');
                button.style.backgroundColor = '#008000'; 
            } else {
                icon.classList.replace('fa-toggle-on', 'fa-toggle-off');
                button.style.backgroundColor = '#f00'; 
            }
        } else {
            alert("Unable to change status.");
        }
    })
    .catch(error => console.error('Error:', error));
}


function setHover(button, isHover) {
    const icon = button.querySelector('i');
    const statusText = button.querySelector('span');
    
    if (icon.classList.contains('fa-toggle-on')) {
        button.style.backgroundColor = isHover ? '#006400' : '#008000';
        statusText.textContent = 'Active';
    } else {
        button.style.backgroundColor = isHover ? '#a11' : '#f00';
        statusText.textContent = 'Inactive';
    }
}
</script>

@endsection