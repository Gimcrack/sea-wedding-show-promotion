<template>
    <div class="promotion" :class="{expanded, done}">
        <div class="promotion-content">
            <header>
                <template v-if="! done">
                    <strong>Today Only &nbsp;</strong>
                    <div>
                        <i class="fa fa-gift"></i> Enter to win a $50 gift card
                    </div>
                </template>

                <transition name="fade">
                    <div v-if="done">
                        <i class="fa fa-thumbs-up"></i> We got it. Thank you for contacting Special Events Alaska and for visiting our booth at the Anchorage Wedding Fair.
                    </div>
                </transition>

            </header>

            <transition name="fade">
                <div v-show="expanded && ! done" class="form">
                    <div class="promotion-form-group">
                        <label for="name">Name</label>
                        <input @input="input" required autofocus id="name" v-model="form.name" type="text" class="promotion-form-control">
                        <i class="fa fa-fw fa-user"></i>
                        <span v-if="errors.name" class="helptext input">
              Name is a required field
          </span>
                    </div>

                    <div class="promotion-form-group">
                        <label for="phone">Phone</label>
                        <input @input="input" required id="phone" v-model="form.phone" type="text" class="promotion-form-control">
                        <i class="fa fa-fw fa-phone"></i>
                        <span v-if="errors.phone" class="helptext input">
              Phone number is a required field
          </span>
                    </div>

                    <div class="promotion-form-group">
                        <label for="email">Email</label>
                        <input @input="input" required id="email" v-model="form.email" type="text" class="promotion-form-control">
                        <i class="fa fa-fw fa-envelope"></i>
                        <span v-if="errors.email" class="helptext input">
              Email is a required field
          </span>
                    </div>

                    <div class="promotion-form-group">
                        <label for="wedding_date">Wedding Date</label>
                        <input id="wedding_date" v-model="form.wedding_date" type="date" class="promotion-form-control">
                        <i class="fa fa-fw fa-calendar"></i>
                    </div>

                    <div class="promotion-form-group">
                        <label for="guest_count">Guest Count</label>
                        <input id="guest_count" v-model="form.guest_count" type="text" class="promotion-form-control">
                        <i class="fa fa-fw fa-users"></i>
                    </div>

                    <div class="promotion-form-group">
                        <label for="venue">Venue</label>
                        <input id="venue" v-model="form.venue" type="text" class="promotion-form-control">
                        <i class="fa fa-fw fa-map-marker"></i>
                    </div>

                    <div class="promotion-form-group">
                        <label for="contact">
                            Opt Out
                        </label>
                        <div class="promotion-checkbox">
                            <label for="contact">
                                <input id="contact" type="checkbox" v-model="form.dont_contact">
                                Please do not contact me about my event
                            </label>
                        </div>
                    </div>

                    <form @submit.prevent="submit" class="promotion-form-group">
                        <label for="interest">I'm Interested In</label>
                        <div class="promotion-checkbox-group">
                            <label>
                                <input id="interest_tents" v-model="form.interest.tents" type="checkbox" class="promotion-form-control">
                                Tents
                            </label>
                            <label>
                                <input id="interest_tables" v-model="form.interest.tables" type="checkbox" class="promotion-form-control">
                                Tables
                            </label>
                            <label>
                                <input id="interest_chairs" v-model="form.interest.chairs" type="checkbox" class="promotion-form-control">
                                Chairs
                            </label>
                            <label>
                                <input id="interest_linens" v-model="form.interest.linens" type="checkbox" class="promotion-form-control">
                                Linens
                            </label>
                            <label>
                                <input id="interest_glassware" v-model="form.interest.glassware" type="checkbox" class="promotion-form-control">
                                Glassware
                            </label>
                            <label>
                                <input id="interest_china" v-model="form.interest.china" type="checkbox" class="promotion-form-control">
                                China
                            </label>
                            <label>
                                <input id="interest_flatware" v-model="form.interest.flatware" type="checkbox" class="promotion-form-control">
                                Flatware
                            </label>
                            <label>
                                <input id="interest_backdrop" v-model="form.interest.backdrop" type="checkbox" class="promotion-form-control">
                                Backdrop
                            </label>
                            <label>
                                <input id="interest_lighting" v-model="form.interest.lighting" type="checkbox" class="promotion-form-control">
                                Lighting
                            </label>
                            <label>
                                <input id="interest_photo_booth" v-model="form.interest.photo_booth" type="checkbox" class="promotion-form-control">
                                Photo Booth
                            </label>
                            <label>
                                <input id="interest_dance_floor" v-model="form.interest.dance_floor" type="checkbox" class="promotion-form-control">
                                Dance Floor
                            </label>

                        </div>

                        <div style="display:flex; flex-direction:column; align-items:center; width:100%;">
                            <button v-if="busy" disabled="disabled" class="promotion-btn disabled">
                                <i class="fa fa-refresh fa-spin"></i>
                            </button>
                            <button v-else type="submit" class="promotion-btn">Go</button>
                            <span v-if="has_errors" class="helptext">
              Oops. Looks like you left out some required information. Please fill out all required fields and submit again.
            </span>
                        </div>

                    </form>

                </div>
            </transition>

            <button v-if="! done" @click="toggleExpanded" class="promotion-btn btn-plain">
                <i class="fa" :class="[ expanded ? 'fa-chevron-up' : 'fa-chevron-down' ]"></i>
            </button>
        </div>

    </div>
