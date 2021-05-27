<template>
    <div>
        <jet-form-section @submitted="post">
        <template #title>
            Create restaurant
        </template>
        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="current_password" value="Restaurant name" />
                <jet-input id="current_password" type="text" class="mt-1 block w-full" v-model="form.name" ref="current_password" autocomplete="current-password" />
<!--                <jet-input-error :message="form.errors.name" class="mt-2" />-->
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="password" value="Maximum people" />
                <jet-input id="password" type="text" class="mt-1 block w-full" v-model="form.max_people" ref="password" autocomplete="new-password" />
<!--                <jet-input-error :message="form.errors.max_people" class="mt-2" />-->
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="password_confirmation" value="Tables number" />
                <jet-input id="password_confirmation" type="text" class="mt-1 block w-full" v-model="form.tables_count" autocomplete="new-password" />
<!--                <jet-input-error :message="form.errors.tables_count" class="mt-2" />-->
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
    data() {
        return {
            form: {
                name: '',
                max_people: '',
                tables_count: '',
            },
            errors : {
                name : [],
                max_people : [],
                tables_count : [],
            },
        }
    },
    methods: {
         post() {
                axios.post(Ziggy.routes["create-restaurant-web"].uri,
                    this.form
                ).then((response) => {
                    // console.log(response);
                }).catch((error) => {
                    console.log(error.response.data );
                    this.errors = error.response.data.errors

                    // $('.newsLetterButton').removeProp('disabled');
                });
            }
    }

}
</script>
<style>

</style>
