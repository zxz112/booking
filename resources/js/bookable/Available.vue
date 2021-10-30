<template>
    <div>
        <transition>
            <div v-if="availability" style="color:green">AVAILABLE</div>
            <div v-if="noAvailability" style="color:red">NOAVAILABLE</div>
        </transition>
       <div class="form-row">
           <div class="form-group col-md-6">
               <input type="text" class="form-control" v-model="from" v-on:keyup.enter="check" :class="{'is-invalid': errorFor('from')}">
               <errors :errors="errorFor('from')"></errors>
           </div>
           <div class="form-group col-md-6">
               <input type="text" class="form-control" v-model="to" v-on:keyup.enter="check" :class="{'is-invalid': errorFor('to')}">
               <errors :errors="errorFor('to')"></errors>
           </div>
       </div>
        <div class="row">
            <div class="col">
                <button type="submit" class="btn btn-primary mb-3 w-100" v-on:click="check">
                    <span v-if="!loading">Check!</span>
                    <span v-if="loading"><i class="fas fa-spinner fa-spin"></i>Checking</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import validation from '../mixins/validation';
export default {
    mixins: [validation],
    data() {
        return {
            from: this.$store.state.lastSearch.from,
            to: this.$store.state.lastSearch.to,
            loading: false,
            status: null,
        }
    },
    methods: {
        check: async function () {
            this.loading = true;
            localStorage.setItem('lastSearch', JSON.stringify({from: this.from, to: this.to}))
            this.$store.dispatch('setLastSearch', {from: this.from, to: this.to})

            try {
                this.status = (await axios(`/api/bookables/${this.$route.params.id}/available?from=${this.from}&to=${this.to}`)).status;
                this.$emit('availability', this.availability)
                this.errors = null;
            } catch (error) {
                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                } else {
                    this.errors = null;
                }
                this.$emit('availability', this.availability)
                this.status = error.response.status;
            }
            this.loading = false;
        },
    },
    computed: {
        hasErrors() {
            return this.status == 422 && this.errors;
        },
        availability() {
            return this.status == 200;
        },
        noAvailability() {
            return this.status == 404;
        }
    }
}
</script>
<style>
.error {
    border: 2px solid red;
}
</style>
