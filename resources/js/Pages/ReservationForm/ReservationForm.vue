<template>
    <div>
        <jet-form-section @submitted="post">
            <template #form>
                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="restaurant" value="Restaurant name" />
                    <select id="restaurant"  class="block mt-1 w-full" v-model="form.restaurant">
                        <option v-for="option in restaurants" v-bind:value="option.id">
                            {{ option.name }}
                        </option>
                    </select>
                    <jet-label for="table" value="table name" />
                    <select id="table"  class="block mt-1 w-full" v-model="form.table">
                        <option v-for="option in tables" v-bind:value="option.id">
                            {{'table No: ' + option.id + ' has ' + option.table_size + ' seats'}}
                        </option>
                    </select>
                        <div>
                            <jet-label for="date" value="Date" />
                            <date-picker :disabled="(form.table === null)" @input="getDisabledHours" id="date"  v-model="date"/>
                        </div>
                    <div class="row">
                        <div>
                            <jet-label value="Pick start time" />
                            <vue-timepicker ref="start" v-model="start" :closeOnComplete="true"  :hideClearButton="true" hide-disabled-minutes hide-disabled-hours :minute-range="[0]" :format="HH" :hour-range="availableStart"/>
                        </div>
                        <div>
                            <jet-label value="Pick end time" />
                            <vue-timepicker ref="end" v-model="end" :closeOnComplete="true" :disabled="disabledEndTime" :hideClearButton="true" hide-disabled-minutes hide-disabled-hours :minute-range="[0]" :format="HH" :hour-range="availableEnd"/>
                        </div>
                    </div>
                    <div>
                        <span>Please provide your contact details as well as guests</span>
                        <jet-label for="name" value="Name" />
                        <jet-input id="name" type="text" class="mt-1 block w-full" v-model="contact.name" ref="name" />
                        <jet-label for="surname" value="Surname" />
                        <jet-input id="surname" type="text" class="mt-1 block w-full" v-model="contact.surname" ref="surname" />
                        <jet-label for="email" value="email" />
                        <jet-input id="email" type="text" class="mt-1 block w-full" v-model="contact.email" ref="email" />
                        <jet-label for="phone" value="phone" />
                        <jet-input id="phone" type="text" class="mt-1 block w-full" v-model="contact.phone" ref="phone" />
                        <div @click="addContact">Add</div>
                    </div>

                    <div class="row" v-for="contact in form.contacts">
                        <div class="col-sm">
                            {{contact.name}}
                        </div>
                        <div class="col-sm">
                            {{contact.surname}}
                        </div>
                        <div class="col-sm">
                            {{contact.email}}
                        </div>
                        <div class="col-sm">
                            {{contact.phone}}
                        </div>
                    </div>
                </div>

<!--                <div class="col-span-6 sm:col-span-4">-->
<!--                    <jet-label for="password" value="Maximum people" />-->
<!--                    <jet-input id="password" type="text" class="mt-1 block w-full" v-model="form.max_people" ref="password" autocomplete="new-password" />-->
<!--                    &lt;!&ndash;                <jet-input-error :message="form.errors.max_people" class="mt-2" />&ndash;&gt;-->
<!--                </div>-->

<!--                <div class="col-span-6 sm:col-span-4">-->
<!--                    <jet-label for="password_confirmation" value="Tables number" />-->
<!--                    <jet-input id="password_confirmation" type="text" class="mt-1 block w-full" v-model="form.tables_count" autocomplete="new-password" />-->
<!--                    &lt;!&ndash;                <jet-input-error :message="form.errors.tables_count" class="mt-2" />&ndash;&gt;-->
<!--                </div>-->

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
import VueTimepicker from 'vue3-timepicker'
import DatePicker from 'vue3-datepicker'

// CSS
import 'vue3-timepicker/dist/VueTimepicker.css'

import { useForm } from '@inertiajs/inertia-vue3'

export default {
    components: {
        DatePicker,
        VueTimepicker,
        JetActionMessage,
        JetButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
    },
    props: {
        restaurants: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {
            contact: {
                name: null,
                surname: null,
                phone: null,
                email: null,

            },

            disabledEndTime: false,
            date: null,
            start: null,
            end: null,
            availableStart:[
                1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23
            ],
            availableEnd:[
                2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24
            ],
            form: {
                name: '',
                max_people: '',
                tables_count: '',
                restaurant: null,
                start: null,
                end: null,
                table: null,
                date: null,
                contacts: [],
            },
            disabledHours: [],
            errors : {
                name : [],
                max_people : [],
                tables_count : [],
            },
        }
    },
    watch: {
        start: function () {
            if (this.start.HH !== '' && typeof this.start.HH !== undefined && this.start.HH !== null && this.start.HH !== false) {
                let start = parseInt(this.start.HH);
                this.resetEnd();
                this.availableEnd = this.availableEnd.filter(x => (parseInt(x) > start));
                while (start <= 24) {
                    if (this.disabledHours.includes(start) === true) {
                        console.log(this.disabledHours)
                        console.log(start);
                        this.availableEnd = this.availableEnd.filter(x => (x <= start));
                        break;
                    }
                    start++;
                }
                this.disabledEndTime = false;
            }
        },
        date: function() {
            this.getDisabledHours();
        }
    },
    computed: {
        tables() {
            console.log(this.restaurants);
            let result = [];
            for (let restaurant in this.restaurants) {
                if (this.restaurants[restaurant].id === this.form.restaurant) {
                    result = this.restaurants[restaurant].tables;
                }
            }

            return result;
        }
    },
    methods: {
        addContact() {
            this.form.contacts.push(this.contact);
            this.contact = {
                name: null,
                surname: null,
                phone: null,
                email: null,
            };
        },
        resetEnd() {
            this.availableEnd = [
                2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24
            ];

            this.$refs.end.clearTime();
        },
        resetStart() {
            this.disabledEndTime = true;
            this.availableStart = [
                1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23
            ];

            this.$refs.start.clearTime();
        },
        getDisabledHours() {
            this.resetEnd();
            this.resetStart();
            let date = this.date.setMinutes(this.date.getMinutes() - this.date.getTimezoneOffset());
            this.form.date = date.toString().slice(0,10)
            axios.post('/' + Ziggy.routes["allowedHours"].uri,
                {
                    date: this.form.date,
                    table: this.form.table
                }

            ).then((response) => {
                this.disabledHours = response.data;
                console.log(this.disabledHours);
                console.log(response);
                this.disableStart();
                this.$refs.start.toggleActive();
                this.$refs.end.toggleActive();
            }).catch((error) => {
                console.log(error.response.data );
                // this.errors = error.response.data.errors
                this.disableStart();
                this.$refs.start.toggleActive();
                this.$refs.end.toggleActive();
            });
        },
        disableStart() {
            this.availableStart = this.availableStart.filter(x => !this.disabledHours.includes(x));
            this.availableEnd = this.availableEnd.filter(x => !this.disabledHours.includes(x));
        },
        post() {
            console.log(this.form)
            // this.date.getYear()
            console.log(this.date);
            let date = this.date.setMinutes(this.date.getMinutes() - this.date.getTimezoneOffset());
            this.form.date = date.toString().slice(0,10)
            console.log(date)

            axios.post('/' + Ziggy.routes["submitReservation"].uri,
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