</template>

<script>
    export default {

        methods : {
            toggleExpanded() {
                this.expanded = ! this.expanded;

                setTimeout( () => {
                    document.getElementById('name').focus();
                }, 500);
            },

            input() {
                this.errors = {};
                this.has_errors = false;
            },

            validate() {
                this.errors = {};
                this.has_errors = false;

                ['name','phone','email'].forEach( o => {
                    if ( ! this.form[o] ) {
                        this.errors[o] = true;
                        this.has_errors = true;
                    }
                });

                return ! this.has_errors;
            },

            submit() {
                if ( ! this.validate() )
                    return false;

                this.busy = true;

                window.axios.post('/api/send', this.form)
                    .then( () => {
                        this.busy = false;
                        this.done = true;
                        this.expanded = false;
                    });


            }
        },

        computed : {
            emailText() {
                let text = '';

                for (let prop in this.form)
                {
                    if ( prop === 'interest') {
                        for (let prop_int in this.form.interest)
                        {
                            text += `<strong>Interested In ${prop_int}</strong> : ${this.form.interest[prop_int]} <br/>`
                        }
                    }

                    else {
                        text += `<strong>${prop}</strong> : ${this.form[prop]} <br/>`;
                    }
                }

                return text;
            }
        },

        data() {
            return {
                busy : false,
                expanded : false,
                done : false,

                errors : {},
                has_errors : false,

                form : {
                    name : null,
                    phone : null,
                    email : null,
                    wedding_date : null,
                    guest_count : null,
                    venue : null,
                    interest : {
                        tents : false,
                        tables : false,
                        chairs : false,
                        linens : false,
                        glassware : false,
                        china : false,
                        flatware : false,
                        backdrop : false,
                        lighting : false,
                        photo_booth : false,
                        dance_floor : false,
                    },
                    dont_contact : false,
                }
            }
        }
    }
</script>

