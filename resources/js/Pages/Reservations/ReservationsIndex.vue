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
                                Id
                            </div>
                            <div class="col-sm">
                                Client name
                            </div>
                            <div class="col-sm">
                                Table id
                            </div>
                            <div class="col-sm">
                                Start at
                            </div>
                            <div class="col-sm">
                                End at
                            </div>
                            <div class="col-sm">
                                Actions
                            </div>
                        </div>
                        <!--                        {{tables}}-->
                        <template v-for="reservation in reservations">
                            <reservation :reservation="reservation"/>
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
import Reservation from "@/Pages/Reservations/Reservation";

export default {
    components: {
        Reservation,
        AppLayout,
        Welcome,
        Restaurant
    },
    props: {
        reservations: {
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
