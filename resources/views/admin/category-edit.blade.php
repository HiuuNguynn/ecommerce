@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Edit Category</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <a href="{{ route('admin.categories') }}">
                        <div class="text-tiny">Categories</div>
                    </a>
                </li>
                <li>
                    <i class="icon-chevron-right"></i>
                </li>
                <li>
                    <div class="text-tiny">Edit Category</div>
                </li>
            </ul>
        </div>

        <!-- Edit Brand -->
        <div class="wg-box">
            <form class="form-new-product form-style-1" action="{{ route('admin.category.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $category->id }}" />

                <fieldset class="name">
                    <div class="body-title">Category Name <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Category name" name="name"
                        tabindex="0" value="{{ old('name', $category->name) }}" aria-required="true" required="">
                </fieldset>
                @error('name') 
                    <span class="alert alert-danger text-center">{{ $message }}</span> 
                @enderror

                <fieldset class="name">
                    <div class="body-title">Category Slug <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Category Slug" name="slug"
                        tabindex="0" value="{{ old('slug', $category->slug) }}" aria-required="true" required="">
                </fieldset>
                @error('slug') 
                    <span class="alert alert-danger text-center">{{ $message }}</span> 
                @enderror

                <fieldset>
                    <div class="body-title">Upload Image <span class="tf-color-1">*</span></div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreview" @if(!$category->image) style="display:none" @endif>
                            <img id="previewImg" 
                                 src="{{ $category->image ? asset('uploads/categories/' . $category->image) : '' }}" 
                                 class="effect8" 
                                 alt="Preview Image">
                        </div>
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your images here or select 
                                    <span class="tf-color">click to browse</span>
                                </span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('image') 
                    <span class="alert alert-danger text-center">{{ $message }}</span> 
                @enderror

                <div class="bot">
                    <div></div>
                    <button class="tf-button w208" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Xem trước ảnh khi chọn file
        $("#myFile").on("change", function(e) {
            const file = this.files[0]; // Lấy file đầu tiên
            if (file) {
                $("#previewImg").attr("src", URL.createObjectURL(file)); // Cập nhật ảnh
                $("#imgpreview").show(); // Hiển thị ảnh xem trước
            }
        });

        // Tự động tạo Slug từ Brand Name nếu người dùng chưa nhập slug
        $("input[name='name']").on("input", function() {
            let slugField = $("input[name='slug']");
            if (!slugField.data("edited")) {
                slugField.val(StringToSlug($(this).val()));
            }
        });

        // Người dùng nhập slug thủ công thì không tự động thay đổi nữa
        $("input[name='slug']").on("input", function() {
            $(this).data("edited", true);
        });

        function StringToSlug(Text) {
            return Text.toLowerCase()
                .replace(/[^\w\s]/g, "")  // Loại bỏ ký tự đặc biệt
                .replace(/\s+/g, "-");    // Thay thế khoảng trắng bằng "-"
        }
    });
</script>
@endpush
