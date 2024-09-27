<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pedidos pendientes') }}
        </h2>
    </x-slot>
    <div x-data="kitchen">
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="space-y-2">
                            <div class="grid grid-cols-5 font-bold">
                                <div>Descripción</div>
                                <div class="text-center">Notas</div>
                                <div class="text-center">Cantidad</div>
                                <div class="text-center">Mesa</div>
                                <div class="text-center">Acciones</div>
                            </div>

                            <template x-for="order in pendingOrders" :key="order.id">
                                <div class="grid grid-cols-5">
                                    <div x-text="order.menu_entry.name"></div>
                                    <div class="text-center" x-text="order.notes"></div>
                                    <div class="text-center" x-text="order.quantity"></div>
                                    <div class="text-center" x-text="order.table.name"></div>
                                    <div class="text-center">
                                        <button @click="updateOrderToPreparing(order)" class="bg-blue-950 text-while px-5 rounded">Preparar</button>
                                    </div>
                                </div>
                            </template>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-bold text-lg text-gray-800 dark:text-gray-200 leading-tight">Ordenes en preparacion</h2>
        </div>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="space-y-2">
                            <div class="grid grid-cols-5 font-bold">
                                <div>Descripción</div>
                                <div class="text-center">Notas</div>
                                <div class="text-center">Cantidad</div>
                                <div class="text-center">Mesa</div>
                                <div class="text-center">Acciones</div>
                            </div>
                            
                            <template x-for="order in preparingOrders" :key="order.id">
                                <div class="grid grid-cols-5">
                                    <div x-text="order.menu_entry.name"></div>
                                    <div class="text-center" x-text="order.notes"></div>
                                    <div class="text-center" x-text="order.quantity"></div>
                                    <div class="text-center" x-text="order.table.name"></div>
                                    <div class="text-center">
                                        <button @click="updateOrderToCompleted(order)" class="bg-blue-950 text-while px-5 rounded">Listo</button>
                                    </div>
                                </div>
                            </template>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-bold text-lg text-gray-800 dark:text-gray-200 leading-tight">Últimos pedidos atendidos</h2>
        </div>
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="space-y-2">
                            <div class="grid grid-cols-5 font-bold">
                                <div>Descripción</div>
                                <div class="text-center">Notas</div>
                                <div class="text-center">Cantidad</div>
                                <div class="text-center">Mesa</div>
                                <div class="text-center"></div>
                            </div>
                            
                            <template x-for="order in completedOrders" :key="order.id">
                                <div class="grid grid-cols-5">
                                    <div x-text="order.menu_entry.name"></div>
                                    <div class="text-center" x-text="order.notes"></div>
                                    <div class="text-center" x-text="order.quantity"></div>
                                    <div class="text-center" x-text="order.table.name"></div>
                                    <div class="text-center">
                                        ✅
                                    </div>
                                </div>
                            </template>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('kitchen', () => ({

                init() {
                    setInterval(() => {
                        axios.get('/orders/kitchen')
                        .then(response => {
                            this.pendingOrders = response.data;
                        })
                    }, 3000);
                },
                
                pendingOrders: {!! $pendingOrders->toJson() !!},
                preparingOrders: {!! $preparingOrders->toJson() !!},
                completedOrders: {!! $completedOrders->toJson() !!},

                updateOrderToPreparing(order) {
                    this.updateStatusOrder(order, {status: this.orderStatus.Preparing})
                        .then(response => {
                             let index = this.pendingOrders.findIndex(pendingOrder => pendingOrder.id == order.id);
                            this.pendingOrders.splice(index, 1);
                            this.preparingOrders.push(response.data);
                        });
                },

                updateOrderToCompleted(order) {
                    this.updateStatusOrder(order, {status: this.orderStatus.Completed})
                        .then(response => {
                            let index = this.preparingOrders.findIndex(preparingOrder => preparingOrder.id == order.id);
                            this.preparingOrders.splice(index, 1);
                            this.completedOrders.push(response.data);
                        });
                },

                updateStatusOrder(order, data) {
                    return axios.put('/update-orders-status/' + order.id, data)
                }

            }));
        });
    </script>
</x-app-layout>
