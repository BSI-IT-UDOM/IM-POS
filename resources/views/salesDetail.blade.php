@extends('layouts.app-nav')

@section('content')

<div class="flex flex-col">
    <div class="bg-background flex flex-col items-center flex-grow px-4 md:px-0 mt-2">
        <div class="flex flex-col md:flex-row justify-between items-center w-full md:w-4/5">
            <a href="#" id="SaleDetail" class="bg-primary text-primary-foreground py-1 px-8 rounded-lg md:mb-3 sm:mb-2">CREATE</a>
            <div class="relative flex w-full md:w-auto">
                <form id="searchForm" method="GET" class="w-full md:w-auto flex items-center">
                    <input id="searchInput" type="text" name="search" placeholder="Search..." class="border border-input rounded-full py-1 px-4 pl-10 w-full md:w-auto focus:outline-none focus:ring-2 focus:ring-primary" />
                    <button type="submit" class="bg-gray-200 rounded-full py-1 px-4 absolute right-0 top-0 mt-1 mr-2 flex items-center justify-center">
                        <i class="fas fa-search text-gray-500"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="w-full md:w-4/5 border-2 border-bsicolor p-2 font-times">
            <div class="overflow-x-auto">
                <h4 class="text-center font-bold pb-4 text-lg"><u>SALES DETAIL</u></h4>
                <table class="min-w-full bg-white border-collapse">
                    <thead>
                        <tr class="bg-primary text-primary-foreground text-lg">
                            <th class="py-4 px-4 border border-white">NO.</th>
                            <th class="py-4 px-4 border border-white">MENU NAME</th>
                            <th class="py-4 px-4 border border-white">QTY</th>
                            <th class="py-4 px-4 border border-white">PRICE</th>
                            <th class="py-4 px-4 border border-white">Currency</th>
                            <th class="py-4 px-4 border border-white">DATE</th>
                        </tr>
                    </thead>
                    <tbody id="inventoryTableBody">
                        @foreach ($report as $data)
                        <tr class="{{ $loop->index % 2 === 0 ? 'bg-zinc-200' : 'bg-zinc-300' }} text-base {{ $loop->first ? 'border-t-4' : '' }} text-center border-white">
                            <td class="py-3 px-4 border border-white">{{ $data->ID }}</td>
                            <td class="py-3 px-4 border border-white">{{ $data->Menu_Name}}</td>
                            <td class="py-3 px-4 border border-white">{{ $data->Qty}}</td>
                            <td class="py-3 px-4 border border-white">{{ $data->Price }}</td>
                            <td class="py-3 px-4 border border-white">{{$data->Currency}}</td>
                            <td class="py-3 px-4 border border-white">{{$data->Sale_date}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Include the popup form -->
    @include('popups.create-sales-detail')
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // $(document).ready(function () {
    //     $('#searchInput').on('keyup', function () {
    //         var searchValue = $(this).val();

    //         $.ajax({
    //             url: "{{ route('expenses.search') }}", 
    //             method: "GET",
    //             data: { search: searchValue },
    //             success: function (response) {
    //                 $('#inventoryTableBody').html(response.html);
    //             }
    //         });
    //     });
    // });

    const createButton = document.getElementById('SaleDetail');
    const popupForm = document.getElementById('popupSaleDetail');

    createButton.addEventListener('click', () => {
        popupForm.classList.remove('hidden');
    });
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            popupForm.classList.remove('hidden');
        });
    @endif
</script>

@endsection
