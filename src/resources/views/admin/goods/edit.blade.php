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
                        <h1 class="h3 mb-0 text-gray-800">管理者編集</h1>
                    </div>

                    <div class="form-wrap">
                        <form method="POST" action="{{ route('user.edit-confirm',$user) }}">
                            @csrf
                            <div class="mb-3 row">
                                <label for="inputName" class="col-sm-2 col-form-label">管理者名</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" value="{{ $user->name }}" class="form-control" id="inputName">
                                    @if($errors->has('name'))
                                        <span>{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputId" class="col-sm-2 col-form-label">ログインID</label>
                                <div class="col-sm-10">
                                    <input type="text" name="login_id" value="{{ $user->login_id }}" class="form-control" id="inputId">
                                    @if($errors->has('login_id'))
                                        <span>{{ $errors->first('login_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">パスワード</label>
                                <div class="col-sm-10">
                                    <input type="password" name="password" class="form-control" id="inputPassword">
                                    @if($errors->has('password'))
                                        <span>{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="inputPasswordConfirmation" class="col-sm-2 col-form-label">パスワード確認</label>
                                <div class="col-sm-10">
                                    <input type="password" name="password_confirmation" class="form-control" id="inputPasswordConfirmation">
                                    @if($errors->has('password_confirmation'))
                                        <span>{{ $errors->first('password_confirmation') }}</span>
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