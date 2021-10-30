<template>
    <success v-if="success">THANK YOUUUU</success>
    <div class="row" v-else>
        <div class="col-md-8" v-if="getBasketCount">
            <form class="needs-validation" novalidate="">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="firstName" class="form-label">First name</label>
                        <input type="text" class="form-control" id="firstName" placeholder="" value="" required="" v-model="customer.first_name" :class="{'is-invalid': errorFor('customer.first_name')}">
                        <errors :errors="errorFor('customer.first_name')"></errors>
                        <div class="invalid-feedback">
                            Valid first name is required.
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <label for="lastName" class="form-label">Last name</label>
                        <input type="text" class="form-control" id="lastName" placeholder="" value="" required="" v-model="customer.last_name" :class="{'is-invalid': errorFor('customer.last_name')}">
                        <errors :errors="errorFor('customer.last_name')"></errors>
                        <div class="invalid-feedback">
                            Valid last name is required.
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="email" class="form-label">Email <span class="text-muted">(Optional)</span></label>
                        <input type="email" class="form-control" id="email" placeholder="you@example.com" v-model="customer.email" :class="{'is-invalid': errorFor('customer.email')}">
                        <errors :errors="errorFor('customer.email')"></errors>
                        <div class="invalid-feedback">
                            Please enter a valid email address for shipping updates.
                        </div>
                    </div>

                </div>

                <div class="row gy-3">
                    <div class="col-md-6">
                        <label for="cc-name" class="form-label">City</label>
                        <input type="text" class="form-control" id="cc-name" placeholder="" required="" v-model="customer.city" :class="{'is-invalid': errorFor('customer.city')}">
                        <errors :errors="errorFor('customer.city')"></errors>
                        <small class="text-muted">Full name as displayed on card</small>
                        <div class="invalid-feedback">
                            Name on card is required
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="cc-number" class="form-label">Street</label>
                        <input type="text" class="form-control" id="cc-number" placeholder="" required="" v-model="customer.street" :class="{'is-invalid': errorFor('customer.street')}">
                        <errors :errors="errorFor('customer.street')"></errors>
                        <div class="invalid-feedback">
                            Credit card number is required
                        </div>
                    </div>
                </div>
                <div class="row gy-3">
                    <div class="col-md-6">
                        <label for="zip" class="form-label">Country</label>
                        <input type="text" class="form-control" id="country" placeholder="" required="" v-model="customer.country" :class="{'is-invalid': errorFor('customer.country')}">
                        <errors :errors="errorFor('customer.country')"></errors>
                        <div class="invalid-feedback">
                            Country code required.
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="zip" class="form-label">State</label>
                        <input type="text" class="form-control" id="state" placeholder="" required="" v-model="customer.state" :class="{'is-invalid': errorFor('customer.state')}">
                        <errors :errors="errorFor('customer.state')"></errors>
                        <div class="invalid-feedback">
                            State code required.
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="zip" class="form-label">Zip</label>
                        <input type="text" class="form-control" id="zip" placeholder="" required="" v-model="customer.zip" :class="{'is-invalid': errorFor('customer.zip')}">
                        <errors :errors="errorFor('customer.zip')"></errors>
                        <div class="invalid-feedback">
                            Zip code required.
                        </div>
                    </div>
                </div>

                <hr class="my-4">
                <button class="w-100 btn btn-primary btn-lg" type="submit" @click.prevent="book" :disabled="loading">Book now!</button>
            </form>
        </div>
        <div class="col-md-8" v-else>
            <div class="jumbotron jumbotron-fluid text-center">
                <h1>Empty</h1>
            </div>
        </div>
        <div class="col-md-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3 mt-3" v-if="getBasketCount">
                <span class="text-primary">Your cart</span>
                <span class="badge bg-primary rounded-pill color-white">{{getBasketCount}}</span>
            </h4>
            <h4  class="d-flex justify-content-between align-items-center mb-3" v-else>Basket empty</h4>
            <transition-group>
            <ul class="list-group mb-3" v-for="(basketItem, i) in basket.items" :key="basketItem.bookable.id">
                <li class="list-group-item">
                    <div class="d-flex justify-content-between">
                        <router-link :to="{name: 'bookable', params: {id: basketItem['bookable']['id']}}">
                            <h5 class="mb-0">{{basketItem.bookable.title}}</h5>
                        </router-link>
                        <div class="d-flex flex-column text-right">
                            <span class="text-muted mb-1">{{basketItem.price.total}}$</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="text-muted">From {{basketItem.dates.from}}</div>
                        <div class="text-muted">To {{basketItem.dates.to}}</div>
                    </div>
                    <div class="text-right">
                        <i class="fas fa-trash" @click="$store.commit('removeFromBasket', basketItem.bookable.id)"></i>
                    </div>
                </li>
            </ul>
            </transition-group>
        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex';
import { mapGetters } from 'vuex';
import validationErrors from './../mixins/validation'
export default {
    mixins: [validationErrors],
    data() {
      return {
          successSubmit: false,
          loading: false,
          customer: {
              first_name: null,
              last_name: null,
              email: null,
              street: null,
              city: null,
              country: null,
              state: null,
              zip: null,
          }
      }
    },
    methods: {
      async book() {
        this.loading = true;
        this.errors = null;

        try {
            await axios.post('/api/checkout', {
                customer: this.customer,
                bookings: this.basket.items.map(item => {
                    return {
                        bookable_id: item.bookable.id,
                        from: item.dates.from,
                        to: item.dates.to,
                    }
                })
            })
            this.successSubmit = true;
            this.$store.dispatch('clearBasket');
        } catch (error) {
            this.errors = error.response.data.errors;
        }
        this.loading = false;
      }
    },
    computed: {
        ...mapState({
            basket: (state) => state.basket,
        }),
        ...mapGetters({
            getBasketCount: 'getBasketCount'
        }),
        success() {
            return this.loading == false && this.getBasketCount === 0 && this.successSubmit;
        }
    }
}
</script>
<style scoped>
.badge {
    color:white;
}
</style>
