<template>
    <div>
        <div class="row">
            <div class="col-sm">
                {{name}}
            </div>
            <div class="col-sm">
                {{tablesCount}}
            </div>
            <div class="col-sm">
                <div class="row">
                    <div class="col-sm">
                         <a :href="tablesUrl">Display tables</a>
                    </div>
                    <div class="col-sm">
                         <a :href="reservationsUrl">Display reservations</a>
                    </div>
                </div>
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

export default {
    components: {
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
        name: {
            type: String,
            required: true,
        },
        tablesCount: {
            type: Number,
            default: null,
            required: true,
        },
    },
    data() {
        return {
        }
    },
    computed: {
        tablesUrl() {
            return route('tables-index', this.id);
        },
        reservationsUrl() {
            return route('reservations-index', this.id);
        }
    },
    methods: {
        // tablesUrl(id) {
        //     console.log(Ziggy.route('tables-index', {restaurant_id: id}))
        //     return Ziggy.route('tables-index', {restaurant_id: id});
        // },
        // post() {
        //     axios.post(Ziggy.routes["create-restaurant-web"].uri,
        //         this.form
        //     ).then((response) => {
        //         // console.log(response);
        //     }).catch((error) => {
        //         console.log(error.response.data );
        //         this.errors = error.response.data.errors
        //
        //         // $('.newsLetterButton').removeProp('disabled');
        //     });
        // }
    }
}
</script>
<style>

</style>
