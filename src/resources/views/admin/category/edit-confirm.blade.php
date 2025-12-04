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
                        <h1 class="h3 mb-0 text-gray-800">カテゴリー登録確認</h1>
                    </div>

                    @php
                        $input_data = session('input_data');
                    @endphp
                    <div class="form-wrap">
                        <form method="POST" action="{{ route('category.update', $category) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">カテゴリー名</label>
                                <div class="col-sm-10">
                                    {{$input_data['name']}}
                                </div>
                                <input type="hidden" name="name" value="{{$input_data['name']}}">
                            </div>
                            {{-- <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">表示順</label>
                                <div class="col-sm-10">
                                    {{$input_data['display_order']}}
                                </div>
                                <input type="hidden" name="display_order" value="{{$input_data['display_order']}}">
                            </div> --}}
                            <button type="submit" class="btn btn-primary">入力確認へ</button>
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