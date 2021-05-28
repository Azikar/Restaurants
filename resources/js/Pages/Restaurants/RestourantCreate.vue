<template>
    <div>
        <error-messages ref="error" :errors="errors"/>
        <success-message ref="success" :message="message"/>
        <jet-form-section @submitted="post">
        <template #title>
            Create restaurant
        </template>
        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="current_password" value="Restaurant name" />
                <jet-input id="current_password" type="text" class="mt-1 block w-full" v-model="form.name" ref="current_password" autocomplete="current-password" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="password" value="Maximum people" />
                <jet-input id="password" type="text" class="mt-1 block w-full" v-model="form.max_people" ref="password" autocomplete="new-password" />
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
import SuccessMessage from "@/Pages/ReservationForm/SuccessMessage";

export default {
    components: {
        SuccessMessage,
        ErrorMessages,
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
    },
    data() {
        return {
            form: {
                name: '',
                max_people: '',
            },
            errors: [],
            message: ''
        }
    },
    methods: {
         post() {
                axios.post(Ziggy.routes['create-restaurant-web'].uri,
                    this.form
                ).then((response) => {
                    this.message = 'success'
                    // this.$refs.success.open();
                    window.location.href = route('restaurants')
                }).catch((error) => {
                    this.errors = error.response.data.errors
                    this.$refs.error.open();
                });
            }
    }

}
</script>
