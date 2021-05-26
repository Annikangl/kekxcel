<?php include("./Views/layouts/header.tpl.php"); ?>

<main class="main">
    <section class="form">
        <div class="container">
            <div class="row">
                <div class="search__area">
                    <form id="search_form">
                        <div class="col s4">
                            <input type="text" name="search-input" id="search-input" placeholder="Введите запрос">
                        </div>
                        <!-- <div class="col s4"> <input type="date" name="bithdate" placeholder="Дата
                        рождения"> </div> <div class="col s4"> <input type="text" name="bithdate"
                        placeholder="Серия и номер паспорта"> </div> <div class="col s2"> <button
                        type="submit" class="btn" name="search-btn">Найти</button> </div> -->
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="message__area" style="display: none;">
                    <div class="card-panel red lighten-4"></div>
                </div>

                <div class="row">

                    <div class="col s8">
                        <form method="POST" id="import_excel_form" class="upload-form" enctype="multipart/form-data">
                            <div class="file-field input-field">
                                <div class="btn">
                                    <span>Выбрать файл</span>
                                    <input type="file" name="import_excel">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" placeholder="Загрузить .xls, .xlsx">
                                </div>
                            </div>

                            <button class="btn waves-effect waves-light" type="submit" name="import" id="import">Импорт</button>
                        </form>
                    </div>

                    <div class="col s4">
                        <form name="export" id="export_form" method="POST" class="upload-form">
                            <button class="btn waves-effect waves-light" type="submit" name="export" id="import">Экспорт</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <section class="section table-sec">
        <div class="container">
            <div class="table-wrapper">
                <table id="data-table" class="centered">
                    <thead>
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
                        <div class="preloader-wrapper big active">
                            <div class="spinner-layer spinner-blue-only">
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
</body>

<script src="./assets/libs/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {

        load_data('GET', '', 'getData');

        var upload_forms = $('.upload-form').hide();

        // var search_block = $('.search__area').hide();

        $('#upload-forms').on('click', function() {
            upload_forms.slideToggle(300);
            return false;
        })

        // $('#search').on('click', function () {
        //     search_block.slideToggle(300);
        //     return false;
        // });

        function load_data(method, url, query) {
            $.ajax({
                url: url,
                method: method,
                data: {
                    query: query
                },

                beforeSend: function() {
                    $(".preloader").show();
                },

                success: function(data) {
                    $('#table-body').html(data);
                },

                complete: function() {
                    $(".preloader").hide();
                    
                    // Подсветка необработанных полей
                    highlightTableRows();
                },

                error: function(jqXHR, excepriont) {
                    console.log('Error');
                    var message = '<div class="card-panel red lighten-2">Ошибка сервера</div>';
                    $('#table-body').html(message);
                }
            })
        }

        $('#search-input').keyup(function() {

            search_query = $('#search-input').val();

            load_data('POST', 'search', search_query);

            // if (search_query != '') {
            //     load_data('POST', 'search', search_query);
            // } else {
            //     load_data('GET', '');
            // }

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

                beforeSend: function() {},

                success: function(data) {
                    load_data('GET', '', 'getData');
                    console.log(data);
                }

            })
        })

        $('#export_form').on('submit', function(e) {
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
                    console.log(data);
                },

                error: function(err) {
                    console.log('Error');
                }
            })
        })



        function highlightTableRows() {
            var tbody = $('#table-body');
            var comments = tbody.find(".table__content-comment");

            comments.each(function(index, value) {
                if ($(this).text() === "") {
                    $(this).parent().addClass("unprocessed");
                }
            })
        }
    })
</script>

</html>