import { defineStore } from "pinia";
import { useAuthStore } from "./authStore";

import echo from "../echo";

export const useEventStore = defineStore("eventStore", () => {
    const authStore = useAuthStore();

    // Hàm dùng chung để lắng nghe sự kiện real-time
    const listenToEvent = (channel, event, callback) => {
        // Lắng nghe sự kiện
        if (authStore.user.role === "admin") {
            return;
        }

        echo.private(channel).listen(event, (d) => {
            // Nếu user có quyền là manager hoặc
            // user có id trùng với assignee_id trong task (task được giao cho user đó)
            // thì được nhận thông báo real-time
            if (
                authStore.user.role === "manager" ||
                authStore.user.id === d.assignee_id
            ) {
                callback(d);
            }
        });
    };

    return {
        listenToEvent,
    };
});
