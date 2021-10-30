<template>
    <div class="row mt-3">
        <div class="col-md-8">
            <div class="card w-100" v-if="!loading">
                <div class="card-body" v-if="bookable">
                    <h5 class="card-title">{{bookable.title}}</h5>
                    <p class="card-text">{{bookable.description}}</p>
                </div>
            </div>
            <div v-else>
                Loading....
            </div>
            <review-list></review-list>
        </div>
        <div class="col-md-4">
            <available @availability="getPriceBooking($event)" class="mb-4"></available>
            <price :price="price" v-if="price"></price>
            <button v-if="price" class="btn btn-primary mb-3 w-100" @click="addToBasket" :disabled="alreadyInBasket">Booking now!</button>
            <button v-if="alreadyInBasket" class="btn btn-primary mb-3 w-100" @click="removeFromBasket">Remove</button>
            <span style="font-size: 0.7rem;" v-if="alreadyInBasket">If you want buy booking with another date, please, remove booking in basket</span>
        </div>
    </div>
</template>

<script>
import Available from './Available';
import ReviewList from './ReviewList';
import Price from './Price';
import { mapState } from 'vuex';

export default {
    data() {
        return {
            bookable: null,
            loading: true,
            price: null
        }
    },
    components: {
        'available': Available,
        'review-list': ReviewList,
        'price': Price
    },
    created() {
        axios(`/api/bookables/${this.$route.params.id}`).then((request) => {
           this.bookable = request.data;
           this.loading = false;
        });
    },
    computed: {
        ...mapState({
            lastSearch: "lastSearch",
            getAllBasket: 'getAllBasket'
        }),
        alreadyInBasket() {
            if (this.bookable == null) {
                return false;
            }
            return this.$store.getters.alreadyInBasket(this.bookable.id);
        }
    },
    methods: {
        async getPriceBooking(hasAvaibility) {
            if (!hasAvaibility) {
                this.price = null;
                return;
            }
            try {
                this.price = (await axios(`/api/bookables/${this.$route.params.id}/price?from=${this.lastSearch.from}&to=${this.lastSearch.to}`)).data.data;
            } catch (error) {
                this.price = null;
            }
        },
        addToBasket() {
            this.$store.commit('addToBasket', {
                bookable: this.bookable,
                price: this.price,
                dates: this.lastSearch
            });
            console.log()
            localStorage.setItem('basket', JSON.stringify(this.$store.state.basket.items))
        },
        removeFromBasket() {
            this.$store.commit('removeFromBasket', this.bookable.id)
        }
    }
}
</script>
