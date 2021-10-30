<template>
    <div class="d-flex">
        <i class="fas fa-star" v-for="(num, i) in stars" :key="'starFull ' + num"  v-on:click="$emit('selectStar', i + 1)"></i>
        <i class="fas fa-star-half-alt" v-if="halfStar"></i>
        <i class="far fa-star" v-for="(num, i) in emptyStars" :key="'starEmpty ' + num" v-on:click="$emit('selectStar', i + 1 + stars)"></i>
    </div>
</template>

<script>
    export default {
        props:[
            'rating'
        ],
        computed: {
          halfStar() {
              return this.rating % 1 != 0 && this.rating % 1 < 0.5;
          },
          stars() {
              return Math.round(this.rating);
          },
          emptyStars() {
            return 5 - Math.ceil(this.rating);
          }
        }
    }
</script>
