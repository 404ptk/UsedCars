import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Pusher = Pusher;
//window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'ad53a23d1dcc4a6e21d0',
    cluster: 'eu',
    encrypted: true
});

window.Echo.channel('auction')
    .listen('AuctionPriceUpdated', (e) => {
        let auctionId = e.auction.id;
        let newPrice = e.auction.current_price;
        document.querySelector(`#price-${auctionId}`).textContent = `Cena: ${newPrice} zł`;
    });


