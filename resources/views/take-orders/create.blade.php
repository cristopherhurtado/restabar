<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Toma de pedidos') }}
        </h2>
    </x-slot>

    <div class="pt-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <select onchange="window.location.href = '/orders/take/tables/' + this.value" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <option {{ $selectedTable->id == null ? 'selected' : ''}}>Seleccione Mesa</option>
            @foreach ($tables as $table)
                <option value="{{ $table->id }}" {{ $selectedTable->id == $table->id ? 'selected' : '' }}>{{ $table->name }}</option>
            @endforeach
        </select>
    </div>

    <div x-data="takeOrders">
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">  
                        <div class="grid grid-cols-6 gap-5">
                            <template x-for="entry in menuEntries">
                                <div class="p-5 bg-indigo-400 rounded shadow-md">
                                    <div class="font-bold" x-text="entry.name"></div>
                                    <div class="text-sm text-gray-700" x-text="entry.description"></div>
                                    <div x-text="'$' + entry.price/100"></div>
                                    <div>
                                        <template x-if="!isMenuEntryInSelectedTable(entry)">
                                            <button @click="addToOrders(entry, 1)" class="bg-blue-950 text-while px-5 rounded">Añadir</button>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="space-y-2">
                            <div class="grid grid-cols-5 font-bold">
                                <div>Descripción</div>
                                <div class="text-center">Precio</div>
                                <div class="text-center">Cantidad</div>
                                <div class="text-center">Notas</div>
                                <div class="text-center">Acciones</div>
                            </div>

                            <template x-for="order in selectedTable.orders" :key="order.id">
                                <div class="grid grid-cols-5">
                                    <div x-text="order.menu_entry.name"></div>
                                    <div class="text-center" x-text="'$' + order.menu_entry.price/100"></div>
                                    <div class="text-center" x-text="order.quantity"></div>
                                    <div>
                                        <textarea x-model="order.notes" class="text-gray-900"></textarea>
                                        <button @click="updateOrder(order, {notes: order.notes})" class="bg-blue-950 text-while px-5 rounded">Actualizar</button>
                                    </div>
                                    <div class="text-center">
                                        <button @click="updateOrder(order, {quantity: order.quantity + 1})" class="bg-blue-950 text-while px-5 rounded">+</button>
                                        <button  @click="updateOrder(order, {quantity: order.quantity - 1})" class="bg-blue-950 text-while px-5 rounded">-</button>
                                    </div>
                                </div>
                            </template>  
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-1">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <button @click="clearTable" class="bg-red-300 text-while px-5 rounded">Cerrar mesa</button>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('takeOrders', () => ({

                menuEntries: {!! $menuEntries->toJson() !!},

                selectedTable: {!! $selectedTable->toJson() !!},

                isMenuEntryInSelectedTable(entry) {
                    return this.selectedTable.orders.find(order => order.menu_entry.id === entry.id);
                },

                updateOrder(order, data) {
                    axios.put('/orders/' + order.id, data)
                    .then(response => {
                        order.quantity = response.data.quantity;
                        order.notes = response.data.notes;      
                        if(order.quantity <= 0) {
                            let index = this.selectedTable.orders.findIndex(order => order.id === response.data.id);
                            this.selectedTable.orders.splice(index, 1);
                        }
                    })
                },

                addToOrders(entry, quantity) {
                    axios.post('/orders/take/tables/' + this.selectedTable.id, {
                        menu_entry_id: entry.id,  
                        quantity: quantity,
                    })
                    .then(response => {
                        this.selectedTable.orders.push(response.data);
                    })
                },

                clearTable() {
                    axios.delete('/orders/tables/' + this.selectedTable.id)
                        .then(response => {
                            this.selectedTable.orders = [];
                        })
                },

            }))
        })
    </script>
</x-app-layout>
