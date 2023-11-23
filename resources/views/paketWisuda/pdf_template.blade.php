<!DOCTYPE html>
<html>

<head>
    <title>PDF Template</title>
    <!-- CSS untuk tata letak halaman -->
    <style>
        /* contoh CSS untuk tata letak halaman */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .header {
            /* Tinggi header yang Anda tentukan di sini */
            height: 100px;
            /* Atur posisi header di bagian atas halaman */
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
        }

        .content {
            /* Margin atas sebesar 150px dari header */
            margin-top: 50px;
            /* Margin bawah sebesar 50px dari footer */
            margin-bottom: 50px;
        }

        .footer {
            /* Tinggi footer yang Anda tentukan di sini */
            height: 50px;
            /* Atur posisi footer di bagian bawah halaman */
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
        }
    </style>
</head>

<body>
    <!-- content -->
    <div class="content">
        {!! $pdfContent !!}
    </div>

    <!-- Script untuk menampilkan footer di setiap halaman -->
    <script type="text/javascript">
        // Fungsi untuk menambahkan margin atas konten pada halaman-halaman berikutnya
        function addMarginToContentOnNextPages() {
            var headerHeight = document.querySelector('.header').offsetHeight;
            var contentElements = document.querySelectorAll('.content');

            // Loop untuk mengatur margin atas pada setiap elemen konten selain halaman pertama
            for (var i = 1; i < contentElements.length; i++) {
                contentElements[i].style.marginTop = headerHeight + 'px';
            }
        }

        // Panggil fungsi setelah halaman selesai dimuat
        document.addEventListener('DOMContentLoaded', function() {
            addMarginToContentOnNextPages();
        });
    </script>
</body>

</html>