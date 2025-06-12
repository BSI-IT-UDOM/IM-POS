<div id="popupSaleDetail" class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center hidden z-20">
    <div class="bg-white rounded-lg shadow-lg max-w-5xl w-full mx-4 max-h-screen overflow-y-auto">
        <div class="bg-gradient-to-b from-blue-500 to-blue-400 rounded-t-lg px-6 py-4">
            <h2 class="text-2xl font-bold text-white mb-2 sm:text-2xl">NEW SALES DETAIL</h2>
        </div>
        <form id="createOrderForm" class="p-6 sm:p-6" method="POST" action="{{ route('sales.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-wrap -mx-2 mb-4">     
                <div class="flex flex-col items-center w-full sm:w-1/2 md:w-1/5 px-2 mb-4">
                    <label for="selectnum" class="block text-lg sm:text-sm font-medium text-gray-900 mb-1">QTY OF SALES </label>
                    <select id="selectnum" name="selectnum" class="text-center border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="0" disabled selected>-- QOM --</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
            </div>
            <h3 class="w-full text-xl font-bold text-gray-800 mb-2">SALES LIST</h3>
            <div class="w-full h-0.5 bg-bsicolor rounded-sm mb-4"></div>
            <div id="itemsContainer" class="flex flex-wrap -mx-2 mb-2">
                <!-- Material rows will be appended here -->
            </div>
            <div class="w-full flex justify-start mb-4 space-x-1">
                <button type="button" id="subtractRowBtn" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-4 rounded focus:outline-none focus:ring-2 focus:ring-red-400 hidden"><i class="fas fa-minus-circle"></i></button>
                <button type="button" id="addMoreRowBtn" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-4 rounded focus:outline-none focus:ring-2 focus:ring-green-400 hidden"><i class="fas fa-plus-circle"></i></button>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-400 mr-2">SAVE</button>
                <button type="button" id="closeSalesPopup" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-gray-400">CANCEL</button>
            </div>
        </form>
    </div>
</div>

<script src="assets/js/selectSearch.js"></script>
<script>
document.getElementById('selectnum').addEventListener('change', function() {
    var itemsContainer = document.getElementById('itemsContainer');
    itemsContainer.innerHTML = '';
    var selectedValue = parseInt(this.value);
    if (selectedValue > 0) {
        document.getElementById('addMoreRowBtn').classList.remove('hidden');
        document.getElementById('subtractRowBtn').classList.remove('hidden');
    } else {
        document.getElementById('addMoreRowBtn').classList.add('hidden');
        document.getElementById('subtractRowBtn').classList.add('hidden');
    }
    for (var i = 0; i < selectedValue; i++) {
        addItemRow(i + 1);
    }
});

document.getElementById('addMoreRowBtn').addEventListener('click', function() {
    var itemsContainer = document.getElementById('itemsContainer');
    var currentRowCount = itemsContainer.children.length;
    addItemRow(currentRowCount + 1);
});

document.getElementById('subtractRowBtn').addEventListener('click', function() {
    var itemsContainer = document.getElementById('itemsContainer');
    if (itemsContainer.children.length > 0) {
        itemsContainer.removeChild(itemsContainer.lastElementChild);
        document.getElementById('selectnum').value = itemsContainer.children.length;
    }
});

