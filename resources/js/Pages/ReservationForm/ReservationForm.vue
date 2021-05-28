<template>
    <div>
        <messages ref="messages" :errors="errors"></messages>
        <success-message ref="success" :message="message"></success-message>
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
                    <select id="table"  class="block mt-1 w-full" @change="setTableSize()" v-model="form.table">
                        <option v-for="option in tables" v-bind:value="option.id">
                            {{'table No: ' + option.id + ' has ' + option.table_size + ' seats'}}
                        </option>
                    </select>
                        <div>
                            <jet-label for="date" value="Date" />
                            <date-picker :disabled="(form.table === null)" @input="getDisabledHours" id="date"  v-model="date"/>
                        </div>
                    <jet-label for="clientName" value="Name" />
                    <jet-input id="clientName" type="text" class="mt-1 block w-full" v-model="form.name" ref="name" />
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
                    <br>
                    <span>Participants</span>
                    <div v-if="tableMaxSeats > form.contacts.length">
                        <span>Please provide your contact details as well as guests</span>
                        <jet-label for="name" value="Name" />
                        <jet-input id="name" type="text" class="mt-1 block w-full" v-model="contact.name" ref="name" />
                        <jet-label for="surname" value="Surname" />
                        <jet-input id="surname" type="text" class="mt-1 block w-full" v-model="contact.surname" ref="surname" />
                        <jet-label for="email" value="email" />
                        <jet-input id="email" type="email" class="mt-1 block w-full" v-model="contact.email" ref="email" />
                        <jet-label for="phone" value="phone" />
                        <jet-input id="phone" type="text" class="mt-1 block w-full" v-model="contact.phone" ref="phone" />
                        <div class='btn' @click="checkIfCanAdd">Add</div>
                    </div>

                    <div class="row" v-for="(contact, index) in form.contacts">
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
                        <div class='btn' @click="remove(index)"> remove</div>
                    </div>
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
import VueTimepicker from 'vue3-timepicker'
import DatePicker from 'vue3-datepicker'

// CSS
import 'vue3-timepicker/dist/VueTimepicker.css'

import Messages from "@/Pages/ReservationForm/ErrorMessages";
import SuccessMessage from "@/Pages/ReservationForm/SuccessMessage";

export default {
    components: {
        SuccessMessage,
        Messages,
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
            tableMaxSeats: 0,
            form: {
                name: '',
                restaurant: null,
                start: null,
                end: null,
                table: null,
                date: null,
                contacts: [],
            },
            disabledHours: [],
            errors: [],
            message: ''
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
        remove(index) {
             this.form.contacts.splice(index,1)
        },
        setTableSize() {
            for (let table in this.tables) {
                if (this.tables[table].id === this.form.table) {
                    console.log(this.tables[table]);
                    this.tableMaxSeats = this.tables[table].table_size;
                    console.log(  this.tableMaxSeats)
                    break;
                }
            }
        },
        addContact() {
            if (this.contact.name !== null && this.contact.surname !== null && this.contact.phone !== null && this.contact.email !== null) {
                this.form.contacts.push(this.contact);
                this.contact = {
                    name: null,
                    surname: null,
                    phone: null,
                    email: null,
                };
            }
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
            axios.post('/' + Ziggy.routes['allowedHours'].uri,
                {
                    date: this.form.date,
                    table: this.form.table
                }

            ).then((response) => {
                this.disabledHours = response.data;
                this.disableStart();
                this.$refs.start.toggleActive();
                this.$refs.end.toggleActive();
            }).catch((error) => {
                this.disableStart();
                this.$refs.start.toggleActive();
                this.$refs.end.toggleActive();
            });
        },
        checkIfCanAdd() {
            let date = this.date.setMinutes(this.date.getMinutes() - this.date.getTimezoneOffset());
            this.form.date = date.toString().slice(0,10)
            if (this.start !== null && this.end !== null) {
                this.form.start = parseInt(this.start.HH);
                this.form.end = parseInt(this.end.HH);
                axios.post('/' + Ziggy.routes['validateContacts'].uri,
                    {
                        restaurant: this.form.restaurant,
                        table: this.form.table,
                        date: this.form.date,
                        start: this.form.start,
                        end: this.form.end,
                        contact: this.contact,
                        contactsCount: this.form.contacts.length + 1
                    }
                ).then((response) => {
                    this.addContact();
                }).catch((error) => {
                    this.errors = error.response.data.errors
                    this.$refs.messages.open();
                });
            }
        },
        disableStart() {
            this.availableStart = this.availableStart.filter(x => !this.disabledHours.includes(x));
            this.availableEnd = this.availableEnd.filter(x => !this.disabledHours.includes(x));
        },
        post() {
            let date = this.date.setMinutes(this.date.getMinutes() - this.date.getTimezoneOffset());
            this.form.date = date.toString().slice(0,10)
            if (this.start !== null && this.end !== null) {
                this.form.start = parseInt(this.start.HH);
                this.form.end = parseInt(this.end.HH);
                axios.post('/' + Ziggy.routes['placeReservation'].uri,
                    this.form
                ).then((response) => {
                    this.message = 'success'
                    this.$refs.success.open();
                }).catch((error) => {
                    this.errors = error.response.data.errors
                    this.$refs.messages.open();
                });
            }
        }

    }
}
</script>
<style>
.btn{
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
    text-decoration: none;

    color: #333;
    background-color: #fff;
    border-color: #ccc;
}
</style>
