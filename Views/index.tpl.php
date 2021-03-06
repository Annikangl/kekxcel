<?php include("./Views/layouts/header.tpl.php"); ?>


<?php

?>
<main class="main">
    <section class="filters-sec">
        <div class="container">

            <div class="row">
                <div class="search__area">
                    <form id="search_form" class="col-md-4">

                        <div class="form-outline">
                            <input type="search" id="search-input"" class=" form-control" name="search-input" placeholder="Поиск" aria-label="Search" />
                        </div>
                        <!-- <div class="col s4">
                            <input type="text" name="search-input" id="search-input" placeholder="Введите запрос">
                        </div> -->
                    </form>
                </div>
            </div>
        </div>

            <div class="row">
                <div class="col-md-4">
                    <select id="select-time" class="form-control">
                        <option value="" disabled selected>Выберите время импорта</option>
                        <?php if (isset($pageData['timestamp'])) : ?>
                            <?php foreach ($pageData['timestamp'] as $item) : ?>
                                <option value="<?= $item; ?>"><?= $item; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <label>Временная метка</label>
                </div>
                <div class="col s3">
                    <button class="btn btn-primary" id="sort-by-timestamp" type="submit" name="time">Применить</button>
                </div>
            </div>


            <div class="row">
                <div class="message__area" style="display: none;">
                    <div class="card-panel red lighten-4"></div>
                </div>

                <div class="row">

                    <!-- <form method="POST" id="import_excel_form" class="upload-form" enctype="multipart/form-data">
                        <div class="file-field input-field col s6">
                            <div class="btn">
                                <span>Выбрать файл</span>
                                <input type="file" name="import_excel">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="Загрузить .xls, .xlsx">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s6">
                                <button class="btn waves-effect waves-light" type="submit" name="import" id="import">Импорт</button>
                            </div>
                        </div>

                    </form> -->

                </div>
                <div class="row">
                    <div class="col s4">
                        <form name="export" id="export_form" method="POST" class="upload-form">
                            <button class="btn waves-effect waves-light" type="submit" name="export" id="btn-export">Экспорт</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        </div>
    </section>

    <section class="section table-sec">
        <div class="container-fluid">
            <div class="table-wrapper ">
                <table id="data-table" class="table table-stroped">
                    <thead style="text-align: center;" class="table-secondary">
                        <tr>
                            <th class="table__header" rowspan="2">№ п/п</th>
                            <th class="table__header" rowspan="2">ID</th>
                            <th class="table__header" rowspan="2">Фамилия</th>
                            <th class="table__header" rowspan="2">Имя</th>
                            <th class="table__header" rowspan="2">Отчество</th>
                            <th class="table__header" rowspan="2">Дата рождения</th>
                            <th class="table__header" rowspan="2">Место рождения</th>
                            <th class="table__header" rowspan="2">Адрес регистрации</th>
                            <th class="table__header" rowspan="2">Дата обращения</th>
                            <th class="table__header" colspan="5">Документ гражданской принадлежности</th>
                            <th class="table__header" rowspan="2">Номер мобильного телефона</th>
                            <th class="table__header" rowspan="2">Место работы</th>
                            <th class="table__header" rowspan="2">Примечание</th>
                        </tr>
                        <tr>
                            <th class="table__header">Вид документа</th>
                            <th class="table__header">Серия</th>
                            <th class="table__header">Номер</th>
                            <th class="table__header">Дата выдачи</th>
                            <th class="table__header">Кем выдан</th>
                        </tr>
                    </thead>

                    <div class="preloader center-align">
                        <div class="preloader-wrapper small active">
                            <div class="spinner-layer spinner-green-only">
                                <div class="circle-clipper left">
                                    <div class="circle"></div>
                                </div>
                                <div class="gap-patch">
                                    <div class="circle"></div>
                                </div>
                                <div class="circle-clipper right">
                                    <div class="circle"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <tbody id="table-body">

                    </tbody>
                </table>

            </div>
        </div>
    </section>
