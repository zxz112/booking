<template>
    <div>
        <h6 class="mb-3 text-uppercase text-secondary font-weight-bolder pt-4">
            Review list
        </h6>
        <div class="review border-bottom d-none d-md-block" v-for="(review, i) in reviews" :key="'review ' + i">
            <div class="row">
                <div class="col-md-6">ILYA VVV</div>
                <div class="col-md-6 d-flex justify-content-end">
                    <rating v-bind="{'rating': review.rating}" class="fa-lg"></rating>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    {{review.created_at | filterNow}}
                </div>
            </div>
            <div class="row pt-4 pb-4">
                <div class="col-md-12">
                    {{ review.content }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment';

export default {
    data() {
       return {
           test: 'test',
           reviews: []
       }
    },
    created() {
        axios(`/api/bookables/${this.$route.params.id}/review`).then((request) => {
            this.reviews = request.data;
            console.log(this.reviews)
            this.loading = false;
        });
    },
    filters: {
        filterNow(value) {
            return moment(value).fromNow();
        }
    }
}
</script>
<style>
.review {
    margin-bottom: 15px;
}
</style>
