import Echo from "laravel-echo";
import Pusher from "pusher-js";
window.Pusher = Pusher;

const echo = new Echo({
    broadcaster: "pusher",
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    authEndpoint: "http://127.0.0.1:8000/broadcasting/auth", // Laravel xử lý xác thực
    withCredentials: true, // Giúp Laravel nhận session
});

export default echo;