</main>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Окно импорта</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="import_excel_form" class="upload-form" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Загрузить .xls, .xlsx</label>
                        <input class="form-control" type="file" name="import_excel" id="files">
                    </div>
                    <!-- <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Загрузить .xls, .xlsx">
                    </div> -->

                    <div class="row">
                        <div class="col s6">
                            <button class="btn btn-primary" type="submit" name="import" id="import">Импорт</button>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button> -->
            </div>
        </div>
    </div>
</div>
</body>

<script src="./assets/libs/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {

        var message = null;
        var loader = $(".preloader");
        load_data('GET', '', 'getData');
        // $('select').formSelect();

        // var upload_forms = $('.upload-form').hide();

        $('#upload-forms').on('click', function() {
            upload_forms.slideToggle(300);
            return false;
        })

        $('#sort-by-timestamp').on('click', function() {
            var selectOption = $('#select-time').val();
            load_data('GET', 'timesort', selectOption);
        })


        function load_data(method, url, query) {

            $.ajax({
                url: url,
                method: method,
                data: {
                    query: query
                },

                beforeSend: function() {
                    loader.show();
                },

                success: function(data) {
                    $('#table-body').html(data);
                },

                complete: function() {
                    loader.hide();
                    // saveEditElement();
                    showEditableElement();
                    highlightTableRows();
                },

                error: function(jqXHR, excepriont) {
                    message = '<div class="center-align card-panel red lighten-2">Ошибка сервера</div>';
                    $('#table-body').html(message);
                }
            })
        }

        $('#search-input').on('keyup', function() {
            var search_query = $(this).val().trim();
            load_data('POST', 'search', search_query);
        })

        $('#import_excel_form').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: "import",
                method: "POST",
                data: new FormData(this),
                contentType: false,
                dataType: 'text',
                cache: false,
                processData: false,

                beforeSend: function() {
                    loader.show();
                },

                success: function(data) {
                    load_data('GET', '', 'getData');
                    console.log(data);

                },

                complete: function() {
                    message = '<span>Данные успешно загружены!</span>';
                    alert('Импорт завершен');
                    // M.toast({
                    //     html: message
                    // });
                }

            })
        })

        $('#btn-export').on('click', function(e) {
            e.preventDefault();

            var table_headers = [];

            $.each($('.table__header'), function(index, value) {
                table_headers.push(value.textContent);
            })

            $.ajax({
                url: 'export',
                method: 'POST',
                data: JSON.stringify(table_headers),
                dataType: 'binary',
                xhrFields: {
                    'responseType': 'blob'
                },

                success: function(data) {
                    var link = document.createElement('a'),
                        filename = 'file.xlsx';
                    link.href = URL.createObjectURL(data);
                    link.download = filename;
                    link.click();
                },

                error: function(err) {
                    message = '<span>Ошибка экспорта данных!</span>';
                    M.toast({
                        html: message
                    });
                }
            })
        })


        // Подсветка необработанных полей

        function highlightTableRows() {
            var tbody = $('#table-body');
            var comments = tbody.find(".table__content-comment");

            comments.each(function(index, value) {
                if ($(this).text() === "") {
                    $(this).addClass('bg-danger')
                    // $(this).parent().toggleClass("unprocessed");
                }
            })
        }

        /*
        showEditableElement
        добавляет/удаляет активный класс редактируемого элемента и
        сохраняет новое значение в БД
        */

        function showEditableElement() {
            var editableElement = $('.table__content-comment');
            editableElement.on('click', function() {
                $(this).addClass('editable-active');
            })

            editableElement.on('blur', function() {
                var newValue = $(this).text();
                var id = $(this).attr('data-id');
                saveEditableElement($(this), newValue, id);
            })
        }

        /* 
        saveEditableElement()
        @params: editableElement - редактируемый элемент
                 newValue - измененное значение
                 id - id строки в БД по которой будет update
        */
        function saveEditableElement(editableElement, newValue, id) {
            editableElement.removeClass('editable-active');

            if (id != '') {
                $.ajax({
                    url: 'updatefield',
                    method: 'POST',
                    data: {
                        id: id,
                        value: newValue
                    },

                    success: function(response) {
                        highlightTableRows();
                    },

                    error: function(err) {
                        console.log('Query error ' + err);
                        message = ''
                    }
                })
            }

        }


    })
</script>

</html>