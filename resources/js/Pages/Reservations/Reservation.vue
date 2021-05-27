<template>
    <div>
        <contacts ref="contactsModal" :contacts="reservation.contacts"/>
        <div class="row">
            <div v-if='typeof reservation.id !== undefined && reservation.id !== null' class="col-sm">
                {{reservation.id}}
            </div>
            <div v-if='typeof reservation.client_name !== undefined && reservation.client_name !== null' class="col-sm">
                {{reservation.client_name}}
            </div>
            <div v-if='typeof reservation.table_id !== undefined && reservation.table_id !== null' class="col-sm">
                {{reservation.table_id}}
            </div>
            <div v-if='typeof reservation.start_at !== undefined && reservation.start_at !== null' class="col-sm">
                {{reservation.start_at}}
            </div>
            <div v-if='typeof reservation.end_at !== undefined && reservation.end_at !== null' class="col-sm">
                {{reservation.end_at}}
            </div>
            <div class="col-sm">
                <jet-button @click="getParticipants()">View participants</jet-button>
            </div>
        </div>
    </div>
</template>

<script>
import JetActionMessage from '@/Jetstream/ActionMessage'
import JetButton from '@/Jetstream/Button'
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'

import { useForm } from '@inertiajs/inertia-vue3'
import Button from "../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Button";
import TableCreate from "@/Pages/Tables/TableCreate";
import Contacts from "@/Pages/Contacts/Contacts";

export default {
    components: {
        Contacts,
        TableCreate,
        Button,
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
    },
    props: {
        reservation: {
            type: Object,
            required: true,
        },
    },
    // data() {
    //     return {
    //         creating: false,
    //     }
    // },
    computed: {
        // tablesUrl() {
        //     return Ziggy.route('tables-index', {restaurant_id: });
        // },
        // tablesUrl() {
        //     // Ziggy.route()
        //     // console.log(Ziggy.routes['tables-index'].)
        //     // return Ziggy.route('tables-index', {restaurant_id: this.id});
        //     return route('tables-index', this.id);
        // },
        // reservationsUrl() {
        //     return Ziggy.routes["create-restaurant-web"].uri;
        // }
    },
    methods: {
        getParticipants() {
            this.$refs.contactsModal.open();
        }
    }
}
</script>
<style>

</style>
