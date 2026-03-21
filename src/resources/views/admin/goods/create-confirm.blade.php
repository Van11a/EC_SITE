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
                        <h1 class="h3 mb-0 text-gray-800">商品登録確認</h1>
                    </div>

                    <div class="form-wrap">
                        <form method="POST" action="{{ route('goods.store') }}">
                            @csrf
                            <div class="mb-3 row">
                                <label for="inputTitle" class="col-sm-2 col-form-label">型番<span class="text-danger fw-bold">*</span></label>
                                <div class="col-sm-10">
                                    {{$goods['part_number']}}
                                    <input type="hidden" name="part_number" value="{{$goods['part_number']}}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputTitle" class="col-sm-2 col-form-label">商品名<span class="text-danger fw-bold">*</span></label>
                                <div class="col-sm-10">
                                    {{$goods['name']}}
                                    <input type="hidden" name="name" value="{{$goods['name']}}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputTitle" class="col-sm-2 col-form-label">カテゴリー<span class="text-danger fw-bold">*</span></label>
                                <div class="col-sm-10">
                                    {{ $categories->firstWhere('id', $goods['parent_category_id'])->name ?? '' }}
                                    <input type="hidden" name="category_id" value="{{ isset($goods['sub_category_id']) ? $goods['sub_category_id'] : $goods['parent_category_id'] }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputTitle" class="col-sm-2 col-form-label">サブカテゴリー</label>
                                <div class="col-sm-10">
                                    {{ $categories->firstWhere('id', $goods['sub_category_id'])->name ?? '' }}
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">画像１<span class="text-danger fw-bold">*</span></label>
                                <div class="col-sm-10">
                                    <img style="max-height:250px;" src="{{ $goods['image1'] ? Storage::disk('public')->url($goods['image1']) : 'https://placehold.jp/100x100.png' }}">
                                    <input type="hidden" name="image1" value="{{$goods['image1']}}" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">画像２</label>
                                <div class="col-sm-10">
                                    <img style="max-height:250px;" src="{{ (isset($goods['image2']) && $goods['image2']) ? Storage::disk('public')->url($goods['image2']) : 'https://placehold.jp/100x100.png' }}">
                                    <input type="hidden" name="image2" value="{{ isset($goods['image2']) ? $goods['image2'] : '' }}" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">画像３</label>
                                <div class="col-sm-10">
                                    <img style="max-height:250px;" src="{{ (isset($goods['image3']) && $goods['image3']) ? Storage::disk('public')->url($goods['image3']) : 'https://placehold.jp/100x100.png' }}">
                                    <input type="hidden" name="image3" value="{{ isset($goods['image3']) ? $goods['image3'] : '' }}" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">画像４</label>
                                <div class="col-sm-10">
                                    <img style="max-height:250px;" src="{{ (isset($goods['image4']) && $goods['image4']) ? Storage::disk('public')->url($goods['image4']) : 'https://placehold.jp/100x100.png' }}">
                                    <input type="hidden" name="image4" value="{{ isset($goods['image4']) ? $goods['image4'] : '' }}" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">画像５</label>
                                <div class="col-sm-10">
                                    <img style="max-height:250px;" src="{{ (isset($goods['image5']) && $goods['image5']) ? Storage::disk('public')->url($goods['image5']) : 'https://placehold.jp/100x100.png' }}">
                                    <input type="hidden" name="image5" value="{{ isset($goods['image5']) ? $goods['image5'] : '' }}" />
                                </div>
                            </div>
                            <div class="mb-4 row">
                                <label for="inputText" class="col-sm-2 col-form-label">説明文<span class="text-danger fw-bold">*</span></label>
                                <div class="col-sm-10">
                                    {{ $goods['text'] }}
                                    <input type="hidden" name="text" value="{{ isset($goods['text']) ? $goods['text'] : '' }}" />
                                    @if($errors->has('text'))
                                        <span>{{ $errors->first('text') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputUrl" class="col-sm-2 col-form-label">おすすめ設定</label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="is_reccomend" value="{{$goods['is_reccomend']}}" />
                                    @if (isset($goods['is_reccomend']) && $goods['is_reccomend'] == 1)
                                        設定する
                                    @endif
                                    <input type="hidden" name="is_new_window" value="{{ isset($goods['is_new_window']) ? $goods['is_new_window'] : '' }}" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">表示期間</label>
                                <div class="col-sm-10">
                                    <div class="row g-2 align-items-center">
                                        @if (isset($goods['public_start_date'])||isset($goods['public_end_date']))
                                            @if (isset($goods['public_start_date']))
                                                {{date('Y/n/j H:i', strtotime($goods['public_start_date']))}} 
                                            @endif
                                            ～ 
                                            @if (isset($goods['public_end_date']))
                                                {{date('Y/n/j H:i', strtotime($goods['public_end_date']))}}
                                            @endif
                                        @endif
                                        <input type="hidden" name="public_start_date" value="{{ isset($goods['public_start_date']) ? $goods['public_start_date'] : '' }}" />
                                        <input type="hidden" name="public_end_date" value="{{ isset($goods['public_end_date']) ? $goods['public_end_date'] : '' }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputTitle" class="col-sm-2 col-form-label">在庫数</label>
                                <div class="col-sm-10">
                                    {{ isset($goods['stock']) ? $goods['stock'] : '' }}
                                    <input type="hidden" name="stock" value="{{ isset($goods['stock']) ? $goods['stock'] : '' }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputTitle" class="col-sm-2 col-form-label">商品金額<span class="text-danger fw-bold">*</span></label>
                                <div class="col-sm-10">
                                    {{$goods['amount']}}
                                    <input type="hidden" name="amount" value="{{ ($goods['amount']) }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputTitle" class="col-sm-2 col-form-label">コスト</label>
                                <div class="col-sm-10">
                                    {{ isset($goods['cost']) ? $goods['cost'] : '' }}
                                    <input type="hidden" name="cost" value="{{ isset($goods['cost']) ? $goods['cost'] : '' }}">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">表示設定<span class="text-danger fw-bold">*</span></label>
                                <div class="col-sm-10">
                                    @if ($goods['is_display'] == 1)
                                        表示
                                    @elseif ($goods['is_display'] == 0)
                                        非表示
                                    @endif
                                    <input type="hidden" name="is_display" value="{{$goods['is_display']}}" />
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