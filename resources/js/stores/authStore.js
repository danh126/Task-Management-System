import { defineStore } from "pinia";
import { computed, ref } from "vue";
import axios from "axios";

export const useAuthStore = defineStore("authStore", () => {
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

    const changePassword = ref({
        old_pass: "",
        new_pass: "",
        confirm_pass: "",
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

    // Hàm validatedForm create account
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

    // Close change password
    const closeChangePass = () => {
        click.value = false;

        changePassword.value = {
            old_pass: "",
            new_pass: "",
            confirm_pass: "",
        };
    };

    // Required all input change password
    const requiredChangePass = computed(() => {
        return (
            changePassword.value.old_pass !== "" &&
            changePassword.value.new_pass !== "" &&
            changePassword.value.confirm_pass !== ""
        );
    });

    // Validated form change password
    const validatedChangePass = () => {
        const new_pass = changePassword.value.new_pass;
        const confirm_pass = changePassword.value.confirm_pass;

        const specialCharPattern = /[!#$%^&*(),?":{}|<>]/g;

        if (specialCharPattern.test(new_pass)) {
            notification.value = {
                message: "Mật khẩu không được chứa ký tự đặc biệt!",
            };

            setTimeout(() => {
                notification.value = null;
            }, 2500);

            return false;
        }

        if (new_pass !== confirm_pass) {
            notification.value = { message: "Mật khẩu xác nhận không khớp!" };

            setTimeout(() => {
                notification.value = null;
            }, 2500);

            return false;
        } else if (new_pass.length < 8) {
            notification.value = {
                message: "Độ dài mật khẩu mới phải trên 8 ký tự!",
            };

            setTimeout(() => {
                notification.value = null;
            }, 2500);

            return false;
        }

        return true;
    };

    // Change password
    const updatePassword = async () => {
        if (validatedChangePass()) {
            try {
                const response = await axios.post(
                    `/user/change-password/${user.value.id}`,
                    {
                        old_pass: changePassword.value.old_pass,
                        new_pass: changePassword.value.new_pass,
                        confirm_pass: changePassword.value.confirm_pass,
                    }
                );

                if (response.data.user.check_pass) {
                    notification.value = {
                        message: response.data.user.check_pass,
                    };

                    setTimeout(() => {
                        notification.value = null;
                    }, 2500);

                    return;
                }

                alertType.value = "alert-success";
                notification.value = {
                    message: "Cập nhật mật khẩu mới thành công!",
                };

                setTimeout(() => {
                    notification.value = null;
                    alertType.value = "alert-danger";
                    closeChangePass();
                }, 2500);
            } catch (e) {
                console.log(e);
            }
        }
    };

    return {
        listRoles,
        listUsers,
        selectedUser,
        clickCreateAccount,
        account,
        user,
        deleteUser,
        isFormValid,
        alertType,
        notification,
        click,
        changePassword,
        requiredChangePass,
        findUser,
        updateRole,
        clickDeleteUser,
        confirmDelUser,
        createAccount,
        getListUsers,
        closeCreateAccount,
        closeModal,
        logout,
        closeChangePass,
        updatePassword,
    };
});
