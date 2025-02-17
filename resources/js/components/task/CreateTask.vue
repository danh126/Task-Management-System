<template>
    <div>
        <h3 class="text-center mt-2 mb-2">Thêm nhiệm vụ mới</h3>
        <div class="form-group">
            <label for="">Tiêu đề</label>
            <input type="text" class="form-control mt-2 mb-2" />
        </div>
        <div class="form-group">
            <label for="">Mô tả</label>
            <textarea class="form-control mt-2 mb-2"></textarea>
        </div>
        <div class="form-group">
            <label for="">Dự án</label>
            <select class="form-select mt-2 mb-2">
                <option value=""></option>
            </select>
        </div>
        <div class="form-group">
            <label for="">Người phụ trách</label>
            <select class="form-select mt-2 mb-2">
                <option value=""></option>
            </select>
        </div>
        <div class="form-group">
            <label for="">Trạng thái</label>
            <select class="form-select mt-2 mb-2">
                <option value=""></option>
            </select>
        </div>
        <div class="form-group">
            <label for="">Mức độ ưu tiên</label>
            <select class="form-select mt-2 mb-2">
                <option value=""></option>
            </select>
        </div>
        <div class="form-group">
            <label for="">Ngày hết hạn</label>
            <input type="date" class="form-control mt-2 mb-2" />
        </div>

        <div class="form-group text-center mt-2 mb-2">
            <button class="btn btn-primary me-2">Thêm nhiệm vụ</button>
            <button class="btn btn-danger">Thoát</button>
        </div>
    </div>
</template>

<script setup></script>
