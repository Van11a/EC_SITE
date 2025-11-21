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
                        <h1 class="h3 mb-0 text-gray-800">キービジュアル登録確認</h1>
                    </div>

                    @php
                        $input_data = session('input_data');
                    @endphp
                    <div class="form-wrap">
                        <form method="POST" action="{{ route('key_visual.update', $key_visual) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3 row">
                                <label for="inputTitle" class="col-sm-2 col-form-label">タイトル<span class="text-danger fw-bold">*</span></label>
                                <div class="col-sm-10">
                                    {{$input_data['title']}}
                                    <input type="hidden" name="title" value="{{$input_data['title']}}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">画像<span class="text-danger fw-bold">*</span></label>
                                <div class="col-sm-10">
                                    @if(isset($input_data['image']))
                                        <img style="max-height:250px;" src="{{Storage::disk('public')->url($input_data['image'])}}"/>
                                    @elseif(isset($input_data['before_image']))
                                        <img style="max-height:250px;" src="{{Storage::disk('public')->url($input_data['before_image'])}}"/>
                                    @else
                                        <img style="max-height:250px;" src="https://placehold.jp/100x100.png"/>
                                    @endif
                                    <input type="hidden" name="image" value="{{ $input_data['image'] }}"/>
                                    <input type="hidden" name="before_image" value="{{ $input_data['before_image'] }}"/>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputUrl" class="col-sm-2 col-form-label">URL</label>
                                <div class="col-sm-10">
                                    @if (isset($input_data['url']))
                                        {{$input_data['url']}}
                                    @endif
                                    <input type="hidden" name="url" value="{{$input_data['url']}}" />
                                    @if (isset($input_data['url']) && $input_data['is_new_window'] == 1)
                                        <br>（新規ウィンドウで開く）
                                    @endif
                                    <input type="hidden" name="is_new_window" value="{{$input_data['is_new_window']}}" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">表示期間</label>
                                <div class="col-sm-10">
                                    <div class="row g-2 align-items-center">
                                        @if (isset($input_data['public_start_date'])||isset($input_data['public_end_date']))
                                            @if (isset($input_data['public_start_date']))
                                                {{date('Y/n/j H:i', strtotime($input_data['public_start_date']))}} 
                                            @endif
                                            ～ 
                                            @if (isset($input_data['public_end_date']))
                                                {{date('Y/n/j H:i', strtotime($input_data['public_end_date']))}}
                                            @endif
                                        @endif
                                        <input type="hidden" name="public_start_date" value="{{$input_data['public_start_date']}}" />
                                        <input type="hidden" name="public_end_date" value="{{$input_data['public_end_date']}}" />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputDisplayOrder" class="col-sm-2 col-form-label"><span class="text-danger fw-bold">*</span>表示順</label>
                                <div class="col-sm-3">
                                    {{$input_data['display_order']}}
                                    <input type="hidden" name="display_order" value="{{$input_data['display_order']}}" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">表示設定<span class="text-danger fw-bold">*</span></label>
                                <div class="col-sm-10">
                                    @if ($input_data['is_display'] == 1)
                                        表示
                                    @elseif ($input_data['is_display'] == 0)
                                        非表示
                                    @endif
                                    <input type="hidden" name="is_display" value="{{$input_data['is_display']}}" />
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