<template>
  <div>
      <div class="d-flex justify-content-between border-bottom mb-3" v-for="(priceOneDay,days) in price.breakdown" :key="price + Math.random()">
          <span>{{priceOneDay}} x {{days}}</span>
          <span>{{priceOneDay * days}}</span>
      </div>
    <div class="d-flex justify-content-between border-bottom mb-3">
        <span>Total:</span>
        <span>{{price.total}}</span>
    </div>
  </div>
</template>

<script>
export default {
    props: ['price'],
}
</script>

<style scoped>

</style>
