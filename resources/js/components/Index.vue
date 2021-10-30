<template>
    <div>
        <div class="container">
            <div class="nav d-flex justify-content-between">
                <router-link class="nav--link" :to="{'name': 'home'}">Home</router-link>
                <router-link class="nav--link pr-3" :to="{'name': 'basket'}">Basket <span class="badge badge-secondary">{{getBasketCount}}</span></router-link>
            </div>
            <router-view></router-view>
        </div>
    </div>
</template>

<script>

import { mapState } from 'vuex';
import { mapGetters } from 'vuex';

export default {
    data() {
        return {
            lastSearch: this.$store.state.lastSearch
        }
    },
    computed: {
        ...mapState({
            lastSearchComputed: "lastSearch"
        }),
        ...mapGetters({
            getBasketCount: 'getBasketCount'
        })
    }
}
</script>
