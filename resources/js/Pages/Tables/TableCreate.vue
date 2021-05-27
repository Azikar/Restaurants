<template>
    <div>
        <jet-form-section @submitted="post">
            <template #title>
                Create restaurant
            </template>
            <template #form>
                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="table" value="Restaurant name" />
                    <jet-input id="table" type="text" class="mt-1 block w-full" v-model="form.table_size" ref="current_password" autocomplete="current-password" />
                </div>
            </template>

            <template #actions>
                <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                    Saved.
                </jet-action-message>

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

import { useForm } from '@inertiajs/inertia-vue3'

export default {
    components: {
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
            console.log(Ziggy.routes["create-table-web"])

            axios.post( '/' + Ziggy.routes["create-table-web"].uri,
                // this.form
                {
                    table_size: this.form.table_size,
                    restaurant_id: this.restaurantId
                }
            ).then((response) => {
                location.reload();
            }).catch((error) => {
                this.errors = error.response.data.errors
            });
        }
    }
}
</script>
<style>

</style>
