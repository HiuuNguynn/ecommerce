@extends('layouts.admin')

@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Category Information</h3>
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
                    <div class="text-tiny">New Caterory</div>
                </li>
            </ul>
        </div>

        <!-- new-category -->
        <div class="wg-box">
            <form class="form-new-product form-style-1" action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <fieldset class="name">
                    <div class="body-title">Caterory Name <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Caterory name" name="name"
                        tabindex="0" value="{{ old('name') }}" aria-required="true" required="">
                </fieldset>
                @error('name') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset class="name">
                    <div class="body-title">Caterory Slug <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" placeholder="Caterory Slug" name="slug" tabindex="0" value="{{ old('slug') }}" aria-required="true" required="">
                </fieldset>
                @error('slug') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

                <fieldset>
                    <div class="body-title">Upload Image <span class="tf-color-1">*</span></div>
                    <div class="upload-image flex-grow">
                        <div class="item" id="imgpreview" style="display:none">
                            <img id="previewImg" src="" class="effect8" alt="Preview Image">
                        </div>
                        <div id="upload-file" class="item up-load">
                            <label class="uploadfile" for="myFile">
                                <span class="icon">
                                    <i class="icon-upload-cloud"></i>
                                </span>
                                <span class="body-text">Drop your image here or select <span class="tf-color">click to browse</span></span>
                                <input type="file" id="myFile" name="image" accept="image/*">
                            </label>
                        </div>
                    </div>
                </fieldset>
                @error('image') <span class="alert alert-danger text-center">{{ $message }}</span> @enderror

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

        // Tự động tạo slug từ name
        $("input[name='name']").on("input", function() {
            $("input[name='slug']").val(StringToSlug($(this).val()));
        });

        function StringToSlug(Text) {
            return Text.toLowerCase()
                .replace(/[^\w\s]/g, "")  // Loại bỏ ký tự đặc biệt
                .replace(/\s+/g, "-");    // Thay thế khoảng trắng bằng "-"
        }
    });
</script>
@endpush
