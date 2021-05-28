<template>
    <dialog-modal @close=close() :show="show">
        <template v-slot:content>
            <table style="width:100%">
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Phone</th>
                    <th>Email</th>
                </tr>
                <template v-for="contact in contacts">
                <tr>
                    <td>{{contact.id}}</td>
                    <td>{{contact.Name}}</td>
                    <td>{{contact.Surname}}</td>
                    <td>{{contact.phone}}</td>
                    <td>{{contact.email}}</td>
                </tr>
                </template>
            </table>
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
        }
    },
    methods: {
        open() {
            this.show = true;
        },
        close() {
            this.show = false;
        }
    }
}
</script>
