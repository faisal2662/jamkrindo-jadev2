<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Ikon</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .icon-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }

        .icon-item {
            width: 100px;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            flex-direction: column;
        }
        .icon-item p {
    margin: 5px 0 0;
    font-size: 12px;
    text-align: center;
    color: #555;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    max-width: 100%;
}

        .icon-item:hover {
            border-color: #007bff;
            background-color: #f1f1f1;
        }

        .icon-item img {
            max-width: 50px;
            max-height: 50px;
        }

        .icon-item.selected {
            border-color: #007bff;
            background-color: #e7f3ff;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <input type="text" id="search-icon" placeholder="Cari ikon..." class="form-control">
        <div id="icon-gallery" class="icon-container">
            @foreach ($icons as $icon)
                <div class="icon-item" data-name="{{ $icon['name'] }}">
                    <img src="{{ $icon['url'] }}" alt="{{ $icon['name'] }}">
                    <p> {{$icon['name']}} </p>
                </div>
            @endforeach
        </div>
        <button id="select-icon-btn" class="btn btn-primary mt-3" disabled>Pilih Ikon</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Pilih ikon
            $('.icon-item').on('click', function () {
                $('.icon-item').removeClass('selected');
                $(this).addClass('selected');
                $('#select-icon-btn').prop('disabled', false);
            });

            // Pencarian
            $('#search-icon').on('keyup', function () {
                const searchValue = $(this).val().toLowerCase();
                $('.icon-item').each(function () {
                    const iconName = $(this).data('name').toLowerCase();
                    if (iconName.includes(searchValue)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Tangkap ikon yang dipilih
            $('#select-icon-btn').on('click', function () {
                const selectedIcon = $('.icon-item.selected');
                const iconName = selectedIcon.data('name');
                const iconUrl = selectedIcon.find('img').attr('src');

                alert(`Ikon dipilih: ${iconName}`);
                console.log({ iconName, iconUrl });
            });
        });
    </script>
</body>
</html>