<style lang="scss">

    @import url('https://fonts.googleapis.com/css?family=Poppins');

    /*body, html {*/
        /*margin: 0;*/
        /*padding: 0;*/
    /*}*/

    /*body {*/
        /*background: url('https://images.unsplash.com/photo-1503314885798-a70f8f9028d3?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1500&q=80') fixed no-repeat top center;*/
        /*background-size: cover;*/
    /*}*/

    .promotion {

        .promotion-btn {
            min-width: unset;
            height: unset;
            line-height: unset;
        }

        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;

        .promotion-content {
            max-width: 500px;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        header {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        background-attachment: fixed;
        background-size: cover;
        background-repeat: no-repeat;
        background-image:linear-gradient(to top, rgba(#51A3A3,0.6), rgba(#51A3A3,0.6)), url('https://images.unsplash.com/photo-1503314885798-a70f8f9028d3?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1500&q=80');
        height: 100px;

        font-family: "Poppins", sans-serif;


        @media( max-width: 425px ) {
            font-size: 14px;

            &.expanded {
                margin: 0 !important;
                height: 850px !important;
                padding: 1rem 0 !important;
            }

            .promotion-content {
                max-width: 90vw;
            }

            .promotion-form-control[type=text],
            .promotion-form-control[type=date] {
                width: 85vw !important;
            }

            .helptext.input {
                font-size: 12px;
                right: 0 !important;
            }

            .promotion-checkbox-group label,
            .promotion-checkbox label {
                font-size: 14px !important;
            }
        }

        @media( min-width:426px) and (max-width: 767px) {
            font-size: 18px;

            &.expanded {
                margin: 0 !important;
                height: 850px !important;
                padding: 0 !important;
            }

            .promotion-content {
                max-width: 90vw;
            }
            .promotion-form-control[type=text],
            .promotion-form-control[type=date] {
                width: 85vw !important;
            }
        }

        @media( min-width:768px) and (max-width: 1023px) {
            font-size: 18px;
        }

        @media( min-width: 1024px) {
            font-size: 24px;
        }

        //line-height: 100px;
        color: white;
        text-shadow: 1px 1px rgba(0,0,0,0.8);

        transition: all 0.5s linear;

        &.done {
            height: 180px;
        }

        &.expanded {
            height : 1100px;
            padding: 1rem 0;

            header {
                margin-bottom: 1rem;
            }
        }

        .promotion-btn {
            &.btn-plain {
                background: none;
                border: none;
            }

            display: inline;
            background: #8D6A9F;
            border-radius: 4px;
            color: white;
            border: 1px solid darken(#8D6A9F, 20%);
            padding: 6px 8px;
            cursor: pointer;
            margin: 0 6px;
            font-weight: bold;

            &:hover {
                background: lighten(#8D6A9F,5%);
            }

            &:active {
                background: darken(#8D6A9F,5%);
            }
        }

        .form {
            width: 100%;

            .promotion-form-group {
                position: relative;
                display:flex;
                flex-direction: column;

                .promotion-checkbox {
                    label {
                        font-size: 18px;
                    }
                }

                .promotion-checkbox-group {
                    //display:flex;
                    //flex-direction: column;
                    column-count: 2;
                    //height: 150px;

                    label {
                        display: block;
                        font-size: 18px;
                    }
                }

                label {
                    margin: 0;
                    padding: 0;
                    line-height: 1.5;
                }

                & > i.fa {
                    position: absolute;
                    bottom: 12px;
                    left: 7px;
                    font-size: 18px;
                }

                margin-bottom: 0.75rem;


            }

            .promotion-form-control[type=text],
            .promotion-form-control[type=date]{
                width: 100%;
                border: 1px solid darken(#51A3A3, 20%);
                background: lighten(#51A3A3, 20);
                border-radius: 8px;
                padding: 8px 10px;
                color: white;
                font-size: 20px;
                text-indent: 24px;
            }
        }

        .errors {
            position : absolute;
            bottom: 0;
            background : rgba(#A30000,0.7);
            padding: 0.75rem;

        }



        .helptext {

            &.input {
                position: absolute;
                bottom: 45px;
                right: -20px;
            }

            margin-top: 0.5rem;
            color: #ee0;
            font-size: 14px;
        }

        .fade-enter-active {
            transition: opacity .3s linear 0.5s;
        }
        .fade-leave-active {
            transition: opacity 0 linear;
        }
        .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
            opacity: 0;
        }
    }
</style>