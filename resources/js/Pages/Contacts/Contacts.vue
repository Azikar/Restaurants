<template>
    <dialog-modal @close=close() :show="show">
        <template v-slot:content>
            <div class="row">
                <div class="col-sm">
                    Id
                </div>
                <div class="col-sm">
                    Name
                </div>
                <div class="col-sm">
                    Surname
                </div>
                <div class="col-sm">
                    Phone
                </div>
                <div class="col-sm">
                    Email
                </div>
            </div>
            <template v-for="contact in contacts">
                <div class="row">
                    <div class="col-sm">
                        {{contact.id}}
                    </div>
                    <div class="col-sm">
                        {{contact.Name}}
                    </div>
                    <div class="col-sm">
                        {{contact.Surname}}
                    </div>
                    <div class="col-sm">
                        {{contact.phone}}
                    </div>
                    <div class="col-sm">
                        {{contact.email}}
                    </div>
                </div>
            </template>
        </template>
    </dialog-modal>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import Welcome from '@/Jetstream/Welcome'
import RestourantCreate from "@/Pages/Restaurants/RestourantCreate";
import Restaurant from "@/Pages/Restaurants/Restaurant";
import Modal from "../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Modal";
import DialogModal from "../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/DialogModal";

export default {
    components: {
        DialogModal,
        Modal,
        AppLayout,
        Welcome,
    },
    props: {
        contacts: {
            type: Object,
            required: true
        },
    },
    data() {
        return {
            show: false,
            // contacts: {
            //     type: object
            //
            // },
        }
    },
    created() {
        // this.fetch();
    },
    methods: {
        open() {
            console.log(this.contacts);
            this.show = true;
        },
        close() {
            this.show = false;
        }
        // fetch() {
        //     axios.get(Ziggy.routes["get-restaurants-list"].uri).then((response) => {
        //         // console.log(response);
        //         this.restaurants = response.data.data;
        //         console.log(this.restaurants);
        //     }).catch((error) => {
        //     });
        // }
    }
}
</script>
