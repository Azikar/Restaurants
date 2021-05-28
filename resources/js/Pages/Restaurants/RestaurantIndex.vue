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
                    <div class="container">
                        <div class="row">
                            <div class="col-sm">
                                Name
                            </div>
                            <div class="col-sm">
                                Tables count
                            </div>
                            <div class="col-sm">
                                Actions
                            </div>
                        </div>
                        <template v-for="restaurant in restaurants">
                            <Restaurant :id="restaurant.id" :name="restaurant.name" :tables-count="restaurant.tables_count"/>
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
import Restaurant from "@/Pages/Restaurants/Restaurant";

export default {
    components: {
        AppLayout,
        Welcome,
        Restaurant
    },
    data() {
        return {
            restaurants: [],
        }
    },
    created() {
        this.fetch();
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
