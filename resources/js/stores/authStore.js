import { defineStore } from "pinia";
import { computed, ref } from "vue";
import axios from "axios";

export const useAuthStore = defineStore("authStore", () => {
    // Define
    const user = ref(window.__user__);
    const listUsers = ref({});
    const selectedUser = ref(null);
    const clickCreateAccount = ref(false);
    const deleteUser = ref(null);
    const getIndexDel = ref(null);
    const click = ref(false);

    const alertType = ref("alert-danger");
    const notification = ref(null);

    const account = ref({
        name: "",
        email: "",
        role: "",
    });

    const listRoles = ref([
        { name: "admin" },
        { name: "manager" },
        { name: "employee" },
    ]);

    // Logout account
    const logout = async () => {
        try {
            await axios.post("/logout");
            window.location.href = "/";
        } catch (error) {
            console.error(error);
        }
    };

    // List Users
    const getListUsers = async (page = 1) => {
        try {
            const response = await axios.get("/users?page=" + page);
            listUsers.value = response.data;

            listUsers.value.data.forEach((item) => {
                item.isEdit = false;
            });
        } catch (error) {
            console.log(error);
        }
    };

    // Hàm lấy user được chọn
    const findUser = (user) => {
        user.isEdit = true;
        click.value = true;
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
            Object.assign(listUsers.value.data[index], {
                role: response.data.user.role,
                isEdit: false,
            });

            click.value = false;
        } catch (error) {
            console.log(error);
        }
    };

    // Hàm close form create account
    const closeCreateAccount = () => {
        clickCreateAccount.value = false;

        // Clear form
        account.value = {
            name: "",
            email: "",
            role: "",
        };
    };

    // Hàm click xóa tài khoản
    const clickDeleteUser = (user, index) => {
        getIndexDel.value = index;
        deleteUser.value = { ...user };
    };

    // Hàm close modal
    const closeModal = () => {
        deleteUser.value = null;
        getIndexDel.value = null;
    };

    // Hàm xác nhận xóa tài khoản
    const confirmDelUser = async () => {
        try {
            await axios.delete("/users/" + deleteUser.value.id);
            listUsers.value.data.splice(getIndexDel.value, 1);

            getIndexDel.value = null;
            deleteUser.value = null;
        } catch (error) {
            console.log(error);
        }
    };

    // Hàm validatedForm
    const isFormValid = computed(() => {
        return (
            account.value.name !== "" &&
            account.value.email !== "" &&
            account.value.role !== ""
        );
    });

    // Hàm thêm tài khoản mới
    const createAccount = async () => {
        try {
            const response = await axios.post("/users", {
                name: account.value.name,
                email: account.value.email,
                role: account.value.role,
            });

            // Thông báo tạo tài khoản thành công
            alertType.value = "alert-success";
            notification.value = { message: "Tạo tài khoản thành công!" };

            // Thoát form và clear text
            account.value = {
                name: "",
                email: "",
                role: "",
            };

            setTimeout(() => {
                notification.value = null;
                clickCreateAccount.value = false;
            }, 2000);

            // Thêm tài khoản vừa tạo vào đầu danh sách
            listUsers.value.data.unshift({
                ...response.data.user,
                isEdit: false,
            });
        } catch (error) {
            notification.value = error.response.data;
            setTimeout(() => {
                notification.value = null;
            }, 2000);
        }
    };

    //getListUsers(); // gọi trực tiếp trong store hoặc gọi ở component

    return {
        listRoles,
        listUsers,
        getListUsers,
        selectedUser,
        clickCreateAccount,
        findUser,
        updateRole,
        account,
        closeCreateAccount,
        user,
        logout,
        deleteUser,
        clickDeleteUser,
        confirmDelUser,
        createAccount,
        isFormValid,
        alertType,
        notification,
        closeModal,
        click,
    };
});
