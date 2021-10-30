export default {
    state: {
        lastSearch: {
            to: null,
            from: null
        },
        basket: {
            items: []
        }
    },
    mutations: {
        setLastSearch(state, date) {
            state.lastSearch = date;
        },
        addToBasket(state, data) {
            state.basket.items.push(data)
        },
        removeFromBasket(state, id) {
            state.basket.items = state.basket.items.filter(item => item.bookable.id != id);
        },
        setBasketItems(state, data) {
            state.basket.items = data;
        }
    },
    actions: {
        setLastSearch(context, date) {
            context.commit('setLastSearch', date);
        },
        setDefaultSearch(context) {
            let dateStorage = localStorage.getItem('lastSearch');
            if (dateStorage) {
                context.commit('setLastSearch', JSON.parse(dateStorage));
            }
        },
        setDefaultBasket(context) {
            let dateStorage = localStorage.getItem('basket');
            if (dateStorage) {
                context.commit('setBasketItems', JSON.parse(dateStorage));
            }
        },
        clearBasket(context) {
            context.commit('setBasketItems', []);
            localStorage.setItem('basket', JSON.stringify(context.state.baket))
        }
    },
    getters: {
        getBasketCount(state) {
            console.log(state.basket.items)
            return state.basket.items.length;
        },
        alreadyInBasket: state => id => {
            return state.basket.items.reduce((result, item) => {
                return result || item.bookable.id == id;
            }, false);
        }
    }
}
