<template>
    <div>
        <canvas ref="chartCanvas"></canvas>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { Chart } from "chart.js/auto"; // Import đầy đủ
import axios from "axios";

// Khai báo biến ref cho canvas
const chartCanvas = ref(null);
let chartInstance = null; // Để tránh tạo nhiều biểu đồ khi component re-render

onMounted(async () => {
    try {
        const response = await axios.get("/projects-progress");
        const progress_data = response.data.progress_data;

        if (!chartCanvas.value) return;

        // Hủy biểu đồ cũ nếu tồn tại (tránh lỗi chồng chéo)
        if (chartInstance) {
            chartInstance.destroy();
        }

        chartInstance = new Chart(chartCanvas.value, {
            type: "bar",
            data: {
                labels: progress_data.map((p) => p.project_name || "N/A"), // Nhãn của cột
                datasets: [
                    {
                        label: "Tiến độ công việc (%)",
                        data: progress_data.map((p) => p.progress),
                        backgroundColor: [
                            "green",
                            "yellow",
                            "orange",
                            "red",
                            "purple",
                            "blue",
                        ],
                    },
                ],
            },
        });
    } catch (e) {
        console.log(e);
    }
});
</script>
