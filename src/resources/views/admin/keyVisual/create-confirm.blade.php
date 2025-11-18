<!DOCTYPE html>
<html lang="ja">

<head>
    @include('admin/head')
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
                        <h1 class="h3 mb-0 text-gray-800">キービジュアル新規登録</h1>
                    </div>

                    <div class="form-wrap">
                        <form method="POST" action="{{ route('keyvisual.store') }}">
                            @csrf
                            <div class="mb-3 row">
                                <label for="inputTitle" class="col-sm-2 col-form-label">タイトル<span class="text-danger fw-bold">*</span></label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="title" value="{{$key_visual['title']}}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">画像<span class="text-danger fw-bold">*</span></label>
                                <div class="col-sm-10">
                                    <img style="max-height:250px;" src="{{ $key_visual['image'] ? Storage::disk('public')->url($key_visual['image']) : 'https://placehold.jp/100x100.png' }}">
                                    <input type="hidden" name="image" value="{{$key_visual['image']}}" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputUrl" class="col-sm-2 col-form-label">URL</label>
                                <div class="col-sm-10">
                                    @if (isset($key_visual['url']))
                                        {{$key_visual['url']}}
                                    @endif
                                    <input type="hidden" name="url" value="{{$key_visual['url']}}" />
                                    @if (isset($key_visual['url']) && $key_visual['is_new_window'] == 1)
                                        <br>（新規ウィンドウで開く）
                                    @endif
                                    <input type="hidden" name="is_new_window" value="{{$key_visual['is_new_window']}}" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">別窓表示</label>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <input type="hidden" name="is_new_window" value="0">
                                        <input class="form-check-input" name="is_new_window" type="checkbox" value="1" @if (old('is_new_window') === 1) checked @endif>
                                        <label class="form-check-label">
                                            この設定を有効にする
                                        </label>
                                    </div>
                                    @if($errors->has('is_new_window'))
                                        <span>{{ $errors->first('is_new_window') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">表示期間</label>
                                <div class="col-sm-10">
                                    <div class="row g-2 align-items-center">
                                        <div class="col-auto">
                                            <input type="date" class="form-control" id="startDate" name="public_start_date" aria-label="開始日" @if((old('public_start_date'))) value="{{old('public_start_date')}}" @endif>
                                        </div>
                                        <div class="col-auto">
                                            <span class="text-muted">〜</span>
                                        </div>
                                        <div class="col-auto">
                                            <input type="date" class="form-control" id="endDate" name="public_end_date" aria-label="終了日" @if((old('public_end_date'))) value="{{old('public_end_date')}}" @endif>
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
                                <label for="inputDisplayOrder" class="col-sm-2 col-form-label">表示順</label>
                                <div class="col-sm-3">
                                    <input 
                                        type="number" 
                                        name="display_order" 
                                        class="form-control" 
                                        id="inputDisplayOrder"
                                        min="0"
                                        step="1"
                                        inputmode="numeric"
                                        pattern="\d*"
                                        value="{{ old('display_order')}}"
                                    >
                                    @if($errors->has('display_order'))
                                        <span>{{ $errors->first('display_order') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
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
                            <button type="submit" class="btn btn-primary">登録する</button>
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
</body>

</html>