<template>
    <!-- Remove the container if you want to extend the Footer to full width. -->
    <div class="container my-5">
        <footer
            class="text-center text-lg-start"
            style="background-color: cadetblue"
        >
            <!-- Copyright -->
            <div
                class="text-center text-white p-3"
                style="background-color: rgba(0, 0, 0, 0.2)"
            >
                © 2025 Copyright:
                <a class="text-white" href="https://ntdanh.id.vn/"
                    >Nguyen Thanh Danh</a
                >
            </div>
            <!-- Copyright -->
        </footer>
    </div>
    <!-- End of .container -->
</template>

<style scoped>
footer {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
}
</style>
