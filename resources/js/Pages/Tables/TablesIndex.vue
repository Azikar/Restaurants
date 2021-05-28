<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="btn" v-if="!creating" @click="creating = !creating">Add new</div>
                <div class="btn" v-else @click="creating = !creating">Cancel</div>
                <table-create v-if="creating" :restaurant-id="restaurantId" />
            </div>
        </div>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm">
                                Table id
                            </div>
                            <div class="col-sm">
                                Table seats
                            </div>
                        </div>
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
        AppLayout,
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
    data() {
        return {
            creating: false,
        }
    },
    methods: {
        fetch() {
            axios.get(Ziggy.routes['get-restaurants-list'].uri).then((response) => {
                this.restaurants = response.data.data;
            }).catch((error) => {});
        }
    }
}
</script>
<style>
.btn {
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
    text-decoration: none;

    color: #333;
    background-color: #fff;
    border-color: #ccc;
}
</style>
