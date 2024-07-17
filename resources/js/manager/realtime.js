import Echo from "laravel-echo";

window.Pusher = require('pusher-js');

window.echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    wsHost: window.location.hostname,
    wsPort: 8880,
    wssPort: 8880,
    encrypted: true,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
});
