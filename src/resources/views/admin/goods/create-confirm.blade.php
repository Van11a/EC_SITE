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
                        <h1 class="h3 mb-0 text-gray-800">管理者登録確認</h1>
                    </div>

                    <div class="form-wrap">
                        <form method="POST" action="{{ route('user.store') }}">
                            @csrf
                            <div class="mb-3 row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">管理者名</label>
                                <div class="col-sm-10">
                                    {{$user['name']}}
                                </div>
                                <input type="hidden" name="name" value="{{$user['name']}}">
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">ログインID</label>
                                <div class="col-sm-10">
                                    {{$user['login_id']}}
                                </div>
                                <input type="hidden" name="login_id" value="{{$user['login_id']}}">
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">パスワード</label>
                                <div class="col-sm-10">
                                    {{$user['password']}}
                                </div>
                                <input type="hidden" name="password" value="{{$user['password']}}">
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