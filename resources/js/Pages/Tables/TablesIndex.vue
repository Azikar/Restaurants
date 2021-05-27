<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <button v-if="!creating" @click="creating = !creating">Add new</button>
                    <button v-else @click="creating = !creating">Cancel</button>
                    <table-create v-if="creating" :restaurant-id="restaurantId" />
                    <div class="container">
                        <div class="row">
                            <div class="col-sm">
                                Table id
                            </div>
                            <div class="col-sm">
                                Table size
                            </div>
                        </div>
<!--                        {{tables}}-->
                        <template v-for="table in tables">
                            <Table :id="table.id" :table-size="table.table_size"/>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Welcome from '@/Jetstream/Welcome'
import RestourantCreate from "@/Pages/Restaurants/RestourantCreate";
import Restaurant from "@/Pages/Restaurants/Restaurant";
import Table from "@/Pages/Tables/Table";
import TableCreate from "@/Pages/Tables/TableCreate";

export default {
    components: {
        TableCreate,
        Table,
        RestourantCreate,
        AppLayout,
        Welcome,
        Restaurant
    },
    props: {
        tables: {
            type: Object,
            required: true,
        },
        restaurantId: {
            type:Number,
            required: true,
        }
    },
    created() {
        // this.fetch();
    },
    data() {
        return {
            creating: false,
        }
    },
    methods: {
        fetch() {
            axios.get(Ziggy.routes["get-restaurants-list"].uri).then((response) => {
                // console.log(response);
                this.restaurants = response.data.data;
                console.log(this.restaurants);
            }).catch((error) => {
                // console.log(error.response.data );
                // this.errors = error.response.data.errors

                // $('.newsLetterButton').removeProp('disabled');
            });
        }
    }
}
</script>
