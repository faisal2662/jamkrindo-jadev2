<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Table</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .form-check {
            margin-bottom: 15px;
        }

        .dynamic-column {
            border: 1px solid #ced4da;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Tambah Table</h2>
        <form action="{{ route('table.store') }}" id="form" method="POST">
            @csrf
            <div class="form-group">
                <label for="tableName">Nama Table</label>
                <input type="text" class="form-control" id="tableName" name="tableName"
                    placeholder="Masukkan nama table" required>
            </div>

            <div id="columnsContainer">
                <div class="dynamic-column mb-3">
                    <div class="form-group">
                        <label for="columnName_0">Nama Kolom</label>
                        <input type="text" class="form-control" id="columnName_0" name="columnName[]"
                            placeholder="Masukkan nama kolom" required>
                    </div>
                    <div class="form-group">
                        <label for="columnType_0">Tipe Kolom</label>
                        <select class="form-control" id="columnType_0" name="columnType[]">
                            <option value="string">String</option>
                            <option value="integer">Integer</option>
                            <option value="boolean">Boolean</option>
                            <option value="date">Date</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="lengthValue_0">Length / Value</label>
                        <input type="text" class="form-control" id="lengthValue_0" name="lengthValue[]"
                            placeholder="Masukkan panjang nilai">
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="asDefined_0" name="asDefined_0[]">
                        <label class="form-check-label" for="asDefined_0">As Defined</label>
                    </div>
                    <div class="form-group" id="group-default-null-0" style="display: none;">
                        <label for="defaultValue_0">Default Value</label>
                        <input type="text" class="form-control" id="defaultValue_0" name="defaultValue[]"
                            placeholder="Masukkan nilai default">
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="isNull_0" name="asNull[]">
                        <label class="form-check-label" for="is_null_0">is Null</label>
                    </div>

                </div>
            </div>

            <button type="button" class="btn btn-secondary mb-3" id="addColumn"> <i class="bi bi-plus-circle"></i>
                Tambah Kolom</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
            let columnIndex = 1; // Index untuk ID unik

            $('#addColumn').click(function() {
                var columnHtml = `
                <div class="dynamic-column mb-3">
                    <div class="form-group">
                        <label for="columnName_${columnIndex}">Nama Kolom (${columnIndex})</label>
                        <input required type="text" class="form-control" id="columnName_${columnIndex}" name="columnName[]" placeholder="Masukkan nama kolom" required>
                    </div>
                    <div class="form-group">
                        <label for="columnType_${columnIndex}">Tipe Kolom (${columnIndex})</label>
                        <select class="form-control" required id="columnType_${columnIndex}" name="columnType[]">
                            <option value="string">String</option>
                            <option value="integer">Integer</option>
                            <option value="boolean">Boolean</option>
                            <option value="date">Date</option>
                            <option value="text">TEXT</option>
                            <option value="timestamp">TimeStamp</option>
                        </select>
                    </div>
                     <div class="form-group">
                    <label for="lengthValue_0">Length / Value (${columnIndex})</label>
                    <input type="text" class="form-control" required id="lengthValue_0" name="lengthValue[]" placeholder="Masukkan panjang nilai">
                </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input"  id="asDefined_${columnIndex}" name="asDefined_${columnIndex}[]">
                    <label class="form-check-label" for="asDefined_${columnIndex}">As Defined (${columnIndex})</label>
                </div>
                <div class="form-group group-default-null_${columnIndex}" id="group-default-null_asDefined_${columnIndex}" style="display: none;">
                   <label for="defaultValue_${columnIndex}">Default Value (${columnIndex})</label>
                  <input type="text" class="form-control" id="defaultValue_${columnIndex}" name="defaultValue[]" placeholder="Masukkan nilai default">
                 </div>
                <div class="form-check">
                    <input type="checkbox" class="form-check-input"  id="isNull_${columnIndex}" name="asNull_${columnIndex}[]">
                    <label class="form-check-label" for="is_null_${columnIndex}">is Null (${columnIndex})</label>
                </div>

                    <button type="button" class="btn btn-danger remove-column">Hapus Kolom (${columnIndex})</button>
                </div>
            `;
                $('#columnsContainer').append(columnHtml);
                $(`#asDefined_${columnIndex}`).change(function() {

                    if (this.checked) {
                        console.log('checked_' + this.id);
                        $(`#group-default-null_${this.id}`).show('slow'); // Tampilkan elemen
                    } else {
                        console.log('unchecked_' + this.id);
                        $(`#group-default-null_${this.id}`).hide('slow'); // Sembunyikan elemen
                        $(`#group-default-null_${this.id}`).val(''); // Sembunyikan elemen
                    }
                });
                columnIndex++; // Increment index untuk ID unik
            });
            $('#asDefined_0').change(function() {
                if (this.checked) {
                    $('#group-default-null-0').show('slow');
                    console.log('checked_' + this.id);
                } else {
                    $('#group-default-null-0').hide('slow');
                    $('#group-default-null-0').val('');
                    console.log('unchecked_' + this.id);
                }
            });


            $(document).on('click', '.remove-column', function() {
                $(this).closest('.dynamic-column').remove();
            });
            $('form').on('submit', function(e) {
                // Validasi nama tabel
                var tableName = $('#tableName').val();
                if (!isValidName(tableName)) {
                    e.preventDefault();
                    alert('Nama tabel tidak boleh mengandung spasi atau strip.');
                    return;
                }

                // Validasi nama kolom
                var isValid = true;
                $('input[name="columnName[]"]').each(function() {
                    if (!isValidName($(this).val())) {
                        isValid = false;
                        return false; // Break the loop
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('Nama kolom tidak boleh mengandung spasi atau strip.');
                }
            });

            function isValidName(name) {
                // Cek apakah nama valid (tidak mengandung spasi atau strip)
                return /^[^\s-]+$/.test(name);
            }
        });
    </script>
</body>

</html>
