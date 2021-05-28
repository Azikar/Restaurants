<template>
    <dialog-modal @close=close() :show="show">
        <template v-slot:content>
            <template v-for="error in errors">
                <template v-for="message in error">
                    <div class="col-sm">
                        {{message}}
                    </div>
                </template>
            </template>
        </template>
    </dialog-modal>
</template>

<script>
import Modal from "../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/Modal";
import DialogModal from "../../../../vendor/laravel/jetstream/stubs/inertia/resources/js/Jetstream/DialogModal";

export default {
    components: {
        DialogModal,
        Modal,
    },
    props: {
        errors: {
            type: Array,
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
            console.log(this.contacts);
            this.show = true;
        },
        close() {
            this.show = false;
        }
    }
}
</script>
