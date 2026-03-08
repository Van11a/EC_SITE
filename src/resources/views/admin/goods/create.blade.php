<!DOCTYPE html>
<html lang="ja">

<head>
@include('admin/head')
<script type="text/javascript" src="{{ env('SITE_URL') }}/common/js/imageupload.js"></script>
<title>ES SITE</title>
</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">
    @include('admin/sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">
            @include('admin/topbar')

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">商品新規登録</h1>
                </div>

                <div class="form-wrap">
                    <form method="POST" action="{{ route('goods.create-confirm') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 row">
                            <label for="inputPartNumber" class="col-sm-2 col-form-label">型番<span class="text-danger fw-bold">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="part_number" class="form-control" id="inputPartNumber">
                                @if($errors->has('part_number'))
                                    <span>{{ $errors->first('part_number') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputName" class="col-sm-2 col-form-label">商品名<span class="text-danger fw-bold">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="name" class="form-control" id="inputName">
                                @if($errors->has('name'))
                                    <span>{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputParentCategory" class="col-sm-2 col-form-label">カテゴリー<span class="text-danger fw-bold">*</span></label>
                            <div class="col-sm-10">
                                <select name="parent_category_id" class="form-control" id="inputParentCategory" required>
                                    <option value="">選択してください</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('parent_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                {{--<input type="text" name="parent_category_id" class="form-control" id="inputParentCategory">--}}
                                @if($errors->has('parent_category_id'))
                                    <span>{{ $errors->first('parent_category_id') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputSubCategory" class="col-sm-2 col-form-label">サブカテゴリー</label>
                            <div class="col-sm-10">
                                <select name="sub_category_id" class="form-control" id="inputSubCategory" disabled>
                                    <option value="">選択してください</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label class="col-sm-2 col-form-label">画像１<span class="text-danger fw-bold">*</span></label>
                            <div class="col-sm-10">
                                <div class="mb-2">
                                    <img src="{{old('image1') ? Storage::disk('public')->url(old('image1')) : 'https://placehold.jp/100x100.png' }}" alt="" id="imagePreview1" class="d-none" style="max-width: 150px; height: auto; border: 1px solid #ddd; border-radius: 4px;">
                                </div>
                                <div class="d-flex align-items-center">
                                    <input type="file" id="imageFile1" name="image1" accept="image/*" class="d-none" value="{{old('image1')}}" >
                                    <label class="btn btn-outline-secondary mr-2 mb-0" for="imageFile1" id="fileSelectLabel1">
                                        ファイルを選択
                                    </label>
                                    <span id="fileNameDisplay1" class="text-muted">選択されていません</span>
                                </div>
                                @if($errors->has('image1'))
                                    <span>{{ $errors->first('image1') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label class="col-sm-2 col-form-label">画像２</label>
                            <div class="col-sm-10">
                                <div class="mb-2">
                                    <img src="{{old('image2') ? Storage::disk('public')->url(old('image2')) : 'https://placehold.jp/100x100.png' }}" alt="" id="imagePreview2" class="d-none" style="max-width: 150px; height: auto; border: 1px solid #ddd; border-radius: 4px;">
                                </div>
                                <div class="d-flex align-items-center">
                                    <input type="file" id="imageFile2" name="image2" accept="image/*" class="d-none" value="{{old('image2')}}" >
                                    <label class="btn btn-outline-secondary mr-2 mb-0" for="imageFile2" id="fileSelectLabel2">
                                        ファイルを選択
                                    </label>
                                    <span id="fileNameDisplay2" class="text-muted">選択されていません</span>
                                </div>
                                @if($errors->has('image2'))
                                    <span>{{ $errors->first('image2') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label class="col-sm-2 col-form-label">画像３</label>
                            <div class="col-sm-10">
                                <div class="mb-2">
                                    <img src="{{old('image3') ? Storage::disk('public')->url(old('image3')) : 'https://placehold.jp/100x100.png' }}" alt="" id="imagePreview3" class="d-none" style="max-width: 150px; height: auto; border: 1px solid #ddd; border-radius: 4px;">
                                </div>
                                <div class="d-flex align-items-center">
                                    <input type="file" id="imageFile3" name="image3" accept="image/*" class="d-none" value="{{old('image3')}}" >
                                    <label class="btn btn-outline-secondary mr-2 mb-0" for="imageFile3" id="fileSelectLabel3">
                                        ファイルを選択
                                    </label>
                                    <span id="fileNameDisplay3" class="text-muted">選択されていません</span>
                                </div>
                                @if($errors->has('image3'))
                                    <span>{{ $errors->first('image3') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label class="col-sm-2 col-form-label">画像４</label>
                            <div class="col-sm-10">
                                <div class="mb-2">
                                    <img src="{{old('image4') ? Storage::disk('public')->url(old('image4')) : 'https://placehold.jp/100x100.png' }}" alt="" id="imagePreview4" class="d-none" style="max-width: 150px; height: auto; border: 1px solid #ddd; border-radius: 4px;">
                                </div>
                                <div class="d-flex align-items-center">
                                    <input type="file" id="imageFile4" name="image4" accept="image/*" class="d-none" value="{{old('image4')}}" >
                                    <label class="btn btn-outline-secondary mr-2 mb-0" for="imageFile4" id="fileSelectLabel4">
                                        ファイルを選択
                                    </label>
                                    <span id="fileNameDisplay4" class="text-muted">選択されていません</span>
                                </div>
                                @if($errors->has('image4'))
                                    <span>{{ $errors->first('image4') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label class="col-sm-2 col-form-label">画像５</label>
                            <div class="col-sm-10">
                                <div class="mb-2">
                                    <img src="{{old('image5') ? Storage::disk('public')->url(old('image5')) : 'https://placehold.jp/100x100.png' }}" alt="" id="imagePreview5" class="d-none" style="max-width: 150px; height: auto; border: 1px solid #ddd; border-radius: 4px;">
                                </div>
                                <div class="d-flex align-items-center">
                                    <input type="file" id="imageFile5" name="image5" accept="image/*" class="d-none" value="{{old('image5')}}" >
                                    <label class="btn btn-outline-secondary mr-2 mb-0" for="imageFile5" id="fileSelectLabel5">
                                        ファイルを選択
                                    </label>
                                    <span id="fileNameDisplay5" class="text-muted">選択されていません</span>
                                </div>
                                @if($errors->has('image5'))
                                    <span>{{ $errors->first('image5') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label class="col-sm-2 col-form-label">おすすめ設定</label>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input type="hidden" name="is_reccomend" value="0">
                                    <input class="form-check-input" name="is_reccomend" type="checkbox" value="1" @if (old('is_reccomend') === 1) checked @endif>
                                    <label class="form-check-label">
                                        設定する
                                    </label>
                                </div>
                                @if($errors->has('is_reccomend'))
                                    <span>{{ $errors->first('is_reccomend') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label class="col-sm-2 col-form-label">表示期間</label>
                            <div class="col-sm-10">
                                <div class="row g-2 align-items-center">
                                    <div class="col-auto">
                                        <input type="datetime-local" class="form-control" id="startDate" name="public_start_date" aria-label="開始日" @if((old('public_start_date'))) value="{{old('public_start_date')}}" @endif>
                                    </div>
                                    <div class="col-auto">
                                        <span class="text-muted">〜</span>
                                    </div>
                                    <div class="col-auto">
                                        <input type="datetime-local" class="form-control" id="endDate" name="public_end_date" aria-label="終了日" @if((old('public_end_date'))) value="{{old('public_end_date')}}" @endif>
                                    </div>
                                    @if($errors->has('public_start_date') || $errors->has('public_end_date'))
                                        <div class="col-12 mt-1">
                                            @if($errors->has('public_start_date'))
                                                <span>{{ $errors->first('public_start_date') }}</span>
                                            @endif
                                            @if($errors->has('public_end_date'))
                                                <span>{{ $errors->first('public_end_date') }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputStock" class="col-sm-2 col-form-label">在庫数</label>
                            <div class="col-sm-10">
                                <input type="number" name="stock" class="form-control" id="inputStock">
                                @if($errors->has('stock'))
                                    <span>{{ $errors->first('stock') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputAmount" class="col-sm-2 col-form-label">商品金額<span class="text-danger fw-bold">*</span></label>
                            <div class="col-sm-10">
                                <input type="number" name="amount" class="form-control" id="inputAmount">
                                @if($errors->has('amount'))
                                    <span>{{ $errors->first('amount') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="inputCost" class="col-sm-2 col-form-label">コスト</label>
                            <div class="col-sm-10">
                                <input type="number" name="cost" class="form-control" id="inputCost">
                                @if($errors->has('cost'))
                                    <span>{{ $errors->first('cost') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label class="col-sm-2 col-form-label">表示設定<span class="text-danger fw-bold">*</span></label>
                            <div class="col-sm-10">
                                <div class="d-flex"> 
                                    <div class="form-check mr-2">
                                        <input class="form-check-input" type="radio" name="is_display" id="displayOn" value="1" @if(old('is_display',1) == 1) checked @endif>
                                        <label class="form-check-label" for="displayOn">
                                            表示
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_display" id="displayOff" value="0" @if(old('is_display',0) == 0) checked @endif>
                                        <label class="form-check-label" for="displayOff">
                                            非表示
                                        </label>
                                    </div>
                                </div>
                                @if($errors->has('is_display'))
                                    <span>{{ $errors->first('is_display') }}</span>
                                @endif
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" onclick="CheckImagesSize();">入力確認へ</button>
                    </form>
                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<script>
    $('#inputParentCategory').change(function(){
        $('#inputSubCategory').empty(); //要素のリセット
        const seleted_category_id = $(this).val();

        if(seleted_category_id){
            fetch(`/admin/category/${seleted_category_id}/subcategories`)
            .then(response => {
                return response.json();
            })
            .then(data => {
                $('#inputSubCategory').prop('disabled',false);
                $.each(data.sub_categories, function(index, val) {
                $('#inputSubCategory').append('<option value="' + val.id + '">' + val.name + '</option>');
            });
            })
            .catch(error => {
                console.error("エラー詳細:", error);
                console.log("失敗しました");
            });
        }else{
            $('#inputSubCategory').empty();
            $('#inputSubCategory').append('<option value="">選択してください</option>');
            $('#inputSubCategory').prop('disabled',true);
        }
    });
</script>
</body>

</html>