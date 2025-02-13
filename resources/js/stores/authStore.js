import { defineStore } from "pinia";
import { ref } from "vue";

export const useAuthStore = defineStore("authStore", () => {
    // List Users
    const listRoles = ref([
        { name: "admin" },
        { name: "manager" },
        { name: "employee" },
    ]);

    const listUsers = ref([]);
    const selectedUser = ref(null);
    const createAccount = ref(false);

    const getListUsers = async () => {
        try {
            const response = await axios.get("/users");
            listUsers.value = response.data;

            listUsers.value.forEach((item) => {
                item.isEdit = false;
            });
        } catch (error) {
            console.log(error);
        }
    };

    // Lấy user được chọn
    const findUser = (user) => {
        user.isEdit = true;
        selectedUser.value = { ...user };
    };

    // Hàm update role
    const updateRole = async (index) => {
        try {
            const response = await axios.put(
                "/users/" + selectedUser.value.id,
                {
                    role: selectedUser.value.role,
                }
            );

            // Cập nhật lại listUsers ở row vừa update
            Object.assign(listUsers.value[index], {
                role: response.data.user.role,
                isEdit: false,
            });
        } catch (error) {
            // console.log(error);
        }
    };

    // Create Account
    const account = ref({
        name: "",
        email: "",
        role: "",
    });

    // Hàm close form create account
    const closeCreateAccount = () => {
        createAccount.value = false;

        // Clear form
        account.value = {
            name: "",
            email: "",
            role: "",
        };
    };

    // getListUsers(); // gọi trực tiếp trong store hoặc gọi ở component

    return {
        listRoles,
        listUsers,
        getListUsers,
        selectedUser,
        createAccount,
        findUser,
        updateRole,
        account,
        closeCreateAccount,
    };
});
