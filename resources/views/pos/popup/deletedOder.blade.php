<!-- Delete Order Modal -->
<div id="deleteOrderModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white p-6 rounded shadow-lg w-80">
        <h2 class="text-lg font-semibold mb-4">Enter Supervisor Password</h2>
        <form id="deleteOrderForm" method="POST" action="{{ route('order.delete') }}">
            @csrf
            <input type="hidden" name="pos_order_id" id="modal_order_id">
            <input type="password" name="password" placeholder="Supervisor Password" class="w-full border p-2 mb-4 rounded" required>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeDeleteOrderModal()" class="px-3 py-1 bg-gray-300 rounded">Cancel</button>
                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded">Delete</button>
            </div>
        </form>
    </div>
</div>
