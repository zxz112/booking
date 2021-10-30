<template>
    <div v-if="loading">
        Loading ...
    </div>
    <div v-else class="mt-3">
        <div class="row mb-3" v-for="row in rows">
            <div class="col d-flex align-items-stretch" v-for="(item, index) in getRowItems(row)" :key="item.id">
                <bookable-item v-bind="item">
                </bookable-item>
            </div>
            <div class="col" v-for="p in getPlaceholderRow(row)" :key="'p' + p"></div>
        </div>
    </div>
</template>

<script>
import BookableItem from './BookableItem';
export default {
    components: {
        'bookable-item': BookableItem
    },
    data() {
        return {
            items: null,
            loading: false,
            columns: 3
        }
    },
    computed: {
       rows: function() {
            return this.items == null ?  0 : Math.ceil(this.items.length / this.columns);
        }
    },
    methods : {
      getRowItems(row) {
          return this.items.slice((row - 1) * this.columns, row * this.columns);
      },
      getPlaceholderRow(row) {
          console.log(row);
          return this.columns - this.getRowItems(row).length;
      }
    },
    created() {
        this.loading = true;
        axios.get('/api/bookables').then(response => {
            this.items = response.data;
            this.loading = false;
        });
    }
}
</script>
