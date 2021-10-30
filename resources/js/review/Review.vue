<template>
    <div>
        <fatal-error v-if="error"></fatal-error>
        <success v-if="success">THANK YOUUUUU</success>
        <div class="row" v-if="!success && !error">
            <div :class="[{'col-md-4': twoColumns}, {'d-none': oneColumn}]" >
                <div class="card">
                    <div class="card-body">
                        <div v-if="loading">Loading</div>
                        <div v-if="hasBooking">
                            <p>
                                Stayed at
                                <router-link :to="{name: 'bookable', params: {id: this.$route.params.id}}">{{booking.bookable.title}}</router-link>
                            </p>
                            <p>From {{booking.from}} to {{booking.to}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div :class="[{'col-md-8': twoColumns}, {'col-md-12': oneColumn}]">
                <div v-if="loading">
                    Loading...
                </div>
                <div v-else>
                    <div v-if="!alreadyReviewed">
                        <div class="form-group">
                            <label class="text-muted">Select your rating</label>
                            <rating :rating="review.rating" class="fa-4x" v-on:selectStar="changeStar"></rating>
                        </div>
                        <div class="form-group">
                            <label for="content">Describe your expirience with</label>
                            <textarea name="content" class="form-control" cols="30" rows="10" v-model="review.content" :class="[{'is-invalid': errorFor('content')}]"></textarea>
                            <errors :errors="errorFor('content')"></errors>
                        </div>
                        <button class="btn btn-lg btn-primary btn-block" @click="submit" :disabled="loading">Submit</button>
                    </div>
                    <div v-else>
                        You`ve already left a review for this booking!
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {is404, is422} from '../../utils/response';
import validation from '../mixins/validation';

export default {
    mixins: [validation],
    data() {
       return {
           review: {
               id: null,
               rating: 5,
               content: ''
           },
           booking: null,
           content: '',
           loading: false,
           existingReview: null,
           error: false,
           success: false
       }
    },
    methods: {
        changeStar(num) {
            this.review.rating = num;
        },
        async submit() {
            this.loading = false;
            try {
                let request = (await axios.post('/api/reviews', this.review));
                this.success = request.status == 201;
            } catch (error) {
                if (is422(error)) {
                    const errors = error.response.data.errors;
                    if (errors['content'] && _.size(errors) == 1) {
                        this.errors = errors;
                        return;
                    }
                }
                this.error = true;
            }
            this.loading = false;
        }
    },
    async created() {
        this.loading = true;
        this.review.id = this.$route.params.id;
        this.review.id = this.$route.params.id;
        try {
            let result = (await axios.get(`/api/reviews/${this.$route.params.id}`)).data.data;
        } catch (error) {
            if (is404(error)) {
                try {
                    this.booking = (await axios.get(`/api/bookables/${this.$route.params.id}/booking`)).data.data;
                } catch(e) {
                    this.error = !is404(error);
                }
            } else {
                this.error = true;
            }
        }
        this.loading = false;
    },
    computed: {
        alreadyReviewed() {
          return this.hasReview || !this.hasBooking;
        },
        hasReview() {
            return this.existingReview != null;
        },
        hasBooking() {
            return this.booking != null;
        },
        oneColumn() {
            return !this.loading && this.alreadyReviewed;
        },
        twoColumns() {
            return !this.loading && !this.alreadyReviewed;
        },
    },

}
</script>
