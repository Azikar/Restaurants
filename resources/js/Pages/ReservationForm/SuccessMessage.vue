<template>
    <dialog-modal @close=close() :show="show">
        <template v-slot:content>
            {{message}}
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
        message: {
            type: String,
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
