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
                        <h1 class="h3 mb-0 text-gray-800">キービジュアル削除確認</h1>
                    </div>

                    <div class="form-wrap">
                        <form method="POST" action="{{ route('key_visual.destroy', $key_visual) }}">
                            @csrf
                            @method('DELETE')

                            <div class="mb-3 row">
                                <label for="inputTitle" class="col-sm-2 col-form-label">タイトル<span class="text-danger fw-bold">*</span></label>
                                <div class="col-sm-10">
                                    {{$key_visual['title']}}
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">画像<span class="text-danger fw-bold">*</span></label>
                                <div class="col-sm-10">
                                    @if(isset($key_visual['image']))
                                        <img style="max-height:250px;" src="{{Storage::disk('public')->url($key_visual['image'])}}"/>
                                    @else
                                        <img style="max-height:250px;" src="https://placehold.jp/100x100.png"/>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputUrl" class="col-sm-2 col-form-label">URL</label>
                                <div class="col-sm-10">
                                    @if (isset($key_visual['url']))
                                        {{$key_visual['url']}}
                                    @endif
                                    @if (isset($key_visual['url']) && $key_visual['is_new_window'] == 1)
                                        <br>（新規ウィンドウで開く）
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">表示期間</label>
                                <div class="col-sm-10">
                                    <div class="row g-2 align-items-center">
                                        @if (isset($key_visual['public_start_date'])||isset($key_visual['public_end_date']))
                                            @if (isset($key_visual['public_start_date']))
                                                {{date('Y/n/j H:i', strtotime($key_visual['public_start_date']))}} 
                                            @endif
                                            ～ 
                                            @if (isset($key_visual['public_end_date']))
                                                {{date('Y/n/j H:i', strtotime($key_visual['public_end_date']))}}
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputDisplayOrder" class="col-sm-2 col-form-label"><span class="text-danger fw-bold">*</span>表示順</label>
                                <div class="col-sm-3">
                                    {{$key_visual['display_order']}}
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">表示設定<span class="text-danger fw-bold">*</span></label>
                                <div class="col-sm-10">
                                    @if ($key_visual['is_display'] == 1)
                                        表示
                                    @elseif ($key_visual['is_display'] == 0)
                                        非表示
                                    @endif
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">削除する</button>
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