<template>
    <div>
        <div class="row">
            <div class="col-sm">
                {{id}}
            </div>
            <div class="col-sm">
                {{tableSize}}
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

export default {
    components: {
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
        id: {
            type: Number,
            required: true,
        },
        tableSize: {
            type: Number,
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

    }
}
</script>
<style>

</style>
