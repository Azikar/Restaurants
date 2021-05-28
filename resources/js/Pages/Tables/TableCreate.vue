<template>
    <div>
        <error-messages ref="error" :errors="errors"></error-messages>
        <jet-form-section @submitted="post">
            <template #form>
                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="table" value="Table seats" />
                    <jet-input id="table" type="text" class="mt-1 block w-full" v-model="form.table_size" ref="current_password" autocomplete="current-password" />
                </div>
            </template>
            <template #actions>
                <jet-button :class="{ 'opacity-25': form.processing }">
                    Save
                </jet-button>
            </template>
        </jet-form-section>
    </div>
</template>

<script>
import JetActionMessage from '@/Jetstream/ActionMessage'
import JetButton from '@/Jetstream/Button'
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'

import ErrorMessages from "@/Pages/ReservationForm/ErrorMessages";

export default {
    components: {
        ErrorMessages,
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
    },
    props: {
        restaurantId: {
            type: Number,
            required: true,
        },
    },
    data() {
        return {
            form: {
                table_size: null,
            },
            errors : {
                table_size : [],
            },
        }
    },
    methods: {
        post() {
            axios.post( '/' + Ziggy.routes['create-table-web'].uri,
                {
                    table_size: this.form.table_size,
                    restaurant_id: this.restaurantId
                }
            ).then((response) => {
                location.reload();
            }).catch((error) => {
                this.errors = error.response.data.errors
                this.$refs.error.open();
            });
        }
    }
}
</script>
