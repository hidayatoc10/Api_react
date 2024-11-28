<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ Auth::user()->username }}</title>
</head>

<body>
    <form action="/home" method="post">
        @csrf
        <label for="nama">Nama</label><br>
        <input type="text" name="nama" id="nama" class="@error('nama') error @enderror" autofocus required
            maxlength="100">
        @error('nama')
            <div style="color: red">{{ $message }}</div>
        @enderror
        <p>

            <label for="username">Username</label><br>
            <input type="text" name="username" id="username" required
                maxlength="100">
        <p>

            <label for="nomor_telepon">Nomor Telepon</label><br>
            <input type="number" name="nomor_telepon" id="nomor_telepon" required maxlength="14">
        <p>

            <label for="email">Email</label><br>
            <input type="email" name="email" id="email" required maxlength="50">
        <p>

            <label for="password">Password</label><br>
            <input type="password" name="password" id="password" required maxlength="100">
        <p>

            <button type="submit">Tambah User</button>
    </form>
    <h3>Ingin logout? <a onclick="fungsi();" style="color: salmon; cursor: pointer">klik disini</a></h3>

    <script>
        function fungsi() {
            swal({
                    title: "Apkaha Anda Ingin Logout",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    window.location.href = '/logout';
                    if (willDelete) {
                        window.url('/logout');
                        swal("Poof! Your file has been deleted!", {
                            icon: "success",
                        });
                    }
                });
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <style>
        form .username {
            border-color: red;
        }
    </style>
</body>

</html>