function addItemRow(index) {
    var today = new Date().toISOString().split('T')[0];
    var itemRow = `
        <div class="item-row w-full flex">
            <div class="flex flex-col items-center w-full sm:w-1/5 px-2 mb-6">
                <label for="inputSelectMenu${index}" class="block text-lg sm:text-sm font-medium text-gray-900 mb-1">MENU</label>
                <select id="inputSelectMenu${index}" name="inputSelectMenu${index}" class="text-center text-lg sm:text-sm font-medium border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="handleSelect(event)" required>
                <option value="" disabled selected>-- MENU --</option>
                    @foreach ($menuDetail as $data)
                    <option value="{{ $data->Menu_id }}">
                        {{ $data->Menu->Menu_name_eng }}
                    </option>
                    @endforeach  
                    
                </select>
            </div>
            <div class="flex flex-col items-center w-full sm:w-1/5 px-2 mb-8">
                <label for="inputSelectAddons${index}" class="block text-lg sm:text-sm font-medium text-gray-900 mb-1">ADDONS</label>
                <select id="inputSelectAddons${index}" name="inputSelectAddons${index}" class="text-center text-lg sm:text-sm font-medium border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="handleSelect(event)" required>
                    <option value="" disabled selected>-- ADDONS --</option>
                    @foreach ($addOns as $data)
                    <option value="{{ $data->Addons_id }}">
                        {{ $data->Addons_name }}
                    </option>
                    @endforeach    
                </select>
            </div>
            <div class="flex flex-col items-center w-full sm:w-1/5 px-2 mb-8">
                <label for="inputSelectSize${index}" class="block text-lg sm:text-sm font-medium text-gray-900 mb-1">SIZE</label>
                <select id="inputSelectSize${index}" name="inputSelectSize${index}" class="text-center text-lg sm:text-sm font-medium border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="handleSelect(event)" required>
                    <option value="" disabled selected>-- SIZE --</option>
                    @foreach ($size as $data)
                    <option value="{{ $data->Size_id }}">
                        {{ $data->Size_name }}
                    </option>
                    @endforeach    
                </select>
            </div>
            <div class="flex flex-col items-center w-full sm:w-1/5 px-2 mb-8">
                <label for="qty${index}" class="block text-lg sm:text-sm font-medium text-gray-900 mb-1">QTY</label>
                <input type="number" id="qty${index}" name="qty${index}" class="text-center border border-gray-300 rounded-md px-3 py-1 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" oninput="updateTotalPrice()">
            </div>
            <div class="flex flex-col items-center w-full sm:w-1/5 px-2 mb-8">
                <label for="price${index}" class="block text-lg sm:text-sm font-medium text-gray-900 mb-1">PRICE</label>
                <input type="number" id="price${index}" name="price${index}" class="text-center border border-gray-300 rounded-md px-3 py-1 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" step="any" oninput="updateTotalPrice()">
            </div>
            <div class="flex flex-col items-center w-full sm:w-1/5 px-2 mb-8">
                <label for="inputSelectCurrency${index}" class="block text-lg sm:text-sm font-medium text-gray-900 mb-1">CURRENCY</label>
                <select id="inputSelectCurrency${index}" name="inputSelectCurrency${index}" class="text-center text-lg sm:text-sm font-medium border border-gray-300 rounded-md px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="handleSelect(event)" required>
                    
                    @foreach ($currency as $data)
                    <option value="{{ $data->Currency_id }}">
                        {{ $data->Currency_alias }}
                    </option>
                    @endforeach    
                </select>
            </div>
            <div class="flex flex-col items-center w-full sm:w-1/5 px-2 mb-8">
                <label for="sale_date${index}" class="block text-lg sm:text-sm font-medium text-gray-900 mb-1"> DATE</label>
                <input type="date" id="sale_date${index}" name="sale_date${index}" class="text-center border border-gray-300 rounded-md px-3 py-1 w-full focus:outline-none focus:ring-2 focus:ring-blue-500" value="${today}">
            </div>
        </div>
    `;
    document.getElementById('itemsContainer').insertAdjacentHTML('beforeend', itemRow);
}

document.getElementById('closeSalesPopup').addEventListener('click', function() {
    document.getElementById('popupSaleDetail').classList.add('hidden');
    document.getElementById('createOrderForm').reset();
    
    const invalidFields = document.querySelectorAll('.is-invalid');
    invalidFields.forEach(field => field.classList.remove('is-invalid'));
    const errorMessages = document.querySelectorAll('.invalid-feedback');
    errorMessages.forEach(message => message.textContent = '');
    location.reload();
});
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("itemsContainer").addEventListener("change", function (event) {
        if (event.target && event.target.matches("select[id^='inputSelectMenu']")) {
            let selectedMenuId = event.target.value;
            let index = event.target.id.replace("inputSelectMenu", "");
            let priceField = document.getElementById(`price${index}`);

            if (selectedMenuId) {
                fetch(`/get-menu-price/${selectedMenuId}`)
                    .then(response => response.json())
                    .then(data => {
                        priceField.value = data.price;
                    })
                    .catch(error => console.error("Error fetching price:", error));
            }
        }
    });
});

</script>
